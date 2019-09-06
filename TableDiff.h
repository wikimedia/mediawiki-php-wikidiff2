#ifndef TABLEDIFF_H
#define TABLEDIFF_H

#include "Wikidiff2.h"

class TableDiff: public Wikidiff2 {
	public:
	protected:
		void printAdd(const String& line, int leftLine, int rightLine);
		void printDelete(const String& line, int leftLine, int rightLine);
		void printWordDiff(const String& text1, const String & text2, int leftLine, int rightLine, bool printLeft = true, bool printRight = true, const String & srcAnchor = "", const String & dstAnchor = "", bool moveDirectionDownwards = false);
		void printTextWithDiv(const String& input);
		void printBlockHeader(int leftLine, int rightLine);
		void printContext(const String& input, int leftLine, int rightLine);

		void printWordDiffSide(WordDiff& worddiff, bool added);
};

#endif
