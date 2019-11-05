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


void Wikidiff2::diffLines(const StringVector & lines1, const StringVector & lines2,
		int numContextLines, int maxMovedLines)
{
	// first do line-level diff
	StringDiff linediff(lines1, lines2);

	int from_index = 1, to_index = 1;

	// Should a line number be printed before the next context line?
	// Set to true initially so we get a line number on line 1
	bool showLineNumber = true;

	if (needsJSONFormat()) {
		result += "{\"diff\": [";
	}

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

					if (!printMovedLineDiff(linediff, i, j, maxMovedLines, from_index, to_index+j,
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

					if (!printMovedLineDiff(linediff, i, j, maxMovedLines, from_index+j, to_index,
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

					if ((i != 0 && j < numContextLines) /*trailing*/
							|| (i != linediff.size() - 1 && j >= n - numContextLines)) /*leading*/ {
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

					printWordDiff(fromLine, toLine, from_index+j, to_index+j,
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

	if (needsJSONFormat()) {
		result.append("]");
		result.append("}");
	}
}

bool Wikidiff2::printMovedLineDiff(StringDiff & linediff, int opIndex, int opLine, int maxMovedLines,
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

		result += "<tr><td /><td class=\"diff-context\" colspan=3>";
		result += ch;
		result += "</td></tr>";
	};
#else
	auto debugPrintf = [](...) { };
#endif

	if(!allowPrintMovedLineDiff(linediff, maxMovedLines)) {
		debugPrintf("printMovedLineDiff: diff too large (maxMovedLines=%ld), not detecting moved lines", maxMovedLines);
		return false;
	}

	debugPrintf("printMovedLineDiff (...), %d, %d\n", opIndex, opLine);

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
			printWordDiff(*linediff[best->opIndexFrom].from[best->opLineFrom],
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
					"from: (%d,%d) to: (%d,%d)\n",
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
					tmp = std::make_shared<DiffMapEntry>(words2, words1, i, k, opIndex, opLine);
					potentialMatch = cmpDiffMapEntries(tmp->opIndexFrom, tmp->opLineFrom);
				} else {
					textUtil.explodeWords(*linediff[opIndex].from[opLine], words2);
					tmp = std::make_shared<DiffMapEntry>(words1, words2, opIndex, opLine, i, k);
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
	if (found && found->ds.charSimilarity > movedLineThreshold()) {
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
			printWordDiff(*linediff[found->opIndexFrom].from[found->opLineFrom],
				*linediff[found->opIndexTo].to[found->opLineTo],
				leftLine, rightLine, offsetFrom, offsetTo);
			found->lhsDisplayed = true;
			found->rhsDisplayed = true;
		}
		else {
			// XXXX todo: we already have the diff, don't have to do it again, just have to print it
			printWordDiff(*linediff[found->opIndexFrom].from[found->opLineFrom],
				*linediff[found->opIndexTo].to[found->opLineTo],
				leftLine, rightLine, offsetFrom, offsetTo, printLeft, printRight,
				makeAnchorName(opIndex, opLine, printLeft),
				makeAnchorName(otherIndex, otherLine, !printLeft),
				movedir(opIndex,opLine, otherIndex,otherLine));
		}

		debugPrintf("copy: %d, del: %d, add: %d, change: %d, similarity: %.4f\n"
					"from: (%d,%d) to: (%d,%d)\n",
			found->ds.opCharCount[DiffOp<Word>::copy], found->ds.opCharCount[DiffOp<Word>::del], found->ds.opCharCount[DiffOp<Word>::add], found->ds.opCharCount[DiffOp<Word>::change], found->ds.charSimilarity,
			found->opIndexFrom, found->opLineFrom, found->opIndexTo, found->opLineTo);

		return true;
	}

	return false;
}

void Wikidiff2::debugPrintWordDiff(WordDiff & worddiff)
{
	for (unsigned i = 0; i < worddiff.size(); ++i) {
		DiffOp<Word> & op = worddiff[i];
		switch (op.op) {
			case DiffOp<Word>::copy:
				result += "Copy\n";
				break;
			case DiffOp<Word>::del:
				result += "Delete\n";
				break;
			case DiffOp<Word>::add:
				result += "Add\n";
				break;
			case DiffOp<Word>::change:
				result += "Change\n";
				break;
		}
		result += "From: ";
		bool first = true;
		for (int j=0; j<op.from.size(); j++) {
			if (first) {
				first = false;
			} else {
				result += ", ";
			}
			result += "(";
			result += op.from[j]->whole() + ")";
		}
		result += "\n";
		result += "To: ";
		first = true;
		for (int j=0; j<op.to.size(); j++) {
			if (first) {
				first = false;
			} else {
				result += ", ";
			}
			result += "(";
			result += op.to[j]->whole() + ")";
		}
		result += "\n\n";
	}
}

void Wikidiff2::printHtmlEncodedText(const String & input)
{
	size_t start = 0;
	size_t end = input.find_first_of("<>&");
	while (end != String::npos) {
		if (end > start) {
			result.append(input, start, end - start);
		}
		switch (input[end]) {
			case '<':
				result.append("&lt;");
				break;
			case '>':
				result.append("&gt;");
				break;
			default /*case '&'*/:
				result.append("&amp;");
		}
		start = end + 1;
		end = input.find_first_of("<>&", start);
	}
	// Append the rest of the string after the last special character
	if (start < input.size()) {
		result.append(input, start, input.size() - start);
	}
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

const Wikidiff2::String & Wikidiff2::execute(const String & text1, const String & text2,
	int numContextLines, int maxMovedLines)
{
	// Allocate some result space to avoid excessive copying
	result.clear();
	result.reserve(text1.size() + text2.size() + 10000);

	// Split input strings into lines
	StringVector lines1;
	StringVector lines2;
	explodeLines(text1, lines1);
	explodeLines(text2, lines2);

	// Do the diff
	diffLines(lines1, lines2, numContextLines, maxMovedLines);

	// Return a reference to the result buffer
	return result;
}

const Wikidiff2::String Wikidiff2::toString(long input)
{
	StringStream stream;
	stream << input;
	return String(stream.str());
}

bool Wikidiff2::needsJSONFormat()
{
	return false;
}
