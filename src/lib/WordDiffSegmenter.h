#ifndef WORDDIFFSEGMENTER_H
#define WORDDIFFSEGMENTER_H

#include "DiffEngine.h"

namespace wikidiff2 {

class WordDiffSegmenter {
	public:
		typedef Diff<Word> WordDiff;
		typedef DiffOp<Word>::PointerVector PointerVector;
		typedef PointerVector::iterator PointerVectorIterator;

		static PointerVector empty;

		/**
		 * Take a word diff which compared one line with multiple lines. Find the line
		 * breaks in the RHS and split them out into a single "add" operation, which
		 * will act as a split marker for the formatter.
		 */
		static void segment(WordDiff & diff);
};

} // namespace wikidiff2
#endif // WORDDIFFSEGMENTER_H
