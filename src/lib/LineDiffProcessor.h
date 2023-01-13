#ifndef LINEDIFFPROCESSOR_H
#define LINEDIFFPROCESSOR_H
#include "DiffEngine.h"
#include "WordDiffCache.h"

namespace wikidiff2 {

/**
 * Class to do post-processing operations on line diffs.
 */
class LineDiffProcessor {
	public:
		typedef std::basic_string<char, std::char_traits<char>, WD2_ALLOCATOR<char> > String;
		typedef Diff<String> StringDiff;
		typedef Diff<Word> WordDiff;
		typedef DiffOp<String> StringDiffOp;
		typedef DiffOp<String>::PointerVector PointerVector;

		/**
		 * Options to be passed to the constructor
		 */
		struct Config {
			/**
			 * Changed lines with a similarity value below this threshold will
			 * be split into a deleted line and added line. This helps matching
			 * up moved lines in some cases.
			 */
			double changeThreshold;
		};

		LineDiffProcessor(const Config & config_, WordDiffCache & wordDiffCache_)
			: config(config_), wordDiffCache(wordDiffCache_)
		{}

		/**
		 * Process the line diff. Detect dissimilar changes and replace them
		 * with add+delete options.
		 *
		 * @param lineDiff In/out parameter. The contents will be replaced with
		 *   the new diff.
		 */
		void process(StringDiff & lineDiff);

		/**
		 * Empty line pointer vector
		 */
		static PointerVector empty;

	private:
		/**
		 * The cache used for all necessary word diff operations
		 */
		WordDiffCache & wordDiffCache;

		/**
		 * The config options
		 */
		Config config;

		bool looksLikeChange(const String * del, const String * add);
		void detectDissimilarChanges(StringDiff & result, StringDiffOp & diffOp);
		void writeChange(StringDiff& diff, StringDiffOp& diffOp);
};

} // namespace wikidiff2

#endif // LINEDIFFPROCESSOR_H
