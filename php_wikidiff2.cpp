/* $Id$ */

#ifdef HAVE_CONFIG_H
#include "config.h"
#endif

#include "php.h"
#include "php_ini.h"
#include "ext/standard/info.h"
#include "php_wikidiff2.h"
#include "Wikidiff2.h"
#include "TableDiff.h"
#include "InlineDiff.h"
#include "InlineDiffJSON.h"

#if PHP_MAJOR_VERSION >= 7
#define COMPAT_RETURN_STRINGL(s, l) { RETURN_STRINGL(s, l); return; }
#else
#define COMPAT_RETURN_STRINGL(s, l) { RETURN_STRINGL(s, l, 1); return; }
#endif

static int le_wikidiff2;

zend_function_entry wikidiff2_functions[] = {
	PHP_FE(wikidiff2_do_diff,     NULL)
	PHP_FE(wikidiff2_inline_diff, NULL)
	PHP_FE(wikidiff2_inline_json_diff, NULL)
	PHP_FE(wikidiff2_version, NULL)
	{NULL, NULL, NULL}
};


zend_module_entry wikidiff2_module_entry = {
#if ZEND_MODULE_API_NO >= 20010901
	STANDARD_MODULE_HEADER,
#endif
	"wikidiff2",
	wikidiff2_functions,
	PHP_MINIT(wikidiff2),
	PHP_MSHUTDOWN(wikidiff2),
	PHP_RINIT(wikidiff2),
	PHP_RSHUTDOWN(wikidiff2),
	PHP_MINFO(wikidiff2),
#if ZEND_MODULE_API_NO >= 20010901
	WIKIDIFF2_VERSION_STRING,
#endif
	STANDARD_MODULE_PROPERTIES
};

/* {{{ INI Settings */
PHP_INI_BEGIN()
	PHP_INI_ENTRY("wikidiff2.change_threshold",  WIKIDIFF2_CHANGE_THRESHOLD_DEFAULT, PHP_INI_ALL, NULL)
	PHP_INI_ENTRY("wikidiff2.moved_line_threshold",  WIKIDIFF2_MOVED_LINE_THRESHOLD_DEFAULT, PHP_INI_ALL, NULL)
	PHP_INI_ENTRY("wikidiff2.moved_paragraph_detection_cutoff",  WIKIDIFF2_MOVED_PARAGRAPH_DETECTION_CUTOFF_DEFAULT, PHP_INI_ALL, NULL)
PHP_INI_END()
/* }}} */

#ifdef COMPILE_DL_WIKIDIFF2
ZEND_GET_MODULE(wikidiff2)
#endif

PHP_MINIT_FUNCTION(wikidiff2)
{
	REGISTER_INI_ENTRIES();
	return SUCCESS;
}

PHP_MSHUTDOWN_FUNCTION(wikidiff2)
{
	UNREGISTER_INI_ENTRIES();
	return SUCCESS;
}

PHP_RINIT_FUNCTION(wikidiff2)
{
	return SUCCESS;
}

PHP_RSHUTDOWN_FUNCTION(wikidiff2)
{
	return SUCCESS;
}

PHP_MINFO_FUNCTION(wikidiff2)
{
	php_info_print_table_start();
	php_info_print_table_header(2, "wikidiff2 support", "enabled");
	php_info_print_table_row(2, "wikidiff2 version", WIKIDIFF2_VERSION_STRING);
	php_info_print_table_end();
}

/* {{{ proto string wikidiff2_do_diff(string text1, string text2, int numContextLines)
 *
 * Warning: the input text must be valid UTF-8! Do not pass user input directly
 * to this function.
 */
