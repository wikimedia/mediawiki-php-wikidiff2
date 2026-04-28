#ifndef WORDDIFFSEGMENTER_H
#define WORDDIFFSEGMENTER_H

#include "DiffEngine.h"

namespace wikidiff2 {

class WordDiffSegmenter {
	public:
		using WordDiff = Diff<Word>;
		using PointerVector = DiffOp<Word>::PointerVector;
		using PointerVectorIterator = PointerVector::iterator;

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
