#ifndef TEXTUTIL_H
#define TEXTUTIL_H

#include <thai/thailib.h>
#include <thai/thwchar.h>
#include <thai/thbrk.h>

namespace TextUtil
{
	typedef std::basic_string<char, std::char_traits<char>, WD2_ALLOCATOR<char> > String;
	typedef std::vector<Word, WD2_ALLOCATOR<Word> > WordVector;
	typedef std::set<int, std::less<int>, WD2_ALLOCATOR<int> > IntSet;
	typedef std::vector<int, WD2_ALLOCATOR<int> > IntVector;

	// helper functions used in both DiffEngine and Wikidiff2

	inline bool isLetter(int ch)
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

	inline bool isSpace(int ch)
	{
		return ch == ' ' || ch == '\t';
	}

	// Weak UTF-8 decoder
	// Will return garbage on invalid input (overshort sequences, overlong sequences, etc.)
	inline int nextUtf8Char(String::const_iterator & p, String::const_iterator & charStart,
			String::const_iterator end)
	{
		int c = 0;
		unsigned char byte;
		int seqLength = 0;
		charStart = p;
		if (p == end) {
			return 0;
		}
		do {
			byte = (unsigned char)*p;
			if (byte < 0x80) {
				c = byte;
				seqLength = 0;
			} else if (byte >= 0xc0) {
				// Start of UTF-8 character
				// If this is unexpected, due to an overshort sequence, we ignore the invalid
				// sequence and resynchronise here
				if (byte < 0xe0) {
					seqLength = 1;
					c = byte & 0x1f;
				} else if (byte < 0xf0) {
					seqLength = 2;
					c = byte & 0x0f;
				} else {
					seqLength = 3;
					c = byte & 7;
				}
			} else if (seqLength) {
				c <<= 6;
				c |= byte & 0x3f;
				--seqLength;
			} else {
				// Unexpected continuation, ignore
			}
			++p;
		} while (seqLength && p != end);
		return c;
	}

	// Split a string into words
	//
	// TODO: I think the best way to do this would be to use ICU BreakIterator
	// instead of libthai + DIY. Basically you'd run BreakIterators from several
	// different locales (en, th, ja) and merge the results, i.e. if a break occurs
	// in any locale at a given position, split the string. I don't know if the
	// quality of the Thai dictionary in ICU matches the one in libthai, we would
	// have to check this somehow.
	inline void explodeWords(const String & text, WordVector &words)
	{
		// Decode the UTF-8 in the string.
		// * Save the character sizes (in bytes)
		// * Convert the string to TIS-620, which is the internal character set of libthai.
		// * Save the character offsets of any break positions (same format as libthai).

		String tisText, charSizes;
		String::const_iterator suffixEnd, charStart, p;
		IntSet breaks;

		tisText.reserve(text.size());
		charSizes.reserve(text.size());
		wchar_t ch, lastChar;
		thchar_t thaiChar;
		bool hasThaiChars = false;

		p = text.begin();
		ch = nextUtf8Char(p, charStart, text.end());
		lastChar = 0;
		int charIndex = 0;
		while (ch) {
			thaiChar = th_uni2tis(ch);
			if (thaiChar >= 0x80 && thaiChar != THCHAR_ERR) {
				hasThaiChars = true;
			}
			tisText += (char)thaiChar;
			charSizes += (char)(p - charStart);

			if (isLetter(ch)) {
				if (lastChar && !isLetter(lastChar)) {
					breaks.insert(charIndex);
				}
			} else {
				breaks.insert(charIndex);
			}
			charIndex++;
			lastChar = ch;
			ch = nextUtf8Char(p, charStart, text.end());
		}

		// If there were any Thai characters in the string, run th_brk on it and add
		// the resulting break positions
		if (hasThaiChars) {
			IntVector thaiBreakPositions;
			tisText += '\0';
			thaiBreakPositions.resize(tisText.size());
			int numBreaks = th_brk((const thchar_t*)(tisText.data()),
					&thaiBreakPositions[0], thaiBreakPositions.size());
			thaiBreakPositions.resize(numBreaks);
			breaks.insert(thaiBreakPositions.begin(), thaiBreakPositions.end());
		}

		// Add a fake end-of-string character and have a break on it, so that the
		// last word gets added without special handling
		breaks.insert(charSizes.size());
		charSizes += (char)0;

		// Now make the word array by traversing the breaks set
		p = text.begin();
		IntSet::iterator pBrk = breaks.begin();
		String::const_iterator wordStart = text.begin();
		String::const_iterator suffixStart = text.end();

		// If there's a break at the start of the string, skip it
		if (pBrk != breaks.end() && *pBrk == 0) {
			pBrk++;
		}

		for (charIndex = 0; charIndex < charSizes.size(); p += charSizes[charIndex++]) {
			// Assume all spaces are ASCII
			if (isSpace(*p)) {
				suffixStart = p;
			}
			if (pBrk != breaks.end() && charIndex == *pBrk) {
				if (suffixStart == text.end()) {
					words.push_back(Word(wordStart, p, p));
				} else {
					words.push_back(Word(wordStart, suffixStart, p));
				}
				pBrk++;
				suffixStart = text.end();
				wordStart = p;
			}
		}
	}
}

#endif // TEXTUTIL_H
