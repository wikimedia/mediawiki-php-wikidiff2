/**
 * Diff formatter, based on code by Steinar H. Gunderson, converted to work with the
 * Dairiki diff engine by Tim Starling
 *
 * GPL.
 */

#include <stdio.h>
#include <string.h>
#include <sstream>
#include <stdarg.h>
#include "Wikidiff2.h"
#include <regex>
#include <iostream>

namespace wikidiff2 {

void Wikidiff2::printDiff(const StringDiff & linediff)
{
	int from_index = 1, to_index = 1;

	// Should a line number be printed before the next context line?
	// Set to true initially so we get a line number on line 1
	bool showLineNumber = true;

	printFileHeader();

	int currentOffsetFrom = 0;
	int currentOffsetTo = 0;
	int newLineLength = 1;
	for (int i = 0; i < linediff.size(); ++i) {
		int n, j, n1, n2;
		// Line 1 changed, show heading with no leading context
		if (linediff[i].op != DiffOp<String>::copy && i == 0) {
			printBlockHeader(1, 1);
		}

		switch (linediff[i].op) {
			case DiffOp<String>::add:
				// inserted lines
				n = linediff[i].to.size();
				for (j=0; j<n; j++) {

					String toLine = *linediff[i].to[j];

					if (!printMovedLineDiff(linediff, i, j, from_index, to_index+j,
						 -1, currentOffsetTo)) {

						printAdd(toLine, from_index, to_index+j, -1, currentOffsetTo);
					}

					currentOffsetTo += toLine.length() + newLineLength;
				}
				to_index += n;
				break;
			case DiffOp<String>::del:
				// deleted lines
				n = linediff[i].from.size();
				for (j=0; j<n; j++) {

					String fromLine = *linediff[i].from[j];

					if (!printMovedLineDiff(linediff, i, j, from_index+j, to_index,
						currentOffsetFrom, -1)) {

						printDelete(fromLine, from_index+j, to_index, currentOffsetFrom, -1);
					}

					currentOffsetFrom += fromLine.length() + newLineLength;
				}
				from_index += n;
				break;
			case DiffOp<String>::copy:
				// copy/context
				n = linediff[i].from.size();

				for (j=0; j<n; j++) {

					String line = *linediff[i].from[j];

					if ((i != 0 && j < config.numContextLines) /*trailing*/
							|| (i != linediff.size() - 1 && j >= n - config.numContextLines)) /*leading*/ {
						if (showLineNumber) {
							printBlockHeader(from_index, to_index);
							showLineNumber = false;
						}

						printContext(line, from_index, to_index, currentOffsetFrom, currentOffsetTo);
					} else {
						showLineNumber = true;
					}

					currentOffsetTo += line.length() + newLineLength;
					currentOffsetFrom += line.length() + newLineLength;

					from_index++;
					to_index++;
				}
				break;
			case DiffOp<String>::change:
				// replace, i.e. we do a word diff between the two sets of lines
				n1 = linediff[i].from.size();
				n2 = linediff[i].to.size();
				n = std::min(n1, n2);
				for (j=0; j<n; j++) {

					String toLine = *linediff[i].to[j];
					String fromLine = *linediff[i].from[j];

					printWordDiffFromStrings(fromLine, toLine, from_index+j, to_index+j,
						currentOffsetFrom, currentOffsetTo);

					currentOffsetTo += toLine.length() + newLineLength;
					currentOffsetFrom += fromLine.length() + newLineLength;
				}
				from_index += n;
				to_index += n;
				break;
		}
		// Not first line anymore, don't show line number by default
		showLineNumber = false;
	}

	printFileFooter();
}

/**
 * Tell registered formatters to print an added line
 *
 * @see Formatter::printAdd
 */
void Wikidiff2::printAdd(const String & line, int leftLine, int rightLine, int offsetFrom, int offsetTo)
{
	for (auto f = formatters.begin(); f != formatters.end(); f++) {
		(*f)->printAdd(line, leftLine, rightLine, offsetFrom, offsetTo);
	}	
}

/**
 * Tell registered formatters to print a deleted line
 *
 * @see Formatter::printDelete
 */
void Wikidiff2::printDelete(const String & line, int leftLine, int rightLine, int offsetFrom, int offsetTo)
{
	for (auto f = formatters.begin(); f != formatters.end(); f++) {
		(*f)->printDelete(line, leftLine, rightLine, offsetFrom, offsetTo);
	}
}

/**
 * Tell registered formatters to print a word diff
 *
 * @see Formatter::printWordDiff
 */
void Wikidiff2::printWordDiff(
	const WordDiff & wordDiff,
	int leftLine, int rightLine, 
	int offsetFrom, int offsetTo, 
	bool printLeft, bool printRight,
	const String & srcAnchor, const String & dstAnchor,
	bool moveDirectionDownwards)
{
	for (auto f = formatters.begin(); f != formatters.end(); f++) {
		(*f)->printWordDiff(wordDiff,
				leftLine, rightLine,
				offsetFrom, offsetTo,
				printLeft, printRight,
				srcAnchor, dstAnchor,
				moveDirectionDownwards
		);
	}
}

/**
 * Do a word diff and then tell formatters to print it
 */
void Wikidiff2::printWordDiffFromStrings(
	const String & text1, const String & text2,
	int leftLine, int rightLine, 
	int offsetFrom, int offsetTo, 
	bool printLeft, bool printRight,
	const String & srcAnchor, const String & dstAnchor,
	bool moveDirectionDownwards)
{
	WordVector words1, words2;

	textUtil.explodeWords(text1, words1);
	textUtil.explodeWords(text2, words2);
	WordDiff worddiff(wordDiffConfig, words1, words2);

	printWordDiff(
			worddiff,
			leftLine, rightLine,
			offsetFrom, offsetTo,
			printLeft, printRight,
			srcAnchor, dstAnchor,
			moveDirectionDownwards
	);
}

/**
 * Tell all formatters that we are starting
 *
 * @see Formatter::printFileHeader
 */
void Wikidiff2::printFileHeader()
{
	for (auto f = formatters.begin(); f != formatters.end(); f++) {
		(*f)->printFileHeader();
	}
}

/**
 * Tell all formatters that we are ending
 *
 * @see Formatter::printFileFooter
 */
void Wikidiff2::printFileFooter()
{
	for (auto f = formatters.begin(); f != formatters.end(); f++) {
		(*f)->printFileFooter();
	}
}

/**
 * Tell all formatters to print a block header
 *
 * @see Formatter::printBlockHeader
 */
void Wikidiff2::printBlockHeader(int leftLine, int rightLine)
{
	for (auto f = formatters.begin(); f != formatters.end(); f++) {
		(*f)->printBlockHeader(leftLine, rightLine);
	}
}

/**
 * Tell all formatters to print a context line
 *
 * @see Formatter::printContext
 */
void Wikidiff2::printContext(const String & input, int leftLine, int rightLine, int offsetFrom, int offsetTo)
{
	for (auto f = formatters.begin(); f != formatters.end(); f++) {
		(*f)->printContext(input, leftLine, rightLine, offsetFrom, offsetTo);
	}
}

/**
 * Detect a moved line at the current position. If there was a moved line, print it
 * and return true. If there was no moved line, do nothing and return false.
 *
 * @param linediff The line-level diff
 * @param opIndex The current index into linediff
 * @param opLine The current index into linediff[opIndex].from or
 *   linediff[opIndex].to, specifying a particular added or deleted line.
 * @param leftLine The 1-based line number on the LHS
 * @param rightLine The 1-based line number on the RHS
 * @param offsetFrom The 0-based byte offset in the LHS input string
 * @param offsetTo The 0-based byte offset in the RHS input string
 */
bool Wikidiff2::printMovedLineDiff(const StringDiff & linediff, int opIndex, int opLine,
	int leftLine, int rightLine, int offsetFrom, int offsetTo)
{
	// helper fn creates 64-bit lookup key from opIndex and opLine
	auto makeKey = [](int index, int line) {
		return uint64_t(index) << 32 | line;
	};

	auto makeAnchorName = [](int index, int line, bool lhs) {
		char ch[2048];
		snprintf(ch, sizeof(ch), "movedpara_%d_%d_%s", index, line, lhs? "lhs": "rhs");
		return String(ch);
	};

	// check whether this paragraph immediately follows the other.
	// if so, they will be matched up next to each other and displayed as a change, not a move.
	auto isNext = [] (int opIndex, int opLine, int otherIndex, int otherLine) {
		if(otherIndex==opIndex && otherLine==opLine+1)
			return true;
		if(otherIndex==opIndex+1 && otherLine==0)
			return true;
		return false;
	};

	// compare positions of moved lines, return true if moved downwards
	auto movedir = [] (int opIndex, int opLine, int otherIndex, int otherLine) {
		return (otherIndex > opIndex) || (otherIndex == opIndex && otherLine > opLine);
	};

#ifdef DEBUG_MOVED_LINES
	auto debugPrintf = [this](const char *fmt, ...) {
		char ch[2048];
		va_list ap;
		va_start(ap, fmt);
		vsnprintf(ch, sizeof(ch), fmt, ap);
		va_end(ap);

		std::cerr << ch << std::endl;
	};
#else
	auto debugPrintf = [](...) { };
#endif

	if(!allowPrintMovedLineDiff(linediff, config.maxMovedLines)) {
		debugPrintf("printMovedLineDiff: diff too large (maxMovedLines=%ld), not detecting moved lines",
			config.maxMovedLines);
		return false;
	}

	debugPrintf("printMovedLineDiff (...), %d, %d", opIndex, opLine);

	bool printLeft = linediff[opIndex].op == DiffOp<String>::del ? true : false;
	bool printRight = !printLeft;

	// check whether this op actually refers to the diff map entry
	auto cmpDiffMapEntries = [&](int otherIndex, int otherLine) -> bool {
		// check whether the other paragraph already exists in the diff map.
		uint64_t otherKey = makeKey(otherIndex, otherLine);
		auto it = diffMap.find(otherKey);
		if (it != diffMap.end()) {
			// if found, check whether it refers to the current paragraph.
			auto other = it->second;
			bool cmp = (printLeft ?
				other->opIndexFrom == opIndex && other->opLineFrom == opLine :
				other->opIndexTo == opIndex && other->opLineTo == opLine);
			if(!cmp && (printLeft ? other->lhsDisplayed : other->rhsDisplayed)) {
				// the paragraph was already moved to a different place. a move operation can only have one source and one destination.
				debugPrintf("printMovedLineDiff(..., %d, %d): excluding this candidate (multiple potential matches). op=%s, printLeft %s, otheridx/line %d/%d, found %d/%d, other->lhsDisplayed %s, other->rhsDisplayed  %s",
					opIndex, opLine,
					linediff[opIndex].op == DiffOp<String>::add ? "add": linediff[opIndex].op == DiffOp<String>::del ? "del": "???",
					printLeft ? "true" : "false",
					otherIndex, otherLine, (printLeft ? other->opIndexFrom : other->opIndexTo), (printLeft? other->opLineFrom: other->opLineTo),
					other->lhsDisplayed ? "true" : "false",
					other->rhsDisplayed ? "true" : "false");
				return false;
			}
			// the entry in the diff map refers to this paragraph.
			debugPrintf("printMovedLineDiff(..., %d, %d): diffMap entry refers to this paragraph (or other side not displayed). op=%s, printLeft %s, otheridx/line %d/%d, found %d/%d",
				opIndex, opLine,
				linediff[opIndex].op == DiffOp<String>::add ? "add": linediff[opIndex].op == DiffOp<String>::del ? "del": "???",
				printLeft ? "true" : "false",
				otherIndex, otherLine, (printLeft ? other->opIndexFrom : other->opIndexTo), (printLeft? other->opLineFrom: other->opLineTo));
			return true;
		}
		// no entry in the diffMap.
		debugPrintf("printMovedLineDiff(..., %d, %d): no diffMap entry found. op=%s, printLeft %s, otheridx/line %d/%d",
			opIndex, opLine,
			linediff[opIndex].op == DiffOp<String>::add ? "add": linediff[opIndex].op == DiffOp<String>::del ? "del": "???",
			printLeft ? "true" : "false",
			otherIndex, otherLine);
		return true;
	};

	// look for corresponding moved line for the opposite case in moved-line-map
	// if moved line exists:
	//     print diff to the moved line, omitting the left/right side for added/deleted line
	uint64_t key = makeKey(opIndex, opLine);
	auto it = diffMap.find(key);
	if (it != diffMap.end()) {
		auto best = it->second;
		int otherIndex = linediff[opIndex].op == DiffOp<String>::add ? best->opIndexFrom : best->opIndexTo;
		int otherLine = linediff[opIndex].op == DiffOp<String>::add ? best->opLineFrom : best->opLineTo;

		if(!cmpDiffMapEntries(otherIndex, otherLine))
			return false;

		if(isNext(otherIndex, otherLine, opIndex, opLine)) {
			debugPrintf("this one was already shown as a change, not displaying again...");
			return true;
		} else {
			// XXXX todo: we already have the diff, don't have to do it again, just have to print it
			printWordDiffFromStrings(*linediff[best->opIndexFrom].from[best->opLineFrom],
				*linediff[best->opIndexTo].to[best->opLineTo],
				leftLine, rightLine, offsetFrom, offsetTo, printLeft, printRight,
				makeAnchorName(opIndex, opLine, printLeft),
				makeAnchorName(otherIndex, otherLine, !printLeft),
				movedir(opIndex,opLine, otherIndex,otherLine));
		}

		if(printLeft)
			best->lhsDisplayed = true;
		else
			best->rhsDisplayed = true;

		debugPrintf("found in diffmap. copy: %d, del: %d, add: %d, change: %d, similarity: %.4f\n"
					"from: (%d,%d) to: (%d,%d)",
			best->ds.opCharCount[DiffOp<Word>::copy], best->ds.opCharCount[DiffOp<Word>::del], best->ds.opCharCount[DiffOp<Word>::add], best->ds.opCharCount[DiffOp<Word>::change], best->ds.charSimilarity,
			best->opIndexFrom, best->opLineFrom, best->opIndexTo, best->opLineTo);

		return true;
	}

	debugPrintf("nothing found in moved-line-map");

	// else:
	//     try to find a corresponding moved line in deleted/added lines
	int otherOp = (linediff[opIndex].op == DiffOp<String>::add ? DiffOp<String>::del : DiffOp<String>::add);
	std::shared_ptr<DiffMapEntry> found = nullptr;
	for (int i = 0; i < linediff.size(); ++i) {
		if (linediff[i].op == otherOp) {
			auto& lines = (linediff[opIndex].op == DiffOp<String>::add ? linediff[i].from : linediff[i].to);
			for (int k = 0; k < lines.size(); ++k) {
				auto it= diffMap.find(makeKey(i, k));
				if(it!=diffMap.end())
				{
					auto found = it->second;
					debugPrintf("found: lhsDisplayed=%s, rhsDisplayed=%s\n", found->lhsDisplayed? "true": "false", found->rhsDisplayed? "true": "false");
					if( (printLeft && found->lhsDisplayed) || (printRight && found->rhsDisplayed) )
					{
						debugPrintf("%chs already displayed, not considering this one", printLeft? 'l': 'r');
						continue;
					}
				}
				WordVector words1, words2;
				std::shared_ptr<DiffMapEntry> tmp;
				textUtil.explodeWords(*lines[k], words1);
				bool potentialMatch = false;
				if (otherOp == DiffOp<String>::del) {
					textUtil.explodeWords(*linediff[opIndex].to[opLine], words2);
					tmp = std::make_shared<DiffMapEntry>(wordDiffConfig, words2, words1, i, k, opIndex, opLine);
					potentialMatch = cmpDiffMapEntries(tmp->opIndexFrom, tmp->opLineFrom);
				} else {
					textUtil.explodeWords(*linediff[opIndex].from[opLine], words2);
					tmp = std::make_shared<DiffMapEntry>(wordDiffConfig, words1, words2, opIndex, opLine, i, k);
					potentialMatch = cmpDiffMapEntries(tmp->opIndexTo, tmp->opLineTo);
				}
				if (!found || (tmp->ds.charSimilarity > found->ds.charSimilarity) && potentialMatch) {
					found= tmp;
				}
			}
		}
	}

	if(found)
		debugPrintf("candidate found with similarity %.2f (from %d:%d to %d:%d)", found->ds.charSimilarity, found->opIndexFrom, found->opLineFrom, found->opIndexTo, found->opLineTo);

	// if candidate exists:
	//     add candidate to moved-line-map twice, for add/del case
	//     print diff to the moved line, omitting the left/right side for added/deleted line
	if (found && found->ds.charSimilarity > config.movedLineThreshold) {
		// if we displayed a diff to the found block before, don't display this one as moved.
		int otherIndex = linediff[opIndex].op == DiffOp<String>::add ? found->opIndexFrom : found->opIndexTo;
		int otherLine = linediff[opIndex].op == DiffOp<String>::add ? found->opLineFrom : found->opLineTo;

		if(!cmpDiffMapEntries(otherIndex, otherLine))
			return false;

		if(diffMap.find(makeKey(otherIndex, otherLine)) != diffMap.end()) {
			debugPrintf("found existing diffMap entry -- not overwriting.");
			return false;
		}

		if(printLeft)
			found->lhsDisplayed = true;
		else
			found->rhsDisplayed = true;

		diffMap[key] = found;
		diffMap[makeKey(otherIndex, otherLine)] = found;
		debugPrintf("inserting (%d,%d) + (%d,%d)", opIndex, opLine, otherIndex, otherLine);

		if(isNext(opIndex, opLine, otherIndex, otherLine)) {
			debugPrintf("This one immediately follows, displaying as change...");
			printWordDiffFromStrings(
				*linediff[found->opIndexFrom].from[found->opLineFrom],
				*linediff[found->opIndexTo].to[found->opLineTo],
				leftLine, rightLine, offsetFrom, offsetTo);
			found->lhsDisplayed = true;
			found->rhsDisplayed = true;
		}
		else {
			// XXXX todo: we already have the diff, don't have to do it again, just have to print it
			printWordDiffFromStrings(*linediff[found->opIndexFrom].from[found->opLineFrom],
				*linediff[found->opIndexTo].to[found->opLineTo],
				leftLine, rightLine, offsetFrom, offsetTo, printLeft, printRight,
				makeAnchorName(opIndex, opLine, printLeft),
				makeAnchorName(otherIndex, otherLine, !printLeft),
				movedir(opIndex,opLine, otherIndex,otherLine));
		}

		debugPrintf("copy: %d, del: %d, add: %d, change: %d, similarity: %.4f\n"
					"from: (%d,%d) to: (%d,%d)",
			found->ds.opCharCount[DiffOp<Word>::copy], found->ds.opCharCount[DiffOp<Word>::del], found->ds.opCharCount[DiffOp<Word>::add], found->ds.opCharCount[DiffOp<Word>::change], found->ds.charSimilarity,
			found->opIndexFrom, found->opLineFrom, found->opIndexTo, found->opLineTo);

		return true;
	}

	return false;
}

void Wikidiff2::explodeLines(const String & text, StringVector &lines)
{
	String::const_iterator ptr = text.begin();
	while (ptr != text.end()) {
		String::const_iterator ptr2 = std::find(ptr, text.end(), '\n');
		lines.push_back(String(ptr, ptr2));

		ptr = ptr2;
		if (ptr != text.end()) {
			++ptr;
		}
	}
}

void Wikidiff2::execute(const String & text1, const String & text2)
{
	// Split input strings into lines
	StringVector lines1;
	StringVector lines2;
	explodeLines(text1, lines1);
	explodeLines(text2, lines2);

	// Do the diff
	StringDiff lineDiff(lineDiffConfig, lines1, lines2);
	printDiff(lineDiff);
}

void Wikidiff2::addFormatter(Formatter & formatter)
{
	formatters.push_back(&formatter);
}

} // namespace wikidiff2
