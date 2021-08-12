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

?>
--EXPECT--
<tr>
  <td colspan="2" class="diff-lineno"><!--LINE 1--></td>
  <td colspan="2" class="diff-lineno"><!--LINE 1--></td>
</tr>
<tr>
  <td class="diff-marker"></td>
  <td class="diff-context diff-left"><div>Die Gemeinde Frankenhardt setzt sich aus 39 Dörfern, Weilern, Höfen und Häusern zusammen.&lt;ref&gt;''Das Land Baden-Württemberg. Amtliche Beschreibung nach Kreisen und Gemeinden. Band IV: Regierungsbezirk Stuttgart, Regionalverbände Franken und Ostwürttemberg.'' Kohlhammer, Stuttgart 1980, ISBN 3-17-005708-1. S. 442–447&lt;/ref&gt;</div></td>
  <td class="diff-marker"></td>
  <td class="diff-context diff-right"><div>Die Gemeinde Frankenhardt setzt sich aus 39 Dörfern, Weilern, Höfen und Häusern zusammen.&lt;ref&gt;''Das Land Baden-Württemberg. Amtliche Beschreibung nach Kreisen und Gemeinden. Band IV: Regierungsbezirk Stuttgart, Regionalverbände Franken und Ostwürttemberg.'' Kohlhammer, Stuttgart 1980, ISBN 3-17-005708-1. S. 442–447&lt;/ref&gt;</div></td>
</tr>
<tr>
  <td class="diff-marker"></td>
  <td class="diff-context diff-left"><br /></td>
  <td class="diff-marker"></td>
  <td class="diff-context diff-right"><br /></td>
</tr>
<tr>
  <td colspan="2" class="diff-empty diff-left"></td>
  <td class="diff-marker"><a class="mw-diff-movedpara-right" href="#movedpara_3_0_lhs">&#x26AB;</a></td>
  <td class="diff-addedline diff-right"><div><a name="movedpara_1_0_rhs"></a><ins class="diffchange diffchange-inline">[[Datei:Wappen Honhardt.png|links|30px|Honhardt]] </ins>Zur ehemaligen Gemeinde Honhardt gehören das Dorf Honhardt, die Weiler Altenfelden, Appensee, Bechhof, Eckarrot, Gauchshausen, Hirschhof, Ipshof, Mainkling, Neuhaus, Reifenhof, Reishof, Sandhof, Steinbach an der Jagst, Unterspeltach, Vorderuhlberg und Zum Wagner, das Gehöft Belzhof und die Wohnplätze Fleckenbacher Sägmühle, Grunbachsägmühle, Henkensägmühle und Tiefensägmühle.</div></td>
</tr>
<tr>
  <td class="diff-marker" data-marker="−"></td>
  <td class="diff-deletedline diff-left"><div>[[Datei:Wappen Honhardt.png|links|60px|Honhardt]]</div></td>
  <td colspan="2" class="diff-empty diff-right"></td>
</tr>
<tr>
  <td class="diff-marker"><a class="mw-diff-movedpara-left" href="#movedpara_1_0_rhs">&#x26AB;</a></td>
  <td class="diff-deletedline diff-left"><div><a name="movedpara_3_0_lhs"></a>Zur ehemaligen Gemeinde Honhardt gehören das Dorf Honhardt, die Weiler Altenfelden, Appensee, Bechhof, Eckarrot, Gauchshausen, Hirschhof, Ipshof, Mainkling, Neuhaus, Reifenhof, Reishof, Sandhof, Steinbach an der Jagst, Unterspeltach, Vorderuhlberg und Zum Wagner, das Gehöft Belzhof und die Wohnplätze Fleckenbacher Sägmühle, Grunbachsägmühle, Henkensägmühle und Tiefensägmühle.</div></td>
  <td colspan="2" class="diff-empty diff-right"></td>
</tr>
<tr>
  <td class="diff-marker"></td>
  <td class="diff-context diff-left"><div>[[Datei:Honhardt.jpg|mini|Der Teilort Honhardt mit Kirche und Schloss. Blick vom Sandberg in Richtung Norden.]]</div></td>
  <td class="diff-marker"></td>
  <td class="diff-context diff-right"><div>[[Datei:Honhardt.jpg|mini|Der Teilort Honhardt mit Kirche und Schloss. Blick vom Sandberg in Richtung Norden.]]</div></td>
</tr>
