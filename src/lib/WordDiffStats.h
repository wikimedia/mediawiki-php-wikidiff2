#ifndef WORDDIFFSTATS_H
#define WORDDIFFSTATS_H

#include "DiffEngine.h"
#include "TextUtil.h"

namespace wikidiff2 {

struct WordDiffStats
{
	int charsTotal = 0;
	int opCharCount[4] = { 0 };
	double charSimilarity;
	bool bailout = false;

	WordDiffStats(const Diff<Word> & diff);
};

} // namespace wikidiff2
#endif // WORDDIFFSTATS_H
