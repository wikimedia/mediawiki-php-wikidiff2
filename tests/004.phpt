--TEST--
Diff test D: inline diffs
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

print wikidiff2_inline_diff( $x, $y, 2 );

?>
--EXPECT--
<div class="mw-diff-inline-header"><!-- LINES 1,1 --></div>
<div class="mw-diff-inline-changed">foo <del>bar</del><ins>test</ins></div>
<div class="mw-diff-inline-deleted mw-diff-empty-line"><del>&#160;</del></div>
<div class="mw-diff-inline-context">baz</div>
<div class="mw-diff-inline-added"><ins>test</ins></div>
<div class="mw-diff-inline-deleted"><del>quux</del></div>
<div class="mw-diff-inline-added mw-diff-empty-line"><ins>&#160;</ins></div>
<div class="mw-diff-inline-context">bang</div>
