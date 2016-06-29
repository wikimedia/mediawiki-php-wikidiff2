/**
 * Diff formatter, based on code by Steinar H. Gunderson, converted to work with the
 * Dairiki diff engine by Tim Starling
 *
 * GPL.
 */

#include <stdio.h>
#include <string.h>
#include "Wikidiff2.h"


void Wikidiff2::diffLines(const StringVector & lines1, const StringVector & lines2,
		int numContextLines)
{
	// first do line-level diff
	StringDiff linediff(lines1, lines2);

	int from_index = 1, to_index = 1;

	// Should a line number be printed before the next context line?
	// Set to true initially so we get a line number on line 1
	bool showLineNumber = true;

	for (int i = 0; i < linediff.size(); ++i) {
		int n, j, n1, n2;
		// Line 1 changed, show heading with no leading context
		if (linediff[i].op != DiffOp<String>::copy && i == 0) {
			printBlockHeader(1, 1);
		}

		switch (linediff[i].op) {
			case DiffOp<String>::add:
				// inserted lines
				n = linediff[i].to.size();
				for (j=0; j<n; j++) {
					printAdd(*linediff[i].to[j]);
				}
				to_index += n;
				break;
			case DiffOp<String>::del:
				// deleted lines
				n = linediff[i].from.size();
				for (j=0; j<n; j++) {
					printDelete(*linediff[i].from[j]);
				}
				from_index += n;
				break;
			case DiffOp<String>::copy:
				// copy/context
				n = linediff[i].from.size();
				for (j=0; j<n; j++) {
					if ((i != 0 && j < numContextLines) /*trailing*/
							|| (i != linediff.size() - 1 && j >= n - numContextLines)) /*leading*/ {
						if (showLineNumber) {
							printBlockHeader(from_index, to_index);
							showLineNumber = false;
						}
						printContext(*linediff[i].from[j]);
					} else {
						showLineNumber = true;
					}
					from_index++;
					to_index++;
				}
				break;
			case DiffOp<String>::change:
				// replace, i.e. we do a word diff between the two sets of lines
				n1 = linediff[i].from.size();
				n2 = linediff[i].to.size();
				n = std::min(n1, n2);
				for (j=0; j<n; j++) {
					printWordDiff(*linediff[i].from[j], *linediff[i].to[j]);
				}
				from_index += n;
				to_index += n;
				if (n1 > n2) {
					for (j=n2; j<n1; j++) {
						printDelete(*linediff[i].from[j]);
					}
				} else {
					for (j=n1; j<n2; j++) {
						printAdd(*linediff[i].to[j]);
					}
				}
				break;
		}
		// Not first line anymore, don't show line number by default
		showLineNumber = false;
	}
}

void Wikidiff2::debugPrintWordDiff(WordDiff & worddiff)
{
	for (unsigned i = 0; i < worddiff.size(); ++i) {
		DiffOp<Word> & op = worddiff[i];
		switch (op.op) {
			case DiffOp<Word>::copy:
				result += "Copy\n";
				break;
			case DiffOp<Word>::del:
				result += "Delete\n";
				break;
			case DiffOp<Word>::add:
				result += "Add\n";
				break;
			case DiffOp<Word>::change:
				result += "Change\n";
				break;
		}
		result += "From: ";
		bool first = true;
		for (int j=0; j<op.from.size(); j++) {
			if (first) {
				first = false;
			} else {
				result += ", ";
			}
			result += "(";
			result += op.from[j]->whole() + ")";
		}
		result += "\n";
		result += "To: ";
		first = true;
		for (int j=0; j<op.to.size(); j++) {
			if (first) {
				first = false;
			} else {
				result += ", ";
			}
			result += "(";
			result += op.to[j]->whole() + ")";
		}
		result += "\n\n";
	}
}

void Wikidiff2::printText(const String & input)
{
	size_t start = 0;
	size_t end = input.find_first_of("<>&");
	while (end != String::npos) {
		if (end > start) {
			result.append(input, start, end - start);
		}
		switch (input[end]) {
			case '<':
				result.append("&lt;");
				break;
			case '>':
				result.append("&gt;");
				break;
			default /*case '&'*/:
				result.append("&amp;");
		}
		start = end + 1;
		end = input.find_first_of("<>&", start);
	}
	// Append the rest of the string after the last special character
	if (start < input.size()) {
		result.append(input, start, input.size() - start);
	}
}

void Wikidiff2::explodeLines(const String & text, StringVector &lines)
{
	String::const_iterator ptr = text.begin();
	while (ptr != text.end()) {
		String::const_iterator ptr2 = std::find(ptr, text.end(), '\n');
		lines.push_back(String(ptr, ptr2));

		ptr = ptr2;
		if (ptr != text.end()) {
			++ptr;
		}
	}
}

const Wikidiff2::String & Wikidiff2::execute(const String & text1, const String & text2, int numContextLines)
{
	// Allocate some result space to avoid excessive copying
	result.clear();
	result.reserve(text1.size() + text2.size() + 10000);

	// Split input strings into lines
	StringVector lines1;
	StringVector lines2;
	explodeLines(text1, lines1);
	explodeLines(text2, lines2);

	// Do the diff
	diffLines(lines1, lines2, numContextLines);

	// Return a reference to the result buffer
	return result;
}
