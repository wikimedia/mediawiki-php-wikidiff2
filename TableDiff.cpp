#include <stdio.h>
#include "Wikidiff2.h"
#include "TableDiff.h"

namespace wikidiff2 {

void TableDiff::printAdd(const String & line, int leftLine, int rightLine, int offsetFrom,
	int offsetTo)
{
	result << "<tr>\n"
		"  <td colspan=\"2\" class=\"diff-empty diff-side-deleted\"></td>\n"
		"  <td class=\"diff-marker\" data-marker=\"+\"></td>\n"
		"  <td class=\"diff-addedline diff-side-added\">";
	printTextWithDiv(line);
	result << "</td>\n</tr>\n";
}

void TableDiff::printDelete(const String & line, int leftLine, int rightLine, int offsetFrom,
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

void TableDiff::printWordDiff(const String & text1, const String & text2, int leftLine,
	int rightLine, int offsetFrom, int offsetTo, bool printLeft, bool printRight,
	const String & srcAnchor, const String & dstAnchor, bool moveDirectionDownwards)
{
	WordVector words1, words2;

	textUtil.explodeWords(text1, words1);
	textUtil.explodeWords(text2, words2);
	WordDiff worddiff(words1, words2, MAX_WORD_LEVEL_DIFF_COMPLEXITY);

	//debugPrintWordDiff(worddiff);

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

void TableDiff::printWordDiffSide(WordDiff &worddiff, bool added)
{
	String word;
	for (unsigned i = 0; i < worddiff.size(); ++i) {
		DiffOp<Word> & op = worddiff[i];
		int n, j;
		if (op.op == DiffOp<Word>::copy) {
			n = op.from.size();
			if (added) {
				for (j=0; j<n; j++) {
					op.to[j]->get_whole(word);
					printHtmlEncodedText(word);
				}
			} else {
				for (j=0; j<n; j++) {
					op.from[j]->get_whole(word);
					printHtmlEncodedText(word);
				}
			}
		} else if (!added && (op.op == DiffOp<Word>::del || op.op == DiffOp<Word>::change)) {
			n = op.from.size();
			result << "<del class=\"diffchange diffchange-inline\">";
			for (j=0; j<n; j++) {
				op.from[j]->get_whole(word);
				printHtmlEncodedText(word);
			}
			result << "</del>";
		} else if (added && (op.op == DiffOp<Word>::add || op.op == DiffOp<Word>::change)) {
			n = op.to.size();
			result << "<ins class=\"diffchange diffchange-inline\">";
			for (j=0; j<n; j++) {
				op.to[j]->get_whole(word);
				printHtmlEncodedText(word);
			}
			result << "</ins>";
		}
	}
}

void TableDiff::printTextWithDiv(const String & input)
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

void TableDiff::printBlockHeader(int leftLine, int rightLine)
{
	result << "<tr>\n"
		"  <td colspan=\"2\" class=\"diff-lineno\"><!--LINE " << leftLine << "--></td>\n"
		"  <td colspan=\"2\" class=\"diff-lineno\"><!--LINE " << rightLine << "--></td>\n"
		"</tr>\n";
}

void TableDiff::printContext(const String & input, int leftLine, int rightLine, int offsetFrom,
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
