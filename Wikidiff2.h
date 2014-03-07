#ifndef WIKIDIFF2_H
#define WIKIDIFF2_H

#define MAX_DIFF_LINE 10000

/** Set WD2_USE_STD_ALLOCATOR depending on whether we're compiling as a PHP module or not */
#if defined(HAVE_CONFIG_H)
	#define WD2_ALLOCATOR PhpAllocator
	#include "php_cpp_allocator.h"
#else
	#define WD2_ALLOCATOR std::allocator
#endif

#include "DiffEngine.h"
#include "Word.h"
#include <string>
#include <vector>
#include <set>

class Wikidiff2 {
	public:
		typedef std::basic_string<char, std::char_traits<char>, WD2_ALLOCATOR<char> > String;
		typedef std::vector<String, WD2_ALLOCATOR<String> > StringVector;
		typedef std::vector<Word, WD2_ALLOCATOR<Word> > WordVector;
		typedef std::vector<int, WD2_ALLOCATOR<int> > IntVector;
		typedef std::set<int, std::less<int>, WD2_ALLOCATOR<int> > IntSet;

		typedef Diff<String> StringDiff;
		typedef Diff<Word> WordDiff;

		const String & execute(const String & text1, const String & text2, int numContextLines);

		inline const String & getResult() const;

	protected:
		String result;

		virtual void diffLines(const StringVector & lines1, const StringVector & lines2,
				int numContextLines);
		virtual void printAdd(const String & line) = 0;
		virtual void printDelete(const String & line) = 0;
		virtual void printWordDiff(const String & text1, const String & text2) = 0;
		virtual void printBlockHeader(int leftLine, int rightLine) = 0;
		virtual void printContext(const String & input) = 0;

		void printText(const String & input);
		inline bool isLetter(int ch);
		inline bool isSpace(int ch);
		void debugPrintWordDiff(WordDiff & worddiff);

		int nextUtf8Char(String::const_iterator & p, String::const_iterator & charStart,
				String::const_iterator end);

		void explodeWords(const String & text, WordVector &tokens);
		void explodeLines(const String & text, StringVector &lines);
};

inline bool Wikidiff2::isLetter(int ch)
{
	// Standard alphanumeric
	if ((ch >= '0' && ch <= '9') ||
	   (ch == '_') ||
	   (ch >= 'A' && ch <= 'Z') ||
	   (ch >= 'a' && ch <= 'z'))
	{
		return true;
	}
	// Punctuation and control characters
	if (ch < 0xc0) return false;
	// Chinese, Japanese: split up character by character
	if (ch >= 0x3000 && ch <= 0x9fff) return false;
	if (ch >= 0x20000 && ch <= 0x2a000) return false;
	// Otherwise assume it's from a language that uses spaces
	return true;
}

inline bool Wikidiff2::isSpace(int ch)
{
	return ch == ' ' || ch == '\t';
}

inline const Wikidiff2::String & Wikidiff2::getResult() const
{
	return result;
}

#endif

