#ifndef INLINEDIFF_H
#define INLINEDIFF_H

#include "Wikidiff2.h"

class InlineDiff: public Wikidiff2 {
	public:
	protected:
		void printAdd(const String& line, int leftLine, int rightLine, int sectionTitleIndex);
		void printDelete(const String& line, int leftLine, int rightLine, int sectionTitleIndex);
		void printWordDiff(const String& text1, const String& text2, int leftLine, int rightLine,
			int sectionTitleIndex, bool printLeft = true, bool printRight = true,
			const String & srcAnchor = "", const String & dstAnchor = "",
			bool moveDirectionDownwards = false);
		void printBlockHeader(int leftLine, int rightLine);
		void printContext(const String& input, int leftLine, int rightLine, int sectionTitleIndex);

		void printWrappedLine(const char* pre, const String& line, const char* post);
};

#endif
