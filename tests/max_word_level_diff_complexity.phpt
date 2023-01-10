--TEST--
php.ini max_word_level_diff_complexity
--INI--
wikidiff2.max_word_level_diff_complexity=16
--FILE--
<?php
$x = "a a a a a";
$y = "b a a a b";

print "complexity " . ini_get('wikidiff2.max_word_level_diff_complexity') . "\n";
print wikidiff2_inline_diff($x, $y, 2);

ini_set('wikidiff2.max_word_level_diff_complexity', 100);
print "complexity " . ini_get('wikidiff2.max_word_level_diff_complexity') . "\n";
print wikidiff2_inline_diff($x, $y, 2);
print "\n";
--EXPECT--
complexity 16
<div class="mw-diff-inline-header"><!-- LINES 1,1 --></div>
<div class="mw-diff-inline-changed"><del>a a a a a</del><ins>b a a a b</ins></div>
complexity 100
<div class="mw-diff-inline-header"><!-- LINES 1,1 --></div>
<div class="mw-diff-inline-changed"><del>a</del><ins>b</ins> a a a <del>a</del><ins>b</ins></div>
