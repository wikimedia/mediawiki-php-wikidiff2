#include "WordDiffStats.h"

namespace wikidiff2 {

WordDiffStats::WordDiffStats(const Diff<Word> & diff)
{
	auto countOpChars = [] (const DiffEngine<Word>::PointerVector& p) {
		return std::accumulate(p.begin(), p.end(), 0, [] (int a, const Word *b) {
			return a + b->size();
		});
	};

	if (diff.bailout) {
		charSimilarity = 0.0;
		bailout = true;
		return;
	}

	for (int i = 0; i < diff.size(); ++i) {
		int op = diff[i].op;
		int charCount;
		switch (op) {
			case DiffOp<Word>::del:
			case DiffOp<Word>::copy:
				charCount = countOpChars(diff[i].from);
				break;
			case DiffOp<Word>::add:
				charCount = countOpChars(diff[i].to);
				break;
			case DiffOp<Word>::change:
				charCount = std::max(countOpChars(diff[i].from), countOpChars(diff[i].to));
				break;
		}
		opCharCount[op] += charCount;
		charsTotal += charCount;
	}
	if (opCharCount[DiffOp<Word>::copy] == 0) {
		charSimilarity = 0.0;
	} else {
		if (charsTotal) {
			charSimilarity = double(opCharCount[DiffOp<Word>::copy]) / charsTotal;
		} else {
			charSimilarity = 0.0;
		}
	}
}

} // namespace wikidiff2
