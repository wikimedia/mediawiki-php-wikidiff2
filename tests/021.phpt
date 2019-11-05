--TEST--
Inline JSON - Diff test D: inline diffs
--FILE--
<?php
$x = <<<EOT
foo bar

baz
quux
bang
EOT;

#---------------------------------------------------

$y = <<<EOT
foo test
baz
test

bang
EOT;

#---------------------------------------------------

print wikidiff2_inline_json_diff( $x, $y, 2 );

?>
--EXPECT--
{"diff": [{"type": 3, "lineNumber": 1, "text": "foo bartest", "offset": {"from": 0,"to": 0}, "highlightRanges": [{"start": 4, "length": 3, "type": 1 },{"start": 7, "length": 4, "type": 0 }]},{"type": 2, "text": "", "offset": {"from": 8,"to": null}},{"type": 0, "lineNumber": 2, "text": "baz", "offset": {"from": 9,"to": 9}},{"type": 1, "lineNumber": 3, "text": "test", "offset": {"from": null,"to": 13}},{"type": 2, "text": "quux", "offset": {"from": 13,"to": null}},{"type": 1, "lineNumber": 4, "text": "", "offset": {"from": null,"to": 18}},{"type": 0, "lineNumber": 5, "text": "bang", "offset": {"from": 18,"to": 19}}]}
