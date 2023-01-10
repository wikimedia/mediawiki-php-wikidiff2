#ifndef TEXTUTIL_H
#define TEXTUTIL_H

#include "wd2_allocator.h"
#include "Word.h"
#include <thai/thbrk.h>
#include <string>
#include <vector>

namespace wikidiff2 {

// helper functions used in both DiffEngine and Wikidiff2
class TextUtil
{
public:

	typedef std::basic_string<char, std::char_traits<char>, WD2_ALLOCATOR<char> > String;
	typedef std::vector<Word, WD2_ALLOCATOR<Word> > WordVector;
	typedef std::vector<int, WD2_ALLOCATOR<int> > IntVector;

private:
	ThBrk * breaker;

	ThBrk * getBreaker() {
		if (!breaker) {
			breaker = th_brk_new(NULL);
		}
		return breaker;
	}

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

	int nextUtf8Char(String::const_iterator & p, String::const_iterator & charStart,
		String::const_iterator end);

public:

	TextUtil();
	~TextUtil();

	static TextUtil & getInstance();

	// Split a string into words
	void explodeWords(const String & text, WordVector &words);
};

} // namespace wikidiff2

#endif // TEXTUTIL_H
