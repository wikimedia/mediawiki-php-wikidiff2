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
		typedef PointerVector::iterator PointerVectorIterator;

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

			/**
			 * The minimum similarity which must be maintained during a split
			 * detection search. The split size increases until either the
			 * similarity between the LHS and the multiple RHS lines becomes
			 * less than initialSplitThreshold, or maxSplitSize is reached.
			 */
			double initialSplitThreshold;

			/**
			 * The minimum similarity between one LHS line and multiple RHS
			 * lines which must be achieved to format the block as a split.
			 */
			double finalSplitThreshold;

			/**
			 * The maximum number of RHS lines which can be compared with
			 * one LHS line.
			 */
			int64_t maxSplitSize;
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

		/**
		 * The return value of getSplit
		 */
		struct SplitInfo {
			/** The number of lines in the RHS that correspond to the single LHS line */
			int size;
			/** The similarity metric */
			double similarity;
		};

		void detectChanges(StringDiff & result, StringDiffOp & diffOp);

		SplitInfo getSplit(
			PointerVectorIterator pDel, PointerVectorIterator pDelEnd,
			PointerVectorIterator pAdd, PointerVectorIterator pAddEnd);

		const WordDiffStats & getConcatDiffStats(
			PointerVectorIterator from, PointerVectorIterator fromEnd,
			PointerVectorIterator to, PointerVectorIterator toEnd);

};

} // namespace wikidiff2

#endif // LINEDIFFPROCESSOR_H
