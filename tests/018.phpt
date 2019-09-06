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
{"diff": [{"type": 0, "lineNumber": 1, "text": "== Added line =="},{"type": 0, "lineNumber": 2, "text": ""},{"type": 1, "lineNumber": 3, "text": "sjgfkdjfgb"},{"type": 0, "lineNumber": 4, "text": "== Removed line =="},{"type": 0, "lineNumber": 5, "text": ""},{"type": 2, "text": "kjahegwnygw"},{"type": 0, "lineNumber": 6, "text": "== Moved text =="},{"type": 0, "lineNumber": 7, "text": "a"},{"type": 4, "moveInfo": {"id": "movedpara_5_0_lhs", "linkId": "movedpara_7_0_rhs", "linkDirection": 0}, "text": "---line---"},{"type": 0, "lineNumber": 8, "text": "a"},{"type": 0, "lineNumber": 9, "text": "a"},{"type": 0, "lineNumber": 12, "text": "a"},{"type": 0, "lineNumber": 13, "text": "a"},{"type": 5, "lineNumber": 14, "moveInfo": {"id": "movedpara_7_0_rhs", "linkId": "movedpara_5_0_lhs", "linkDirection": 1}, "text": "---line---", "highlightRanges": []},{"type": 0, "lineNumber": 15, "text": "a"},{"type": 0, "lineNumber": 16, "text": "a"},{"type": 0, "lineNumber": 19, "text": "a"},{"type": 0, "lineNumber": 20, "text": "a"},{"type": 4, "moveInfo": {"id": "movedpara_9_0_lhs", "linkId": "movedpara_11_0_rhs", "linkDirection": 0}, "text": "--line1--"},{"type": 4, "moveInfo": {"id": "movedpara_9_1_lhs", "linkId": "movedpara_11_1_rhs", "linkDirection": 0}, "text": "--line2--"},{"type": 0, "lineNumber": 21, "text": "a"},{"type": 0, "lineNumber": 22, "text": "a"},{"type": 0, "lineNumber": 27, "text": "a"},{"type": 0, "lineNumber": 28, "text": "a"},{"type": 5, "lineNumber": 29, "moveInfo": {"id": "movedpara_11_0_rhs", "linkId": "movedpara_9_0_lhs", "linkDirection": 1}, "text": "--line1--", "highlightRanges": []},{"type": 5, "lineNumber": 30, "moveInfo": {"id": "movedpara_11_1_rhs", "linkId": "movedpara_9_1_lhs", "linkDirection": 1}, "text": "--line2--", "highlightRanges": []},{"type": 0, "lineNumber": 31, "text": "a"},{"type": 0, "lineNumber": 32, "text": "a"},{"type": 0, "lineNumber": 35, "text": "a"},{"type": 0, "lineNumber": 36, "text": "== Shortest sequence in Y =="},{"type": 2, "text": "x1"},{"type": 0, "lineNumber": 37, "text": "x2"},{"type": 0, "lineNumber": 38, "text": "x1"},{"type": 0, "lineNumber": 39, "text": "x2"},{"type": 0, "lineNumber": 40, "text": "x1"},{"type": 2, "text": "x2"},{"type": 2, "text": "x1"},{"type": 2, "text": "x2"},{"type": 0, "lineNumber": 41, "text": "context"},{"type": 0, "lineNumber": 42, "text": "context"},{"type": 0, "lineNumber": 45, "text": "context"},{"type": 0, "lineNumber": 46, "text": "== Changed line =="},{"type": 3, "lineNumber": 47, "text": "blah blah blah 12", "highlightRanges": [{"start": 15, "length": 1, "type": 1 },{"start": 16, "length": 1, "type": 0 }]},{"type": 0, "lineNumber": 48, "text": ""}]}
