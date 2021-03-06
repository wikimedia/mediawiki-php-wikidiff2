# wikidiff2

Wikidiff2 is partly based on the original php-wikidiff, partly on MediaWiki's DifferenceEngine.php, and partly Tim Starling's own work. It performs word-level (space-delimited) diffs on general text, and character-level diffs on text composed of characters from the Japanese and Thai alphabets and the unified han. Japanese, Chinese and Thai do not use spaces to separate words. The input is assumed to be UTF-8 encoded. Invalid UTF-8 may cause undesirable operation, such as truncation of the output, so the input should be validated by the application. The input text should have unix-style line endings.

The output is an HTML fragment -- a number of HTML table rows with the rest of the document structure omitted. The characters "<", ">" and "&" will be HTML-escaped in the output.

A number of test files are provided:

* test-a1 and test-a2, expected output test-a.diff
* test-b1 and test-b2, expected output test-b.diff

These pairs together give 85.9% coverage of DiffEngine.h. The remaining untested part is mostly in `_DiffEngine::_shift_boundaries()`.

* chinese-reverse-1.txt and chinese-reverse-2.txt (in chinese-reverse.zip)

These files are 2.3MB each, and give a worst-case performance test. Performance in the worst case is sensitive to the performance of the associative array class used to cross-reference the strings. I tried using an STL map and a Judy array. The Judy array gave an 11% improvement in execution time over the map, which could probably be increased to 15% with further optimisation work. I don't consider that to be a sufficient improvement to warrant adding a library dependency, but the code has been left in for the benefit of Judy fans and performance perfectionists. It can be enabled by compiling with -DUSE_JUDY. The C++ wrapper for JudyHS might be of use to someone.

Wikidiff2 is a PHP extension.

## Dependencies

* GCC 4.7
* `libthai`, a Thai language support library <http://linux.thai.net/plone/TLWG/libthai/>. On Debian-based systems this also needs the `libthai0` and `libthai-dev` packages.

To build wikidiff2 as a PHP extension, you also need the `php-dev` and `pkg-config` packages.


## Compilation and installation

```
$ phpize
$ ./configure
$ make
$ sudo make install
```

## License
wikidiff2 is licensed under the GPL v2 or any later version. The GPL is incompatible
with the PHP license, meaning that any binaries of wikidiff2 are not redistributable
under either license.

## LocalSettings configuration

```
ini_set("wikidiff2.moved_line_threshold", <float>);
```

Wikidiff2 estimates similarity of added and deleted lines based on changed character count. When the similarity of an added and deleted line is greater than this threshold, the lines are displayed as moved.

Range 0.0 .. 1.0. Default 0.4.

-------

```
ini_set("wikidiff2.change_threshold", <float>);
```

Changed lines with a similarity value below this threshold will be split into a deleted line and added line. This helps matching up moved lines in some cases.

Range 0.0 .. 1.0. Default 0.2.

-------

```
ini_set("wikidiff2.moved_paragraph_detection_cutoff", <int>);
```

When the number of added and deleted lines in a table diff is greater than this limit, no attempt to detect moved lines will be made.

Default 30.
