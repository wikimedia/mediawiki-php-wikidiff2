--TEST--
Inline JSON - JSON skip section titles test
--FILE--
<?php
$x = <<<EOT
Intro text here

== Section 1 ==
Line A

Line B

Line C

== Section 2 ==

Line D

Line E

Line F

=== Subsection 3===

Line G

Line H

Line I

Line J

==Section 4==

Line K

Line L

== Section 5 ==

Line M

Line N

Line O

Line P

Line Q

Line R

Line S

Line T

EOT;

#---------------------------------------------------

$y = <<<EOT
Intro text here (changed)

== Section 1 ==
Line A

Line B

Line C

== Section 2 ==

Line D

Line E

Line F

=== Subsection 3===

Line G

Line H (changed)

Line I

Line J

==Section 4==

Line K

Line L

== Section 5 ==

Line M

Line N

Line O

Line P (changed)

Line Q

Line R

Line S

Line T

EOT;

#---------------------------------------------------

print wikidiff2_inline_json_diff( $x, $y, [ 27, 67, 108, 171, 202 ], 2 );

?>
--EXPECT--
{"diff": [{"type": 3, "lineNumber": 1, "text": "Intro text here (changed)", "highlightRanges": [{"start": 15, "length": 10, "type": 0 }]},{"type": 0, "lineNumber": 2, "text": ""},{"type": 0, "lineNumber": 3, "text": "== Section 1 ==", "sectionTitleIndex": 0},{"type": 0, "lineNumber": 20, "text": "Line G", "sectionTitleIndex": 1},{"type": 0, "lineNumber": 21, "text": "", "sectionTitleIndex": 1},{"type": 3, "lineNumber": 22, "text": "Line H (changed)", "sectionTitleIndex": 1, "highlightRanges": [{"start": 6, "length": 10, "type": 0 }]},{"type": 0, "lineNumber": 23, "text": "", "sectionTitleIndex": 1},{"type": 0, "lineNumber": 24, "text": "Line I", "sectionTitleIndex": 1},{"type": 0, "lineNumber": 40, "text": "Line O", "sectionTitleIndex": 2},{"type": 0, "lineNumber": 41, "text": "", "sectionTitleIndex": 2},{"type": 3, "lineNumber": 42, "text": "Line P (changed)", "sectionTitleIndex": 2, "highlightRanges": [{"start": 6, "length": 10, "type": 0 }]},{"type": 0, "lineNumber": 43, "text": "", "sectionTitleIndex": 2},{"type": 0, "lineNumber": 44, "text": "Line Q", "sectionTitleIndex": 2}], "sectionTitles": ["== Section 1 ==","=== Subsection 3===","== Section 5 =="]}
