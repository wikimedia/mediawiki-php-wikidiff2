--TEST--
Test case for T217546 derived from https://en.wikipedia.org/w/index.php?title=New_Hampshire_Route_145&type=revision&diff=100781760&oldid=80300958
--FILE--
<?php
$before = <<<EOT
{{Infobox_road
| system            = [[New Hampshire Highway System]]
| browse            = {{nh browse|previous_type=NH|previous_route=142|next_type=NH|next_route=149}}
}}'''New Hampshire Route 145''' ('''NH 145''') is a north–south highway in [[Coos County, New Hampshire|Coos County]] in northern [[New Hampshire]]. The highway runs between [[Colebrook, New Hampshire|Colebrook]] and [[Pittsburg, New Hampshire|Pittsburg]].

The southern terminus of NH 145 is at the junction with [[U.S. Highway 3|US 3]] in Colebrook on the [[Vermont]] border. The highway passes through [[Clarksville, New Hampshire|Clarksville]] township and the village center. The northern terminus of NH 145 is in Pittsburg at the junction with US 3. Total length of the highway is approximately 13.2 miles (21.3 km).

== See also ==
*[[List of New Hampshire numbered highways]]


{{NewHampshire-State-Highway-stub}}
[[Category:New Hampshire state highways|145]]
EOT;

#---------------------------------------------------

$after = <<<EOT
{{Infobox NH Route
|previous_type=NH
|previous_route=142
|next_type=NH
|next_route=149
}}
'''New Hampshire Route 145''' (abbreviated '''NH 145''') is a 13.12&#160;mile long north–south [[state highway]] in [[Coos County, New Hampshire|Coos County]] in northern [[New Hampshire]]. The highway runs between [[Colebrook, New Hampshire|Colebrook]] and [[Pittsburg, New Hampshire|Pittsburg]].

The southern terminus of NH 145 is at [[U.S. Route 3 (New Hampshire)|U.S. Route 3]] in Colebrook on the [[Vermont]] border. The highway passes through [[Clarksville, New Hampshire|Clarksville]] township and the village center. The northern terminus of NH 145 is in Pittsburg at US 3.

==References==
<references/>

[[Category:New Hampshire state highways|145]]
[[Category:Coos County, New Hampshire]]

{{NewHampshire-State-Highway-stub}}
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
  <td colspan="2" class="diff-empty diff-side-deleted"></td>
  <td class="diff-marker" data-marker="+"></td>
  <td class="diff-addedline diff-side-added"><div>{{Infobox NH Route</div></td>
</tr>
<tr>
  <td class="diff-marker" data-marker="−"></td>
  <td class="diff-deletedline diff-side-deleted"><div>{{Infobox_road</div></td>
  <td colspan="2" class="diff-empty diff-side-added"></td>
</tr>
<tr>
  <td colspan="2" class="diff-empty diff-side-deleted"></td>
  <td class="diff-marker" data-marker="+"></td>
  <td class="diff-addedline diff-side-added"><div>|previous_type=NH</div></td>
</tr>
<tr>
  <td class="diff-marker" data-marker="−"></td>
  <td class="diff-deletedline diff-side-deleted"><div>| system            = [[New Hampshire Highway System]]</div></td>
  <td colspan="2" class="diff-empty diff-side-added"></td>
</tr>
<tr>
  <td colspan="2" class="diff-empty diff-side-deleted"></td>
  <td class="diff-marker" data-marker="+"></td>
  <td class="diff-addedline diff-side-added"><div>|previous_route=142</div></td>
</tr>
<tr>
  <td class="diff-marker" data-marker="−"></td>
  <td class="diff-deletedline diff-side-deleted"><div>| browse            = {{nh browse|previous_type=NH|previous_route=142|next_type=NH|next_route=149}}</div></td>
  <td colspan="2" class="diff-empty diff-side-added"></td>
</tr>
<tr>
  <td colspan="2" class="diff-empty diff-side-deleted"></td>
  <td class="diff-marker" data-marker="+"></td>
  <td class="diff-addedline diff-side-added"><div>|next_type=NH</div></td>
</tr>
<tr>
  <td class="diff-marker"><a class="mw-diff-movedpara-left" href="#movedpara_8_2_rhs">&#x26AB;</a></td>
  <td class="diff-deletedline diff-side-deleted"><div><a name="movedpara_7_0_lhs"></a><del class="diffchange diffchange-inline">}}</del>'''New Hampshire Route 145''' ('''NH 145''') is a north–south highway in [[Coos County, New Hampshire|Coos County]] in northern [[New Hampshire]]. The highway runs between [[Colebrook, New Hampshire|Colebrook]] and [[Pittsburg, New Hampshire|Pittsburg]].</div></td>
  <td colspan="2" class="diff-empty diff-side-added"></td>
</tr>
<tr>
  <td colspan="2" class="diff-empty diff-side-deleted"></td>
  <td class="diff-marker" data-marker="+"></td>
  <td class="diff-addedline diff-side-added"><div>|next_route=149</div></td>
</tr>
<tr>
  <td colspan="2" class="diff-empty diff-side-deleted"></td>
  <td class="diff-marker" data-marker="+"></td>
  <td class="diff-addedline diff-side-added"><div>}}</div></td>
