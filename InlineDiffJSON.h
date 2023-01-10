
#ifndef INLINEDIFFJSON_H
#define INLINEDIFFJSON_H

#include <stdio.h>

#include "Wikidiff2.h"

namespace wikidiff2 {

enum DiffType {Context, AddLine, DeleteLine, Change, MoveSource, MoveDestination};
enum HighlightType {Add, Delete};
enum LinkDirection {Down, Up};

class InlineDiffJSON: public Wikidiff2 {
public:
	InlineDiffJSON(const Config& config_)
		: Wikidiff2(config_)
	{}

	bool hasResults = false;
protected:
	void printFileHeader();
	void printFileFooter();
	void printAdd(const String& line, int leftLine, int rightLine, int offsetFrom,
		int offsetTo);
	void printDelete(const String& line, int leftLine, int rightLine, int offsetFrom,
		int offsetTo);
	void printAddDelete(const String& line, DiffType diffType, const String& lineNumber,
		int offsetFrom, int offsetTo);
	void printWordDiff(const String& text1, const String& text2, int leftLine, int rightLine,
		int offsetFrom, int offsetTo, bool printLeft = true, bool printRight = true,
		const String & srcAnchor = "", const String & dstAnchor = "", bool moveDirectionDownwards = false);
	void printBlockHeader(int leftLine, int rightLine);
	void printContext(const String& input, int leftLine, int rightLine, int offsetFrom,
		int offsetTo);
	void appendOffset(int offsetFrom, int offsetTo);
	void printEscapedJSON(const String &s);
	bool needsJSONFormat();
};

} // namespace wikidiff2

#endif /* InlineDiffJSON_h */
