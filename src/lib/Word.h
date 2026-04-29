#ifndef WORD_H
#define WORD_H

#include <cstddef>
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
	using String = std::basic_string<char, std::char_traits<char>, WD2_ALLOCATOR<char> >;
	using Iterator = String::const_iterator;

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
		return body() == w.body();
	}
	bool operator!=(const Word &w) const {
		return !operator==(w);
	}
	bool operator<(const Word &w) const {
		return body() < w.body();
	}

	std::string_view body() const {
		std::size_t bodyLength = bodyEnd - start;
		return std::string_view{&*start, bodyLength};
	}

	std::string_view suffix() const {
		std::size_t suffixLen = end - bodyEnd;
		return std::string_view{&*bodyEnd, suffixLen};
	}

	std::string_view whole() const {
		std::size_t wholeSize = end - start;
		return std::string_view{&*start, wholeSize};
	}

	size_t size() const {
		return whole().size();
	}

	bool isNewline() const {
		using namespace std::literals;
		return whole() == "\n"sv;
	}
};

} // namespace wikidiff2

template<class CharT, class Traits>
std::basic_ostream<CharT, Traits>&
operator<<(std::basic_ostream<CharT, Traits> & os, const wikidiff2::Word & word)
{
	auto s = word.whole();
	os.write(s.data(), s.size());
	return os;
}

#endif
