--TEST--
Test case for T182300 from https://de.wikipedia.org/wiki/Special:Diff/171771634
--FILE--
<?php
$before = <<<EOT
Die Gemeinde Frankenhardt setzt sich aus 39 Dörfern, Weilern, Höfen und Häusern zusammen.<ref>''Das Land Baden-Württemberg. Amtliche Beschreibung nach Kreisen und Gemeinden. Band IV: Regierungsbezirk Stuttgart, Regionalverbände Franken und Ostwürttemberg.'' Kohlhammer, Stuttgart 1980, ISBN 3-17-005708-1. S. 442–447</ref>

[[Datei:Wappen Honhardt.png|links|60px|Honhardt]]
Zur ehemaligen Gemeinde Honhardt gehören das Dorf Honhardt, die Weiler Altenfelden, Appensee, Bechhof, Eckarrot, Gauchshausen, Hirschhof, Ipshof, Mainkling, Neuhaus, Reifenhof, Reishof, Sandhof, Steinbach an der Jagst, Unterspeltach, Vorderuhlberg und Zum Wagner, das Gehöft Belzhof und die Wohnplätze Fleckenbacher Sägmühle, Grunbachsägmühle, Henkensägmühle und Tiefensägmühle.
[[Datei:Honhardt.jpg|mini|Der Teilort Honhardt mit Kirche und Schloss. Blick vom Sandberg in Richtung Norden.]]
EOT;

#---------------------------------------------------

$after = <<<EOT
Die Gemeinde Frankenhardt setzt sich aus 39 Dörfern, Weilern, Höfen und Häusern zusammen.<ref>''Das Land Baden-Württemberg. Amtliche Beschreibung nach Kreisen und Gemeinden. Band IV: Regierungsbezirk Stuttgart, Regionalverbände Franken und Ostwürttemberg.'' Kohlhammer, Stuttgart 1980, ISBN 3-17-005708-1. S. 442–447</ref>

[[Datei:Wappen Honhardt.png|links|30px|Honhardt]] Zur ehemaligen Gemeinde Honhardt gehören das Dorf Honhardt, die Weiler Altenfelden, Appensee, Bechhof, Eckarrot, Gauchshausen, Hirschhof, Ipshof, Mainkling, Neuhaus, Reifenhof, Reishof, Sandhof, Steinbach an der Jagst, Unterspeltach, Vorderuhlberg und Zum Wagner, das Gehöft Belzhof und die Wohnplätze Fleckenbacher Sägmühle, Grunbachsägmühle, Henkensägmühle und Tiefensägmühle.
[[Datei:Honhardt.jpg|mini|Der Teilort Honhardt mit Kirche und Schloss. Blick vom Sandberg in Richtung Norden.]]
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
  <td class="diff-context diff-side-deleted"><div>Die Gemeinde Frankenhardt setzt sich aus 39 Dörfern, Weilern, Höfen und Häusern zusammen.&lt;ref&gt;''Das Land Baden-Württemberg. Amtliche Beschreibung nach Kreisen und Gemeinden. Band IV: Regierungsbezirk Stuttgart, Regionalverbände Franken und Ostwürttemberg.'' Kohlhammer, Stuttgart 1980, ISBN 3-17-005708-1. S. 442–447&lt;/ref&gt;</div></td>
  <td class="diff-marker"></td>
  <td class="diff-context diff-side-added"><div>Die Gemeinde Frankenhardt setzt sich aus 39 Dörfern, Weilern, Höfen und Häusern zusammen.&lt;ref&gt;''Das Land Baden-Württemberg. Amtliche Beschreibung nach Kreisen und Gemeinden. Band IV: Regierungsbezirk Stuttgart, Regionalverbände Franken und Ostwürttemberg.'' Kohlhammer, Stuttgart 1980, ISBN 3-17-005708-1. S. 442–447&lt;/ref&gt;</div></td>
</tr>
<tr>
  <td class="diff-marker"></td>
  <td class="diff-context diff-side-deleted"><br /></td>
  <td class="diff-marker"></td>
  <td class="diff-context diff-side-added"><br /></td>
</tr>
<tr>
  <td colspan="2" class="diff-empty diff-side-deleted"></td>
  <td class="diff-marker"><a class="mw-diff-movedpara-right" href="#movedpara_3_0_lhs">&#x26AB;</a></td>
  <td class="diff-addedline diff-side-added"><div><a name="movedpara_1_0_rhs"></a><ins class="diffchange diffchange-inline">[[Datei:Wappen Honhardt.png|links|30px|Honhardt]] </ins>Zur ehemaligen Gemeinde Honhardt gehören das Dorf Honhardt, die Weiler Altenfelden, Appensee, Bechhof, Eckarrot, Gauchshausen, Hirschhof, Ipshof, Mainkling, Neuhaus, Reifenhof, Reishof, Sandhof, Steinbach an der Jagst, Unterspeltach, Vorderuhlberg und Zum Wagner, das Gehöft Belzhof und die Wohnplätze Fleckenbacher Sägmühle, Grunbachsägmühle, Henkensägmühle und Tiefensägmühle.</div></td>
