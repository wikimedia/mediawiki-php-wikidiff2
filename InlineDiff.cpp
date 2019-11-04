#include "InlineDiff.h"

void InlineDiff::printAdd(const String& line, int leftLine, int rightLine,
	int sectionTitleIndex)
{
	if(line.empty()) {
		printWrappedLine("<div class=\"mw-diff-inline-added mw-diff-empty-line\"><ins>", line, "</ins></div>\n");
	} else {
		printWrappedLine("<div class=\"mw-diff-inline-added\"><ins>", line, "</ins></div>\n");
	}
}

void InlineDiff::printDelete(const String& line, int leftLine, int rightLine,
	int sectionTitleIndex)
{
	if(line.empty()) {
		printWrappedLine("<div class=\"mw-diff-inline-deleted mw-diff-empty-line\"><del>", line, "</del></div>\n");
	} else {
		printWrappedLine("<div class=\"mw-diff-inline-deleted\"><del>", line, "</del></div>\n");
	}
}

void InlineDiff::printWordDiff(const String& text1, const String& text2, int leftLine, int rightLine,
	int sectionTitleIndex, bool printLeft, bool printRight, const String & srcAnchor,
	const String & dstAnchor, bool moveDirectionDownwards)
{
	WordVector words1, words2;

	TextUtil::explodeWords(text1, words1);
	TextUtil::explodeWords(text2, words2);
	WordDiff worddiff(words1, words2, MAX_WORD_LEVEL_DIFF_COMPLEXITY);
	String word;

	bool moved = printLeft != printRight,
		 isMoveSrc = moved && printLeft,
		 isMoveDest = moved && printRight;

	if (moved) {
		result += String("<div class=\"mw-diff-inline-moved mw-diff-inline-moved-") +
			(printLeft ? "source" : "destination") + " mw-diff-inline-moved-" +
			(moveDirectionDownwards ? "downwards" : "upwards") + "\">";
		result += "<a name=\"" + srcAnchor + "\"></a>";
		if (!moveDirectionDownwards) {
			result += "<a class=\"mw-diff-movedpara-" +
				String(printLeft ? "left" : "right") + "\" data-title-tag=\"" +
				(printRight ? "new" : "old") + "\" href=\"#" + dstAnchor + "\">" + "&#9650;" + "</a>";
		}
	} else {
		result += "<div class=\"mw-diff-inline-changed\">";
	}

	for (unsigned i = 0; i < worddiff.size(); ++i) {
		DiffOp<Word> & op = worddiff[i];
		int n, j;
		if (op.op == DiffOp<Word>::copy) {
			n = op.from.size();
			for (j=0; j<n; j++) {
				op.from[j]->get_whole(word);
				printHtmlEncodedText(word);
			}
		} else if (op.op == DiffOp<Word>::del) {
			n = op.from.size();
			if (!isMoveSrc)
				result += "<del>";
			for (j=0; j<n; j++) {
				op.from[j]->get_whole(word);
				printHtmlEncodedText(word);
			}
			if (!isMoveSrc)
				result += "</del>";
		} else if (op.op == DiffOp<Word>::add) {
			if (isMoveSrc)
				continue;
			n = op.to.size();
			result += "<ins>";
			for (j=0; j<n; j++) {
				op.to[j]->get_whole(word);
				printHtmlEncodedText(word);
			}
			result += "</ins>";
		} else if (op.op == DiffOp<Word>::change) {
			n = op.from.size();
			if (!isMoveSrc)
				result += "<del>";
			for (j=0; j<n; j++) {
				op.from[j]->get_whole(word);
				printHtmlEncodedText(word);
			}
			if (isMoveSrc)
				continue;
			result += "</del>";
			n = op.to.size();
			result += "<ins>";
			for (j=0; j<n; j++) {
				op.to[j]->get_whole(word);
				printHtmlEncodedText(word);
			}
			result += "</ins>";
		}
	}
	if (moved && moveDirectionDownwards) {
		result += "<a class=\"mw-diff-movedpara-" +
			String(printLeft ? "left" : "right") + "\" data-title-tag=\"" +
			(printRight ? "new" : "old") + "\" href=\"#" + dstAnchor + "\">" + "&#9660;" + "</a>";
	}
	result += "</div>\n";
}

void InlineDiff::printBlockHeader(int leftLine, int rightLine)
{
	char buf[256]; // should be plenty
	snprintf(buf, sizeof(buf),
		"<div class=\"mw-diff-inline-header\"><!-- LINES %u,%u --></div>\n",
		leftLine, rightLine);
	result += buf;
}

void InlineDiff::printContext(const String & input, int leftLine, int rightLine,
	int sectionTitleIndex)
{
	printWrappedLine("<div class=\"mw-diff-inline-context\">", input, "</div>\n");
}

void InlineDiff::printWrappedLine(const char* pre, const String& line, const char* post)
{
	result += pre;
	if (line.empty()) {
		result += "&#160;";
	} else {
		printHtmlEncodedText(line);
	}
	result += post;
}
