#ifndef WIKIDIFF2_H
#define WIKIDIFF2_H

#include "wd2_allocator.h"
#include "Formatter.h"
#include "DiffEngine.h"
#include "Word.h"
#include "TextUtil.h"
#include <string>
#include <vector>
#include <set>
#include <list>
#include <sstream>

// uncomment this for inline HTML debug output related to moved lines
//#define DEBUG_MOVED_LINES

namespace wikidiff2 {

class Wikidiff2 {
	public:
		typedef std::basic_string<char, std::char_traits<char>, WD2_ALLOCATOR<char> > String;
		typedef std::basic_stringstream<char, std::char_traits<char>, WD2_ALLOCATOR<char> > StringStream;
		typedef std::vector<String, WD2_ALLOCATOR<String> > StringVector;
		typedef std::vector<Word, WD2_ALLOCATOR<Word> > WordVector;
		typedef std::vector<int, WD2_ALLOCATOR<int> > IntVector;
		typedef std::list<int, WD2_ALLOCATOR<int> > IntList;
		typedef std::list<Formatter*, WD2_ALLOCATOR<Formatter*> > FormatterPtrList;

		typedef Diff<String> StringDiff;
		typedef Diff<Word> WordDiff;

		/**
		 * Options used to configure the class, passed to the constructor
		 */
		struct Config {
			/**
			 * The number of copied lines shown before and after each change
			 */
			int64_t numContextLines;

			/**
			 * If the similarity metric between lines exceeds this value the
			 * line will be shown as a change with a word diff. If not, it will
			 * be shown as a delete and add. Between 0 and 1.
			 */
			double changeThreshold;

			/**
			 * If the similarity metric between lines exceeds this value, the
			 * pair may be considered as a move candidate. Between 0 and 1.
			 */
			double movedLineThreshold;

			/**
			 * When the number of added and deleted lines in a diff is greater
			 * than this limit, no attempt to detect moved lines will be made.
			 */
			int64_t maxMovedLines;

			/**
			 * When comparing two lines for changes within the line, a word-level
			 * diff will be done unless the product of the LHS word count and
			 * the RHS word count exceeds this limit.
			 */
			int64_t maxWordLevelDiffComplexity;
		};

		Wikidiff2(const Config& config_)
			: config(config_), textUtil(TextUtil::getInstance())
		{
			lineDiffConfig.bailoutComplexity = 0;
			lineDiffConfig.changeThreshold = config.changeThreshold;
			wordDiffConfig.bailoutComplexity = config.maxWordLevelDiffComplexity;
			wordDiffConfig.changeThreshold = config.changeThreshold;
		}

		void execute(const String & text1, const String & text2);

		void addFormatter(Formatter & formatter);

	private:
		TextUtil & textUtil;
		Config config;
		DiffConfig lineDiffConfig;
		DiffConfig wordDiffConfig;
		FormatterPtrList formatters;

		struct DiffMapEntry
		{
			WordDiffStats ds;
			int opIndexFrom, opLineFrom, opIndexTo, opLineTo;
			bool lhsDisplayed = false, rhsDisplayed = false;

			DiffMapEntry(const DiffConfig& diffConfig, WordVector& words1, WordVector& words2, int opIndexFrom_, int opLineFrom_, int opIndexTo_, int opLineTo_);
		};
		// PhpAllocator can't be specialized for std::pair, so we're using the standard allocator.
		typedef std::map<uint64_t, std::shared_ptr<struct Wikidiff2::DiffMapEntry> > DiffMap;
		DiffMap diffMap;

		class AllowPrintMovedLineDiff {
			bool detectMovedLines = true;       // will be set to false when too many 'add' or 'delete' ops appear in diff.
			bool detectMovedLinesValid = false; // whether detectMovedLines is valid.
			public:
				bool operator() (const StringDiff & linediff, int maxMovedLines);	// calculates & caches comparison count
		} allowPrintMovedLineDiff;

		void printDiff(const StringDiff & linediff);

		void explodeLines(const String & text, StringVector &lines);

		bool printMovedLineDiff(const StringDiff & linediff, int opIndex, int opLine,
			int leftLine, int rightLine, int offsetFrom, int offsetTo);

		void printAdd(const String & line, int leftLine, int rightLine, int offsetFrom, int offsetTo);
		void printDelete(const String & line, int leftLine, int rightLine, int offsetFrom, int offsetTo);

		void printWordDiff(
			const WordDiff & diff,
			int leftLine, int rightLine,
			int offsetFrom, int offsetTo,
			bool printLeft = true, bool printRight = true,
			const String & srcAnchor = "", const String & dstAnchor = "",
			bool moveDirectionDownwards = false);

		void printWordDiffFromStrings(
			const String & text1, const String & text2,
			int leftLine, int rightLine,
			int offsetFrom, int offsetTo,
			bool printLeft = true, bool printRight = true,
			const String & srcAnchor = "", const String & dstAnchor = "",
			bool moveDirectionDownwards = false);

		void printFileHeader();
		void printFileFooter();
		void printBlockHeader(int leftLine, int rightLine);
		void printContext(const String & input, int leftLine, int rightLine, int offsetFrom, int offsetTo);
};

inline Wikidiff2::DiffMapEntry::DiffMapEntry(const DiffConfig& diffConfig,
		Wikidiff2::WordVector& words1, Wikidiff2::WordVector& words2,
		int opIndexFrom_, int opLineFrom_,
		int opIndexTo_, int opLineTo_
):
	ds(diffConfig, words1, words2),
	opIndexFrom(opIndexFrom_), opLineFrom(opLineFrom_), opIndexTo(opIndexTo_), opLineTo(opLineTo_)
{
}

inline bool Wikidiff2::AllowPrintMovedLineDiff::operator () (const StringDiff & linediff, int maxMovedLines)
{
	if(!detectMovedLinesValid) {
		// count the number of added or removed lines which could have been moved.
		int adds = 0, deletes = 0;
		for(int i = 0; i < linediff.size(); ++i) {
			if(linediff[i].op == DiffOp<String>::add)
				adds += linediff[i].to.size();
			if(linediff[i].op == DiffOp<String>::del)
				deletes += linediff[i].from.size();
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

} // namespace wikidiff2

#endif