</tr>
<tr>
  <td colspan="2" class="diff-empty diff-side-deleted"></td>
  <td class="diff-marker"><a class="mw-diff-movedpara-right" href="#movedpara_7_0_lhs">&#x26AB;</a></td>
  <td class="diff-addedline diff-side-added"><div><a name="movedpara_8_2_rhs"></a>'''New Hampshire Route 145''' (<ins class="diffchange diffchange-inline">abbreviated </ins>'''NH 145''') is a<ins class="diffchange diffchange-inline"> 13.12&amp;#160;mile long</ins> north–south<ins class="diffchange diffchange-inline"> [[state</ins> highway<ins class="diffchange diffchange-inline">]]</ins> in [[Coos County, New Hampshire|Coos County]] in northern [[New Hampshire]]. The highway runs between [[Colebrook, New Hampshire|Colebrook]] and [[Pittsburg, New Hampshire|Pittsburg]].</div></td>
</tr>
<tr>
  <td class="diff-marker"></td>
  <td class="diff-context diff-side-deleted"><br /></td>
  <td class="diff-marker"></td>
  <td class="diff-context diff-side-added"><br /></td>
</tr>
<tr>
  <td class="diff-marker" data-marker="−"></td>
  <td class="diff-deletedline diff-side-deleted"><div>The southern terminus of NH 145 is at<del class="diffchange diffchange-inline"> the junction with</del> [[U.S. <del class="diffchange diffchange-inline">Highway</del> 3|<del class="diffchange diffchange-inline">US</del> 3]] in Colebrook on the [[Vermont]] border. The highway passes through [[Clarksville, New Hampshire|Clarksville]] township and the village center. The northern terminus of NH 145 is in Pittsburg at<del class="diffchange diffchange-inline"> the junction with</del> US 3<del class="diffchange diffchange-inline">. Total length of the highway is approximately 13.2 miles (21.3 km)</del>.</div></td>
  <td class="diff-marker" data-marker="+"></td>
  <td class="diff-addedline diff-side-added"><div>The southern terminus of NH 145 is at [[U.S. <ins class="diffchange diffchange-inline">Route</ins> 3<ins class="diffchange diffchange-inline"> (New Hampshire)</ins>|<ins class="diffchange diffchange-inline">U.S. Route</ins> 3]] in Colebrook on the [[Vermont]] border. The highway passes through [[Clarksville, New Hampshire|Clarksville]] township and the village center. The northern terminus of NH 145 is in Pittsburg at US 3.</div></td>
</tr>
<tr>
  <td class="diff-marker"></td>
  <td class="diff-context diff-side-deleted"><br /></td>
  <td class="diff-marker"></td>
  <td class="diff-context diff-side-added"><br /></td>
</tr>
<tr>
  <td class="diff-marker" data-marker="−"></td>
  <td class="diff-deletedline diff-side-deleted"><div>==<del class="diffchange diffchange-inline"> See also </del>==</div></td>
  <td class="diff-marker" data-marker="+"></td>
  <td class="diff-addedline diff-side-added"><div>==<ins class="diffchange diffchange-inline">References</ins>==</div></td>
