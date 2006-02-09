#ifndef WIKIDIFF2_H
#define WIKIDIFF2_H

#define MAX_DIFF_LINE 10000

#include "DiffEngine.h"
#include <string>

// a small class to accomodate word-level diffs; basically, a body and an
// optional suffix (the latter consisting of a single whitespace), where
// only the bodies are compared on operator==.
class Word {
public:
	std::string body;
	std::string whole;
	
	Word(std::string body, std::string suffix) : body(body), whole(body + suffix) {}
	bool operator== (const Word &w) const {
		return (body == w.body);
	}
	bool operator!=(const Word &w) const {
		return !(body == w.body);
	}
	bool operator<(const Word &w) const {
		return body < w.body;
	}
};

// operations for the diff, as returned by do_diff
template<class T>
struct diff_op
{
	unsigned char op;
	const T *from, *to;
	unsigned from_ind, to_ind;

	diff_op<T> () {}
};

template<class T>
std::vector<diff_op<T> > do_diff(const std::vector<T> &text1, const std::vector<T> &text2);

void print_diff(std::vector<std::string> &text1, std::vector<std::string> &text2, int num_lines_context, std::string &ret);
void print_worddiff(const std::string & text1, const std::string & text2, std::string &ret);
void print_worddiff_side(Diff<Word> &worddiff, bool added, std::string &ret);
void split_tokens(const char *text, std::vector<Word> &tokens);
void print_add(const std::string & line, std::string & ret);
void print_del(const std::string & line, std::string & ret);
void print_htmlspecialchars(const std::string & input, std::string & ret);
void debug_print_worddiff(Diff<Word> &worddiff, std::string &ret);
const char *wikidiff2_do_diff(const char *text1, const char *text2, int num_lines_context);


#endif

