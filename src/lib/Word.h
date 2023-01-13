#ifndef WORD_H
#define WORD_H

#include <string>
#include <algorithm>
#include <iostream>
#include "wd2_allocator.h"

namespace wikidiff2 {

// A small class to accomodate word-level diffs; basically, a body and an
// optional suffix (the latter consisting of a single whitespace), where
// only the bodies are compared on operator==.
//
// This class stores iterators pointing to the line string, this is to avoid
// excessive allocation calls. To avoid invalidation, the source string should
// not be changed or destroyed.
class Word {
public:
	typedef std::basic_string<char, std::char_traits<char>, WD2_ALLOCATOR<char> > String;
	typedef String::const_iterator Iterator;

	Iterator start;
	Iterator bodyEnd;
	Iterator end;

	/**
	  * The body is the character sequence [bs, be)
	  * The whitespace suffix is the character sequence [be, se)
	  */
	Word(Iterator bs, Iterator be, Iterator se)
		: start(bs), bodyEnd(be), end(se)
	{}

	bool operator== (const Word &w) const {
		return (bodyEnd - start == w.bodyEnd - w.start)
			&& std::equal(start, bodyEnd, w.start);
	}
	bool operator!=(const Word &w) const {
		return !operator==(w);
	}
	bool operator<(const Word &w) const {
		return std::lexicographical_compare(start, bodyEnd, w.start, w.bodyEnd);
	}

	size_t size() const {
		return end - start;
	}

	bool isNewline() const {
		return size() == 1 && *start == '\n';
	}
};

} // namespace wikidiff2

template<class CharT, class Traits>
std::basic_ostream<CharT, Traits>&
operator<<(std::basic_ostream<CharT, Traits> & os, const wikidiff2::Word & word)
{
	os.write(&*word.start, word.size());
	return os;
}

#endif
