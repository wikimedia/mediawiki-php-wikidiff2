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
			result << op.from[j]->whole() << ")";
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
			result << op.to[j]->whole() + ")";
		}
		result << "\n\n";
	}
}

void Formatter::printHtmlEncodedText(const String & input)
{
	size_t start = 0;
	size_t end = input.find_first_of("<>&");
	while (end != String::npos) {
		if (end > start) {
			result.write(input.data() + start, end - start);
		}
		switch (input[end]) {
			case '<':
				result << "&lt;";
				break;
			case '>':
				result << "&gt;";
				break;
			default /*case '&'*/:
				result << "&amp;";
		}
		start = end + 1;
		end = input.find_first_of("<>&", start);
	}
	// Append the rest of the string after the last special character
	if (start < input.size()) {
		result.write(input.data() + start, input.size() - start);
	}
}

Formatter::String Formatter::toString(long input) const
{
	StringStream stream;
	stream << input;
	return String(stream.str());
}

} // namespace wikidiff2
