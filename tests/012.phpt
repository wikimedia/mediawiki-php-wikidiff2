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
print "\n----INLINE:----\n";
print wikidiff2_inline_diff( $before, $after, 2 );

?>
--EXPECT--
<tr>
  <td colspan="2" class="diff-lineno"><!--LINE 1--></td>
  <td colspan="2" class="diff-lineno"><!--LINE 1--></td>
</tr>
<tr>
  <td class="diff-marker"></td>
  <td class="diff-context diff-side-deleted"><div>* [[Startpage]]</div></td>
  <td class="diff-marker"></td>
  <td class="diff-context diff-side-added"><div>* [[Startpage]]</div></td>
</tr>
<tr>
  <td class="diff-marker"></td>
  <td class="diff-context diff-side-deleted"><div>* [[MetaGer]]</div></td>
  <td class="diff-marker"></td>
  <td class="diff-context diff-side-added"><div>* [[MetaGer]]</div></td>
</tr>
<tr>
  <td class="diff-marker" data-marker="−"></td>
  <td class="diff-deletedline diff-side-deleted"><div>* [<del class="diffchange diffchange-inline">https://search.disconnect.me </del>Disconnect]<del class="diffchange diffchange-inline"> (externe Seite)</del></div></td>
  <td class="diff-marker" data-marker="+"></td>
  <td class="diff-addedline diff-side-added"><div>* [<ins class="diffchange diffchange-inline">[</ins>Disconnect]<ins class="diffchange diffchange-inline">]</ins></div></td>
</tr>
<tr>
  <td class="diff-marker"></td>
  <td class="diff-context diff-side-deleted"><br /></td>
  <td class="diff-marker"></td>
  <td class="diff-context diff-side-added"><br /></td>
</tr>
<tr>
  <td class="diff-marker"></td>
  <td class="diff-context diff-side-deleted"><div>== Weblinks ==</div></td>
  <td class="diff-marker"></td>
  <td class="diff-context diff-side-added"><div>== Weblinks ==</div></td>
</tr>

----INLINE:----
<div class="mw-diff-inline-header"><!-- LINES 1,1 --></div>
<div class="mw-diff-inline-context">* [[Startpage]]</div>
<div class="mw-diff-inline-context">* [[MetaGer]]</div>
<div class="mw-diff-inline-changed">* [<del>https://search.disconnect.me </del><ins>[</ins>Disconnect]<del> (externe Seite)</del><ins>]</ins></div>
<div class="mw-diff-inline-context">&#160;</div>
<div class="mw-diff-inline-context">== Weblinks ==</div>
