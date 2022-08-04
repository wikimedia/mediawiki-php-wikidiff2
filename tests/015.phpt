--TEST--
Test case for T182300 from https://de.wikipedia.org/wiki/Special:Diff/171746522
--FILE--
<?php
$before = <<<EOT
* [http://www.nationalregisterofhistoricplaces.com/az/state.html National Register of Historic Places – Arizona]

{{NaviBlock
|Navigationsleiste Einträge im National Register of Historic Places in Arizona
|Navigationsleiste Listen der National Historic Places der Vereinigten Staaten
}}

[[Kategorie:Denkmal im National Register of Historic Places (Arizona)| ]]
EOT;

#---------------------------------------------------

$after = <<<EOT
* [http://www.nationalregisterofhistoricplaces.com/az/state.html National Register of Historic Places – Arizona]

{{Navigationsleiste Listen der National Historic Places der Vereinigten Staaten}}

[[Kategorie:Denkmal im National Register of Historic Places (Arizona)| ]]
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
  <td class="diff-context diff-side-deleted"><div>* [http://www.nationalregisterofhistoricplaces.com/az/state.html National Register of Historic Places – Arizona]</div></td>
  <td class="diff-marker"></td>
  <td class="diff-context diff-side-added"><div>* [http://www.nationalregisterofhistoricplaces.com/az/state.html National Register of Historic Places – Arizona]</div></td>
</tr>
<tr>
  <td class="diff-marker"></td>
  <td class="diff-context diff-side-deleted"><br /></td>
  <td class="diff-marker"></td>
  <td class="diff-context diff-side-added"><br /></td>
</tr>
<tr>
  <td colspan="2" class="diff-empty diff-side-deleted"></td>
  <td class="diff-marker"><a class="mw-diff-movedpara-right" href="#movedpara_3_1_lhs">&#x26AB;</a></td>
  <td class="diff-addedline diff-side-added"><div><a name="movedpara_1_0_rhs"></a><ins class="diffchange diffchange-inline">{{</ins>Navigationsleiste Listen der National Historic Places der Vereinigten Staaten<ins class="diffchange diffchange-inline">}}</ins></div></td>
</tr>
<tr>
  <td class="diff-marker" data-marker="−"></td>
  <td class="diff-deletedline diff-side-deleted"><div>{{NaviBlock</div></td>
  <td colspan="2" class="diff-empty diff-side-added"></td>
</tr>
<tr>
  <td class="diff-marker" data-marker="−"></td>
  <td class="diff-deletedline diff-side-deleted"><div>|Navigationsleiste Einträge im National Register of Historic Places in Arizona</div></td>
  <td colspan="2" class="diff-empty diff-side-added"></td>
</tr>
<tr>
  <td class="diff-marker"><a class="mw-diff-movedpara-left" href="#movedpara_1_0_rhs">&#x26AB;</a></td>
  <td class="diff-deletedline diff-side-deleted"><div><a name="movedpara_3_1_lhs"></a><del class="diffchange diffchange-inline">|</del>Navigationsleiste Listen der National Historic Places der Vereinigten Staaten</div></td>
  <td colspan="2" class="diff-empty diff-side-added"></td>
</tr>
<tr>
  <td class="diff-marker" data-marker="−"></td>
  <td class="diff-deletedline diff-side-deleted"><div>}}</div></td>
  <td colspan="2" class="diff-empty diff-side-added"></td>
</tr>
<tr>
  <td class="diff-marker"></td>
  <td class="diff-context diff-side-deleted"><br /></td>
  <td class="diff-marker"></td>
  <td class="diff-context diff-side-added"><br /></td>
</tr>
<tr>
  <td class="diff-marker"></td>
  <td class="diff-context diff-side-deleted"><div>[[Kategorie:Denkmal im National Register of Historic Places (Arizona)| ]]</div></td>
  <td class="diff-marker"></td>
  <td class="diff-context diff-side-added"><div>[[Kategorie:Denkmal im National Register of Historic Places (Arizona)| ]]</div></td>
</tr>

----INLINE:----
<div class="mw-diff-inline-header"><!-- LINES 1,1 --></div>
<div class="mw-diff-inline-context">* [http://www.nationalregisterofhistoricplaces.com/az/state.html National Register of Historic Places – Arizona]</div>
<div class="mw-diff-inline-context">&#160;</div>
<div class="mw-diff-inline-moved mw-diff-inline-moved-destination mw-diff-inline-moved-downwards"><a name="movedpara_1_0_rhs"></a><del>|</del><ins>{{</ins>Navigationsleiste Listen der National Historic Places der Vereinigten Staaten<ins>}}</ins><a class="mw-diff-movedpara-right" data-title-tag="new" href="#movedpara_3_1_lhs">&#9660;</a></div>
<div class="mw-diff-inline-deleted"><del>{{NaviBlock</del></div>
<div class="mw-diff-inline-deleted"><del>|Navigationsleiste Einträge im National Register of Historic Places in Arizona</del></div>
<div class="mw-diff-inline-moved mw-diff-inline-moved-source mw-diff-inline-moved-upwards"><a name="movedpara_3_1_lhs"></a><a class="mw-diff-movedpara-left" data-title-tag="old" href="#movedpara_1_0_rhs">&#9650;</a>|Navigationsleiste Listen der National Historic Places der Vereinigten Staaten</div>
<div class="mw-diff-inline-deleted"><del>}}</del></div>
<div class="mw-diff-inline-context">&#160;</div>
<div class="mw-diff-inline-context">[[Kategorie:Denkmal im National Register of Historic Places (Arizona)| ]]</div>
