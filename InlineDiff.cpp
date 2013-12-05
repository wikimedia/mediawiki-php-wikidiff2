#include "InlineDiff.h"

void InlineDiff::printAdd(const String& line)
{
	printWrappedLine("<div class=\"mw-diff-inline-added\"><ins>", line, "</ins></div>\n");
}

void InlineDiff::printDelete(const String& line)
{
	printWrappedLine("<div class=\"mw-diff-inline-deleted\"><del>", line, "</del></div>\n");
}

void InlineDiff::printWordDiff(const String& text1, const String& text2)
{
	WordVector words1, words2;

	explodeWords(text1, words1);
	explodeWords(text2, words2);
	WordDiff worddiff(words1, words2);
	String word;

	result += "<div class=\"mw-diff-inline-changed\">";
	for (unsigned i = 0; i < worddiff.size(); ++i) {
		DiffOp<Word> & op = worddiff[i];
		int n, j;
		if (op.op == DiffOp<Word>::copy) {
			n = op.from.size();
			for (j=0; j<n; j++) {
				op.from[j]->get_whole(word);
				printText(word);
			}
		} else if (op.op == DiffOp<Word>::del) {
			n = op.from.size();
			result += "<del>";
			for (j=0; j<n; j++) {
				op.from[j]->get_whole(word);
				printText(word);
			}
			result += "</del>";
		} else if (op.op == DiffOp<Word>::add) {
			n = op.to.size();
			result += "<ins>";
			for (j=0; j<n; j++) {
				op.to[j]->get_whole(word);
				printText(word);
			}
			result += "</ins>";
		} else if (op.op == DiffOp<Word>::change) {
			n = op.from.size();
			result += "<del>";
			for (j=0; j<n; j++) {
				op.from[j]->get_whole(word);
				printText(word);
			}
			result += "</del>";
			n = op.to.size();
			result += "<ins>";
			for (j=0; j<n; j++) {
				op.to[j]->get_whole(word);
				printText(word);
			}
			result += "</ins>";
		}
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

void InlineDiff::printContext(const String & input)
{
	printWrappedLine("<div class=\"mw-diff-inline-context\">", input, "</div>\n");
}

void InlineDiff::printWrappedLine(const char* pre, const String& line, const char* post)
{
	result += pre;
	if (line.empty()) {
		result += "&#160;";
	} else {
		printText(line);
	}
	result += post;
}
