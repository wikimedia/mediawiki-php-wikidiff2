--TEST--
Inline JSON - JSON escape test case
--FILE--
<?php
$before = <<<EOT
<ref name="RefForwardSlashQuote"/>

<ref name=RefForwardSlash/>

<ref name="RefDoubleQuote">

Test ForwardSlash/Not Backslash

<ref name="RefBackSlashQuote"\>

<ref name=RefBackSlash\>

<ref name='RefSingleQuote'>

Test BackSlash\Not Forwardslash

/ & \/

`1~!@#$%^&*()_+-={':[,]}|;.</>?

\u0123\u4567\u89AB\uCDEF\uabcd\uef4A

// /* <!-- --# -- --> */

&#34; \u0022 %22 0x22 034 &#x22;

\"\uCAFE\uBABE\uAB98\uFCDE\ubcda\uef4A`1~!@#$%^&*()_+-=[]{}|;:',./<>?

\b\f\\n\r\t

1e00,2e+00,2e-00

You can ''italicize'' text by putting 2 apostrophes on ''each'' side.

3 apostrophes will '''bold''' the text.

5 apostrophes will '''''bold and italicize''''' the text.

(Using 4 apostrophes doesn't do anything special -- <br /> 3 of them '''bold''' the text as usual; the others are ''''just'''' apostrophes  around the text.)

You can break lines<br/> without a new paragraph.<br/> Please use this sparingly.

Put text in a <kbd>monospace ('typewriter') font</kbd>. The same font is  generally used for <code> computer code</code>.

<strike>Strike out</strike> or <u>underline</u> text, or write it <span style= "font-variant:small-caps"> in small caps</span>.

Superscripts and subscripts: X<sup>2</sup>, H<sub>2</sub>O

<center>Centered text</center> * Please note the American spelling of "center".

* This is how to {{Font color||yellow|highlight part of a sentence}}.

<blockquote>
The '''blockquote''' command ''formats'' block  quotations, typically by surrounding them  with whitespace and a slightly different font.
</blockquote>

Invisible comments to editors (<!-- -->) appear only while editing the page. <!-- Note to editors: blah blah blah. -->

== Section headings ==

''Headings'' organize your writing into  sections. The ''Wiki'' software can automatically generate a [[help:Section|table of contents]] from them.

=== Subsection ===
Using more "equals" (=) signs creates a subsection.

==== A smaller subsection ====

Don't skip levels, like from two to four equals signs.

Start with 2 equals signs, not 1. If you use only 1 on each side, it will be the equivalent of h1 tags, which should be reserved for page titles.

* ''Unordered lists'' are easy to do:
** Start every line with a asterisk.
*** More asterisks indicate a deeper level.
*: Previous item continues.
** A newline
* in a list
marks the end of the list.
*Of course you can start again.

# ''Numbered lists'' are:
## Very organized
## Easy to follow
A newline marks the end of the list.
# New numbering starts with 1.

Here's a ''definition list'':
; Word : Definition of the word
; A longer phrase needing definition
: Phrase defined
; A word : Which has a definition
: Also a second definition
: And even a third

* You can even do mixed lists
*# and nest them
*# inside each other
*#* or break lines<br>in lists.
*#; definition lists
*#: can be
*#:; nested : too

External link can be used to link to a wiki page that cannot be linked to with <nowiki>[[page]]</nowiki>:
http://meta.wikimedia.org/w/index.php?title=Fotonotes&oldid=482030#Installation

You can make a link point to a different place with a [[Help:Piped link|piped link]]. Put the linkbtarget first, then the pipe character "|", then the link text.

<math>\sum_{n=0}^\infty \frac{x^n}{n!}</math>
EOT;

#---------------------------------------------------

$after = <<<EOT
<ref name="RefForwardSlashQuote"/>
<ref name=RefForwardSlash/>
<ref name="RefDoubleQuote">
Test ForwardSlash/Not Backslash
<ref name="RefBackSlashQuote"\>
<ref name=RefBackSlash\>
<ref name='RefSingleQuote'>
Test BackSlash\Not Forwardslash
/ & \/
`1~!@#$%^&*()_+-={':[,]}|;.</>?
\u0123\u4567\u89AB\uCDEF\uabcd\uef4A
// /* <!-- --# -- --> */
&#34; \u0022 %22 0x22 034 &#x22;
\"\uCAFE\uBABE\uAB98\uFCDE\ubcda\uef4A`1~!@#$%^&*()_+-=[]{}|;:',./<>?
\b\f\\n\r\t
1e00,2e+00,2e-00
You can ''italicize'' text by putting 2 apostrophes on ''each'' side.
3 apostrophes will '''bold''' the text.
5 apostrophes will '''''bold and italicize''''' the text.
(Using 4 apostrophes doesn't do anything special -- <br /> 3 of them '''bold''' the text as usual; the others are ''''just'''' apostrophes  around the text.)
You can break lines<br/> without a new paragraph.<br/> Please use this sparingly.
Put text in a <kbd>monospace ('typewriter') font</kbd>. The same font is  generally used for <code> computer code</code>.
<strike>Strike out</strike> or <u>underline</u> text, or write it <span style= "font-variant:small-caps"> in small caps</span>.
Superscripts and subscripts: X<sup>2</sup>, H<sub>2</sub>O
<center>Centered text</center> * Please note the American spelling of "center".
* This is how to {{Font color||yellow|highlight part of a sentence}}.
<blockquote>
The '''blockquote''' command ''formats'' block  quotations, typically by surrounding them  with whitespace and a slightly different font.
</blockquote>
Invisible comments to editors (<!-- -->) appear only while editing the page. <!-- Note to editors: blah blah blah. -->
== Section headings ==
''Headings'' organize your writing into  sections. The ''Wiki'' software can automatically generate a [[help:Section|table of contents]] from them.
=== Subsection ===
Using more "equals" (=) signs creates a subsection.
==== A smaller subsection ====
Don't skip levels, like from two to four equals signs.
Start with 2 equals signs, not 1. If you use only 1 on each side, it will be the equivalent of h1 tags, which should be reserved for page titles.

* ''Unordered lists'' are easy to do:
** Start every line with a asterisk (change).
*** More asterisks indicate a deeper level.
*: Previous item continues.
** A newline (change)
* in a list
marks the end of the list.
*Of course you can start again (change).

# ''Numbered lists'' are:
## Very organized (change)
## Easy to follow
A newline marks the end of the list (change).
# New numbering starts with 1.

Here's a ''definition list'':
; Word : Definition of the word (change)
; A longer phrase needing definition
: Phrase defined (change)
; A word : Which has a definition
: Also a second definition (change)
: And even a third

* You can even do mixed lists
*# and nest them (change)
*# inside each other
*#* or break lines<br>in lists (change).
*#; definition lists
*#: can be (change)
*#:; nested : too

(Change) External link can be used to link to a wiki page that cannot be linked to with <nowiki>[[page]]</nowiki>:
http://meta.wikimedia.org/w/index.php?title=Fotonotes&oldid=482030#Installation

You can make a link point to a different place with a (change) [[Help:Piped link|piped link]]. Put the linkbtarget first, then the pipe character "|", then the link text.

<math>\sum_{n=0}^\infty \frac{x^n}{n!}</math>
EOT;

#---------------------------------------------------

print wikidiff2_inline_json_diff( $before, $after, 2 );

?>
--EXPECT--
{"diff": [{"type": 0, "lineNumber": 1, "text": "<ref name=\"RefForwardSlashQuote\"/>"},{"type": 2, "text": ""},{"type": 0, "lineNumber": 2, "text": "<ref name=RefForwardSlash/>"},{"type": 2, "text": ""},{"type": 0, "lineNumber": 3, "text": "<ref name=\"RefDoubleQuote\">"},{"type": 2, "text": ""},{"type": 0, "lineNumber": 4, "text": "Test ForwardSlash/Not Backslash"},{"type": 2, "text": ""},{"type": 0, "lineNumber": 5, "text": "<ref name=\"RefBackSlashQuote\"\\>"},{"type": 2, "text": ""},{"type": 0, "lineNumber": 6, "text": "<ref name=RefBackSlash\\>"},{"type": 2, "text": ""},{"type": 0, "lineNumber": 7, "text": "<ref name='RefSingleQuote'>"},{"type": 2, "text": ""},{"type": 0, "lineNumber": 8, "text": "Test BackSlash\\Not Forwardslash"},{"type": 2, "text": ""},{"type": 0, "lineNumber": 9, "text": "/ & \\/"},{"type": 2, "text": ""},{"type": 0, "lineNumber": 10, "text": "`1~!@#$%^&*()_+-={':[,]}|;.</>?"},{"type": 2, "text": ""},{"type": 0, "lineNumber": 11, "text": "\\u0123\\u4567\\u89AB\\uCDEF\\uabcd\\uef4A"},{"type": 2, "text": ""},{"type": 0, "lineNumber": 12, "text": "// /* <!-- --# -- --> */"},{"type": 2, "text": ""},{"type": 0, "lineNumber": 13, "text": "&#34; \\u0022 %22 0x22 034 &#x22;"},{"type": 2, "text": ""},{"type": 0, "lineNumber": 14, "text": "\\\"\\uCAFE\\uBABE\\uAB98\\uFCDE\\ubcda\\uef4A`1~!@#$%^&*()_+-=[]{}|;:',./<>?"},{"type": 2, "text": ""},{"type": 0, "lineNumber": 15, "text": "\\b\f\\n\r\t"},{"type": 2, "text": ""},{"type": 0, "lineNumber": 16, "text": "1e00,2e+00,2e-00"},{"type": 2, "text": ""},{"type": 0, "lineNumber": 17, "text": "You can ''italicize'' text by putting 2 apostrophes on ''each'' side."},{"type": 2, "text": ""},{"type": 0, "lineNumber": 18, "text": "3 apostrophes will '''bold''' the text."},{"type": 2, "text": ""},{"type": 0, "lineNumber": 19, "text": "5 apostrophes will '''''bold and italicize''''' the text."},{"type": 2, "text": ""},{"type": 0, "lineNumber": 20, "text": "(Using 4 apostrophes doesn't do anything special -- <br /> 3 of them '''bold''' the text as usual; the others are ''''just'''' apostrophes  around the text.)"},{"type": 2, "text": ""},{"type": 0, "lineNumber": 21, "text": "You can break lines<br/> without a new paragraph.<br/> Please use this sparingly."},{"type": 2, "text": ""},{"type": 0, "lineNumber": 22, "text": "Put text in a <kbd>monospace ('typewriter') font</kbd>. The same font is  generally used for <code> computer code</code>."},{"type": 2, "text": ""},{"type": 0, "lineNumber": 23, "text": "<strike>Strike out</strike> or <u>underline</u> text, or write it <span style= \"font-variant:small-caps\"> in small caps</span>."},{"type": 2, "text": ""},{"type": 0, "lineNumber": 24, "text": "Superscripts and subscripts: X<sup>2</sup>, H<sub>2</sub>O"},{"type": 2, "text": ""},{"type": 0, "lineNumber": 25, "text": "<center>Centered text</center> * Please note the American spelling of \"center\"."},{"type": 2, "text": ""},{"type": 0, "lineNumber": 26, "text": "* This is how to {{Font color||yellow|highlight part of a sentence}}."},{"type": 2, "text": ""},{"type": 0, "lineNumber": 27, "text": "<blockquote>"},{"type": 0, "lineNumber": 28, "text": "The '''blockquote''' command ''formats'' block  quotations, typically by surrounding them  with whitespace and a slightly different font."},{"type": 0, "lineNumber": 29, "text": "</blockquote>"},{"type": 2, "text": ""},{"type": 0, "lineNumber": 30, "text": "Invisible comments to editors (<!-- -->) appear only while editing the page. <!-- Note to editors: blah blah blah. -->"},{"type": 2, "text": ""},{"type": 0, "lineNumber": 31, "text": "== Section headings =="},{"type": 2, "text": ""},{"type": 0, "lineNumber": 32, "text": "''Headings'' organize your writing into  sections. The ''Wiki'' software can automatically generate a [[help:Section|table of contents]] from them."},{"type": 2, "text": ""},{"type": 0, "lineNumber": 33, "text": "=== Subsection ==="},{"type": 0, "lineNumber": 34, "text": "Using more \"equals\" (=) signs creates a subsection."},{"type": 2, "text": ""},{"type": 0, "lineNumber": 35, "text": "==== A smaller subsection ===="},{"type": 2, "text": ""},{"type": 0, "lineNumber": 36, "text": "Don't skip levels, like from two to four equals signs."},{"type": 2, "text": ""},{"type": 0, "lineNumber": 37, "text": "Start with 2 equals signs, not 1. If you use only 1 on each side, it will be the equivalent of h1 tags, which should be reserved for page titles."},{"type": 0, "lineNumber": 38, "text": ""},{"type": 0, "lineNumber": 39, "text": "* ''Unordered lists'' are easy to do:"},{"type": 3, "lineNumber": 40, "text": "** Start every line with a asterisk (change).", "highlightRanges": [{"start": 35, "length": 9, "type": 0 }]},{"type": 0, "lineNumber": 41, "text": "*** More asterisks indicate a deeper level."},{"type": 0, "lineNumber": 42, "text": "*: Previous item continues."},{"type": 3, "lineNumber": 43, "text": "** A newline (change)", "highlightRanges": [{"start": 12, "length": 9, "type": 0 }]},{"type": 0, "lineNumber": 44, "text": "* in a list"},{"type": 0, "lineNumber": 45, "text": "marks the end of the list."},{"type": 3, "lineNumber": 46, "text": "*Of course you can start again (change).", "highlightRanges": [{"start": 30, "length": 9, "type": 0 }]},{"type": 0, "lineNumber": 47, "text": ""},{"type": 0, "lineNumber": 48, "text": "# ''Numbered lists'' are:"},{"type": 3, "lineNumber": 49, "text": "## Very organized (change)", "highlightRanges": [{"start": 17, "length": 9, "type": 0 }]},{"type": 0, "lineNumber": 50, "text": "## Easy to follow"},{"type": 3, "lineNumber": 51, "text": "A newline marks the end of the list (change).", "highlightRanges": [{"start": 35, "length": 9, "type": 0 }]},{"type": 0, "lineNumber": 52, "text": "# New numbering starts with 1."},{"type": 0, "lineNumber": 53, "text": ""},{"type": 0, "lineNumber": 54, "text": "Here's a ''definition list'':"},{"type": 3, "lineNumber": 55, "text": "; Word : Definition of the word (change)", "highlightRanges": [{"start": 31, "length": 9, "type": 0 }]},{"type": 0, "lineNumber": 56, "text": "; A longer phrase needing definition"},{"type": 3, "lineNumber": 57, "text": ": Phrase defined (change)", "highlightRanges": [{"start": 16, "length": 9, "type": 0 }]},{"type": 0, "lineNumber": 58, "text": "; A word : Which has a definition"},{"type": 3, "lineNumber": 59, "text": ": Also a second definition (change)", "highlightRanges": [{"start": 26, "length": 9, "type": 0 }]},{"type": 0, "lineNumber": 60, "text": ": And even a third"},{"type": 0, "lineNumber": 61, "text": ""},{"type": 0, "lineNumber": 62, "text": "* You can even do mixed lists"},{"type": 3, "lineNumber": 63, "text": "*# and nest them (change)", "highlightRanges": [{"start": 16, "length": 9, "type": 0 }]},{"type": 0, "lineNumber": 64, "text": "*# inside each other"},{"type": 3, "lineNumber": 65, "text": "*#* or break lines<br>in lists (change).", "highlightRanges": [{"start": 30, "length": 9, "type": 0 }]},{"type": 0, "lineNumber": 66, "text": "*#; definition lists"},{"type": 3, "lineNumber": 67, "text": "*#: can be (change)", "highlightRanges": [{"start": 10, "length": 9, "type": 0 }]},{"type": 0, "lineNumber": 68, "text": "*#:; nested : too"},{"type": 0, "lineNumber": 69, "text": ""},{"type": 3, "lineNumber": 70, "text": "(Change) External link can be used to link to a wiki page that cannot be linked to with <nowiki>[[page]]</nowiki>:", "highlightRanges": [{"start": 0, "length": 9, "type": 0 }]},{"type": 0, "lineNumber": 71, "text": "http://meta.wikimedia.org/w/index.php?title=Fotonotes&oldid=482030#Installation"},{"type": 0, "lineNumber": 72, "text": ""},{"type": 3, "lineNumber": 73, "text": "You can make a link point to a different place with a (change) [[Help:Piped link|piped link]]. Put the linkbtarget first, then the pipe character \"|\", then the link text.", "highlightRanges": [{"start": 53, "length": 9, "type": 0 }]},{"type": 0, "lineNumber": 74, "text": ""},{"type": 0, "lineNumber": 75, "text": "<math>\\sum_{n=0}^\\infty \frac{x^n}{n!}</math>"}]}
