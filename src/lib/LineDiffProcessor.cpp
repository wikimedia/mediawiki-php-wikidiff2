#include "LineDiffProcessor.h"

namespace wikidiff2 {

LineDiffProcessor::PointerVector LineDiffProcessor::empty;

/**
 * Get diff stats from the cache.
 */
const WordDiffStats & LineDiffProcessor::getConcatDiffStats(
	PointerVectorIterator from, PointerVectorIterator fromEnd,
	PointerVectorIterator to, PointerVectorIterator toEnd)
{
	// TODO: assert that lines are actually consecutive in memory
	return wordDiffCache.getConcatDiffStats(
		*from, fromEnd - from,
		*to, toEnd - to);
}

/**
 * Go through the changed lines. Detect splits. If the lines are dissimilar,
 * convert to delete+add.
 */
void LineDiffProcessor::detectChanges(StringDiff & result, StringDiffOp & diffOp)
{
	PointerVectorIterator pDel = diffOp.from.begin(),
		pDelEnd = diffOp.from.end(),
		pAdd = diffOp.to.begin(),
		pAddEnd = diffOp.to.end();

	SplitInfo split{0, 0};
	int savedSize = 0;

	auto flushSaved = [&]() {
		if (savedSize) {
			result.add_edit(StringDiffOp(StringDiffOp::change,
				PointerVector(pDel - savedSize, pDel),
				PointerVector(pAdd - savedSize, pAdd)));
			savedSize = 0;
		}
	};

	for (; pAdd != pAddEnd && pDel != pDelEnd; pDel++, pAdd += split.size) {
		split = getSplit(pDel, pDelEnd, pAdd, pAddEnd);
		if (split.size > 1) {
			// Add the split as a separate change
			flushSaved();
			result.add_edit(StringDiffOp(StringDiffOp::change,
				PointerVector(pDel, pDel + 1), 
				PointerVector(pAdd, pAdd + split.size)));
		} else if (split.similarity >= config.changeThreshold) {
			// Save regular change for aggregation
			savedSize++;
		} else {
			// Convert dissimilar change to delete + add
			flushSaved();
			result.add_edit(StringDiffOp(StringDiffOp::add,
				empty, PointerVector(pAdd, pAdd + 1)));
			result.add_edit(StringDiffOp(StringDiffOp::del, 
				PointerVector(pDel, pDel + 1), empty));
			// Set split.size = 1 for the loop increment
			split.size = 1;
		}
	}
	flushSaved();

	// Handle the trailing part which doesn't match due to unequal length
	if (pDel != pDelEnd) {
		result.add_edit(StringDiffOp(StringDiffOp::del,
			PointerVector(pDel, pDelEnd), empty));
	} else if (pAdd != pAddEnd) {
		result.add_edit(StringDiffOp(StringDiffOp::add,
			empty, PointerVector(pAdd, pAddEnd)));
	}
}

/**
 * Determine whether there is a line split at the start of the given LHS and
 * RHS half-open ranges.
 *
 * @param pDel The start of the LHS range
 * @param pDelEnd The end (not inclusive) of the LHS range
 * @param pAdd The start of the RHS range
 * @param pAddEnd The end (not inclusive) of the RHS range
 */
LineDiffProcessor::SplitInfo LineDiffProcessor::getSplit(
	PointerVectorIterator pDel, PointerVectorIterator pDelEnd, 
	PointerVectorIterator pAdd, PointerVectorIterator pAddEnd)
{
	int splitSize = 0;
	int bestSplitSize = 0;
	double bestSimilarity = -1;
	double singleSimilarity = -1;
	while (pAdd + splitSize < pAddEnd && splitSize < config.maxSplitSize) {
		splitSize++;
		const WordDiffStats & ds = getConcatDiffStats(
				pDel, pDel + 1, pAdd, pAdd + splitSize);
		double similarity = ds.charSimilarity;
		if (splitSize == 1) {
			singleSimilarity = similarity;
		}
		if (ds.bailout && splitSize == 1) {
			// Treat bailout with splitSize=1 as similar
			similarity = 1.0;
		}
		if (similarity > bestSimilarity) {
			bestSimilarity = similarity;
			bestSplitSize = splitSize;
		}
		if (ds.bailout || similarity <= config.initialSplitThreshold) {
			break;
		}
	}
	if (bestSplitSize > 1 && bestSimilarity < config.finalSplitThreshold) {
		// If a split was not detected, reduce the split size to 1 and return
		// the similarity for single line comparison
		return SplitInfo{1, singleSimilarity};
	}
	return SplitInfo{bestSplitSize, bestSimilarity};
}

void LineDiffProcessor::process(StringDiff & lineDiff) {
	StringDiff result;
	auto n = lineDiff.size();

	for (size_t i = 0; i < n; i++) {
		StringDiffOp & diffOp = lineDiff[i];
		if (diffOp.op == StringDiffOp::change) {
			detectChanges(result, diffOp);
		} else {
			result.add_edit(diffOp);
		}
	}
	lineDiff.swap(result);
}

} // namespace wikidiff2
