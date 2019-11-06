--TEST--
Inline JSON - JSON multibyte offset tests
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

Line F

Line D

Line E 日

=== Subsection 3===

Line G

Line H 一

Line J

==Section 4==

Line K

Line L

== Section 5 ==

Line M

Line N

Line I

Line O

Line P 月

Line Q

Line R

Line S

Line T

EOT;

#---------------------------------------------------

print wikidiff2_inline_json_diff( $x, $y, 2 );

?>
--EXPECT--
{"diff": [{"type": 3, "lineNumber": 1, "text": "Intro text here (changed)", "offset": {"from": 0,"to": 0}, "highlightRanges": [{"start": 15, "length": 10, "type": 0 }]},{"type": 0, "lineNumber": 2, "text": "", "offset": {"from": 16,"to": 26}},{"type": 0, "lineNumber": 3, "text": "== Section 1 ==", "offset": {"from": 17,"to": 27}},{"type": 0, "lineNumber": 9, "text": "", "offset": {"from": 56,"to": 66}},{"type": 0, "lineNumber": 10, "text": "== Section 2 ==", "offset": {"from": 57,"to": 67}},{"type": 1, "lineNumber": 11, "text": "", "offset": {"from": null,"to": 83}},{"type": 5, "lineNumber": 12, "moveInfo": {"id": "movedpara_2_1_rhs", "linkId": "movedpara_5_1_lhs", "linkDirection": 0}, "text": "Line F", "offset": {"from": null,"to": 84}, "highlightRanges": []},{"type": 0, "lineNumber": 13, "text": "", "offset": {"from": 73,"to": 91}},{"type": 0, "lineNumber": 14, "text": "Line D", "offset": {"from": 74,"to": 92}},{"type": 0, "lineNumber": 15, "text": "", "offset": {"from": 81,"to": 99}},{"type": 3, "lineNumber": 16, "text": "Line E 日", "offset": {"from": 82,"to": 100}, "highlightRanges": [{"start": 6, "length": 4, "type": 0 }]},{"type": 2, "text": "", "offset": {"from": 89,"to": null}},{"type": 4, "moveInfo": {"id": "movedpara_5_1_lhs", "linkId": "movedpara_2_1_rhs", "linkDirection": 1}, "text": "Line F", "offset": {"from": 90,"to": null}},{"type": 0, "lineNumber": 17, "text": "", "offset": {"from": 97,"to": 111}},{"type": 0, "lineNumber": 18, "text": "=== Subsection 3===", "offset": {"from": 98,"to": 112}},{"type": 0, "lineNumber": 20, "text": "Line G", "offset": {"from": 119,"to": 133}},{"type": 0, "lineNumber": 21, "text": "", "offset": {"from": 126,"to": 140}},{"type": 3, "lineNumber": 22, "text": "Line H 一", "offset": {"from": 127,"to": 141}, "highlightRanges": [{"start": 6, "length": 4, "type": 0 }]},{"type": 2, "text": "", "offset": {"from": 134,"to": null}},{"type": 4, "moveInfo": {"id": "movedpara_8_1_lhs", "linkId": "movedpara_10_1_rhs", "linkDirection": 0}, "text": "Line I", "offset": {"from": 135,"to": null}},{"type": 0, "lineNumber": 23, "text": "", "offset": {"from": 142,"to": 152}},{"type": 0, "lineNumber": 24, "text": "Line J", "offset": {"from": 143,"to": 153}},{"type": 0, "lineNumber": 35, "text": "", "offset": {"from": 206,"to": 216}},{"type": 0, "lineNumber": 36, "text": "Line N", "offset": {"from": 207,"to": 217}},{"type": 1, "lineNumber": 37, "text": "", "offset": {"from": null,"to": 224}},{"type": 5, "lineNumber": 38, "moveInfo": {"id": "movedpara_10_1_rhs", "linkId": "movedpara_8_1_lhs", "linkDirection": 1}, "text": "Line I", "offset": {"from": null,"to": 225}, "highlightRanges": []},{"type": 0, "lineNumber": 39, "text": "", "offset": {"from": 214,"to": 232}},{"type": 0, "lineNumber": 40, "text": "Line O", "offset": {"from": 215,"to": 233}},{"type": 0, "lineNumber": 41, "text": "", "offset": {"from": 222,"to": 240}},{"type": 3, "lineNumber": 42, "text": "Line P 月", "offset": {"from": 223,"to": 241}, "highlightRanges": [{"start": 6, "length": 4, "type": 0 }]},{"type": 0, "lineNumber": 43, "text": "", "offset": {"from": 230,"to": 252}},{"type": 0, "lineNumber": 44, "text": "Line Q", "offset": {"from": 231,"to": 253}}]}
