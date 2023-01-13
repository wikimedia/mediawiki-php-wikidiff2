#include "WordDiffSegmenter.h"

namespace wikidiff2 {

WordDiffSegmenter::PointerVector WordDiffSegmenter::empty;

void WordDiffSegmenter::segment(WordDiff & diff)
{
	WordDiff result;
	PointerVectorIterator pWord, segmentStart;
	result.edits.reserve(diff.size());

	for (int i = 0; i < diff.size(); i++) {
		DiffOp<Word> & edit = diff[i];

		if (edit.op == DiffOp<Word>::change) {
			segmentStart = edit.to.begin();
			bool isFirstSegment = true;

			for (pWord = edit.to.begin(); pWord != edit.to.end(); pWord++) {
				if ((*pWord)->isNewline()) {
					if (isFirstSegment) {
						isFirstSegment = false;
						if (pWord - segmentStart > 0) {
							// Emit the part from the start to the line break as a change op
							result.add_edit(DiffOp<Word>(DiffOp<Word>::change, edit.from, PointerVector(segmentStart, pWord)));
						} else {
							// Line break at the start of the RHS: emit the LHS as a delete op
							result.add_edit(DiffOp<Word>(DiffOp<Word>::del, edit.from, empty));
						}
					} else {
						// More than one line break: the whole LHS has already been emitted so we 
						// just need to emit the RHS part not including the line break as an add op
						if (pWord - segmentStart > 0) {
							result.add_edit(DiffOp<Word>(DiffOp<Word>::add, empty, PointerVector(segmentStart, pWord)));
						}
					}
					// Add the newline marker
					result.add_edit(DiffOp<Word>(DiffOp<Word>::add, empty, PointerVector(pWord, pWord + 1)));
					segmentStart = pWord + 1;
				}
			}

			if (isFirstSegment) {
				// No line break detected
				result.add_edit(edit);
			} else if (pWord - segmentStart > 0) {
				// Emit the trailing part after the last line break
				result.add_edit(DiffOp<Word>(DiffOp<Word>::add, empty, PointerVector(segmentStart, pWord)));
			}
		} else if (edit.op == DiffOp<Word>::add) {
			segmentStart = edit.to.begin();
			bool isFirstSegment = true;

			for (pWord = edit.to.begin(); pWord != edit.to.end(); pWord++) {
				if ((*pWord)->isNewline()) {
					isFirstSegment = false;
					if (pWord - segmentStart > 0) {
						result.add_edit(DiffOp<Word>(DiffOp<Word>::add, empty, PointerVector(segmentStart, pWord)));
					}
					result.add_edit(DiffOp<Word>(DiffOp<Word>::add, empty, PointerVector(pWord, pWord + 1)));
					segmentStart = pWord + 1;
				}
			}

			if (isFirstSegment) {
				result.add_edit(edit);
			} else if (pWord - segmentStart > 0) {
				result.add_edit(DiffOp<Word>(DiffOp<Word>::add, empty, PointerVector(segmentStart, pWord)));
			}
		} else {
			result.add_edit(edit);
		}
	}
	diff.swap(result);
}

} // namespace wikidiff2
