#ifndef PHP_WIKIDIFF2_H
#define PHP_WIKIDIFF2_H

extern zend_module_entry wikidiff2_module_entry;
#define phpext_wikidiff2_ptr &wikidiff2_module_entry

#ifdef PHP_WIN32
#	define PHP_WIKIDIFF2_API __declspec(dllexport)
#elif defined(__GNUC__) && __GNUC__ >= 4
#	define PHP_WIKIDIFF2_API __attribute__ ((visibility("default")))
#else
#	define PHP_WIKIDIFF2_API
#endif

PHP_MINIT_FUNCTION(wikidiff2);
PHP_MSHUTDOWN_FUNCTION(wikidiff2);
PHP_RINIT_FUNCTION(wikidiff2);
PHP_RSHUTDOWN_FUNCTION(wikidiff2);
PHP_MINFO_FUNCTION(wikidiff2);

PHP_FUNCTION(wikidiff2_do_diff);
PHP_FUNCTION(wikidiff2_inline_diff);
PHP_FUNCTION(wikidiff2_inline_json_diff);
PHP_FUNCTION(wikidiff2_multi_format_diff);
PHP_FUNCTION(wikidiff2_version);

#endif


/*
 * Local variables:
 * tab-width: 4
 * c-basic-offset: 4
 * End:
 * vim600: noet sw=4 ts=4 fdm=marker
 * vim<600: noet sw=4 ts=4
 */
