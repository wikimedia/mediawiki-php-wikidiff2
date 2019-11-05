--TEST--
Inline JSON - Diff test A
--FILE--
<?php
$x = <<<EOT
== Added line ==

== Removed line ==

kjahegwnygw
== Moved text ==
a
---line---
a
a
a
a
a
a
a
a
== Two moved lines ==
a
a
a
--line1--
--line2--
a
a
a
a
a
a
a
a
a
a
a
a
a
== Shortest sequence in Y ==
x1
x2
x1
x2
x1
x2
x1
x2
context
context
context
context
context
== Changed line ==
blah blah blah 1


EOT;

#---------------------------------------------------

$y = <<<EOT
== Added line ==

sjgfkdjfgb
== Removed line ==

== Moved text ==
a
a
a
a
a
a
a
---line---
a
a
== Two moved lines ==
a
a
a
a
a
a
a
a
a
a
a
--line1--
--line2--
a
a
a
a
a
== Shortest sequence in Y ==
x2
x1
x2
x1
context
context
context
context
context
== Changed line ==
blah blah blah 2


EOT;

#---------------------------------------------------

print wikidiff2_inline_json_diff( $x, $y, 2 );

?>
--EXPECT--
{"diff": [{"type": 0, "lineNumber": 1, "text": "== Added line ==", "offset": {"from": 0,"to": 0}},{"type": 0, "lineNumber": 2, "text": "", "offset": {"from": 17,"to": 17}},{"type": 1, "lineNumber": 3, "text": "sjgfkdjfgb", "offset": {"from": null,"to": 18}},{"type": 0, "lineNumber": 4, "text": "== Removed line ==", "offset": {"from": 18,"to": 29}},{"type": 0, "lineNumber": 5, "text": "", "offset": {"from": 37,"to": 48}},{"type": 2, "text": "kjahegwnygw", "offset": {"from": 38,"to": null}},{"type": 0, "lineNumber": 6, "text": "== Moved text ==", "offset": {"from": 50,"to": 49}},{"type": 0, "lineNumber": 7, "text": "a", "offset": {"from": 67,"to": 66}},{"type": 4, "moveInfo": {"id": "movedpara_5_0_lhs", "linkId": "movedpara_7_0_rhs", "linkDirection": 0}, "text": "---line---", "offset": {"from": 69,"to": null}},{"type": 0, "lineNumber": 8, "text": "a", "offset": {"from": 80,"to": 68}},{"type": 0, "lineNumber": 9, "text": "a", "offset": {"from": 82,"to": 70}},{"type": 0, "lineNumber": 12, "text": "a", "offset": {"from": 88,"to": 76}},{"type": 0, "lineNumber": 13, "text": "a", "offset": {"from": 90,"to": 78}},{"type": 5, "lineNumber": 14, "moveInfo": {"id": "movedpara_7_0_rhs", "linkId": "movedpara_5_0_lhs", "linkDirection": 1}, "text": "---line---", "offset": {"from": null,"to": 80}, "highlightRanges": []},{"type": 0, "lineNumber": 15, "text": "a", "offset": {"from": 92,"to": 91}},{"type": 0, "lineNumber": 16, "text": "a", "offset": {"from": 94,"to": 93}},{"type": 0, "lineNumber": 19, "text": "a", "offset": {"from": 120,"to": 119}},{"type": 0, "lineNumber": 20, "text": "a", "offset": {"from": 122,"to": 121}},{"type": 4, "moveInfo": {"id": "movedpara_9_0_lhs", "linkId": "movedpara_11_0_rhs", "linkDirection": 0}, "text": "--line1--", "offset": {"from": 124,"to": null}},{"type": 4, "moveInfo": {"id": "movedpara_9_1_lhs", "linkId": "movedpara_11_1_rhs", "linkDirection": 0}, "text": "--line2--", "offset": {"from": 134,"to": null}},{"type": 0, "lineNumber": 21, "text": "a", "offset": {"from": 144,"to": 123}},{"type": 0, "lineNumber": 22, "text": "a", "offset": {"from": 146,"to": 125}},{"type": 0, "lineNumber": 27, "text": "a", "offset": {"from": 156,"to": 135}},{"type": 0, "lineNumber": 28, "text": "a", "offset": {"from": 158,"to": 137}},{"type": 5, "lineNumber": 29, "moveInfo": {"id": "movedpara_11_0_rhs", "linkId": "movedpara_9_0_lhs", "linkDirection": 1}, "text": "--line1--", "offset": {"from": null,"to": 139}, "highlightRanges": []},{"type": 5, "lineNumber": 30, "moveInfo": {"id": "movedpara_11_1_rhs", "linkId": "movedpara_9_1_lhs", "linkDirection": 1}, "text": "--line2--", "offset": {"from": null,"to": 149}, "highlightRanges": []},{"type": 0, "lineNumber": 31, "text": "a", "offset": {"from": 160,"to": 159}},{"type": 0, "lineNumber": 32, "text": "a", "offset": {"from": 162,"to": 161}},{"type": 0, "lineNumber": 35, "text": "a", "offset": {"from": 168,"to": 167}},{"type": 0, "lineNumber": 36, "text": "== Shortest sequence in Y ==", "offset": {"from": 170,"to": 169}},{"type": 2, "text": "x1", "offset": {"from": 199,"to": null}},{"type": 0, "lineNumber": 37, "text": "x2", "offset": {"from": 202,"to": 198}},{"type": 0, "lineNumber": 38, "text": "x1", "offset": {"from": 205,"to": 201}},{"type": 0, "lineNumber": 39, "text": "x2", "offset": {"from": 208,"to": 204}},{"type": 0, "lineNumber": 40, "text": "x1", "offset": {"from": 211,"to": 207}},{"type": 2, "text": "x2", "offset": {"from": 214,"to": null}},{"type": 2, "text": "x1", "offset": {"from": 217,"to": null}},{"type": 2, "text": "x2", "offset": {"from": 220,"to": null}},{"type": 0, "lineNumber": 41, "text": "context", "offset": {"from": 223,"to": 210}},{"type": 0, "lineNumber": 42, "text": "context", "offset": {"from": 231,"to": 218}},{"type": 0, "lineNumber": 45, "text": "context", "offset": {"from": 255,"to": 242}},{"type": 0, "lineNumber": 46, "text": "== Changed line ==", "offset": {"from": 263,"to": 250}},{"type": 3, "lineNumber": 47, "text": "blah blah blah 12", "offset": {"from": 282,"to": 269}, "highlightRanges": [{"start": 15, "length": 1, "type": 1 },{"start": 16, "length": 1, "type": 0 }]},{"type": 0, "lineNumber": 48, "text": "", "offset": {"from": 299,"to": 286}}]}
