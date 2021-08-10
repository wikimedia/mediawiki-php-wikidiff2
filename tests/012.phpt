--TEST--
Test case for WIKIDIFF2_CHANGE_THRESHOLD_DEFAULT reduced from 0.25 to 0.2 from https://de.wikipedia.org/wiki/Special:Diff/170728571/170728517
--FILE--
<?php
$before = <<<EOT
* [[Startpage]]
* [[MetaGer]]
* [https://search.disconnect.me Disconnect] (externe Seite)

== Weblinks ==
EOT;

#---------------------------------------------------

$after = <<<EOT
* [[Startpage]]
* [[MetaGer]]
* [[Disconnect]]

== Weblinks ==
EOT;

#---------------------------------------------------

print wikidiff2_do_diff( $before, $after, 2 );

?>
--EXPECT--
<tr>
  <td colspan="2" class="diff-lineno"><!--LINE 1--></td>
  <td colspan="2" class="diff-lineno"><!--LINE 1--></td>
</tr>
<tr>
  <td class="diff-marker"></td>
  <td class="diff-context diff-left"><div>* [[Startpage]]</div></td>
  <td class="diff-marker"></td>
  <td class="diff-context diff-right"><div>* [[Startpage]]</div></td>
</tr>
<tr>
  <td class="diff-marker"></td>
  <td class="diff-context diff-left"><div>* [[MetaGer]]</div></td>
  <td class="diff-marker"></td>
  <td class="diff-context diff-right"><div>* [[MetaGer]]</div></td>
</tr>
<tr>
  <td class="diff-marker" data-marker="−"></td>
  <td class="diff-deletedline diff-left"><div>* [<del class="diffchange diffchange-inline">https://search.disconnect.me </del>Disconnect]<del class="diffchange diffchange-inline"> (externe Seite)</del></div></td>
  <td class="diff-marker" data-marker="+"></td>
  <td class="diff-addedline diff-right"><div>* [<ins class="diffchange diffchange-inline">[</ins>Disconnect]<ins class="diffchange diffchange-inline">]</ins></div></td>
</tr>
<tr>
  <td class="diff-marker"></td>
  <td class="diff-context diff-left"><br /></td>
  <td class="diff-marker"></td>
  <td class="diff-context diff-right"><br /></td>
</tr>
<tr>
  <td class="diff-marker"></td>
  <td class="diff-context diff-left"><div>== Weblinks ==</div></td>
  <td class="diff-marker"></td>
  <td class="diff-context diff-right"><div>== Weblinks ==</div></td>
</tr>
