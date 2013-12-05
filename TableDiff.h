#ifndef TABLEDIFF_H
#define TABLEDIFF_H

#include "Wikidiff2.h"

class TableDiff: public Wikidiff2 {
	public:
	protected:
		void printAdd(const String& line);
		void printDelete(const String& line);
		void printWordDiff(const String& text1, const String & text2);
		void printTextWithDiv(const String& input);
		void printBlockHeader(int leftLine, int rightLine);
		void printContext(const String& input);

		void printWordDiffSide(WordDiff& worddiff, bool added);
};

#endif
