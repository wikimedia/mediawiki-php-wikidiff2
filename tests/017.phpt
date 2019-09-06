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

?>
--EXPECT--
<tr>
  <td colspan="2" class="diff-lineno"><!--LINE 1--></td>
  <td colspan="2" class="diff-lineno"><!--LINE 1--></td>
</tr>
<tr>
  <td colspan="2" class="diff-empty">&#160;</td>
  <td class="diff-marker">+</td>
  <td class="diff-addedline"><div>{{Infobox NH Route</div></td>
</tr>
<tr>
  <td class="diff-marker">−</td>
  <td class="diff-deletedline"><div>{{Infobox_road</div></td>
  <td colspan="2" class="diff-empty">&#160;</td>
</tr>
<tr>
  <td colspan="2" class="diff-empty">&#160;</td>
  <td class="diff-marker">+</td>
  <td class="diff-addedline"><div>|previous_type=NH</div></td>
</tr>
<tr>
  <td class="diff-marker">−</td>
  <td class="diff-deletedline"><div>| system            = [[New Hampshire Highway System]]</div></td>
  <td colspan="2" class="diff-empty">&#160;</td>
</tr>
<tr>
  <td colspan="2" class="diff-empty">&#160;</td>
  <td class="diff-marker">+</td>
  <td class="diff-addedline"><div>|previous_route=142</div></td>
</tr>
<tr>
  <td class="diff-marker">−</td>
  <td class="diff-deletedline"><div>| browse            = {{nh browse|previous_type=NH|previous_route=142|next_type=NH|next_route=149}}</div></td>
  <td colspan="2" class="diff-empty">&#160;</td>
</tr>
<tr>
  <td colspan="2" class="diff-empty">&#160;</td>
  <td class="diff-marker">+</td>
  <td class="diff-addedline"><div>|next_type=NH</div></td>
</tr>
<tr>
  <td class="diff-marker"><a class="mw-diff-movedpara-left" href="#movedpara_8_2_rhs">&#x26AB;</a></td>
  <td class="diff-deletedline"><div><a name="movedpara_7_0_lhs"></a><del class="diffchange diffchange-inline">}}</del>'''New Hampshire Route 145''' ('''NH 145''') is a north–south highway in [[Coos County, New Hampshire|Coos County]] in northern [[New Hampshire]]. The highway runs between [[Colebrook, New Hampshire|Colebrook]] and [[Pittsburg, New Hampshire|Pittsburg]].</div></td>
  <td colspan="2" class="diff-empty">&#160;</td>
</tr>
<tr>
  <td colspan="2" class="diff-empty">&#160;</td>
  <td class="diff-marker">+</td>
  <td class="diff-addedline"><div>|next_route=149</div></td>
</tr>
<tr>
  <td colspan="2" class="diff-empty">&#160;</td>
  <td class="diff-marker">+</td>
  <td class="diff-addedline"><div>}}</div></td>
</tr>
<tr>
  <td colspan="2" class="diff-empty">&#160;</td>
  <td class="diff-marker"><a class="mw-diff-movedpara-right" href="#movedpara_7_0_lhs">&#x26AB;</a></td>
  <td class="diff-addedline"><div><a name="movedpara_8_2_rhs"></a>'''New Hampshire Route 145''' (<ins class="diffchange diffchange-inline">abbreviated </ins>'''NH 145''') is a<ins class="diffchange diffchange-inline"> 13.12&amp;#160;mile long</ins> north–south<ins class="diffchange diffchange-inline"> [[state</ins> highway<ins class="diffchange diffchange-inline">]]</ins> in [[Coos County, New Hampshire|Coos County]] in northern [[New Hampshire]]. The highway runs between [[Colebrook, New Hampshire|Colebrook]] and [[Pittsburg, New Hampshire|Pittsburg]].</div></td>
</tr>
<tr>
  <td class="diff-marker">&#160;</td>
  <td class="diff-context"></td>
  <td class="diff-marker">&#160;</td>
  <td class="diff-context"></td>