</tr>
<tr>
  <td colspan="2" class="diff-empty diff-side-deleted"></td>
  <td class="diff-marker" data-marker="+"></td>
  <td class="diff-addedline diff-side-added"><div>&lt;references/&gt;</div></td>
</tr>
<tr>
  <td class="diff-marker"><a class="mw-diff-movedpara-left" href="#movedpara_16_0_rhs">&#x26AB;</a></td>
  <td class="diff-deletedline diff-side-deleted"><div><a name="movedpara_14_0_lhs"></a><del class="diffchange diffchange-inline">*</del>[[<del class="diffchange diffchange-inline">List of </del>New Hampshire <del class="diffchange diffchange-inline">numbered</del> highways]]</div></td>
  <td colspan="2" class="diff-empty diff-side-added"></td>
</tr>
<tr>
  <td class="diff-marker"></td>
  <td class="diff-context diff-side-deleted"><br /></td>
  <td class="diff-marker"></td>
  <td class="diff-context diff-side-added"><br /></td>
</tr>
<tr>
  <td colspan="2" class="diff-empty diff-side-deleted"></td>
  <td class="diff-marker"><a class="mw-diff-movedpara-right" href="#movedpara_14_0_lhs">&#x26AB;</a></td>
  <td class="diff-addedline diff-side-added"><div><a name="movedpara_16_0_rhs"></a>[[<ins class="diffchange diffchange-inline">Category:</ins>New Hampshire <ins class="diffchange diffchange-inline">state</ins> highways<ins class="diffchange diffchange-inline">|145</ins>]]</div></td>
</tr>
<tr>
  <td colspan="2" class="diff-empty diff-side-deleted"></td>
  <td class="diff-marker"><a class="mw-diff-movedpara-right" href="#movedpara_18_0_lhs">&#x26AB;</a></td>
  <td class="diff-addedline diff-side-added"><div><a name="movedpara_16_1_rhs"></a>[[Category:<ins class="diffchange diffchange-inline">Coos</ins> <ins class="diffchange diffchange-inline">County,</ins> <ins class="diffchange diffchange-inline">New</ins> <ins class="diffchange diffchange-inline">Hampshire</ins>]]</div></td>
</tr>
<tr>
  <td class="diff-marker"></td>
  <td class="diff-context diff-side-deleted"><br /></td>
  <td class="diff-marker"></td>
  <td class="diff-context diff-side-added"><br /></td>
</tr>
<tr>
  <td class="diff-marker"></td>
  <td class="diff-context diff-side-deleted"><div>{{NewHampshire-State-Highway-stub}}</div></td>
  <td class="diff-marker"></td>
  <td class="diff-context diff-side-added"><div>{{NewHampshire-State-Highway-stub}}</div></td>
</tr>
<tr>
  <td class="diff-marker"><a class="mw-diff-movedpara-left" href="#movedpara_16_1_rhs">&#x26AB;</a></td>
  <td class="diff-deletedline diff-side-deleted"><div><a name="movedpara_18_0_lhs"></a>[[Category:<del class="diffchange diffchange-inline">New</del> <del class="diffchange diffchange-inline">Hampshire</del> <del class="diffchange diffchange-inline">state</del> <del class="diffchange diffchange-inline">highways|145</del>]]</div></td>
  <td colspan="2" class="diff-empty diff-side-added"></td>
</tr>

