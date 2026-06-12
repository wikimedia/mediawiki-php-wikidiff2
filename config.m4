PHP_ARG_ENABLE(wikidiff2, whether to enable wikidiff2 support,
[  --enable-wikidiff2           Enable wikidiff2 support])

if test "$PHP_WIKIDIFF2" != "no"; then
  PHP_REQUIRE_CXX
  AC_LANG_CPLUSPLUS

  PKG_CHECK_MODULES([LIBTHAI], [libthai >= 0.1.25])
  PHP_EVAL_INCLINE([$LIBTHAI_CFLAGS])
  PHP_EVAL_LIBLINE([$LIBTHAI_LIBS], [WIKIDIFF2_SHARED_LIBADD])

  export OLD_CPPFLAGS="$CPPFLAGS"
  export CPPFLAGS="$CPPFLAGS $INCLUDES -DHAVE_WIKIDIFF2"
  AC_CHECK_HEADER([thai/thailib.h], [], AC_MSG_ERROR('thai/thailib.h' header not found'))
  export CPPFLAGS="$OLD_CPPFLAGS"

  PHP_SUBST(WIKIDIFF2_SHARED_LIBADD)
  AC_DEFINE(HAVE_WIKIDIFF2, 1, [ ])
  PHP_NEW_EXTENSION(wikidiff2, \
	src/php_wikidiff2.cpp \
	src/lib/Wikidiff2.cpp \
	src/lib/Formatter.cpp \
	src/lib/TableFormatter.cpp \
	src/lib/InlineFormatter.cpp \
	src/lib/InlineJSONFormatter.cpp \
	src/lib/TextUtil.cpp \
	src/lib/LineDiffProcessor.cpp \
	src/lib/WordDiffCache.cpp \
	src/lib/WordDiffSegmenter.cpp \
	src/lib/WordDiffStats.cpp, $ext_shared,, [-Wno-write-strings -std=c++17], [cxx])

  PHP_ADD_BUILD_DIR($ext_builddir/src)
  PHP_ADD_BUILD_DIR($ext_builddir/src/lib)
  PHP_ADD_INCLUDE($ext_srcdir/src)
fi
