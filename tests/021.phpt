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

print wikidiff2_inline_json_diff( $x, $y, "", 2 );

?>
--EXPECT--
{"diff": [{"type": 3, "lineNumber": 1, "text": "foo bartest", "highlightRanges": [{"start": 4, "length": 3, "type": 1 },{"start": 7, "length": 4, "type": 0 }]},{"type": 2, "text": ""},{"type": 0, "lineNumber": 2, "text": "baz"},{"type": 1, "lineNumber": 3, "text": "test"},{"type": 2, "text": "quux"},{"type": 1, "lineNumber": 4, "text": ""},{"type": 0, "lineNumber": 5, "text": "bang"}], "sectionTitles": []}