----INLINE:----
<div class="mw-diff-inline-header"><!-- LINES 1,1 --></div>
<div class="mw-diff-inline-added"><ins>{{Infobox NH Route</ins></div>
<div class="mw-diff-inline-deleted"><del>{{Infobox_road</del></div>
<div class="mw-diff-inline-added"><ins>|previous_type=NH</ins></div>
<div class="mw-diff-inline-deleted"><del>| system            = [[New Hampshire Highway System]]</del></div>
<div class="mw-diff-inline-added"><ins>|previous_route=142</ins></div>
<div class="mw-diff-inline-deleted"><del>| browse            = {{nh browse|previous_type=NH|previous_route=142|next_type=NH|next_route=149}}</del></div>
<div class="mw-diff-inline-added"><ins>|next_type=NH</ins></div>
<div class="mw-diff-inline-moved mw-diff-inline-moved-source mw-diff-inline-moved-downwards"><a name="movedpara_7_0_lhs"></a>}}'''New Hampshire Route 145''' ('''NH 145''') is a north–south highway in [[Coos County, New Hampshire|Coos County]] in northern [[New Hampshire]]. The highway runs between [[Colebrook, New Hampshire|Colebrook]] and [[Pittsburg, New Hampshire|Pittsburg]].<a class="mw-diff-movedpara-left" data-title-tag="old" href="#movedpara_8_2_rhs">&#9660;</a></div>
<div class="mw-diff-inline-added"><ins>|next_route=149</ins></div>
<div class="mw-diff-inline-added"><ins>}}</ins></div>
<div class="mw-diff-inline-moved mw-diff-inline-moved-destination mw-diff-inline-moved-upwards"><a name="movedpara_8_2_rhs"></a><a class="mw-diff-movedpara-right" data-title-tag="new" href="#movedpara_7_0_lhs">&#9650;</a><del>}}</del>'''New Hampshire Route 145''' (<ins>abbreviated </ins>'''NH 145''') is a<ins> 13.12&amp;#160;mile long</ins> north–south<ins> [[state</ins> highway<ins>]]</ins> in [[Coos County, New Hampshire|Coos County]] in northern [[New Hampshire]]. The highway runs between [[Colebrook, New Hampshire|Colebrook]] and [[Pittsburg, New Hampshire|Pittsburg]].</div>
<div class="mw-diff-inline-context">&#160;</div>
<div class="mw-diff-inline-changed">The southern terminus of NH 145 is at<del> the junction with</del> [[U.S. <del>Highway</del><ins>Route</ins> 3<ins> (New Hampshire)</ins>|<del>US</del><ins>U.S. Route</ins> 3]] in Colebrook on the [[Vermont]] border. The highway passes through [[Clarksville, New Hampshire|Clarksville]] township and the village center. The northern terminus of NH 145 is in Pittsburg at<del> the junction with</del> US 3<del>. Total length of the highway is approximately 13.2 miles (21.3 km)</del>.</div>
<div class="mw-diff-inline-context">&#160;</div>
<div class="mw-diff-inline-changed">==<del> See also </del><ins>References</ins>==</div>
<div class="mw-diff-inline-added"><ins>&lt;references/&gt;</ins></div>
<div class="mw-diff-inline-moved mw-diff-inline-moved-source mw-diff-inline-moved-downwards"><a name="movedpara_14_0_lhs"></a>*[[List of New Hampshire numbered highways]]<a class="mw-diff-movedpara-left" data-title-tag="old" href="#movedpara_16_0_rhs">&#9660;</a></div>
<div class="mw-diff-inline-context">&#160;</div>
<div class="mw-diff-inline-moved mw-diff-inline-moved-destination mw-diff-inline-moved-upwards"><a name="movedpara_16_0_rhs"></a><a class="mw-diff-movedpara-right" data-title-tag="new" href="#movedpara_14_0_lhs">&#9650;</a><del>*</del>[[<del>List of </del><ins>Category:</ins>New Hampshire <del>numbered</del><ins>state</ins> highways<ins>|145</ins>]]</div>
<div class="mw-diff-inline-moved mw-diff-inline-moved-destination mw-diff-inline-moved-downwards"><a name="movedpara_16_1_rhs"></a>[[Category:<del>New</del><ins>Coos</ins> <del>Hampshire</del><ins>County,</ins> <del>state</del><ins>New</ins> <del>highways|145</del><ins>Hampshire</ins>]]<a class="mw-diff-movedpara-right" data-title-tag="new" href="#movedpara_18_0_lhs">&#9660;</a></div>
<div class="mw-diff-inline-context">&#160;</div>
<div class="mw-diff-inline-context">{{NewHampshire-State-Highway-stub}}</div>
<div class="mw-diff-inline-moved mw-diff-inline-moved-source mw-diff-inline-moved-upwards"><a name="movedpara_18_0_lhs"></a><a class="mw-diff-movedpara-left" data-title-tag="old" href="#movedpara_16_1_rhs">&#9650;</a>[[Category:New Hampshire state highways|145]]</div>
