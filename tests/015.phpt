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

?>
--EXPECT--
<tr>
  <td colspan="2" class="diff-lineno"><!--LINE 1--></td>
  <td colspan="2" class="diff-lineno"><!--LINE 1--></td>
</tr>
<tr>
  <td class="diff-marker"></td>
  <td class="diff-context diff-left"><div>* [http://www.nationalregisterofhistoricplaces.com/az/state.html National Register of Historic Places – Arizona]</div></td>
  <td class="diff-marker"></td>
  <td class="diff-context diff-right"><div>* [http://www.nationalregisterofhistoricplaces.com/az/state.html National Register of Historic Places – Arizona]</div></td>
</tr>
<tr>
  <td class="diff-marker"></td>
  <td class="diff-context diff-left"><br /></td>
  <td class="diff-marker"></td>
  <td class="diff-context diff-right"><br /></td>
</tr>
<tr>
  <td colspan="2" class="diff-empty"></td>
  <td class="diff-marker"><a class="mw-diff-movedpara-right" href="#movedpara_3_1_lhs">&#x26AB;</a></td>
  <td class="diff-addedline diff-right"><div><a name="movedpara_1_0_rhs"></a><ins class="diffchange diffchange-inline">{{</ins>Navigationsleiste Listen der National Historic Places der Vereinigten Staaten<ins class="diffchange diffchange-inline">}}</ins></div></td>
</tr>
<tr>
  <td class="diff-marker" data-marker="−"></td>
  <td class="diff-deletedline diff-left"><div>{{NaviBlock</div></td>
  <td colspan="2" class="diff-empty"></td>
</tr>
<tr>
  <td class="diff-marker" data-marker="−"></td>
  <td class="diff-deletedline diff-left"><div>|Navigationsleiste Einträge im National Register of Historic Places in Arizona</div></td>
  <td colspan="2" class="diff-empty"></td>
</tr>
<tr>
  <td class="diff-marker"><a class="mw-diff-movedpara-left" href="#movedpara_1_0_rhs">&#x26AB;</a></td>
  <td class="diff-deletedline diff-left"><div><a name="movedpara_3_1_lhs"></a><del class="diffchange diffchange-inline">|</del>Navigationsleiste Listen der National Historic Places der Vereinigten Staaten</div></td>
  <td colspan="2" class="diff-empty"></td>
</tr>
<tr>
  <td class="diff-marker" data-marker="−"></td>
  <td class="diff-deletedline diff-left"><div>}}</div></td>
  <td colspan="2" class="diff-empty"></td>
</tr>
<tr>
  <td class="diff-marker"></td>
  <td class="diff-context diff-left"><br /></td>
  <td class="diff-marker"></td>
  <td class="diff-context diff-right"><br /></td>
</tr>
<tr>
  <td class="diff-marker"></td>
  <td class="diff-context diff-left"><div>[[Kategorie:Denkmal im National Register of Historic Places (Arizona)| ]]</div></td>
  <td class="diff-marker"></td>
  <td class="diff-context diff-right"><div>[[Kategorie:Denkmal im National Register of Historic Places (Arizona)| ]]</div></td>
</tr>
