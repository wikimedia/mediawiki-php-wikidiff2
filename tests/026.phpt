--TEST--
Inline JSON - JSON byte offset tests
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

print wikidiff2_inline_json_diff( $x, $y, 2 );

?>
--EXPECT--
{"diff": [{"type": 3, "lineNumber": 1, "text": "Intro text here (changed)", "offset": {"from": 0,"to": 0}, "highlightRanges": [{"start": 15, "length": 10, "type": 0 }]},{"type": 0, "lineNumber": 2, "text": "", "offset": {"from": 16,"to": 26}},{"type": 0, "lineNumber": 3, "text": "== Section 1 ==", "offset": {"from": 17,"to": 27}},{"type": 0, "lineNumber": 20, "text": "Line G", "offset": {"from": 119,"to": 129}},{"type": 0, "lineNumber": 21, "text": "", "offset": {"from": 126,"to": 136}},{"type": 3, "lineNumber": 22, "text": "Line H (changed)", "offset": {"from": 127,"to": 137}, "highlightRanges": [{"start": 6, "length": 10, "type": 0 }]},{"type": 0, "lineNumber": 23, "text": "", "offset": {"from": 134,"to": 154}},{"type": 0, "lineNumber": 24, "text": "Line I", "offset": {"from": 135,"to": 155}},{"type": 0, "lineNumber": 40, "text": "Line O", "offset": {"from": 215,"to": 235}},{"type": 0, "lineNumber": 41, "text": "", "offset": {"from": 222,"to": 242}},{"type": 3, "lineNumber": 42, "text": "Line P (changed)", "offset": {"from": 223,"to": 243}, "highlightRanges": [{"start": 6, "length": 10, "type": 0 }]},{"type": 0, "lineNumber": 43, "text": "", "offset": {"from": 230,"to": 260}},{"type": 0, "lineNumber": 44, "text": "Line Q", "offset": {"from": 231,"to": 261}}]}
