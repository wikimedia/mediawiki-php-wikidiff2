#include "TextUtil.h"

#include <thai/thailib.h>
#include <thai/thwchar.h>

#include <algorithm>

namespace wikidiff2 {

static thread_local TextUtil tl_textUtil;

TextUtil::TextUtil()
	: breaker(NULL)
{}

TextUtil::~TextUtil()
{
	if (breaker) {
		th_brk_delete(breaker);
	}
}

TextUtil & TextUtil::getInstance() {
	return tl_textUtil;
}

// Weak UTF-8 decoder
// Will return garbage on invalid input (overshort sequences, overlong sequences, etc.)
int TextUtil::nextUtf8Char(String::const_iterator & p, String::const_iterator & charStart,
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
void TextUtil::explodeWords(const String & text, WordVector &words)
{
	// Decode the UTF-8 in the string.
	// * Save the character sizes (in bytes)
	// * Convert the string to TIS-620, which is the internal character set of libthai.
	// * Save the character offsets of any break positions (same format as libthai).

	String tisText, charSizes;
	String::const_iterator suffixEnd, charStart, p;
	IntVector breaks;

	tisText.reserve(text.size() + 1);
	charSizes.reserve(text.size() + 1);
	breaks.reserve(text.size() + 1);
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
				breaks.push_back(charIndex);
			}
		} else {
			breaks.push_back(charIndex);
		}
		charIndex++;
		lastChar = ch;
		ch = nextUtf8Char(p, charStart, text.end());
	}

	// If there were any Thai characters in the string, run th_brk on it and add
	// the resulting break positions
	if (hasThaiChars) {
		tisText += '\0';
		int numBreaks = breaks.size();
		breaks.resize(numBreaks + tisText.size());
		IntVector::iterator thaiBreaksBegin = breaks.begin() + numBreaks;

		numBreaks += th_brk_find_breaks(getBreaker(), (const thchar_t*)(tisText.data()),
				&*thaiBreaksBegin, tisText.size());
		breaks.resize(numBreaks);
		// Merge break positions and de-dupe.
		std::inplace_merge(breaks.begin(), thaiBreaksBegin, breaks.end());
		breaks.erase(std::unique(breaks.begin(), breaks.end()), breaks.end());
	}

	// Add a fake end-of-string character and have a break on it, so that the
	// last word gets added without special handling
	breaks.push_back(charSizes.size());
	charSizes += (char)0;

	// Now make the word array by traversing the breaks vector
	p = text.begin();
	IntVector::iterator pBrk = breaks.begin();
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

} // namespace wikidiff2
