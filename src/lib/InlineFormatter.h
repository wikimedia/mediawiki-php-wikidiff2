#ifndef INLINEFORMATTER_H
#define INLINEFORMATTER_H

#include "Formatter.h"

namespace wikidiff2 {

class InlineFormatter: public Formatter {
	public:
		const char * getName() override;
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
		void printWrappedLine(const char* pre, const String& line, const char* post);
};

} // namespace wikidiff2

#endif
