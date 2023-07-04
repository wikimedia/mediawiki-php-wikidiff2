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

#include <memory>
#include <list>

#define WIKIDIFF2_VERSION_STRING "1.14.1"

#if PHP_VERSION_ID >= 80000
#	include "wikidiff2_arginfo.h"
#else
#	define arginfo_wikidiff2_do_diff NULL
#	define arginfo_wikidiff2_inline_diff NULL
#	define arginfo_wikidiff2_inline_json_diff NULL
#	define arginfo_wikidiff2_version NULL
#	define arginfo_wikidiff2_multi_format_diff NULL
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
	PHP_FE(wikidiff2_multi_format_diff, arginfo_wikidiff2_multi_format_diff)
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
	PHP_INI_ENTRY("wikidiff2.max_split_size", "1", PHP_INI_ALL, NULL)
	PHP_INI_ENTRY("wikidiff2.initial_split_threshold",  "0.1", PHP_INI_ALL, NULL)
	PHP_INI_ENTRY("wikidiff2.final_split_threshold",  "0.6", PHP_INI_ALL, NULL)
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
	config.maxSplitSize = INI_INT("wikidiff2.max_split_size");
	config.initialSplitThreshold = INI_FLT("wikidiff2.initial_split_threshold");
	config.finalSplitThreshold = INI_FLT("wikidiff2.final_split_threshold");
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
	php_error_docref(NULL, E_WARNING, "%s", e.what());
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
	size_t text1_len;
	size_t text2_len;
	zend_long numContextLines;

	ZEND_PARSE_PARAMETERS_START(3, 3)
		Z_PARAM_STRING(text1, text1_len)
		Z_PARAM_STRING(text2, text2_len)
		Z_PARAM_LONG(numContextLines)
	ZEND_PARSE_PARAMETERS_END();

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
		php_error_docref(NULL, E_WARNING, "out of memory");
	} catch (std::exception &e) {
		wikidiff2_handle_exception(e);
	} catch (...) {
		php_error_docref(NULL, E_WARNING, "unknown exception");
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
	size_t text1_len;
	size_t text2_len;
	zend_long numContextLines;

	ZEND_PARSE_PARAMETERS_START(3, 3)
		Z_PARAM_STRING(text1, text1_len)
		Z_PARAM_STRING(text2, text2_len)
		Z_PARAM_LONG(numContextLines)
	ZEND_PARSE_PARAMETERS_END();

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
		php_error_docref(NULL, E_WARNING, "out of memory");
	} catch (std::exception &e) {
		wikidiff2_handle_exception(e);
	} catch (...) {
		php_error_docref(NULL, E_WARNING, "unknown exception");
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
	size_t text1_len;
	size_t text2_len;
	zend_long numContextLines;

	ZEND_PARSE_PARAMETERS_START(3, 3)
		Z_PARAM_STRING(text1, text1_len)
		Z_PARAM_STRING(text2, text2_len)
		Z_PARAM_LONG(numContextLines)
	ZEND_PARSE_PARAMETERS_END();

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
		php_error_docref(NULL, E_WARNING, "out of memory");
	} catch (std::exception &e) {
		wikidiff2_handle_exception(e);
	} catch (...) {
		php_error_docref(NULL, E_WARNING, "unknown exception");
	}
}

/* {{{ proto string wikidiff2_version()
 */
PHP_FUNCTION(wikidiff2_version)
{
	COMPAT_RETURN_STRINGL( const_cast<char*>(WIKIDIFF2_VERSION_STRING), strlen(WIKIDIFF2_VERSION_STRING));
}

