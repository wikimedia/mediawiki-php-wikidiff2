#include "InlineFormatter.h"

namespace wikidiff2 {

const char * InlineFormatter::getName()
{
	return "inline";
}

void InlineFormatter::printAdd(const String& line, int leftLine, int rightLine, int offsetFrom,
	int offsetTo)
{
	if(line.empty()) {
		printWrappedLine("<div class=\"mw-diff-inline-added mw-diff-empty-line\"><ins>", line, "</ins></div>\n");
	} else {
		printWrappedLine("<div class=\"mw-diff-inline-added\"><ins>", line, "</ins></div>\n");
	}
}

void InlineFormatter::printDelete(const String& line, int leftLine, int rightLine,
	int offsetFrom, int offsetTo)
{
	if(line.empty()) {
		printWrappedLine("<div class=\"mw-diff-inline-deleted mw-diff-empty-line\"><del>", line, "</del></div>\n");
	} else {
		printWrappedLine("<div class=\"mw-diff-inline-deleted\"><del>", line, "</del></div>\n");
	}
}

void InlineFormatter::printWordDiff(const WordDiff & worddiff, int leftLine, int rightLine,
	int offsetFrom, int offsetTo, bool printLeft, bool printRight,
	const String & srcAnchor, const String & dstAnchor, bool moveDirectionDownwards)
{
	bool moved = printLeft != printRight,
		 isMoveSrc = moved && printLeft,
		 isMoveDest = moved && printRight;

	if (moved) {
		result << "<div class=\"mw-diff-inline-moved mw-diff-inline-moved-"
			<< (printLeft ? "source" : "destination")
			<< " mw-diff-inline-moved-"
			<< (moveDirectionDownwards ? "downwards" : "upwards")
			<< "\">";
		result << "<a name=\"" << srcAnchor << "\"></a>";
		if (!moveDirectionDownwards) {
			result << "<a class=\"mw-diff-movedpara-"
				<< (printLeft ? "left" : "right")
				<< "\" data-title-tag=\"" << (printRight ? "new" : "old")
				<< "\" href=\"#" << dstAnchor << "\">&#9650;</a>";
		}
	} else {
		result << "<div class=\"mw-diff-inline-changed\">";
	}

	for (unsigned i = 0; i < worddiff.size(); ++i) {
		const DiffOp<Word> & op = worddiff[i];
		int n, j;
		if (op.op == DiffOp<Word>::copy) {
			n = op.from.size();
			for (j=0; j<n; j++) {
				printHtmlEncodedText(*op.from[j]);
			}
		} else if (op.op == DiffOp<Word>::del) {
			n = op.from.size();
			if (!isMoveSrc)
				result << "<del>";
			for (j=0; j<n; j++) {
				printHtmlEncodedText(*op.from[j]);
			}
			if (!isMoveSrc)
				result << "</del>";
		} else if (op.op == DiffOp<Word>::add) {
			if (isMoveSrc)
				continue;
			n = op.to.size();
			result << "<ins>";
			for (j=0; j<n; j++) {
				printHtmlEncodedText(*op.to[j]);
			}
			result << "</ins>";
		} else if (op.op == DiffOp<Word>::change) {
			n = op.from.size();
			if (!isMoveSrc)
				result << "<del>";
			for (j=0; j<n; j++) {
				printHtmlEncodedText(*op.from[j]);
			}
			if (isMoveSrc)
				continue;
			result << "</del>";
			n = op.to.size();
			result << "<ins>";
			for (j=0; j<n; j++) {
				printHtmlEncodedText(*op.to[j]);
			}
			result << "</ins>";
		}
	}
	if (moved && moveDirectionDownwards) {
		result << "<a class=\"mw-diff-movedpara-"
			<< (printLeft ? "left" : "right") << "\" data-title-tag=\""
			<< (printRight ? "new" : "old") << "\" href=\"#" << dstAnchor << "\">&#9660;</a>";
	}
	result << "</div>\n";
}

void InlineFormatter::printBlockHeader(int leftLine, int rightLine)
{
	result << "<div class=\"mw-diff-inline-header\"><!-- LINES "
		<< leftLine << "," << rightLine << " --></div>\n";
}

void InlineFormatter::printContext(const String & input, int leftLine, int rightLine,
	int offsetFrom, int offsetTo)
{
	printWrappedLine("<div class=\"mw-diff-inline-context\">", input, "</div>\n");
}

/**
 * HTML-encode and output a line with some text before and after it
 */
void InlineFormatter::printWrappedLine(const char* pre, const String& line, const char* post)
{
	result << pre;
	if (line.empty()) {
		result << "&#160;";
	} else {
		printHtmlEncodedText(line);
	}
	result << post;
}

void InlineFormatter::printConcatDiff(
	const WordDiff & wordDiff,
	int leftLine, int rightLine,
	int offsetFrom, int offsetTo)
{
	result << "<div class=\"mw-diff-inline-changed\">";

	for (unsigned i = 0; i < wordDiff.size(); ++i) {
		const DiffOp<Word> & op = wordDiff[i];
		int n, j;
		if (isNewlineMarker(op)) {
			printNewlineMarker();
		} else if (op.op == DiffOp<Word>::copy) {
			n = op.from.size();
			for (j=0; j<n; j++) {
				printHtmlEncodedText(*op.from[j]);
			}
		} else if (op.op == DiffOp<Word>::del) {
			n = op.from.size();
			result << "<del>";
			for (j=0; j<n; j++) {
				printHtmlEncodedText(*op.from[j]);
			}
			result << "</del>";
		} else if (op.op == DiffOp<Word>::add) {
			n = op.to.size();
			result << "<ins>";
			for (j=0; j<n; j++) {
				printHtmlEncodedText(*op.to[j]);
			}
			result << "</ins>";
		} else if (op.op == DiffOp<Word>::change) {
			n = op.from.size();
			result << "<del>";
			for (j=0; j<n; j++) {
				printHtmlEncodedText(*op.from[j]);
			}
			result << "</del>";
			n = op.to.size();
			result << "<ins>";
			for (j=0; j<n; j++) {
				printHtmlEncodedText(*op.to[j]);
			}
			result << "</ins>";
		}
	}
	result << "</div>\n";
}

void InlineFormatter::printNewlineMarker() {
	result << "<span class=\"mw-inline-diff-newline\"></span><br>";
}

} // namespace wikidiff2
