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

print wikidiff2_inline_json_diff( $x, $y, [ 0, 29, 49, 95, 169, 250 ], 2 );

?>
--EXPECT--
{"diff": [{"type": 0, "lineNumber": 1, "text": "== Added line ==", "sectionTitleIndex": 0},{"type": 0, "lineNumber": 2, "text": "", "sectionTitleIndex": 0},{"type": 1, "lineNumber": 3, "text": "sjgfkdjfgb", "sectionTitleIndex": 0},{"type": 0, "lineNumber": 4, "text": "== Removed line ==", "sectionTitleIndex": 1},{"type": 0, "lineNumber": 5, "text": "", "sectionTitleIndex": 1},{"type": 2, "text": "kjahegwnygw", "sectionTitleIndex": 1},{"type": 0, "lineNumber": 6, "text": "== Moved text ==", "sectionTitleIndex": 2},{"type": 0, "lineNumber": 7, "text": "a", "sectionTitleIndex": 2},{"type": 4, "moveInfo": {"id": "movedpara_5_0_lhs", "linkId": "movedpara_7_0_rhs", "linkDirection": 0}, "text": "---line---", "sectionTitleIndex": 2},{"type": 0, "lineNumber": 8, "text": "a", "sectionTitleIndex": 2},{"type": 0, "lineNumber": 9, "text": "a", "sectionTitleIndex": 2},{"type": 0, "lineNumber": 12, "text": "a", "sectionTitleIndex": 2},{"type": 0, "lineNumber": 13, "text": "a", "sectionTitleIndex": 2},{"type": 5, "lineNumber": 14, "moveInfo": {"id": "movedpara_7_0_rhs", "linkId": "movedpara_5_0_lhs", "linkDirection": 1}, "text": "---line---", "sectionTitleIndex": 2, "highlightRanges": []},{"type": 0, "lineNumber": 15, "text": "a", "sectionTitleIndex": 2},{"type": 0, "lineNumber": 16, "text": "a", "sectionTitleIndex": 2},{"type": 0, "lineNumber": 19, "text": "a", "sectionTitleIndex": 3},{"type": 0, "lineNumber": 20, "text": "a", "sectionTitleIndex": 3},{"type": 4, "moveInfo": {"id": "movedpara_9_0_lhs", "linkId": "movedpara_11_0_rhs", "linkDirection": 0}, "text": "--line1--", "sectionTitleIndex": 3},{"type": 4, "moveInfo": {"id": "movedpara_9_1_lhs", "linkId": "movedpara_11_1_rhs", "linkDirection": 0}, "text": "--line2--", "sectionTitleIndex": 3},{"type": 0, "lineNumber": 21, "text": "a", "sectionTitleIndex": 3},{"type": 0, "lineNumber": 22, "text": "a", "sectionTitleIndex": 3},{"type": 0, "lineNumber": 27, "text": "a", "sectionTitleIndex": 3},{"type": 0, "lineNumber": 28, "text": "a", "sectionTitleIndex": 3},{"type": 5, "lineNumber": 29, "moveInfo": {"id": "movedpara_11_0_rhs", "linkId": "movedpara_9_0_lhs", "linkDirection": 1}, "text": "--line1--", "sectionTitleIndex": 3, "highlightRanges": []},{"type": 5, "lineNumber": 30, "moveInfo": {"id": "movedpara_11_1_rhs", "linkId": "movedpara_9_1_lhs", "linkDirection": 1}, "text": "--line2--", "sectionTitleIndex": 3, "highlightRanges": []},{"type": 0, "lineNumber": 31, "text": "a", "sectionTitleIndex": 3},{"type": 0, "lineNumber": 32, "text": "a", "sectionTitleIndex": 3},{"type": 0, "lineNumber": 35, "text": "a", "sectionTitleIndex": 3},{"type": 0, "lineNumber": 36, "text": "== Shortest sequence in Y ==", "sectionTitleIndex": 4},{"type": 2, "text": "x1", "sectionTitleIndex": 4},{"type": 0, "lineNumber": 37, "text": "x2", "sectionTitleIndex": 4},{"type": 0, "lineNumber": 38, "text": "x1", "sectionTitleIndex": 4},{"type": 0, "lineNumber": 39, "text": "x2", "sectionTitleIndex": 4},{"type": 0, "lineNumber": 40, "text": "x1", "sectionTitleIndex": 4},{"type": 2, "text": "x2", "sectionTitleIndex": 4},{"type": 2, "text": "x1", "sectionTitleIndex": 4},{"type": 2, "text": "x2", "sectionTitleIndex": 4},{"type": 0, "lineNumber": 41, "text": "context", "sectionTitleIndex": 4},{"type": 0, "lineNumber": 42, "text": "context", "sectionTitleIndex": 4},{"type": 0, "lineNumber": 45, "text": "context", "sectionTitleIndex": 4},{"type": 0, "lineNumber": 46, "text": "== Changed line ==", "sectionTitleIndex": 5},{"type": 3, "lineNumber": 47, "text": "blah blah blah 12", "sectionTitleIndex": 5, "highlightRanges": [{"start": 15, "length": 1, "type": 1 },{"start": 16, "length": 1, "type": 0 }]},{"type": 0, "lineNumber": 48, "text": "", "sectionTitleIndex": 5}], "sectionTitles": ["== Added line ==","== Removed line ==","== Moved text ==","== Two moved lines ==","== Shortest sequence in Y ==","== Changed line =="]}
