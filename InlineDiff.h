#ifndef INLINEDIFF_H
#define INLINEDIFF_H

#include "Wikidiff2.h"

namespace wikidiff2 {

class InlineDiff: public Wikidiff2 {
	public:
	protected:
		void printAdd(const String& line, int leftLine, int rightLine, int offsetFrom,
			int offsetTo);
		void printDelete(const String& line, int leftLine, int rightLine, int offsetFrom,
			int offsetTo);
		void printWordDiff(const String& text1, const String& text2, int leftLine, int rightLine,
			int offsetFrom, int offsetTo, bool printLeft = true, bool printRight = true,
			const String & srcAnchor = "", const String & dstAnchor = "",
			bool moveDirectionDownwards = false);
		void printBlockHeader(int leftLine, int rightLine);
		void printContext(const String& input, int leftLine, int rightLine, int offsetFrom,
			int offsetTo);

		void printWrappedLine(const char* pre, const String& line, const char* post);
};

} // namespace wikidiff2

#endif
