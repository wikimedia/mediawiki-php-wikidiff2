
#ifndef INLINEDIFFJSON_H
#define INLINEDIFFJSON_H

#include <stdio.h>

#include "Wikidiff2.h"

enum DiffType {Context, AddLine, DeleteLine, Change, MoveSource, MoveDestination};
enum HighlightType {Add, Delete};
enum LinkDirection {Down, Up};

class InlineDiffJSON: public Wikidiff2 {
public:
	bool hasResults = false;
protected:
	void printAdd(const String& line, int leftLine, int rightLine, int sectionTitleIndex);
	void printDelete(const String& line, int leftLine, int rightLine, int sectionTitleIndex);
	void printAddDelete(const String& line, DiffType diffType,
		const String& lineNumber, int sectionTitleIndex);
	void printWordDiff(const String& text1, const String& text2,
		int leftLine, int rightLine, int sectionTitleIndex, bool printLeft = true,
		bool printRight = true, const String & srcAnchor = "", const String & dstAnchor = "",
		bool moveDirectionDownwards = false);
	void printBlockHeader(int leftLine, int rightLine);
	void printContext(const String& input, int leftLine, int rightLine, int sectionTitleIndex);
	void printEscapedJSON(const String &s);
	void appendSectionTitleIndex(int sectionTitleIndex);
	bool needsJSONFormat();
	void printSectionTitles(const StringVector & sectionTitles);	
};

#endif /* InlineDiffJSON_h */
