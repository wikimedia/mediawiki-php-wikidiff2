#include "WordDiffCache.h"

#include <stdexcept>
#include <iostream>

namespace wikidiff2 {

WordDiffCache::WordDiffPtr WordDiffCache::getDiff(const String * from, const String * to)
{
	DiffCacheKey key(getKey(from), getKey(to));
	DiffCache::iterator it = diffCache.find(key);
	if (it == diffCache.end()) {
		const WordVector & words1 = explodeWords(from);
		const WordVector & words2 = explodeWords(to);
		WordDiffPtr wordDiffPtr = std::allocate_shared<WordDiff>(WD2_ALLOCATOR<WordDiff>(),
			diffConfig, words1, words2);
		auto result = diffCache.insert(std::make_pair(key, wordDiffPtr));
		it = result.first;
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
	DiffCacheKey key = std::make_pair(getKey(from), getKey(to));
	StatsCache::iterator it = statsCache.find(key);
	if (it == statsCache.end()) {
		WordDiffPtr diff = getDiff(from, to);
		auto result = statsCache.insert(std::make_pair(key, WordDiffStats(*diff)));
		it = result.first;
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
	size_t key = getKey(line);
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

void WordDiffCache::dumpDebugReport()
{
	auto h = hitStats;
	using std::endl;
	std::cerr << "Diff cache: " << h.diffHits << " / " << h.diffTotal << endl
		<< "Stat cache " << h.statHits << " / " << h.statTotal << endl
		<< "Word cache " << h.wordHits << " / " << h.wordTotal << endl;
}

} // namespace wikidiff2
