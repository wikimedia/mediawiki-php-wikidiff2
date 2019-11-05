#include <stdio.h>
#include "Wikidiff2.h"
#include "TableDiff.h"

void TableDiff::printAdd(const String & line, int leftLine, int rightLine, int sectionTitleIndex)
{
	result += "<tr>\n"
		"  <td colspan=\"2\" class=\"diff-empty\">&#160;</td>\n"
		"  <td class=\"diff-marker\">+</td>\n"
		"  <td class=\"diff-addedline\">";
	printTextWithDiv(line);
	result += "</td>\n</tr>\n";
}

void TableDiff::printDelete(const String & line, int leftLine, int rightLine, int sectionTitleIndex)
{
	result += "<tr>\n"
		"  <td class=\"diff-marker\">−</td>\n"
		"  <td class=\"diff-deletedline\">";
	printTextWithDiv(line);
	result += "</td>\n"
		"  <td colspan=\"2\" class=\"diff-empty\">&#160;</td>\n"
		"</tr>\n";
}

void TableDiff::printWordDiff(const String & text1, const String & text2, int leftLine,
	int rightLine, int sectionTitleIndex, bool printLeft, bool printRight,
	const String & srcAnchor, const String & dstAnchor, bool moveDirectionDownwards)
{
	WordVector words1, words2;

	textUtil.explodeWords(text1, words1);
	textUtil.explodeWords(text2, words2);
	WordDiff worddiff(words1, words2, MAX_WORD_LEVEL_DIFF_COMPLEXITY);

	//debugPrintWordDiff(worddiff);

	result += "<tr>\n";

	// print left side or blank placeholder.
	if (printLeft) {
		result += "  <td class=\"diff-marker\">";
		if(dstAnchor != "")
			result += "<a class=\"mw-diff-movedpara-left\" href=\"#" + dstAnchor + "\">&#x26AB;</a>";
		else
			result += "−";
		result += "</td>\n";
		result += "  <td class=\"diff-deletedline\"><div>";
		if(srcAnchor != "")
			result += "<a name=\"" + srcAnchor + "\"></a>";
		printWordDiffSide(worddiff, false);
		result += "</div></td>\n";
	} else {
		result += "  <td colspan=\"2\" class=\"diff-empty\">&#160;</td>\n";
	}

	// print right side or blank placeholder.
	if (printRight) {
		result += "  <td class=\"diff-marker\">";
		if(dstAnchor != "")
			result += "<a class=\"mw-diff-movedpara-right\" href=\"#" + dstAnchor + "\">&#x26AB;</a>";
		else
			result += "+";
		result += "</td>\n";
		result += "  <td class=\"diff-addedline\"><div>";
		if(srcAnchor != "")
			result += "<a name=\"" + srcAnchor + "\"></a>";
		printWordDiffSide(worddiff, true);
		result += "</div></td>\n"
			"</tr>\n";
	} else {
		result += "  <td colspan=\"2\" class=\"diff-empty\">&#160;</td>\n"
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
			result += "<del class=\"diffchange diffchange-inline\">";
			for (j=0; j<n; j++) {
				op.from[j]->get_whole(word);
				printHtmlEncodedText(word);
			}
			result += "</del>";
		} else if (added && (op.op == DiffOp<Word>::add || op.op == DiffOp<Word>::change)) {
			n = op.to.size();
			result += "<ins class=\"diffchange diffchange-inline\">";
			for (j=0; j<n; j++) {
				op.to[j]->get_whole(word);
				printHtmlEncodedText(word);
			}
			result += "</ins>";
		}
	}
}

void TableDiff::printTextWithDiv(const String & input)
{
	// Wrap string in a <div> if it's not empty
	if (input.size() > 0) {
		result.append("<div>");
		printHtmlEncodedText(input);
		result.append("</div>");
	}
}

void TableDiff::printBlockHeader(int leftLine, int rightLine)
{
	char buf[256]; // should be plenty
	snprintf(buf, sizeof(buf),
		"<tr>\n"
		"  <td colspan=\"2\" class=\"diff-lineno\"><!--LINE %u--></td>\n"
		"  <td colspan=\"2\" class=\"diff-lineno\"><!--LINE %u--></td>\n"
		"</tr>\n",
		leftLine, rightLine);
	result += buf;
}

void TableDiff::printContext(const String & input, int leftLine, int rightLine, int sectionTitleIndex)
{
	result +=
		"<tr>\n"
		"  <td class=\"diff-marker\">&#160;</td>\n"
		"  <td class=\"diff-context\">";
	printTextWithDiv(input);
	result +=
		"</td>\n"
		"  <td class=\"diff-marker\">&#160;</td>\n"
		"  <td class=\"diff-context\">";
	printTextWithDiv(input);
	result += "</td>\n</tr>\n";
}
