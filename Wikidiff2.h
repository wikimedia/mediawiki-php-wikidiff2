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
#include <memory>

#define WIKIDIFF2_VERSION_STRING "1.8.1"
// uncomment this for inline HTML debug output related to moved lines
//#define DEBUG_MOVED_LINES

class Wikidiff2 {
	public:
		typedef std::basic_string<char, std::char_traits<char>, WD2_ALLOCATOR<char> > String;
		typedef std::vector<String, WD2_ALLOCATOR<String> > StringVector;
		typedef std::vector<Word, WD2_ALLOCATOR<Word> > WordVector;
		typedef std::vector<int, WD2_ALLOCATOR<int> > IntVector;

		typedef Diff<String> StringDiff;
		typedef Diff<Word> WordDiff;

		const String & execute(const String & text1, const String & text2, int numContextLines, int maxMovedLines);

		inline const String & getResult() const;

	protected:
		enum { MAX_WORD_LEVEL_DIFF_COMPLEXITY = 40000000 };
		String result;

		struct DiffMapEntry
		{
			WordDiffStats ds;
			int opIndexFrom, opLineFrom, opIndexTo, opLineTo;
			bool lhsDisplayed = false, rhsDisplayed = false;

			DiffMapEntry(WordVector& words1, WordVector& words2, int opIndexFrom_, int opLineFrom_, int opIndexTo_, int opLineTo_);
		};
		// PhpAllocator can't be specialized for std::pair, so we're using the standard allocator.
		typedef std::map<uint64_t, std::shared_ptr<struct Wikidiff2::DiffMapEntry> > DiffMap;
		DiffMap diffMap;

		class AllowPrintMovedLineDiff {
			bool detectMovedLines = true;       // will be set to false when too many 'add' or 'delete' ops appear in diff.
			bool detectMovedLinesValid = false; // whether detectMovedLines is valid.
			public:
				bool operator() (StringDiff & linediff, int maxMovedLines);	// calculates & caches comparison count
		} allowPrintMovedLineDiff;

		virtual void diffLines(const StringVector & lines1, const StringVector & lines2,
				int numContextLines, int maxMovedLines);
		virtual void printAdd(const String & line) = 0;
		virtual void printDelete(const String & line) = 0;
		virtual void printWordDiff(const String & text1, const String & text2, bool printLeft = true, bool printRight = true, const String & srcAnchor = "", const String & dstAnchor = "", bool moveDirectionDownwards = false) = 0;
		virtual void printBlockHeader(int leftLine, int rightLine) = 0;
		virtual void printContext(const String & input) = 0;

		void printText(const String & input);
		void debugPrintWordDiff(WordDiff & worddiff);

		void explodeLines(const String & text, StringVector &lines);

		bool printMovedLineDiff(StringDiff & linediff, int opIndex, int opLine, int maxMovedLines);
};

inline const Wikidiff2::String & Wikidiff2::getResult() const
{
	return result;
}

inline Wikidiff2::DiffMapEntry::DiffMapEntry(Wikidiff2::WordVector& words1, Wikidiff2::WordVector& words2, int opIndexFrom_, int opLineFrom_, int opIndexTo_, int opLineTo_):
	ds(words1, words2, MAX_WORD_LEVEL_DIFF_COMPLEXITY),
	opIndexFrom(opIndexFrom_), opLineFrom(opLineFrom_), opIndexTo(opIndexTo_), opLineTo(opLineTo_)
{
}

inline bool Wikidiff2::AllowPrintMovedLineDiff::operator () (StringDiff & linediff, int maxMovedLines)
{
	if(!detectMovedLinesValid) {
		// count the number of added or removed lines which could have been moved.
		int adds = 0, deletes = 0;
		for(int i = 0; i < linediff.size(); ++i) {
			if(linediff[i].op == DiffOp<String>::add)
				++adds;
			if(linediff[i].op == DiffOp<String>::del)
				++deletes;
			// number of comparisons is (number of additions) x (number of deletions).
			// if count is too large, don't try detecting moved lines.
			if(adds+deletes > maxMovedLines) {
				detectMovedLines = false;
				break;
			}
		}
		detectMovedLinesValid = true;
	}
	return detectMovedLines;
}


#endif
