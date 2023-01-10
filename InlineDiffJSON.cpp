
#include "InlineDiffJSON.h"
#include <string>
#include <sstream>
#include <iomanip>

namespace wikidiff2 {

void InlineDiffJSON::printFileHeader()
{
	result << "{\"diff\": [";
}

void InlineDiffJSON::printFileFooter()
{
	result << "]}";
}

void InlineDiffJSON::printAdd(const String& line, int leftLine, int rightLine,
	int offsetFrom, int offsetTo)
{
	printAddDelete(line, DiffType::AddLine, toString(rightLine), offsetFrom, offsetTo);
}

void InlineDiffJSON::printDelete(const String& line, int leftLine, int rightLine,
	int offsetFrom, int offsetTo)
{
	printAddDelete(line, DiffType::DeleteLine, "", offsetFrom, offsetTo);
}

void InlineDiffJSON::printAddDelete(const String& line, DiffType diffType, const String& lineNumber,
	int offsetFrom, int offsetTo) {
	if (hasResults)
		result << ",";

	String lineNumberJSON = lineNumber.length() == 0 ? "" : ", \"lineNumber\": " + lineNumber;
	result << "{\"type\": " << (int)diffType;
	if (lineNumber.length()) {
		result << ", \"lineNumber\": " << lineNumber;
	}
	result << ", \"text\": \"";
	printEscapedJSON(line);
	result << "\"";
	appendOffset(offsetFrom, offsetTo);
	result << "}";

	hasResults = true;
}

void InlineDiffJSON::printWordDiff(const String& text1, const String& text2, int leftLine,
	int rightLine, int offsetFrom, int offsetTo, bool printLeft, bool printRight,
	const String & srcAnchor, const String & dstAnchor, bool moveDirectionDownwards)
{
	WordVector words1, words2;

	textUtil.explodeWords(text1, words1);
	textUtil.explodeWords(text2, words2);
	WordDiff worddiff(words1, words2, MAX_WORD_LEVEL_DIFF_COMPLEXITY);
	String word;

	bool moved = printLeft != printRight,
	isMoveSrc = moved && printLeft;

	if (hasResults)
		result << ",";
	if (moved) {
		LinkDirection direction = moveDirectionDownwards ? LinkDirection::Down : LinkDirection::Up;
		if (isMoveSrc) {
			result << "{\"type\": " << (int)DiffType::MoveSource
				<< ", \"moveInfo\": "
				<< "{\"id\": \"" << srcAnchor << "\", \"linkId\": \"" << dstAnchor
				<< "\", \"linkDirection\": " << (int)direction << "}"
				<< ", \"text\": \"";
		} else {
			result << "{\"type\": " << (int)DiffType::MoveDestination
				<< ", \"lineNumber\": " << rightLine
				<< ", \"moveInfo\": "
				<< "{\"id\": \"" << srcAnchor << "\", \"linkId\": \"" << dstAnchor
				<< "\", \"linkDirection\": " << (int)direction << "}"
				<< ", \"text\": \"";
		}
	} else {
		result << "{\"type\": " << (int)DiffType::Change
			<< ", \"lineNumber\": " << rightLine 
			<< ", \"text\": \"";
	}
	hasResults = true;

	unsigned int rangeCalcResult = 0;
	String ranges;
	for (unsigned i = 0; i < worddiff.size(); ++i) {
		DiffOp<Word> & op = worddiff[i];
		unsigned long n;
		int j;
		if (op.op == DiffOp<Word>::copy) {
			n = op.from.size();
			for (j=0; j<n; j++) {
				op.from[j]->get_whole(word);
				rangeCalcResult += word.length();
				printEscapedJSON(word);
			}
		} else if (op.op == DiffOp<Word>::del) {
			n = op.from.size();
			unsigned int start = rangeCalcResult;
			unsigned int length = 0;
			for (j=0; j<n; j++) {
				op.from[j]->get_whole(word);

				length += word.length();
				rangeCalcResult += word.length();
				printEscapedJSON(word);
			}

			if (!isMoveSrc) {
				if (ranges.length() > 1)
					ranges.append(",");
				ranges.append("{\"start\": " + toString(start) + ", \"length\": " +
					toString(length) + ", \"type\": " + toString(HighlightType::Delete) +
					" }");
			}
		} else if (op.op == DiffOp<Word>::add) {
			if (isMoveSrc)
				continue;
			n = op.to.size();
			unsigned int start = rangeCalcResult;
			unsigned int length = 0;
			for (j=0; j<n; j++) {
				op.to[j]->get_whole(word);

				length += word.length();
				rangeCalcResult += word.length();
				printEscapedJSON(word);
			}

			if (ranges.length() > 1)
				ranges.append(",");
			ranges.append("{\"start\": " + toString(start) + ", \"length\": " +
				toString(length) + ", \"type\": " + toString(HighlightType::Add) + " }");

		} else if (op.op == DiffOp<Word>::change) {
			n = op.from.size();
			unsigned int start = rangeCalcResult;
			unsigned int length = 0;
			for (j=0; j<n; j++) {
				op.from[j]->get_whole(word);

				length += word.length();
				rangeCalcResult += word.length();
				printEscapedJSON(word);
			}

			if (!isMoveSrc) {
				if (ranges.length() > 1)
					ranges.append(",");
				ranges.append("{\"start\": " + toString(start) + ", \"length\": " +
					toString(length) + ", \"type\": " + toString(HighlightType::Delete) +
					" }");
			}

			if (isMoveSrc)
				continue;
			n = op.to.size();
			start = rangeCalcResult;
			length = 0;
			for (j=0; j<n; j++) {
				op.to[j]->get_whole(word);

				length += word.length();
				rangeCalcResult += word.length();

				printEscapedJSON(word);
			}

			if (ranges.length() > 1)
				ranges.append(",");
			ranges.append("{\"start\": " + toString(start) + ", \"length\": " +
				toString(length) + ", \"type\": " + toString(HighlightType::Add) + " }");
		}
	}

	result << "\"";
	appendOffset(offsetFrom, offsetTo);
	if (moved && isMoveSrc) {
		result << "}";
	} else {
		result << ", \"highlightRanges\": [" << ranges << "]}";
	}
}

void InlineDiffJSON::printBlockHeader(int leftLine, int rightLine)
{
	//inline diff json not setup to print this
}

void InlineDiffJSON::printContext(const String & input, int leftLine, int rightLine,
	int offsetFrom, int offsetTo)
{
	if (hasResults)
		result << ",";

	result << "{\"type\": " << (int)DiffType::Context
		<< ", \"lineNumber\": " << rightLine << ", \"text\": \"";
	printEscapedJSON(input);
	result << "\"";
	appendOffset(offsetFrom, offsetTo);
	result << "}";
	hasResults = true;
}

void InlineDiffJSON::printEscapedJSON(const String &s) {
	for (auto c = s.cbegin(); c != s.cend(); c++) {
		switch (*c) {
			case '"': result << "\\\""; break;
			case '\\': result << "\\\\"; break;
			case '\b': result << "\\b"; break;
			case '\f': result << "\\f"; break;
			case '\n': result << "\\n"; break;
			case '\r': result << "\\r"; break;
			case '\t': result << "\\t"; break;
			default:
			if ('\x00' <= *c && *c <= '\x1f') {
				char origFill = result.fill();
				result << "\\u"
					<< std::hex << std::setw(4) << std::setfill('0') << (int)*c
					<< std::setfill(origFill) << std::dec;
			} else {
				result << *c;
			}
		}
	}
}

void InlineDiffJSON::appendOffset(int offsetFrom, int offsetTo) {
	result << ", \"offset\": {"
		<< "\"from\": ";
	if (offsetFrom > -1) {
		result << offsetFrom;
	} else {
		result << "null";
	}
	result << ",\"to\": ";
	if (offsetTo > -1) {
		result << offsetTo;
	} else {
		result << "null";
	}
	result << "}";
}

} // namespace wikidiff2