PHP_FUNCTION(wikidiff2_do_diff)
{
	char *text1 = NULL;
	char *text2 = NULL;
	int argc = ZEND_NUM_ARGS();
#if PHP_MAJOR_VERSION >= 7
	size_t text1_len;
	size_t text2_len;
	zend_long numContextLines;
#else
	int text1_len;
	int text2_len;
	long numContextLines;
#endif

	if (zend_parse_parameters(argc TSRMLS_CC, "ssl|l", &text1, &text1_len, &text2,
		&text2_len, &numContextLines) == FAILURE)
	{
		return;
	}


	try {
		TableDiff wikidiff2;
		Wikidiff2::String text1String(text1, text1_len);
		Wikidiff2::String text2String(text2, text2_len);
		const Wikidiff2::String & ret = wikidiff2.execute(text1String, text2String, "", (int)numContextLines, movedParagraphDetectionCutoff());
		COMPAT_RETURN_STRINGL( const_cast<char*>(ret.data()), ret.size());
	} catch (std::bad_alloc &e) {
		zend_error(E_WARNING, "Out of memory in wikidiff2_do_diff().");
	} catch (...) {
		zend_error(E_WARNING, "Unknown exception in wikidiff2_do_diff().");
	}
}

/* {{{ proto string wikidiff2_inline_diff(string text1, string text2, int numContextLines)
 *
 * Warning: the input text must be valid UTF-8! Do not pass user input directly
 * to this function.
 */
PHP_FUNCTION(wikidiff2_inline_diff)
{
	char *text1 = NULL;
	char *text2 = NULL;
	int argc = ZEND_NUM_ARGS();
#if PHP_MAJOR_VERSION >= 7
	size_t text1_len;
	size_t text2_len;
	zend_long numContextLines;
#else
	int text1_len;
	int text2_len;
	long numContextLines;
#endif

	if (zend_parse_parameters(argc TSRMLS_CC, "ssl", &text1, &text1_len, &text2,
		&text2_len, &numContextLines) == FAILURE)
	{
		return;
	}


	try {
		InlineDiff wikidiff2;
		Wikidiff2::String text1String(text1, text1_len);
		Wikidiff2::String text2String(text2, text2_len);
		const Wikidiff2::String& ret = wikidiff2.execute(text1String, text2String, "", (int)numContextLines, movedParagraphDetectionCutoff());
		COMPAT_RETURN_STRINGL( const_cast<char*>(ret.data()), ret.size());
	} catch (std::bad_alloc &e) {
		zend_error(E_WARNING, "Out of memory in wikidiff2_inline_diff().");
	} catch (...) {
		zend_error(E_WARNING, "Unknown exception in wikidiff2_inline_diff().");
	}
}

/* {{{ proto string wikidiff2_inline_json_diff(string text1, string text2, int numContextLines)
 *
 * Warning: the input text must be valid UTF-8! Do not pass user input directly
 * to this function.
 */
PHP_FUNCTION(wikidiff2_inline_json_diff)
{
	char *text1 = NULL;
	char *text2 = NULL;
	char *sectionTitleOffsets = NULL;
	int argc = ZEND_NUM_ARGS();
#if PHP_MAJOR_VERSION >= 7
	size_t text1_len;
	size_t text2_len;
	size_t sectionTitleOffsets_len;
	zend_long numContextLines;
#else
	int text1_len;
	int text2_len;
	int sectionTitleOffsets_len;
	long numContextLines;
#endif

	if (zend_parse_parameters(argc TSRMLS_CC, "sssl", &text1, &text1_len, &text2,
		&text2_len, &sectionTitleOffsets, &sectionTitleOffsets_len, &numContextLines) == FAILURE)
	{
		return;
	}


	try {
		InlineDiffJSON wikidiff2;
		Wikidiff2::String text1String(text1, text1_len);
		Wikidiff2::String text2String(text2, text2_len);
		Wikidiff2::String sectionTitleOffsetsString(sectionTitleOffsets, sectionTitleOffsets_len);
		const Wikidiff2::String& ret = wikidiff2.execute(text1String, text2String,
			sectionTitleOffsetsString, (int)numContextLines, movedParagraphDetectionCutoff());
		COMPAT_RETURN_STRINGL( const_cast<char*>(ret.data()), ret.size());
	} catch (std::bad_alloc &e) {
		zend_error(E_WARNING, "Out of memory in wikidiff2_inline_json_diff().");
	} catch (...) {
		zend_error(E_WARNING, "Unknown exception in wikidiff2_inline_json_diff().");
	}
}

/* {{{ proto string wikidiff2_version()
 */
PHP_FUNCTION(wikidiff2_version)
{
	COMPAT_RETURN_STRINGL( const_cast<char*>(WIKIDIFF2_VERSION_STRING), strlen(WIKIDIFF2_VERSION_STRING));
}

/* }}} */
