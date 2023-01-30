/* This is a generated file, edit the .stub.php file instead.
 * Stub hash: e0a95da74a8ccf227b40dd9dd968d1ff6626c179 */

ZEND_BEGIN_ARG_WITH_RETURN_TYPE_INFO_EX(arginfo_wikidiff2_do_diff, 0, 3, IS_STRING, 0)
	ZEND_ARG_TYPE_INFO(0, text1, IS_STRING, 0)
	ZEND_ARG_TYPE_INFO(0, text2, IS_STRING, 0)
	ZEND_ARG_TYPE_INFO(0, numContextLines, IS_LONG, 0)
ZEND_END_ARG_INFO()

#define arginfo_wikidiff2_inline_diff arginfo_wikidiff2_do_diff

#define arginfo_wikidiff2_inline_json_diff arginfo_wikidiff2_do_diff

ZEND_BEGIN_ARG_WITH_RETURN_TYPE_INFO_EX(arginfo_wikidiff2_multi_format_diff, 0, 2, IS_ARRAY, 0)
	ZEND_ARG_TYPE_INFO(0, text1, IS_STRING, 0)
	ZEND_ARG_TYPE_INFO(0, text2, IS_STRING, 0)
	ZEND_ARG_TYPE_INFO_WITH_DEFAULT_VALUE(0, options, IS_ARRAY, 0, "[]")
ZEND_END_ARG_INFO()

ZEND_BEGIN_ARG_WITH_RETURN_TYPE_INFO_EX(arginfo_wikidiff2_version, 0, 0, IS_STRING, 0)
ZEND_END_ARG_INFO()
