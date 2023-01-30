#include "TableFormatter.h"

namespace wikidiff2 {

const char * TableFormatter::getName()
{
	return "table";
}

void TableFormatter::printAdd(const String & line, int leftLine, int rightLine, int offsetFrom,
	int offsetTo)
{
	result << "<tr>\n"
		"  <td colspan=\"2\" class=\"diff-empty diff-side-deleted\"></td>\n"
		"  <td class=\"diff-marker\" data-marker=\"+\"></td>\n"
		"  <td class=\"diff-addedline diff-side-added\">";
	printTextWithDiv(line);
	result << "</td>\n</tr>\n";
}

void TableFormatter::printDelete(const String & line, int leftLine, int rightLine, int offsetFrom,
	int offsetTo)
{
	result << "<tr>\n"
		"  <td class=\"diff-marker\" data-marker=\"−\"></td>\n"
		"  <td class=\"diff-deletedline diff-side-deleted\">";
	printTextWithDiv(line);
	result << "</td>\n"
		"  <td colspan=\"2\" class=\"diff-empty diff-side-added\"></td>\n"
		"</tr>\n";
}

void TableFormatter::printWordDiff(const WordDiff & worddiff, int leftLine,
	int rightLine, int offsetFrom, int offsetTo, bool printLeft, bool printRight,
	const String & srcAnchor, const String & dstAnchor, bool moveDirectionDownwards)
{
	result << "<tr>\n";

	// print left side or blank placeholder.
	if (printLeft) {
		if(dstAnchor != "")
			result << "  <td class=\"diff-marker\">"
			    "<a class=\"mw-diff-movedpara-left\" href=\"#" << dstAnchor << "\">&#x26AB;</a>"
			    "</td>\n";
		else
			result << "  <td class=\"diff-marker\" data-marker=\"−\"></td>\n";

		result << "  <td class=\"diff-deletedline diff-side-deleted\"><div>";
		if(srcAnchor != "")
			result << "<a name=\"" << srcAnchor << "\"></a>";
		printWordDiffSide(worddiff, false);
		result << "</div></td>\n";
	} else {
		result << "  <td colspan=\"2\" class=\"diff-empty diff-side-deleted\"></td>\n";
	}

	// print right side or blank placeholder.
	if (printRight) {
		if(dstAnchor != "")
			result << "  <td class=\"diff-marker\">"
			    "<a class=\"mw-diff-movedpara-right\" href=\"#" << dstAnchor << "\">&#x26AB;</a>"
			    "</td>\n";
		else
			result << "  <td class=\"diff-marker\" data-marker=\"+\"></td>\n";

		result << "  <td class=\"diff-addedline diff-side-added\"><div>";
		if(srcAnchor != "")
			result << "<a name=\"" << srcAnchor << "\"></a>";
		printWordDiffSide(worddiff, true);
		result << "</div></td>\n"
			"</tr>\n";
	} else {
		result << "  <td colspan=\"2\" class=\"diff-empty diff-side-added\"></td>\n"
			"</tr>\n";
	}
}

bool TableFormatter::isNewlineMarker(const DiffOp<Word> & op)
{
	return op.op == DiffOp<Word>::add
		&& op.to.size() == 1
		&& op.to[0]->isNewline();
}

size_t TableFormatter::printWordDiffSegment(const WordDiff &worddiff, size_t offset, bool added)
{
	for (size_t i = offset; i < worddiff.size(); ++i) {
		const DiffOp<Word> & op = worddiff[i];
		int n, j;
		if (added && isNewlineMarker(op)) {
			// If the line break is at the end of the word diff, we need to add
			// a blank line to the output. However if we are at the start of the
			// segment, we've already done the blank output.
			return (i > offset && i == worddiff.size() - 1) ? i : i + 1;
		}
		if (op.op == DiffOp<Word>::copy) {
			n = op.from.size();
			if (added) {
				for (j=0; j<n; j++) {
					printHtmlEncodedText(*op.to[j]);
				}
			} else {
				for (j=0; j<n; j++) {
					printHtmlEncodedText(*op.from[j]);
				}
			}
		} else if (!added && (op.op == DiffOp<Word>::del || op.op == DiffOp<Word>::change)) {
			n = op.from.size();
			result << "<del class=\"diffchange diffchange-inline\">";
			for (j=0; j<n; j++) {
				printHtmlEncodedText(*op.from[j]);
			}
			result << "</del>";
		} else if (added && (op.op == DiffOp<Word>::add || op.op == DiffOp<Word>::change)) {
			n = op.to.size();
			result << "<ins class=\"diffchange diffchange-inline\">";
			for (j=0; j<n; j++) {
				printHtmlEncodedText(*op.to[j]);
			}
			result << "</ins>";
		}
	}
	return worddiff.size();
}

void TableFormatter::printConcatDiff(const WordDiff & wordDiff, 
	int leftLine, int rightLine, 
	int offsetFrom, int offsetTo)
{
	size_t segmentStart = 0;
	do {
		result << "<tr>\n";

		// print left side or blank placeholder.
		if (segmentStart == 0) {
			result << "  <td class=\"diff-marker\" data-marker=\"−\"></td>\n"
				<< "  <td class=\"diff-deletedline diff-side-deleted\"><div>";
			printWordDiffSegment(wordDiff, 0, false);
			result << "</div></td>\n";
		} else {
			result << "  <td colspan=\"2\" class=\"diff-empty diff-side-deleted\"></td>\n";
		}

		// print right side
		result << "  <td class=\"diff-marker\" data-marker=\"+\"></td>\n"
			<< "  <td class=\"diff-addedline diff-side-added\"><div>";
		segmentStart = printWordDiffSegment(wordDiff, segmentStart, true);
		result << "</div></td>\n"
			"</tr>\n";
	} while (segmentStart < wordDiff.size());
}

void TableFormatter::printTextWithDiv(const String & input)
{
	// Wrap string in a <div> if it's not empty
	if (input.size() > 0) {
		result << "<div>";
		printHtmlEncodedText(input);
		result << "</div>";
	} else {
		// Else add a <br> to preserve line breaks when copying
		result << "<br />";
	}
}

void TableFormatter::printBlockHeader(int leftLine, int rightLine)
{
	result << "<tr>\n"
		"  <td colspan=\"2\" class=\"diff-lineno\"><!--LINE " << leftLine << "--></td>\n"
		"  <td colspan=\"2\" class=\"diff-lineno\"><!--LINE " << rightLine << "--></td>\n"
		"</tr>\n";
}

void TableFormatter::printContext(const String & input, int leftLine, int rightLine, int offsetFrom,
	int offsetTo)
{
	result <<
		"<tr>\n"
		"  <td class=\"diff-marker\"></td>\n"
		"  <td class=\"diff-context diff-side-deleted\">";
	printTextWithDiv(input);
	result <<
		"</td>\n"
		"  <td class=\"diff-marker\"></td>\n"
		"  <td class=\"diff-context diff-side-added\">";
	printTextWithDiv(input);
	result << "</td>\n</tr>\n";
}

} // namespace wikidiff2
