#ifndef WORDDIFFCACHE_H
#define WORDDIFFCACHE_H

#include "DiffEngine.h"
#include "WordDiffStats.h"
#include "TextUtil.h"

#include <map>
#include <vector>
#include <memory>
#include <limits>

namespace wikidiff2 {

class WordDiffCache {
	public:
		typedef std::basic_string<char, std::char_traits<char>, WD2_ALLOCATOR<char> > String;
		typedef Diff<Word> WordDiff;
		typedef std::shared_ptr<WordDiff> WordDiffPtr;
		typedef std::vector<Word, WD2_ALLOCATOR<Word> > WordVector;
		typedef std::vector<String, WD2_ALLOCATOR<String> > StringVector;
		typedef std::vector<const String*, WD2_ALLOCATOR<const String*> > PointerVector;
		typedef PointerVector::iterator PointerVectorIterator;

		WordDiffCache(const DiffConfig & config_)
			: diffConfig(config_), textUtil(TextUtil::getInstance())
		{}

		/**
		 * Get a diff comparing one or more lines with one or more other lines,
		 * by concatenating the lines.
		 *
		 * @param from The first line on the left-hand side. This pointer must
		 *   be within the line vectors registered with setLines().
		 * @param fromSize The number of lines on the left-hand side.
		 * @param to The first line on the right-hand side. This pointer must
		 *   be within the line vectors registered with setLines().
		 * @param toSize The number of lines on the right-hand side.
		 */
		WordDiffPtr getConcatDiff(const String * from, size_t fromSize,
			const String * to, size_t toSize);

		/**
		 * Get a diff comparing a single line with another single line.
		 * The addresses of the input strings must be in the vectors
		 * registered with setLines().
		 */
		WordDiffPtr getDiff(const String * from, const String * to);

		/**
		 * Get diff stats for a single line comparison. The addresses of the
		 * input strings must be in the vectors registered with setLines().
		 */
		const WordDiffStats & getDiffStats(const String * from, const String * to);

		/**
		 * Get diff stats for a multi-line comparison.
		 *
		 * @param from The first line on the left-hand side. This pointer must
		 *   be within the line vectors registered with setLines().
		 * @param fromSize The number of lines on the left-hand side.
		 * @param to The first line on the right-hand side. This pointer must
		 *   be within the line vectors registered with setLines().
		 * @param toSize The number of lines on the right-hand side.
		 */
		const WordDiffStats & getConcatDiffStats(const String * from, size_t fromSize,
			const String * to, size_t toSize);
		/**
		 * Register line vector pointers so that we can interpret String pointers
		 * as array offsets. The vectors must not be destroyed or resized (or have
		 * other things done to them that invalidate their iterators) unless the
		 * caller is done with accessing WordDiffPtr objects and the cache is
		 * destroyed.
		 */
		void setLines(const StringVector * lines0, const StringVector * lines1);

		/**
		 * Write some statistics about hit ratios to stderr.
		 */
		void dumpDebugReport();

	private:
		/** The key class used to find diffs in the cache */
		struct DiffCacheKey {
			int from;
			int fromSize;
			int to;
			int toSize;

			DiffCacheKey(size_t from_, size_t fromSize_, size_t to_, size_t toSize_)
				: from(sizetToInt(from_)),
				fromSize(sizetToInt(fromSize_)),
				to(sizetToInt(to_)),
				toSize(sizetToInt(toSize_))
			{}

			/** For std::map */
			bool operator<(const DiffCacheKey & other) const;
		};

		/** The key class used to find exploded word vectors in the cache */
		struct WordsCacheKey {
			int line;
			int size;

			WordsCacheKey(size_t line_, size_t size_)
				: line(sizetToInt(line_)), size(sizetToInt(size_))
			{}

			/** For std::map */
			bool operator<(const WordsCacheKey & other) const;
		};

		typedef std::map<WordsCacheKey, WordVector, std::less<WordsCacheKey>,
				WD2_ALLOCATOR<std::pair<const WordsCacheKey, WordVector> > > WordsCache;

		typedef std::map<DiffCacheKey, WordDiffPtr, std::less<DiffCacheKey>,
				WD2_ALLOCATOR<std::pair<const DiffCacheKey, WordDiffPtr> > > DiffCache;

		typedef std::map<DiffCacheKey, WordDiffStats, std::less<DiffCacheKey>,
				WD2_ALLOCATOR<std::pair<const DiffCacheKey, WordDiffStats>>> StatsCache;

		static String newlineStorage;
		static Word newline;

		DiffConfig diffConfig;
		WordsCache wordsCache;
		WordVector tempWords;
		DiffCache diffCache;
		StatsCache statsCache;
		TextUtil & textUtil;

		/** The registered line vectors, used to convert pointers to integer offsets */
		const StringVector* linesVecPtrs[2];

		struct {
			/** The number of hits on the word diff cache */
			int diffHits = 0;
			/** The number of requests to the word diff cache */
			int diffTotal = 0;
			/** The number of hits on the WordDiffStats cache */
			int statHits = 0;
			/** The number of requests to the WordDiffStats cache */
			int statTotal = 0;
			/** The number of hits on the exploded word vector cache */
			int wordHits = 0;
			/** The number of requests to the exploded word vector cache */
			int wordTotal = 0;
			/** The number of hits on the multi-line word vector cache */
			int concatWordHits = 0;
			/** The number of requests to the multi-line word vector cache */
			int concatWordTotal = 0;
		} hitStats;

		const WordVector & explodeWords(const String * line);
		const WordVector & getConcatWords(const String * lines, size_t numLines);
		size_t getKey(const String * str);

		static int sizetToInt(size_t x) {
			if (x > std::numeric_limits<int>().max()) {
				throwOutOfRange();
			}
			return (int)x;
		}

		static void throwOutOfRange();

};

} // namespace wikidiff2
#endif // WORDDIFFCACHE_H
