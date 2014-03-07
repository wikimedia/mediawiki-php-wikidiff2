HHVM_EXTENSION(wikidiff2 hhvm_wikidiff2.cpp Wikidiff2.cpp InlineDiff.cpp TableDiff.cpp)
HHVM_SYSTEMLIB(wikidiff2 ext_wikidiff2.php)
target_link_libraries(wikidiff2 libthai.so)
