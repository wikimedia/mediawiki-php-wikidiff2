--TEST--
Inline JSON - Diff test B
--FILE--
<?php
$x = <<<EOT
== Shortest sequence in X ==
x2
x1
x2
x1
context
context
context
context
context


EOT;

#---------------------------------------------------

$y = <<<EOT
== Shortest sequence in X ==
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


EOT;

#---------------------------------------------------

print wikidiff2_inline_json_diff( $x, $y, [ 0 ], 2 );

?>
--EXPECT--
{"diff": [{"type": 0, "lineNumber": 1, "text": "== Shortest sequence in X ==", "sectionTitleIndex": 0},{"type": 1, "lineNumber": 2, "text": "x1", "sectionTitleIndex": 0},{"type": 0, "lineNumber": 3, "text": "x2", "sectionTitleIndex": 0},{"type": 0, "lineNumber": 4, "text": "x1", "sectionTitleIndex": 0},{"type": 0, "lineNumber": 5, "text": "x2", "sectionTitleIndex": 0},{"type": 0, "lineNumber": 6, "text": "x1", "sectionTitleIndex": 0},{"type": 1, "lineNumber": 7, "text": "x2", "sectionTitleIndex": 0},{"type": 1, "lineNumber": 8, "text": "x1", "sectionTitleIndex": 0},{"type": 1, "lineNumber": 9, "text": "x2", "sectionTitleIndex": 0},{"type": 0, "lineNumber": 10, "text": "context", "sectionTitleIndex": 0},{"type": 0, "lineNumber": 11, "text": "context", "sectionTitleIndex": 0}], "sectionTitles": ["== Shortest sequence in X =="]}