</tr>
<tr>
  <td class="diff-marker">−</td>
  <td class="diff-deletedline"><div>The southern terminus of NH 145 is at<del class="diffchange diffchange-inline"> the junction with</del> [[U.S. <del class="diffchange diffchange-inline">Highway</del> 3|<del class="diffchange diffchange-inline">US</del> 3]] in Colebrook on the [[Vermont]] border. The highway passes through [[Clarksville, New Hampshire|Clarksville]] township and the village center. The northern terminus of NH 145 is in Pittsburg at<del class="diffchange diffchange-inline"> the junction with</del> US 3<del class="diffchange diffchange-inline">. Total length of the highway is approximately 13.2 miles (21.3 km)</del>.</div></td>
  <td class="diff-marker">+</td>
  <td class="diff-addedline"><div>The southern terminus of NH 145 is at [[U.S. <ins class="diffchange diffchange-inline">Route</ins> 3<ins class="diffchange diffchange-inline"> (New Hampshire)</ins>|<ins class="diffchange diffchange-inline">U.S. Route</ins> 3]] in Colebrook on the [[Vermont]] border. The highway passes through [[Clarksville, New Hampshire|Clarksville]] township and the village center. The northern terminus of NH 145 is in Pittsburg at US 3.</div></td>
</tr>
<tr>
  <td class="diff-marker">&#160;</td>
  <td class="diff-context"></td>
  <td class="diff-marker">&#160;</td>
  <td class="diff-context"></td>
</tr>
<tr>
  <td class="diff-marker">−</td>
  <td class="diff-deletedline"><div>==<del class="diffchange diffchange-inline"> See also </del>==</div></td>
  <td class="diff-marker">+</td>
  <td class="diff-addedline"><div>==<ins class="diffchange diffchange-inline">References</ins>==</div></td>
</tr>
<tr>
  <td colspan="2" class="diff-empty">&#160;</td>
  <td class="diff-marker">+</td>
  <td class="diff-addedline"><div>&lt;references/&gt;</div></td>
</tr>
<tr>
  <td class="diff-marker"><a class="mw-diff-movedpara-left" href="#movedpara_16_0_rhs">&#x26AB;</a></td>
  <td class="diff-deletedline"><div><a name="movedpara_14_0_lhs"></a><del class="diffchange diffchange-inline">*</del>[[<del class="diffchange diffchange-inline">List of </del>New Hampshire <del class="diffchange diffchange-inline">numbered</del> highways]]</div></td>
  <td colspan="2" class="diff-empty">&#160;</td>
</tr>
<tr>
  <td class="diff-marker">&#160;</td>
  <td class="diff-context"></td>
  <td class="diff-marker">&#160;</td>
  <td class="diff-context"></td>
</tr>
<tr>
  <td colspan="2" class="diff-empty">&#160;</td>
  <td class="diff-marker"><a class="mw-diff-movedpara-right" href="#movedpara_14_0_lhs">&#x26AB;</a></td>
  <td class="diff-addedline"><div><a name="movedpara_16_0_rhs"></a>[[<ins class="diffchange diffchange-inline">Category:</ins>New Hampshire <ins class="diffchange diffchange-inline">state</ins> highways<ins class="diffchange diffchange-inline">|145</ins>]]</div></td>
</tr>
<tr>
  <td colspan="2" class="diff-empty">&#160;</td>
  <td class="diff-marker"><a class="mw-diff-movedpara-right" href="#movedpara_18_0_lhs">&#x26AB;</a></td>
  <td class="diff-addedline"><div><a name="movedpara_16_1_rhs"></a>[[Category:<ins class="diffchange diffchange-inline">Coos</ins> <ins class="diffchange diffchange-inline">County,</ins> <ins class="diffchange diffchange-inline">New</ins> <ins class="diffchange diffchange-inline">Hampshire</ins>]]</div></td>
</tr>
<tr>
  <td class="diff-marker">&#160;</td>
  <td class="diff-context"></td>
  <td class="diff-marker">&#160;</td>
  <td class="diff-context"></td>
</tr>
<tr>
  <td class="diff-marker">&#160;</td>
  <td class="diff-context"><div>{{NewHampshire-State-Highway-stub}}</div></td>
  <td class="diff-marker">&#160;</td>
  <td class="diff-context"><div>{{NewHampshire-State-Highway-stub}}</div></td>
</tr>
<tr>
  <td class="diff-marker"><a class="mw-diff-movedpara-left" href="#movedpara_16_1_rhs">&#x26AB;</a></td>
  <td class="diff-deletedline"><div><a name="movedpara_18_0_lhs"></a>[[Category:<del class="diffchange diffchange-inline">New</del> <del class="diffchange diffchange-inline">Hampshire</del> <del class="diffchange diffchange-inline">state</del> <del class="diffchange diffchange-inline">highways|145</del>]]</div></td>
  <td colspan="2" class="diff-empty">&#160;</td>
</tr>
