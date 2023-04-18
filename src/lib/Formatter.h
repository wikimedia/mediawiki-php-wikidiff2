#ifndef FORMATTER_H
#define FORMATTER_H

#include <string>
#include <sstream>

#include "wd2_allocator.h"
#include "DiffEngine.h"

namespace wikidiff2 {

class Formatter {
	public:
		typedef std::basic_string<char, std::char_traits<char>, WD2_ALLOCATOR<char> > String;
		typedef String::const_iterator StringIterator;
		typedef std::basic_stringstream<char, std::char_traits<char>, WD2_ALLOCATOR<char> > StringStream;
		typedef Diff<Word> WordDiff;

		virtual const char * getName() = 0;

		/**
		 * Append a whole added line to the output
		 *
		 * @param line The text of the added line
		 * @param leftLine The 1-based line number on the LHS
		 * @param rightLine The 1-based line number on the RHS
		 * @param offsetFrom The 0-based byte offset in the LHS input string
		 * @param offsetTo The 0-based byte offset in the RHS input string
		 */
		virtual void printAdd(const String & line, int leftLine, int rightLine, int offsetFrom, int offsetTo) = 0;

		/**
		 * Append a whole deleted line to the output
		 *
		 * @param line The text of the deleted line
		 * @param leftLine The 1-based line number on the LHS
		 * @param rightLine The 1-based line number on the RHS
		 * @param offsetFrom The 0-based byte offset in the LHS input string
		 * @param offsetTo The 0-based byte offset in the RHS input string
		 */
		virtual void printDelete(const String & line, int leftLine, int rightLine, int offsetFrom, int offsetTo) = 0;

		/**
		 * Append the word diff for a changed line to the output
		 *
		 * @param wordDiff The word diff
		 * @param leftLine The 1-based line number on the LHS
		 * @param rightLine The 1-based line number on the RHS
		 * @param offsetFrom The 0-based byte offset in the LHS input string
		 * @param offsetTo The 0-based byte offset in the RHS input string
		 * @param printLeft This is false to suppress LHS output when formatting
		 *   a moved line.
		 * @param printRight This is false to suppress RHS output when formatting
		 *   a moved line
		 * @param srcAnchor The HTML ID of the line currently being printed.
		 *   This is safe for output into HTML without escaping.
		 * @param dstAnchor The HTML ID of the for a link to the source of the
		 *   moved line. This is safe for output into HTML without escaping.
		 * @param moveDirectionDownwards True if the move is downwards, false
		 *   if the move is upwards. Ignore if the operation is not a move.
		 */
		virtual void printWordDiff(
			const WordDiff & wordDiff,
			int leftLine, int rightLine,
			int offsetFrom, int offsetTo,
			bool printLeft = true, bool printRight = true,
			const String & srcAnchor = "", const String & dstAnchor = "",
			bool moveDirectionDownwards = false) = 0;

		/**
		 * Append a word diff to the output which compares one line on the LHS
		 * with multiple lines on the RHS.
		 *
		 * @param wordDiff The word diff
		 * @param leftLine The 1-based line number on the LHS
		 * @param rightLine The 1-based line number of the first line on the RHS
		 * @param offsetFrom The 0-based byte offset in the LHS input string
		 * @param offsetTo The 0-based byte offset in the RHS input string
		 */
		virtual void printConcatDiff(
			const WordDiff & wordDiff,
			int leftLine, int rightLine,
			int offsetFrom, int offsetTo);

		/**
		 * This is called once before any other output to give the subclass a
		 * chance to add a header. No-op by default.
		 */
		virtual void printFileHeader();

		/**
		 * This is called after all other output, to give the subclass a chance
		 * to add a footer. No-op by default.
		 */
		virtual void printFileFooter();

		/**
		 * This is called after context lines were omitted but before the
		 * subsequent call to printContext().
		 *
		 * @param leftLine The 1-based line number on the LHS
		 * @param rightLine The 1-based line number on the RHS
		 */
		virtual void printBlockHeader(int leftLine, int rightLine) = 0;

		/**
		 * Append to the output a line which was identical in the LHS and RHS.
		 *
		 * @param input The text of the line
		 * @param leftLine The 1-based line number on the LHS
		 * @param rightLine The 1-based line number on the RHS
		 * @param offsetFrom The 0-based byte offset in the LHS input string
		 * @param offsetTo The 0-based byte offset in the RHS input string
		 */
		virtual void printContext(const String & input, int leftLine, int rightLine, int offsetFrom, int offsetTo) = 0;

		/**
		 * Get the StringStream to which results were appended.
		 */
		const StringStream & getResult() const {
			return result;
		}

	protected:
		/**
		 * Dump a word diff to the output in a format suitable for debugging
		 */
		void debugPrintWordDiff(const WordDiff & worddiff);

		/**
		 * Encode a Word for HTML and add it to the output
		 */
		void printHtmlEncodedText(const Word & input)
		{
			printHtmlEncodedText(input.start, input.end);
		}

		/**
		 * Encode a String for HTML and add it to the output
		 */
		void printHtmlEncodedText(const String & input)
		{
			printHtmlEncodedText(input.cbegin(), input.cend());
		}

		/**
		 * Encode a string range for HTML and add it to the output
		 */
		void printHtmlEncodedText(StringIterator inputStart, StringIterator inputEnd);

		/**
		 * Convert an integer to a string.
		 */
		String toString(long input) const;

		/**
		 * The stream to write the result to.
		 */
		StringStream result;
};

} // namespace wikidiff2

#endif
