#ifndef WIKIDIFF2_H
#define WIKIDIFF2_H

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
		enum { MAX_WORD_LEVEL_DIFF_COMPLEXITY = 40000000 };
		String result;

		virtual void diffLines(const StringVector & lines1, const StringVector & lines2,
				int numContextLines);
		virtual void printAdd(const String & line) = 0;
		virtual void printDelete(const String & line) = 0;
		virtual void printWordDiff(const String & text1, const String & text2) = 0;
		virtual void printBlockHeader(int leftLine, int rightLine) = 0;
		virtual void printContext(const String & input) = 0;

		void printText(const String & input);
		void debugPrintWordDiff(WordDiff & worddiff);

		void explodeLines(const String & text, StringVector &lines);
};

inline const Wikidiff2::String & Wikidiff2::getResult() const
{
	return result;
}

#endif
