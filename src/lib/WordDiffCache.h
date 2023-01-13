#ifndef WORDDIFFCACHE_H
#define WORDDIFFCACHE_H

#include "DiffEngine.h"
#include "WordDiffStats.h"
#include "TextUtil.h"

#include <map>
#include <vector>
#include <memory>

namespace wikidiff2 {

class WordDiffCache {
	public:
		typedef std::basic_string<char, std::char_traits<char>, WD2_ALLOCATOR<char> > String;
		typedef Diff<Word> WordDiff;
		typedef std::shared_ptr<WordDiff> WordDiffPtr;
		typedef std::vector<Word, WD2_ALLOCATOR<Word> > WordVector;
		typedef std::vector<String, WD2_ALLOCATOR<String> > StringVector;

		WordDiffCache(const DiffConfig & config_)
			: diffConfig(config_), textUtil(TextUtil::getInstance())
		{}

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
		typedef std::map<size_t, WordVector, std::less<size_t>,
				WD2_ALLOCATOR<std::pair<const size_t, WordVector> > > WordsCache;
		typedef std::pair<size_t, size_t> DiffCacheKey;
		typedef std::map<DiffCacheKey, WordDiffPtr, std::less<DiffCacheKey>,
				WD2_ALLOCATOR<std::pair<const DiffCacheKey, WordDiffPtr> > > DiffCache;
	typedef std::map<DiffCacheKey, WordDiffStats, std::less<DiffCacheKey>,
				WD2_ALLOCATOR<std::pair<const DiffCacheKey, WordDiffStats>>> StatsCache;

		DiffConfig diffConfig;
		WordsCache wordsCache;
		WordVector tempWords;
		DiffCache diffCache;
		StatsCache statsCache;
		TextUtil & textUtil;

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
		} hitStats;

		const WordVector & explodeWords(const String * line);
		size_t getKey(const String * str);
};

} // namespace wikidiff2
#endif // WORDDIFFCACHE_H
