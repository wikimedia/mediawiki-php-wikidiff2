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
{"diff": [{"type": 0, "lineNumber": 1, "text": "<ref name=\"RefForwardSlashQuote\"/>", "offset": {"from": 0,"to": 0}},{"type": 2, "text": "", "offset": {"from": 35,"to": null}},{"type": 0, "lineNumber": 2, "text": "<ref name=RefForwardSlash/>", "offset": {"from": 36,"to": 35}},{"type": 2, "text": "", "offset": {"from": 64,"to": null}},{"type": 0, "lineNumber": 3, "text": "<ref name=\"RefDoubleQuote\">", "offset": {"from": 65,"to": 63}},{"type": 2, "text": "", "offset": {"from": 93,"to": null}},{"type": 0, "lineNumber": 4, "text": "Test ForwardSlash/Not Backslash", "offset": {"from": 94,"to": 91}},{"type": 2, "text": "", "offset": {"from": 126,"to": null}},{"type": 0, "lineNumber": 5, "text": "<ref name=\"RefBackSlashQuote\"\\>", "offset": {"from": 127,"to": 123}},{"type": 2, "text": "", "offset": {"from": 159,"to": null}},{"type": 0, "lineNumber": 6, "text": "<ref name=RefBackSlash\\>", "offset": {"from": 160,"to": 155}},{"type": 2, "text": "", "offset": {"from": 185,"to": null}},{"type": 0, "lineNumber": 7, "text": "<ref name='RefSingleQuote'>", "offset": {"from": 186,"to": 180}},{"type": 2, "text": "", "offset": {"from": 214,"to": null}},{"type": 0, "lineNumber": 8, "text": "Test BackSlash\\Not Forwardslash", "offset": {"from": 215,"to": 208}},{"type": 2, "text": "", "offset": {"from": 247,"to": null}},{"type": 0, "lineNumber": 9, "text": "/ & \\/", "offset": {"from": 248,"to": 240}},{"type": 2, "text": "", "offset": {"from": 255,"to": null}},{"type": 0, "lineNumber": 10, "text": "`1~!@#$%^&*()_+-={':[,]}|;.</>?", "offset": {"from": 256,"to": 247}},{"type": 2, "text": "", "offset": {"from": 288,"to": null}},{"type": 0, "lineNumber": 11, "text": "\\u0123\\u4567\\u89AB\\uCDEF\\uabcd\\uef4A", "offset": {"from": 289,"to": 279}},{"type": 2, "text": "", "offset": {"from": 326,"to": null}},{"type": 0, "lineNumber": 12, "text": "// /* <!-- --# -- --> */", "offset": {"from": 327,"to": 316}},{"type": 2, "text": "", "offset": {"from": 352,"to": null}},{"type": 0, "lineNumber": 13, "text": "&#34; \\u0022 %22 0x22 034 &#x22;", "offset": {"from": 353,"to": 341}},{"type": 2, "text": "", "offset": {"from": 386,"to": null}},{"type": 0, "lineNumber": 14, "text": "\\\"\\uCAFE\\uBABE\\uAB98\\uFCDE\\ubcda\\uef4A`1~!@#$%^&*()_+-=[]{}|;:',./<>?", "offset": {"from": 387,"to": 374}},{"type": 2, "text": "", "offset": {"from": 457,"to": null}},{"type": 0, "lineNumber": 15, "text": "\\b\f\\n\r\t", "offset": {"from": 458,"to": 444}},{"type": 2, "text": "", "offset": {"from": 466,"to": null}},{"type": 0, "lineNumber": 16, "text": "1e00,2e+00,2e-00", "offset": {"from": 467,"to": 452}},{"type": 2, "text": "", "offset": {"from": 484,"to": null}},{"type": 0, "lineNumber": 17, "text": "You can ''italicize'' text by putting 2 apostrophes on ''each'' side.", "offset": {"from": 485,"to": 469}},{"type": 2, "text": "", "offset": {"from": 555,"to": null}},{"type": 0, "lineNumber": 18, "text": "3 apostrophes will '''bold''' the text.", "offset": {"from": 556,"to": 539}},{"type": 2, "text": "", "offset": {"from": 596,"to": null}},{"type": 0, "lineNumber": 19, "text": "5 apostrophes will '''''bold and italicize''''' the text.", "offset": {"from": 597,"to": 579}},{"type": 2, "text": "", "offset": {"from": 655,"to": null}},{"type": 0, "lineNumber": 20, "text": "(Using 4 apostrophes doesn't do anything special -- <br /> 3 of them '''bold''' the text as usual; the others are ''''just'''' apostrophes  around the text.)", "offset": {"from": 656,"to": 637}},{"type": 2, "text": "", "offset": {"from": 814,"to": null}},{"type": 0, "lineNumber": 21, "text": "You can break lines<br/> without a new paragraph.<br/> Please use this sparingly.", "offset": {"from": 815,"to": 795}},{"type": 2, "text": "", "offset": {"from": 897,"to": null}},{"type": 0, "lineNumber": 22, "text": "Put text in a <kbd>monospace ('typewriter') font</kbd>. The same font is  generally used for <code> computer code</code>.", "offset": {"from": 898,"to": 877}},{"type": 2, "text": "", "offset": {"from": 1020,"to": null}},{"type": 0, "lineNumber": 23, "text": "<strike>Strike out</strike> or <u>underline</u> text, or write it <span style= \"font-variant:small-caps\"> in small caps</span>.", "offset": {"from": 1021,"to": 999}},{"type": 2, "text": "", "offset": {"from": 1149,"to": null}},{"type": 0, "lineNumber": 24, "text": "Superscripts and subscripts: X<sup>2</sup>, H<sub>2</sub>O", "offset": {"from": 1150,"to": 1127}},{"type": 2, "text": "", "offset": {"from": 1209,"to": null}},{"type": 0, "lineNumber": 25, "text": "<center>Centered text</center> * Please note the American spelling of \"center\".", "offset": {"from": 1210,"to": 1186}},{"type": 2, "text": "", "offset": {"from": 1290,"to": null}},{"type": 0, "lineNumber": 26, "text": "* This is how to {{Font color||yellow|highlight part of a sentence}}.", "offset": {"from": 1291,"to": 1266}},{"type": 2, "text": "", "offset": {"from": 1361,"to": null}},{"type": 0, "lineNumber": 27, "text": "<blockquote>", "offset": {"from": 1362,"to": 1336}},{"type": 0, "lineNumber": 28, "text": "The '''blockquote''' command ''formats'' block  quotations, typically by surrounding them  with whitespace and a slightly different font.", "offset": {"from": 1375,"to": 1349}},{"type": 0, "lineNumber": 29, "text": "</blockquote>", "offset": {"from": 1513,"to": 1487}},{"type": 2, "text": "", "offset": {"from": 1527,"to": null}},{"type": 0, "lineNumber": 30, "text": "Invisible comments to editors (<!-- -->) appear only while editing the page. <!-- Note to editors: blah blah blah. -->", "offset": {"from": 1528,"to": 1501}},{"type": 2, "text": "", "offset": {"from": 1647,"to": null}},{"type": 0, "lineNumber": 31, "text": "== Section headings ==", "offset": {"from": 1648,"to": 1620}},{"type": 2, "text": "", "offset": {"from": 1671,"to": null}},{"type": 0, "lineNumber": 32, "text": "''Headings'' organize your writing into  sections. The ''Wiki'' software can automatically generate a [[help:Section|table of contents]] from them.", "offset": {"from": 1672,"to": 1643}},{"type": 2, "text": "", "offset": {"from": 1820,"to": null}},{"type": 0, "lineNumber": 33, "text": "=== Subsection ===", "offset": {"from": 1821,"to": 1791}},{"type": 0, "lineNumber": 34, "text": "Using more \"equals\" (=) signs creates a subsection.", "offset": {"from": 1840,"to": 1810}},{"type": 2, "text": "", "offset": {"from": 1892,"to": null}},{"type": 0, "lineNumber": 35, "text": "==== A smaller subsection ====", "offset": {"from": 1893,"to": 1862}},{"type": 2, "text": "", "offset": {"from": 1924,"to": null}},{"type": 0, "lineNumber": 36, "text": "Don't skip levels, like from two to four equals signs.", "offset": {"from": 1925,"to": 1893}},{"type": 2, "text": "", "offset": {"from": 1980,"to": null}},{"type": 0, "lineNumber": 37, "text": "Start with 2 equals signs, not 1. If you use only 1 on each side, it will be the equivalent of h1 tags, which should be reserved for page titles.", "offset": {"from": 1981,"to": 1948}},{"type": 0, "lineNumber": 38, "text": "", "offset": {"from": 2127,"to": 2094}},{"type": 0, "lineNumber": 39, "text": "* ''Unordered lists'' are easy to do:", "offset": {"from": 2128,"to": 2095}},{"type": 3, "lineNumber": 40, "text": "** Start every line with a asterisk (change).", "offset": {"from": 2166,"to": 2133}, "highlightRanges": [{"start": 35, "length": 9, "type": 0 }]},{"type": 0, "lineNumber": 41, "text": "*** More asterisks indicate a deeper level.", "offset": {"from": 2203,"to": 2179}},{"type": 0, "lineNumber": 42, "text": "*: Previous item continues.", "offset": {"from": 2247,"to": 2223}},{"type": 3, "lineNumber": 43, "text": "** A newline (change)", "offset": {"from": 2275,"to": 2251}, "highlightRanges": [{"start": 12, "length": 9, "type": 0 }]},{"type": 0, "lineNumber": 44, "text": "* in a list", "offset": {"from": 2288,"to": 2273}},{"type": 0, "lineNumber": 45, "text": "marks the end of the list.", "offset": {"from": 2300,"to": 2285}},{"type": 3, "lineNumber": 46, "text": "*Of course you can start again (change).", "offset": {"from": 2327,"to": 2312}, "highlightRanges": [{"start": 30, "length": 9, "type": 0 }]},{"type": 0, "lineNumber": 47, "text": "", "offset": {"from": 2359,"to": 2353}},{"type": 0, "lineNumber": 48, "text": "# ''Numbered lists'' are:", "offset": {"from": 2360,"to": 2354}},{"type": 3, "lineNumber": 49, "text": "## Very organized (change)", "offset": {"from": 2386,"to": 2380}, "highlightRanges": [{"start": 17, "length": 9, "type": 0 }]},{"type": 0, "lineNumber": 50, "text": "## Easy to follow", "offset": {"from": 2404,"to": 2407}},{"type": 3, "lineNumber": 51, "text": "A newline marks the end of the list (change).", "offset": {"from": 2422,"to": 2425}, "highlightRanges": [{"start": 35, "length": 9, "type": 0 }]},{"type": 0, "lineNumber": 52, "text": "# New numbering starts with 1.", "offset": {"from": 2459,"to": 2471}},{"type": 0, "lineNumber": 53, "text": "", "offset": {"from": 2490,"to": 2502}},{"type": 0, "lineNumber": 54, "text": "Here's a ''definition list'':", "offset": {"from": 2491,"to": 2503}},{"type": 3, "lineNumber": 55, "text": "; Word : Definition of the word (change)", "offset": {"from": 2521,"to": 2533}, "highlightRanges": [{"start": 31, "length": 9, "type": 0 }]},{"type": 0, "lineNumber": 56, "text": "; A longer phrase needing definition", "offset": {"from": 2553,"to": 2574}},{"type": 3, "lineNumber": 57, "text": ": Phrase defined (change)", "offset": {"from": 2590,"to": 2611}, "highlightRanges": [{"start": 16, "length": 9, "type": 0 }]},{"type": 0, "lineNumber": 58, "text": "; A word : Which has a definition", "offset": {"from": 2607,"to": 2637}},{"type": 3, "lineNumber": 59, "text": ": Also a second definition (change)", "offset": {"from": 2641,"to": 2671}, "highlightRanges": [{"start": 26, "length": 9, "type": 0 }]},{"type": 0, "lineNumber": 60, "text": ": And even a third", "offset": {"from": 2668,"to": 2707}},{"type": 0, "lineNumber": 61, "text": "", "offset": {"from": 2687,"to": 2726}},{"type": 0, "lineNumber": 62, "text": "* You can even do mixed lists", "offset": {"from": 2688,"to": 2727}},{"type": 3, "lineNumber": 63, "text": "*# and nest them (change)", "offset": {"from": 2718,"to": 2757}, "highlightRanges": [{"start": 16, "length": 9, "type": 0 }]},{"type": 0, "lineNumber": 64, "text": "*# inside each other", "offset": {"from": 2735,"to": 2783}},{"type": 3, "lineNumber": 65, "text": "*#* or break lines<br>in lists (change).", "offset": {"from": 2756,"to": 2804}, "highlightRanges": [{"start": 30, "length": 9, "type": 0 }]},{"type": 0, "lineNumber": 66, "text": "*#; definition lists", "offset": {"from": 2788,"to": 2845}},{"type": 3, "lineNumber": 67, "text": "*#: can be (change)", "offset": {"from": 2809,"to": 2866}, "highlightRanges": [{"start": 10, "length": 9, "type": 0 }]},{"type": 0, "lineNumber": 68, "text": "*#:; nested : too", "offset": {"from": 2820,"to": 2886}},{"type": 0, "lineNumber": 69, "text": "", "offset": {"from": 2838,"to": 2904}},{"type": 3, "lineNumber": 70, "text": "(Change) External link can be used to link to a wiki page that cannot be linked to with <nowiki>[[page]]</nowiki>:", "offset": {"from": 2839,"to": 2905}, "highlightRanges": [{"start": 0, "length": 9, "type": 0 }]},{"type": 0, "lineNumber": 71, "text": "http://meta.wikimedia.org/w/index.php?title=Fotonotes&oldid=482030#Installation", "offset": {"from": 2945,"to": 3020}},{"type": 0, "lineNumber": 72, "text": "", "offset": {"from": 3025,"to": 3100}},{"type": 3, "lineNumber": 73, "text": "You can make a link point to a different place with a (change) [[Help:Piped link|piped link]]. Put the linkbtarget first, then the pipe character \"|\", then the link text.", "offset": {"from": 3026,"to": 3101}, "highlightRanges": [{"start": 53, "length": 9, "type": 0 }]},{"type": 0, "lineNumber": 74, "text": "", "offset": {"from": 3188,"to": 3272}},{"type": 0, "lineNumber": 75, "text": "<math>\\sum_{n=0}^\\infty \frac{x^n}{n!}</math>", "offset": {"from": 3189,"to": 3273}}]}
