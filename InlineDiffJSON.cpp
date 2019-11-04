
#include "InlineDiffJSON.h"
#include <string>
#include <sstream>
#include <iomanip>

void InlineDiffJSON::printAdd(const String& line, int leftLine, int rightLine,
	const int sectionTitleIndex)
{
	printAddDelete(line, DiffType::AddLine, toString(rightLine), sectionTitleIndex);
}

void InlineDiffJSON::printDelete(const String& line, int leftLine, int rightLine,
	const int sectionTitleIndex)
{
	printAddDelete(line, DiffType::DeleteLine, "", sectionTitleIndex);
}

void InlineDiffJSON::printAddDelete(const String& line, DiffType diffType, const String& lineNumber,
	const int sectionTitleIndex) {
	if (hasResults)
		result.append(",");

	String lineNumberJSON = lineNumber.length() == 0 ? "" : ", \"lineNumber\": " + lineNumber;
	String preStr = "{\"type\": " + toString(diffType) + lineNumberJSON + ", \"text\": ";
	result.append(preStr + "\"");
	printEscapedJSON(line);

	result.append("\"");
	appendSectionTitleIndex(sectionTitleIndex);
	result.append("}");

	hasResults = true;
}

void InlineDiffJSON::printWordDiff(const String& text1, const String& text2, int leftLine,
	int rightLine, const int sectionTitleIndex, bool printLeft, bool printRight,
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
		result.append(",");
	if (moved) {
		String moveObject;
		if (isMoveSrc) {
			LinkDirection direction = moveDirectionDownwards ? LinkDirection::Down : LinkDirection::Up;
			moveObject = "{\"id\": \"" + srcAnchor + "\", \"linkId\": \"" + dstAnchor +
				"\", \"linkDirection\": " + toString(direction) + "}";
			result.append("{\"type\": " + toString(DiffType::MoveSource) +
			", \"moveInfo\": " + moveObject + ", \"text\": \"");
		} else {
			LinkDirection direction = moveDirectionDownwards ? LinkDirection::Down : LinkDirection::Up;
			moveObject = "{\"id\": \"" + srcAnchor + "\", \"linkId\": \"" + dstAnchor +
				"\", \"linkDirection\": " + toString(direction) + "}";
			result.append("{\"type\": " + toString(DiffType::MoveDestination) + ", \"lineNumber\": " +
				toString(rightLine) + ", \"moveInfo\": " + moveObject + ", \"text\": \"");
		}
	} else {
		result.append("{\"type\": " + toString(DiffType::Change) + ", \"lineNumber\": " +
			toString(rightLine) + ", \"text\": \"");
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

	result.append("\"");
	appendSectionTitleIndex(sectionTitleIndex);
	if (moved && isMoveSrc) {
		result.append("}");
	} else {
		result.append(", \"highlightRanges\": [" + ranges + "]}");
	}

}

void InlineDiffJSON::printBlockHeader(int leftLine, int rightLine)
{
	//inline diff json not setup to print this
}

void InlineDiffJSON::printContext(const String & input, int leftLine,
	int rightLine, const int sectionTitleIndex)
{
	if (hasResults)
		result.append(",");

	String preString = "{\"type\": " + toString(DiffType::Context) + ", \"lineNumber\": " +
		toString(rightLine) + ", \"text\": ";

	result.append(preString + "\"");
	printEscapedJSON(input);
	result.append("\"");
	appendSectionTitleIndex(sectionTitleIndex);
	result.append("}");
	hasResults = true;
}

void InlineDiffJSON::printEscapedJSON(const String &s) {
	for (auto c = s.cbegin(); c != s.cend(); c++) {
		switch (*c) {
			case '"': result.append("\\\""); break;
			case '\\': result.append("\\\\"); break;
			case '\b': result.append("\\b"); break;
			case '\f': result.append("\\f"); break;
			case '\n': result.append("\\n"); break;
			case '\r': result.append("\\r"); break;
			case '\t': result.append("\\t"); break;
			default:
			if ('\x00' <= *c && *c <= '\x1f') {
				StringStream o;
				o << "\\u"
				<< std::hex << std::setw(4) << std::setfill('0') << (int)*c;
				result.append(o.str());
			} else {
				result += *c;
			}
		}
	}
}

void InlineDiffJSON::appendSectionTitleIndex(const int sectionTitleIndex) {
	if (sectionTitleIndex > -1) {
		result.append(", \"sectionTitleIndex\": ");
		result.append(toString(sectionTitleIndex));
	}
}

bool InlineDiffJSON::needsJSONFormat()
{
	return true;
}

void InlineDiffJSON::printSectionTitles(const StringVector & sectionTitles) {
	result.append(", \"sectionTitles\": [");
	int i = 0;
	for(const String & sectionTitle : sectionTitles) {
		if (i > 0)
			result.append(",");

		result.append("\"");
		printEscapedJSON(sectionTitle);
		result.append("\"");
		i++;
	}
	result.append("]");
}
