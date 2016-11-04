#ifndef INLINEDIFF_H
#define INLINEDIFF_H

#include "Wikidiff2.h"

class InlineDiff: public Wikidiff2 {
	public:
	protected:
		void printAdd(const String& line);
		void printDelete(const String& line);
		void printWordDiff(const String& text1, const String& text2, bool printLeft = true, bool printRight = true, const String & srcAnchor = "", const String & dstAnchor = "");
		void printBlockHeader(int leftLine, int rightLine);
		void printContext(const String& input);

		void printWrappedLine(const char* pre, const String& line, const char* post);
};

#endif
