#include "LineDiffProcessor.h"

namespace wikidiff2 {

LineDiffProcessor::PointerVector LineDiffProcessor::empty;

/**
 * For a DiffOp::change, decide whether it should be treated as a
 * successive add and delete based on similarity.
 */
bool LineDiffProcessor::looksLikeChange(const String * del, const String * add)
{
	const WordDiffStats & ds = wordDiffCache.getDiffStats(del, add);
	return ds.bailout || ds.charSimilarity > config.changeThreshold;
}

/**
 * Go through list of changed lines. If they are too dissimilar, convert to
 * add+del.
 */
void LineDiffProcessor::detectDissimilarChanges(StringDiff & result, StringDiffOp & diffOp)
{
	int i;
	PointerVector & del = diffOp.from;
	PointerVector & add = diffOp.to;

	for (i = 0; i < del.size() && i < add.size(); ++i) {
		if (!looksLikeChange(del[i], add[i])) {
			if (i > 0) {
				// Turn all "add" and "del" operations that have been detected as "looksLikeChange"
				// so far into a single combined "change" operation in the resulting diff.
				PointerVector d, a;
				for (int k = 0; k < i; ++k) {
					d.push_back(del[k]);
					a.push_back(add[k]);
				}
				result.add_edit(StringDiffOp(StringDiffOp::change, d, a));
				add.erase(add.begin(), add.begin() + i);
				del.erase(del.begin(), del.begin() + i);
				// All elements [0..i - 1] got removed, which moves element i to position 0.
				i = 0;
			}

			// convert dissimilar piece to delete + add
			PointerVector d, a;
			d.push_back(del[i]);
			a.push_back(add[i]);
			result.add_edit(StringDiffOp(StringDiffOp::add, empty, a));
			result.add_edit(StringDiffOp(StringDiffOp::del, d, empty));
			add.erase(add.begin() + i);
			del.erase(del.begin() + i);
			--i;
		}
	}
}

/**
 * Add some kind of change to the output.
 */
void LineDiffProcessor::writeChange(StringDiff& diff, StringDiffOp& diffOp)
{
	PointerVector & del = diffOp.from;
	PointerVector & add = diffOp.to;

	if (del.size() == add.size()) {
		diff.add_edit(StringDiffOp(StringDiffOp::change, del, add));
	} else {
		// this is a change containing added and deleted lines; convert them to the right DiffOps so the
		// moved paragraph detection code gets a chance to see them
		size_t commonSize = std::min(del.size(), add.size());
		PointerVector changeDel(del.begin(), del.begin() + commonSize);
		PointerVector changeAdd(add.begin(), add.begin() + commonSize);
		diff.add_edit(StringDiffOp(StringDiffOp::change, changeDel, changeAdd));
		if (del.size() > commonSize)
			diff.add_edit(StringDiffOp(StringDiffOp::del, PointerVector(del.begin() + commonSize, del.end()), empty));
		if (add.size() > commonSize)
			diff.add_edit(StringDiffOp(StringDiffOp::add, empty, PointerVector(add.begin() + commonSize, add.end())));
	}
}

void LineDiffProcessor::process(StringDiff & lineDiff) {
	StringDiff result;
	auto n = lineDiff.size();

	for (size_t i = 0; i < n; i++) {
		StringDiffOp & diffOp = lineDiff[i];
		PointerVector & del = diffOp.from;
		PointerVector & add = diffOp.to;

		if (diffOp.op == StringDiffOp::change) {
			detectDissimilarChanges(result, diffOp);
			if (del.size() && add.size()) {
				writeChange(result, diffOp);
			} else if (del.size()) {
				result.add_edit(StringDiffOp(StringDiffOp::del, del, empty));
			} else if (add.size()) {
				result.add_edit(StringDiffOp(StringDiffOp::add, empty, add));
			}
		} else {
			result.add_edit(diffOp);
		}
	}
	lineDiff.swap(result);
}

} // namespace wikidiff2
