/* $Id$ */

#ifdef HAVE_CONFIG_H
#include "config.h"
#endif

#include "php.h"
#include "php_ini.h"
#include "ext/standard/info.h"
#include "zend_API.h"
#include "php_wikidiff2.h"
#include "lib/Wikidiff2.h"
#include "lib/TableFormatter.h"
#include "lib/InlineFormatter.h"
#include "lib/InlineJSONFormatter.h"

#define WIKIDIFF2_VERSION_STRING "1.13.0"

#if PHP_VERSION_ID >= 80000
#	include "wikidiff2_arginfo.h"
#else
#	define arginfo_wikidiff2_do_diff NULL
#	define arginfo_wikidiff2_inline_diff NULL
#	define arginfo_wikidiff2_inline_json_diff NULL
#	define arginfo_wikidiff2_version NULL
#endif

#define COMPAT_RETURN_STRINGL(s, l) { RETURN_STRINGL(s, l); return; }

#if PHP_VERSION_ID < 70000
#    error "PHP version 7 or later is required."
#endif

using wikidiff2::Wikidiff2;
using wikidiff2::Formatter;
using wikidiff2::TableFormatter;
using wikidiff2::InlineFormatter;
using wikidiff2::InlineJSONFormatter;

static int le_wikidiff2;

zend_function_entry wikidiff2_functions[] = {
	PHP_FE(wikidiff2_do_diff, arginfo_wikidiff2_do_diff)
	PHP_FE(wikidiff2_inline_diff, arginfo_wikidiff2_inline_diff)
	PHP_FE(wikidiff2_inline_json_diff, arginfo_wikidiff2_inline_json_diff)
	PHP_FE(wikidiff2_version, arginfo_wikidiff2_version)
	{NULL, NULL, NULL}
};


zend_module_entry wikidiff2_module_entry = {
	STANDARD_MODULE_HEADER,
	"wikidiff2",
	wikidiff2_functions,
	PHP_MINIT(wikidiff2),
	PHP_MSHUTDOWN(wikidiff2),
	PHP_RINIT(wikidiff2),
	PHP_RSHUTDOWN(wikidiff2),
	PHP_MINFO(wikidiff2),
	WIKIDIFF2_VERSION_STRING,
	STANDARD_MODULE_PROPERTIES
};

/* {{{ INI Settings */
PHP_INI_BEGIN()
	PHP_INI_ENTRY("wikidiff2.change_threshold",  "0.2", PHP_INI_ALL, NULL)
	PHP_INI_ENTRY("wikidiff2.moved_line_threshold",  "0.4", PHP_INI_ALL, NULL)
	PHP_INI_ENTRY("wikidiff2.moved_paragraph_detection_cutoff",  "100", PHP_INI_ALL, NULL)
	PHP_INI_ENTRY("wikidiff2.max_word_level_diff_complexity", "40000000", PHP_INI_ALL, NULL)
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

/**
 * Get Wikidiff2 config based on the php.ini settings and supplied context line value.
 */
static Wikidiff2::Config wikidiff2_get_config(int numContextLines)
{
	Wikidiff2::Config config;
	config.numContextLines = numContextLines;
	config.changeThreshold = INI_FLT("wikidiff2.change_threshold");
	config.movedLineThreshold = INI_FLT("wikidiff2.moved_line_threshold");
	config.maxMovedLines = INI_INT("wikidiff2.moved_paragraph_detection_cutoff");
	config.maxWordLevelDiffComplexity = INI_INT("wikidiff2.max_word_level_diff_complexity");
	config.maxSplitSize = 1;
	config.initialSplitThreshold = 0.1;
	config.finalSplitThreshold = 0.6;
	return config;
}

static void wikidiff2_do_diff_impl(zval *return_value, 
		const Wikidiff2::Config & config, Formatter & formatter,
		char *text1, size_t text1_len,
		char *text2, size_t text2_len)
{
	Wikidiff2 wikidiff2(config);
	wikidiff2.addFormatter(formatter);
	Wikidiff2::String text1String(text1, text1_len);
	Wikidiff2::String text2String(text2, text2_len);
	wikidiff2.execute(text1String, text2String);
	Wikidiff2::String ret = formatter.getResult().str();
	ZVAL_STRINGL(return_value, const_cast<char*>(ret.data()), ret.size());	
}

static void wikidiff2_handle_exception(std::exception & e)
{
	zend_error(E_WARNING, "Error in wikidiff2: %s", e.what());
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
	size_t text1_len;
	size_t text2_len;
	zend_long numContextLines;

	if (zend_parse_parameters(argc, "ssl|l", &text1, &text1_len, &text2,
		&text2_len, &numContextLines) == FAILURE)
	{
		return;
	}


	try {
		TableFormatter formatter;
		auto config = wikidiff2_get_config(numContextLines);
		wikidiff2_do_diff_impl(
				return_value, 
				config,
				formatter,
				text1, text1_len,
				text2, text2_len
		);
	} catch (std::bad_alloc &e) {
		zend_error(E_WARNING, "Out of memory in wikidiff2_do_diff().");
	} catch (std::exception &e) {
		wikidiff2_handle_exception(e);
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
	size_t text1_len;
	size_t text2_len;
	zend_long numContextLines;

	if (zend_parse_parameters(argc, "ssl", &text1, &text1_len, &text2,
		&text2_len, &numContextLines) == FAILURE)
	{
		return;
	}


	try {
		InlineFormatter formatter;
		wikidiff2_do_diff_impl(
				return_value, 
				wikidiff2_get_config(numContextLines), 
				formatter,
				text1, text1_len,
				text2, text2_len
		);
	} catch (std::bad_alloc &e) {
		zend_error(E_WARNING, "Out of memory in wikidiff2_inline_diff().");
	} catch (std::exception &e) {
		wikidiff2_handle_exception(e);
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
	int argc = ZEND_NUM_ARGS();
	size_t text1_len;
	size_t text2_len;
	zend_long numContextLines;

	if (zend_parse_parameters(argc, "ssl", &text1, &text1_len, &text2,
		&text2_len, &numContextLines) == FAILURE)
	{
		return;
	}


	try {
		InlineJSONFormatter formatter;
		wikidiff2_do_diff_impl(
				return_value, 
				wikidiff2_get_config(numContextLines), 
				formatter,
				text1, text1_len,
				text2, text2_len
		);
	} catch (std::bad_alloc &e) {
		zend_error(E_WARNING, "Out of memory in wikidiff2_inline_json_diff().");
	} catch (std::exception &e) {
		wikidiff2_handle_exception(e);
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
