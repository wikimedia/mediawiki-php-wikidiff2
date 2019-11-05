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

print wikidiff2_inline_json_diff( $x, $y, 2 );

?>
--EXPECT--
{"diff": [{"type": 0, "lineNumber": 1, "text": "== Shortest sequence in X ==", "offset": {"from": 0,"to": 0}},{"type": 1, "lineNumber": 2, "text": "x1", "offset": {"from": null,"to": 29}},{"type": 0, "lineNumber": 3, "text": "x2", "offset": {"from": 29,"to": 32}},{"type": 0, "lineNumber": 4, "text": "x1", "offset": {"from": 32,"to": 35}},{"type": 0, "lineNumber": 5, "text": "x2", "offset": {"from": 35,"to": 38}},{"type": 0, "lineNumber": 6, "text": "x1", "offset": {"from": 38,"to": 41}},{"type": 1, "lineNumber": 7, "text": "x2", "offset": {"from": null,"to": 44}},{"type": 1, "lineNumber": 8, "text": "x1", "offset": {"from": null,"to": 47}},{"type": 1, "lineNumber": 9, "text": "x2", "offset": {"from": null,"to": 50}},{"type": 0, "lineNumber": 10, "text": "context", "offset": {"from": 41,"to": 53}},{"type": 0, "lineNumber": 11, "text": "context", "offset": {"from": 49,"to": 61}}]}