PHP_FUNCTION(wikidiff2_multi_format_diff)
{
	typedef std::shared_ptr<Formatter> FormatterPtr;
	typedef std::list<FormatterPtr, WD2_ALLOCATOR<FormatterPtr>> FormatterList;

	char *text1 = NULL;
	char *text2 = NULL;
	size_t text1_len;
	size_t text2_len;
	zend_array *ht_options = NULL;
	zval *zp_option;

	FormatterList formatters;

	ZEND_PARSE_PARAMETERS_START(2, 3)
		Z_PARAM_STRING(text1, text1_len)
		Z_PARAM_STRING(text2, text2_len)
		Z_PARAM_OPTIONAL
		Z_PARAM_ARRAY_HT(ht_options)
	ZEND_PARSE_PARAMETERS_END();

	Wikidiff2::Config config = wikidiff2_get_config(2);

	if (ht_options) {
		zend_long l_tmp;

		zp_option = zend_hash_str_find(ht_options, "numContextLines", sizeof("numContextLines")-1);
		if (zp_option) config.numContextLines = zval_get_long(zp_option);

		zp_option = zend_hash_str_find(ht_options, "changeThreshold", sizeof("changeThreshold")-1);
		if (zp_option) config.changeThreshold = zval_get_double(zp_option);

		zp_option = zend_hash_str_find(ht_options, "movedLineThreshold", sizeof("movedLineThreshold")-1);
		if (zp_option) config.movedLineThreshold = zval_get_double(zp_option);

		zp_option = zend_hash_str_find(ht_options, "maxMovedLines", sizeof("maxMovedLines")-1);
		if (zp_option) config.maxMovedLines = zval_get_long(zp_option);

		zp_option = zend_hash_str_find(ht_options, "maxWordLevelDiffComplexity", sizeof("maxWordLevelDiffComplexity")-1);
		if (zp_option) config.maxWordLevelDiffComplexity = zval_get_long(zp_option);

		zp_option = zend_hash_str_find(ht_options, "maxSplitSize", sizeof("maxSplitSize")-1);
		if (zp_option) config.maxSplitSize = zval_get_long(zp_option);

		zp_option = zend_hash_str_find(ht_options, "initialSplitThreshold", sizeof("initialSplitThreshold")-1);
		if (zp_option) config.initialSplitThreshold = zval_get_double(zp_option);

		zp_option = zend_hash_str_find(ht_options, "finalSplitThreshold", sizeof("finalSplitThreshold")-1);
		if (zp_option) config.finalSplitThreshold = zval_get_double(zp_option);
	}

	Wikidiff2 wikidiff2(config);

	if (ht_options) {
		zp_option = zend_hash_str_find(ht_options, "formats", sizeof("formats")-1);
		if (zp_option) {
			if (Z_TYPE_P(zp_option) == IS_ARRAY) {
				zend_array *ht_tmp = Z_ARRVAL_P(zp_option);
				zval *zp_formatter;
				ZEND_HASH_FOREACH_VAL(ht_tmp, zp_formatter) {
					if (Z_TYPE_P(zp_formatter) != IS_STRING) {
						php_error_docref(NULL, E_WARNING, "invalid formatter, should be string");
						continue;
					}
					zend_string *s = Z_STR_P(zp_formatter);
					if (zend_string_equals_literal(s, "table")) {
						formatters.push_back(std::allocate_shared<TableFormatter>(
							WD2_ALLOCATOR<TableFormatter>()));
					} else if (zend_string_equals_literal(s, "inline")) {
						formatters.push_back(std::allocate_shared<InlineFormatter>(
							WD2_ALLOCATOR<InlineFormatter>()));
					} else if (zend_string_equals_literal(s, "inlineJSON")) {
						formatters.push_back(std::allocate_shared<InlineJSONFormatter>(
							WD2_ALLOCATOR<InlineJSONFormatter>()));
					} else {
						php_error_docref(NULL, E_WARNING, "unknown formatter \"%s\"", ZSTR_VAL(s));
					}
				}
				ZEND_HASH_FOREACH_END();
			} else {
				php_error_docref(NULL, E_WARNING, "invalid formats option");
			}
		}
	}

	if (formatters.empty()) {
		formatters.push_back(std::allocate_shared<TableFormatter>(
			WD2_ALLOCATOR<TableFormatter>()));
	}

	for (auto f = formatters.begin(); f != formatters.end(); f++) {
		wikidiff2.addFormatter(**f);
	}

	try {
		Wikidiff2::String text1String(text1, text1_len);
		Wikidiff2::String text2String(text2, text2_len);
		wikidiff2.execute(text1String, text2String);
	} catch (std::bad_alloc &e) {
		php_error_docref(NULL, E_WARNING, "out of memory");
	} catch (std::exception &e) {
		wikidiff2_handle_exception(e);
	} catch (...) {
		php_error_docref(NULL, E_WARNING, "unknown exception");
	}

	HashTable * ht_ret = zend_new_array(formatters.size());
	for (auto f = formatters.begin(); f != formatters.end(); f++) {
		const char * name = (*f)->getName();
		zval z_result;
		Wikidiff2::String result = (*f)->getResult().str();
		ZVAL_STRINGL(&z_result, const_cast<char*>(result.data()), result.size());
		zend_hash_str_update(ht_ret, name, strlen(name), &z_result);
	}

	RETVAL_ARR(ht_ret);
}
/* }}} */
