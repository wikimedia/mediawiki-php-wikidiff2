#include "WordDiffCache.h"
#include "WordDiffSegmenter.h"

namespace wikidiff2 {

WordDiffCache::String WordDiffCache::newlineStorage = "\n";
Word WordDiffCache::newline(newlineStorage.begin(),
	newlineStorage.begin() + 1, newlineStorage.begin() + 1);

WordDiffCache::WordDiffPtr WordDiffCache::getDiff(const String * from, const String * to)
{
	return getConcatDiff(from, 1, to, 1);
}

WordDiffCache::WordDiffPtr WordDiffCache::getConcatDiff(
	const String * fromStart, size_t fromSize,
	const String * toStart, size_t toSize)
{
	DiffCacheKey key(
		getKey(fromStart), fromSize,
		getKey(toStart), toSize);
	DiffCache::iterator it = diffCache.find(key);
	if (it == diffCache.end()) {
		const WordVector & words1 = getConcatWords(fromStart, fromSize);
		const WordVector & words2 = getConcatWords(toStart, toSize);
		WordDiffPtr wordDiffPtr = std::allocate_shared<WordDiff>(WD2_ALLOCATOR<WordDiff>(),
			diffConfig, words1, words2);

		if (fromSize > 1 || toSize > 1) {
			WordDiffSegmenter::segment(*wordDiffPtr);
		}

		auto result = diffCache.insert(std::make_pair(key, wordDiffPtr));
		it = result.first;
	} else {
		hitStats.diffHits++;
	}
	hitStats.diffTotal++;
	return it->second;
}

/**
 * Get an integer key from a String address.
 *
 * Maybe a weird concept, but not much worse than what we were doing in Diff
 * already. A hashtable would be slow since String doesn't memoize hashes.
 * We don't accept any pointer, just one that is inside a previously
 * registered vector.
 *
 * Theoretically we could track line numbers right through DiffEngine/Diff
 * instead of reconstructing the line numbers from the pointers.
 */
size_t WordDiffCache::getKey(const String * str)
{
	size_t r = 0;
	for (size_t i = 0; i < 2; i++) {
		const StringVector & lines = *(linesVecPtrs[i]);
		size_t n = lines.size();
		if (n && str >= &lines[0] && str <= &lines[n - 1]) {
			return r + str - &lines[0];
		}
		r += n;
	}
	throw std::invalid_argument("WordDiffCache::getKey: unregistered string pointer");
}

const WordDiffStats & WordDiffCache::getDiffStats(const String * from, const String * to)
{
	return getConcatDiffStats(from, 1, to, 1);
}

const WordDiffStats & WordDiffCache::getConcatDiffStats(
	const String * fromStart, size_t fromSize,
	const String * toStart, size_t toSize)
{
	DiffCacheKey key(
		getKey(fromStart), fromSize,
		getKey(toStart), toSize);
	StatsCache::iterator it = statsCache.find(key);
	if (it == statsCache.end()) {
		WordDiffPtr diff = getConcatDiff(fromStart, fromSize, toStart, toSize);
		auto result = statsCache.insert(std::make_pair(key, WordDiffStats(*diff)));
		it = result.first;
	} else {
		hitStats.statHits++;
	}
	hitStats.statTotal++;
	return it->second;
}

void WordDiffCache::setLines(const StringVector * lines0, const StringVector * lines1)
{
	linesVecPtrs[0] = lines0;
	linesVecPtrs[1] = lines1;
	wordsCache.clear();
	diffCache.clear();
	statsCache.clear();
}

/**
 * Get a vector of words for a line.
 */
const WordDiffCache::WordVector & WordDiffCache::explodeWords(const String * line)
{
	WordsCacheKey key(getKey(line), 1);
	auto it = wordsCache.find(key);
	hitStats.wordTotal++;
	if (it != wordsCache.end()) {
		hitStats.wordHits++;
		return it->second;
	}
	textUtil.explodeWords(*line, tempWords);
	auto result = wordsCache.insert(WordsCache::value_type(key, WordVector()));
	result.first->second.swap(tempWords);
	return result.first->second;
}

/**
 * Get a word vector for one or more lines. If more than one line is requested,
 * the lines will be concatenated with a newline separator.
 *
 * TODO: Unfortunately the concatenated word vector must stay in memory as long
 * as the associated diffs stay in memory, because the diffs contain pointers
 * to the words. An improvement would be to have DiffEngine store integer
 * offsets instead of pointers. This would allow concatenated word vectors to
 * be temporary, reducing memory usage.
 */
const WordDiffCache::WordVector & WordDiffCache::getConcatWords(
	const String * lines, size_t numLines)
{
	if (numLines == 1) {
		return explodeWords(lines);
	}

	WordsCacheKey key(getKey(lines), numLines);
	auto it = wordsCache.find(key);
	hitStats.concatWordTotal++;
	if (it != wordsCache.end()) {
		hitStats.concatWordHits++;
		return it->second;
	}

	WordVector concatWords;
	size_t numWords = 0;
	for (size_t i = 0; i < numLines; i++) {
		numWords += explodeWords(lines + i).size() + 1;
	}
	concatWords.reserve(numWords);

	for (size_t i = 0; i < numLines; i++) {
		const WordVector & words = explodeWords(lines + i);
		if (i > 0) {
			concatWords.push_back(newline);
		}
		for (auto it = words.begin(); it != words.end(); it++) {
			concatWords.push_back(*it);
		}
	}
	auto result = wordsCache.insert(std::make_pair(key, WordVector()));
	result.first->second.swap(concatWords);
	return result.first->second;
}

void WordDiffCache::dumpDebugReport()
{
	auto h = hitStats;
	using std::endl;
	std::cerr << "Diff cache: " << h.diffHits << " / " << h.diffTotal << endl
		<< "Stat cache " << h.statHits << " / " << h.statTotal << endl
		<< "Word cache " << h.wordHits << " / " << h.wordTotal << endl
		<< "Concatenated line word cache " << h.concatWordHits << " / " << h.concatWordTotal << endl;
}

void WordDiffCache::throwOutOfRange()
{
	throw std::out_of_range("Numeric value out of range");
}

bool WordDiffCache::DiffCacheKey::operator<(const DiffCacheKey & other) const
{
	if (from < other.from) return true;
	if (from > other.from) return false;
	if (fromSize < other.fromSize) return true;
	if (fromSize > other.fromSize) return false;
	if (to < other.to) return true;
	if (to > other.to) return false;
	if (toSize < other.toSize) return true;
	if (toSize > other.toSize) return false;
	return false;
}

bool WordDiffCache::WordsCacheKey::operator<(const WordsCacheKey & other) const
{
	if (line < other.line) return true;
	if (line > other.line) return false;
	if (size < other.size) return true;
	if (size > other.size) return false;
	return false;
}

} // namespace wikidiff2
