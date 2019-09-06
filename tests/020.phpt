--TEST--
Inline JSON - Diff test C: https://phabricator.wikimedia.org/T29993
--SKIPIF--
<?php if (!extension_loaded("wikidiff2")) print "skip"; ?>
--FILE--
<?php
$x = <<<EOT
!!FUZZY!!Rajaa

EOT;

#---------------------------------------------------

$y = <<<EOT
Rajaa

EOT;

#---------------------------------------------------

print wikidiff2_inline_json_diff( $x, $y, 2 );

?>
--EXPECT--
{"diff": [{"type": 3, "lineNumber": 1, "text": "!!FUZZY!!Rajaa", "highlightRanges": [{"start": 0, "length": 9, "type": 1 }]}]}
