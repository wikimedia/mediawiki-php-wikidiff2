--TEST--
Diff test C: https://phabricator.wikimedia.org/T29993
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

print wikidiff2_do_diff( $x, $y, 2 );

?>
--EXPECT--
<tr>
  <td colspan="2" class="diff-lineno"><!--LINE 1--></td>
  <td colspan="2" class="diff-lineno"><!--LINE 1--></td>
</tr>
<tr>
  <td class="diff-marker" data-marker="−"></td>
  <td class="diff-deletedline diff-left"><div><del class="diffchange diffchange-inline">!!FUZZY!!</del>Rajaa</div></td>
  <td class="diff-marker" data-marker="+"></td>
  <td class="diff-addedline diff-right"><div>Rajaa</div></td>
</tr>
