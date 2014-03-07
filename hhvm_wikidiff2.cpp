/* $Id$ */

#include "hphp/runtime/base/base-includes.h"
#include "hphp/util/alloc.h"
#include "Wikidiff2.h"
#include "TableDiff.h"
#include "InlineDiff.h"

#include <string>

namespace HPHP {

/* {{{ proto string wikidiff2_do_diff(string text1, string text2, int numContextLines)
 *
 * Warning: the input text must be valid UTF-8! Do not pass user input directly
 * to this function.
 */
static String HHVM_FUNCTION(wikidiff2_do_diff,
	const String& text1,
	const String& text2,
	int64_t numContextLines)
{
    String result;
	try {
		TableDiff wikidiff2;
		Wikidiff2::String text1String(text1.c_str());
		Wikidiff2::String text2String(text2.c_str());
		result = wikidiff2.execute(text1String, text2String, numContextLines);
	} catch (OutOfMemoryException &e) {
		raise_error("Out of memory in wikidiff2_do_diff().");
	} catch (...) {
		raise_error("Unknown exception in wikidiff2_do_diff().");
	}
	return result;
}

/* {{{ proto string wikidiff2_inline_diff(string text1, string text2, int numContextLines)
 *
 * Warning: the input text must be valid UTF-8! Do not pass user input directly
 * to this function.
 */
static String HHVM_FUNCTION(wikidiff2_inline_diff,
	const String& text1,
	const String& text2,
	int64_t numContextLines)
{
    String result;
	try {
		InlineDiff wikidiff2;
		Wikidiff2::String text1String(text1.c_str());
		Wikidiff2::String text2String(text2.c_str());
		result = wikidiff2.execute(text1String, text2String, numContextLines);
	} catch (OutOfMemoryException &e) {
		raise_error("Out of memory in wikidiff2_do_diff().");
	} catch (...) {
		raise_error("Unknown exception in wikidiff2_do_diff().");
	}
	return result;
}

static class Wikidiff2Extension : public Extension {
	public:
		Wikidiff2Extension() : Extension("wikidiff2") {}
		virtual void moduleInit() {
			HHVM_FE(wikidiff2_do_diff);
			HHVM_FE(wikidiff2_inline_diff);
			loadSystemlib();
		}
} s_wikidiff2_extension;

HHVM_GET_MODULE(wikidiff2)

} // namespace HPHP



