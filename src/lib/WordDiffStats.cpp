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
		DiffOp<Word>::Op op = diff[i].op;
		int charCount;
		switch (op) {
			case DiffOp<Word>::Op::del:
			case DiffOp<Word>::Op::copy:
				charCount = countOpChars(diff[i].from);
				break;
			case DiffOp<Word>::Op::add:
				charCount = countOpChars(diff[i].to);
				break;
			case DiffOp<Word>::Op::change:
				charCount = std::max(countOpChars(diff[i].from), countOpChars(diff[i].to));
				break;
		}
		opCharCount[static_cast<int>(op)] += charCount;
		charsTotal += charCount;
	}
	if (opCharCount[static_cast<int>(DiffOp<Word>::Op::copy)] == 0) {
		charSimilarity = 0.0;
	} else {
		if (charsTotal) {
			charSimilarity = double(opCharCount[static_cast<int>(DiffOp<Word>::Op::copy)]) / charsTotal;
		} else {
			charSimilarity = 0.0;
		}
	}
}

} // namespace wikidiff2
