
#ifndef INLINEJSONFORMATTER_H
#define INLINEJSONFORMATTER_H

#include <stdio.h>

#include "Formatter.h"

namespace wikidiff2 {

class InlineJSONFormatter: public Formatter {
public:
	bool hasResults = false;

private:
	enum DiffType {Context, AddLine, DeleteLine, Change, MoveSource, MoveDestination};
	enum HighlightType {Add, Delete};
	enum LinkDirection {Down, Up};

public:
	const char * getName() override;

	void printFileHeader() override;
	void printFileFooter() override;
	void printAdd(const String& line, int leftLine, int rightLine, int offsetFrom,
		int offsetTo) override;
	void printDelete(const String& line, int leftLine, int rightLine, int offsetFrom,
		int offsetTo) override;

	void printWordDiff(
		const WordDiff & wordDiff,
		int leftLine, int rightLine,
		int offsetFrom, int offsetTo,
		bool printLeft = true, bool printRight = true,
		const String & srcAnchor = "", const String & dstAnchor = "",
		bool moveDirectionDownwards = false) override;

	void printBlockHeader(int leftLine, int rightLine) override;
	void printContext(const String& input, int leftLine, int rightLine, int offsetFrom,
		int offsetTo) override;

private:
	void printAddDelete(const String& line, DiffType diffType, const String& lineNumber,
		int offsetFrom, int offsetTo);

	void appendOffset(int offsetFrom, int offsetTo);

	void printEscapedJSON(const String & s) {
		printEscapedJSON(s.cbegin(), s.cend());
	}

	void printEscapedJSON(const Word & word) {
		printEscapedJSON(word.start, word.end);
	}

	void printEscapedJSON(StringIterator start, StringIterator end);
};

} // namespace wikidiff2

#endif /* INLINEJSONFORMATTER_H */
