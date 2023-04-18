#include "Formatter.h"

namespace wikidiff2 {

void Formatter::printFileHeader() {
}

void Formatter::printFileFooter() {
}

void Formatter::debugPrintWordDiff(const WordDiff & worddiff)
{
	for (unsigned i = 0; i < worddiff.size(); ++i) {
		const DiffOp<Word> & op = worddiff[i];
		switch (op.op) {
			case DiffOp<Word>::copy:
				result << "Copy\n";
				break;
			case DiffOp<Word>::del:
				result << "Delete\n";
				break;
			case DiffOp<Word>::add:
				result << "Add\n";
				break;
			case DiffOp<Word>::change:
				result << "Change\n";
				break;
		}
		result << "From: ";
		bool first = true;
		for (int j=0; j<op.from.size(); j++) {
			if (first) {
				first = false;
			} else {
				result << ", ";
			}
			result << "(";
			result << *op.from[j] << ")";
		}
		result << "\n";
		result << "To: ";
		first = true;
		for (int j=0; j<op.to.size(); j++) {
			if (first) {
				first = false;
			} else {
				result << ", ";
			}
			result << "(";
			result << *op.to[j] << ")";
		}
		result << "\n\n";
	}
}

void Formatter::printHtmlEncodedText(StringIterator inputStart, StringIterator inputEnd)
{
	StringIterator p = inputStart;
	char *needleStart = "<>&", *needleEnd = needleStart + 3;

	while (true) {
		StringIterator next = std::find_first_of(p, inputEnd, needleStart, needleEnd);
		if (next > p) {
			result.write(&*p, next - p);
		}
		if (next == inputEnd) {
			break;
		}
		switch (*next) {
			case '<':
				result << "&lt;";
				break;
			case '>':
				result << "&gt;";
				break;
			default /*case '&'*/:
				result << "&amp;";
		}
		p = next + 1;
	}
}

Formatter::String Formatter::toString(long input) const
{
	StringStream stream;
	stream << input;
	return String(stream.str());
}

void Formatter::printConcatDiff(
	const WordDiff & wordDiff,
	int leftLine, int rightLine,
	int offsetFrom, int offsetTo)
{
	throw std::runtime_error("this formatter does not implement line splitting");
}

} // namespace wikidiff2
