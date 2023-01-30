# wikidiff2

Wikidiff2 is a PHP extension which formats changes between two input texts, producing HTML or JSON.

It performs word-level diffs, including support for Thai word segmentation. It can detect moved and
split lines.


## Dependencies

* GCC 4.7+
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

The licensing issue is tracked at https://phabricator.wikimedia.org/T196132


## Configuration

The following php.ini settings are supported:

### wikidiff2.moved_line_threshold

Wikidiff2 estimates similarity of added and deleted lines based on changed character count. When
the similarity of an added and deleted line is greater than this threshold, the lines are
displayed as moved.

Range 0.0 .. 1.0. Default 0.4.

### wikidiff2.change_threshold


Changed lines with a similarity value below this threshold will be split into a deleted line and
added line. This helps matching up moved lines in some cases.

Range 0.0 .. 1.0. Default 0.2.

### wikidiff2.moved_paragraph_detection_cutoff

When the number of added and deleted lines in a table diff is greater than this limit, no attempt
to detect moved lines will be made.

Default 100.

### wikidiff2.max_word_level_diff_complexity

When comparing two lines for changes within the line, a word-level diff will be
done unless the product of the LHS word count and the RHS word count exceeds
this limit.

Default 40000000.


## Usage

The input is assumed to be UTF-8 encoded. Invalid UTF-8 may cause undesirable operation, such as
truncation of the output, so the input should be validated by the application. The input text
should have UNIX-style line endings.

### wikidiff2_do_diff

``` php
function wikidiff2_do_diff(string $text1, string $text2, int $numContextLines): string
```

Compare two strings `$text1` and `$text2`, and produce output formatted as a fragment of an HTML
table, that is, a series of `<tr>` elements.

$numContextLines is the number of copied context lines shown before and after each change. Before
each block of context lines and changes, a line number will appear as an HTML comment inside a
tr/td, e.g.

```
<!--LINE 1-->
```

This allows the application to localize line numbers.


### wikidiff2_inline_diff

``` php
function wikidiff2_inline_diff(string $text1, string $text2, int $numContextLines): string
```

Compare two strings `$text1` and `$text2`, and produce output formatted as inline HTML.

### wikidiff2_inline_json_diff

``` php
function wikidiff2_inline_json_diff(string $text1, string $text2, int $numContextLines): string
```

Compare two strings `$text1` and `$text2` and produce output formatted as JSON.
See the [JSON diff format documentation](https://www.mediawiki.org/wiki/Wikidiff2/JSON_diff_format).


### wikidiff2_multi_format_diff

``` php
function wikidiff2_multi_format_diff(string $text1, string $text2, array $options = []): array
```

Compare two strings `$text1` and `$text2` with an associative array of options:

- **numContextLines**: The number of context lines shown before and after each block

- **changeThreshold**: The minimum similarity a pair of lines must have to be detected as a change
  and shown as a word-level diff. If present, this overrides php.ini `wikidiff2.change_threshold`.

- **movedLineThreshold**: The minimum similarity a pair of lines must have to be detected as a moved
  line. If present, this overrides php.ini `wikidiff2.moved_line_threshold`.

- **maxMovedLines**: The maximum number of added or deleted lines, above which no move detection will
  be performed. If present, this overrides php.ini `moved_paragraph_detection_cutoff`.

- **maxWordLevelDiffComplexity**: The maximum complexity of a word-level diff. If the product of the
  word count in the LHS and RHS exceeds this value, a word-level diff will not be done. If
  present, this overrides php.ini `wikidiff2.max_word_level_diff_complexity`.

- **maxSplitSize**: The maximum number of lines in `$text2` which may be considered for a word-level
  diff against a single line of `$text1`. Default: 1.

- **initialSplitThreshold**: The minimum similarity which must be maintained during a split detection
  search. The search terminates when the similarity falls below this level. Default: 0.1.

- **finalSplitThreshold**: The minimum similarity which must be achieved in order to display the
  comparison between one line and several lines as a split. Default 0.6.

- **formats**: An array of desired formats. Each format is one of the following strings: `table`,
  `inline` or `inlineJSON`. The default is `['table']`.

The return value is an associative array of formatted outputs. The key of each element is the
format name `table`, `inline` or `inlineJSON`, and the value is a string.

### wikidiff2_version

```php
function wikidiff2_version(): string {}
```

Produces the same thing as `phpversion('wikidiff2')`. Probably should be deprecated.
