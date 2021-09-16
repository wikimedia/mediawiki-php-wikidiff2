--TEST--
Test detection of dissimilar paragraphs
--FILE--
<?php
$x = <<<EOT
AAAAA AAAAA AAAAA AAAAA AAAAA AAAAA AAAAA AAAAA AAAAA AAAAA

AAAAA AAAAA AAAAA AAAAA AAAAA AAAAA AAAAA AAAAA AAAAA AAAAA

EOT;

#---------------------------------------------------

$y = <<<EOT
AAAAA AAAAA BBBBB BBBBB BBBBB BBBBB BBBBB BBBBB BBBBB BBBBB

AAAAA BBBBB BBBBB BBBBB BBBBB BBBBB BBBBB BBBBB BBBBB BBBBB

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
  <td class="diff-deletedline diff-side-deleted"><div>AAAAA AAAAA <del class="diffchange diffchange-inline">AAAAA</del> <del class="diffchange diffchange-inline">AAAAA</del> <del class="diffchange diffchange-inline">AAAAA</del> <del class="diffchange diffchange-inline">AAAAA</del> <del class="diffchange diffchange-inline">AAAAA</del> <del class="diffchange diffchange-inline">AAAAA</del> <del class="diffchange diffchange-inline">AAAAA</del> <del class="diffchange diffchange-inline">AAAAA</del></div></td>
  <td class="diff-marker" data-marker="+"></td>
  <td class="diff-addedline diff-side-added"><div>AAAAA AAAAA <ins class="diffchange diffchange-inline">BBBBB</ins> <ins class="diffchange diffchange-inline">BBBBB</ins> <ins class="diffchange diffchange-inline">BBBBB</ins> <ins class="diffchange diffchange-inline">BBBBB</ins> <ins class="diffchange diffchange-inline">BBBBB</ins> <ins class="diffchange diffchange-inline">BBBBB</ins> <ins class="diffchange diffchange-inline">BBBBB</ins> <ins class="diffchange diffchange-inline">BBBBB</ins></div></td>
</tr>
<tr>
  <td class="diff-marker"></td>
  <td class="diff-context diff-side-deleted"><br /></td>
  <td class="diff-marker"></td>
  <td class="diff-context diff-side-added"><br /></td>
</tr>
<tr>
  <td class="diff-marker" data-marker="−"></td>
  <td class="diff-deletedline diff-side-deleted"><div>AAAAA <del class="diffchange diffchange-inline">AAAAA</del> <del class="diffchange diffchange-inline">AAAAA</del> <del class="diffchange diffchange-inline">AAAAA</del> <del class="diffchange diffchange-inline">AAAAA</del> <del class="diffchange diffchange-inline">AAAAA</del> <del class="diffchange diffchange-inline">AAAAA</del> <del class="diffchange diffchange-inline">AAAAA</del> <del class="diffchange diffchange-inline">AAAAA</del> <del class="diffchange diffchange-inline">AAAAA</del></div></td>
  <td class="diff-marker" data-marker="+"></td>
  <td class="diff-addedline diff-side-added"><div>AAAAA <ins class="diffchange diffchange-inline">BBBBB</ins> <ins class="diffchange diffchange-inline">BBBBB</ins> <ins class="diffchange diffchange-inline">BBBBB</ins> <ins class="diffchange diffchange-inline">BBBBB</ins> <ins class="diffchange diffchange-inline">BBBBB</ins> <ins class="diffchange diffchange-inline">BBBBB</ins> <ins class="diffchange diffchange-inline">BBBBB</ins> <ins class="diffchange diffchange-inline">BBBBB</ins> <ins class="diffchange diffchange-inline">BBBBB</ins></div></td>
</tr>