</tr>
<tr>
  <td class="diff-marker" data-marker="−"></td>
  <td class="diff-deletedline diff-side-deleted"><div>[[Datei:Wappen Honhardt.png|links|60px|Honhardt]]</div></td>
  <td colspan="2" class="diff-empty diff-side-added"></td>
</tr>
<tr>
  <td class="diff-marker"><a class="mw-diff-movedpara-left" href="#movedpara_1_0_rhs">&#x26AB;</a></td>
  <td class="diff-deletedline diff-side-deleted"><div><a name="movedpara_3_0_lhs"></a>Zur ehemaligen Gemeinde Honhardt gehören das Dorf Honhardt, die Weiler Altenfelden, Appensee, Bechhof, Eckarrot, Gauchshausen, Hirschhof, Ipshof, Mainkling, Neuhaus, Reifenhof, Reishof, Sandhof, Steinbach an der Jagst, Unterspeltach, Vorderuhlberg und Zum Wagner, das Gehöft Belzhof und die Wohnplätze Fleckenbacher Sägmühle, Grunbachsägmühle, Henkensägmühle und Tiefensägmühle.</div></td>
  <td colspan="2" class="diff-empty diff-side-added"></td>
</tr>
<tr>
  <td class="diff-marker"></td>
  <td class="diff-context diff-side-deleted"><div>[[Datei:Honhardt.jpg|mini|Der Teilort Honhardt mit Kirche und Schloss. Blick vom Sandberg in Richtung Norden.]]</div></td>
  <td class="diff-marker"></td>
  <td class="diff-context diff-side-added"><div>[[Datei:Honhardt.jpg|mini|Der Teilort Honhardt mit Kirche und Schloss. Blick vom Sandberg in Richtung Norden.]]</div></td>
</tr>

----INLINE:----
<div class="mw-diff-inline-header"><!-- LINES 1,1 --></div>
<div class="mw-diff-inline-context">Die Gemeinde Frankenhardt setzt sich aus 39 Dörfern, Weilern, Höfen und Häusern zusammen.&lt;ref&gt;''Das Land Baden-Württemberg. Amtliche Beschreibung nach Kreisen und Gemeinden. Band IV: Regierungsbezirk Stuttgart, Regionalverbände Franken und Ostwürttemberg.'' Kohlhammer, Stuttgart 1980, ISBN 3-17-005708-1. S. 442–447&lt;/ref&gt;</div>
<div class="mw-diff-inline-context">&#160;</div>
<div class="mw-diff-inline-moved mw-diff-inline-moved-destination mw-diff-inline-moved-downwards"><a name="movedpara_1_0_rhs"></a><ins>[[Datei:Wappen Honhardt.png|links|30px|Honhardt]] </ins>Zur ehemaligen Gemeinde Honhardt gehören das Dorf Honhardt, die Weiler Altenfelden, Appensee, Bechhof, Eckarrot, Gauchshausen, Hirschhof, Ipshof, Mainkling, Neuhaus, Reifenhof, Reishof, Sandhof, Steinbach an der Jagst, Unterspeltach, Vorderuhlberg und Zum Wagner, das Gehöft Belzhof und die Wohnplätze Fleckenbacher Sägmühle, Grunbachsägmühle, Henkensägmühle und Tiefensägmühle.<a class="mw-diff-movedpara-right" data-title-tag="new" href="#movedpara_3_0_lhs">&#9660;</a></div>
<div class="mw-diff-inline-deleted"><del>[[Datei:Wappen Honhardt.png|links|60px|Honhardt]]</del></div>
<div class="mw-diff-inline-moved mw-diff-inline-moved-source mw-diff-inline-moved-upwards"><a name="movedpara_3_0_lhs"></a><a class="mw-diff-movedpara-left" data-title-tag="old" href="#movedpara_1_0_rhs">&#9650;</a>Zur ehemaligen Gemeinde Honhardt gehören das Dorf Honhardt, die Weiler Altenfelden, Appensee, Bechhof, Eckarrot, Gauchshausen, Hirschhof, Ipshof, Mainkling, Neuhaus, Reifenhof, Reishof, Sandhof, Steinbach an der Jagst, Unterspeltach, Vorderuhlberg und Zum Wagner, das Gehöft Belzhof und die Wohnplätze Fleckenbacher Sägmühle, Grunbachsägmühle, Henkensägmühle und Tiefensägmühle.</div>
<div class="mw-diff-inline-context">[[Datei:Honhardt.jpg|mini|Der Teilort Honhardt mit Kirche und Schloss. Blick vom Sandberg in Richtung Norden.]]</div>
