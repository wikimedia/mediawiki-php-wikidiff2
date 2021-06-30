--TEST--
Test case for https://gerrit.wikimedia.org/r/404293 from https://de.wikipedia.org/wiki/Special:Diff/169304779/169305386
--FILE--
<?php
$before = <<<EOT
=== Erste Erfolge ===
[[Bild:Lisa - Xandria (Unifest 2006).jpg|mini|links|hochkant|Lisa Middelhauve mit Xandria 2006]]
Heubaum nahm seine musikalischen Ideen, die er nicht mit dem vorausgegangenem Projekt verwirklichen konnte und probte mit Bielefelder Musikern. Einige dieser Musiker spielten zuvor in einer gemeinsamen Band mit dem Bassisten Roland Krueger.<ref Name="MSBio"/><ref Name="AMBio">{{Internetquelle|url=http://www.allmusic.com/artist/xandria-mn0000513830/biography|titel=Xandria|hrsg=Allmusic|autor=Jason Birchmeier|zugriff=2017-09-21}}</ref> Als Studioprojekt unter der musikalischen Leitung Heubaums spielten die Musiker das Demo ''Kill the Sun'' ein. ''Kill the Sun'' wurde zum Download angeboten. Die beteiligten Musiker wurden indes nicht klar benannt und durch die Namen der [[Liste ägyptischer Götter|ägyptischen Gottheiten]] Osiris, Isis, Anubis, Horus und Seth anonymisiert. Später gab die Gruppe an das Demo sei mit dem Schlagzeuger Gerit Lamm und einer regionalen Sängerin, die noch vor der Produktion des Debütalbums ausstieg, aufgenommen worden. Durch die Veröffentlichung als Download erreichte Xandria noch vor Abschluss eines Plattenvertrages ein breites Publikum.<ref>{{Internetquelle|url=http://www.emp.de/art_420455/|titel=Xandria: Kill the Sun|autor=|hrsg=EMP|zugriff=2017-09-21}}</ref><ref Name="MSBio"/>

Udo Zimmer
EOT;

#---------------------------------------------------

$after = <<<EOT
=== Erste Erfolge ===
Heubaum nahm seine musikalischen Ideen, die er nicht mit dem vorausgegangenem Projekt verwirklichen konnte und probte mit Bielefelder Musikern. Einige dieser Musiker spielten zuvor in einer gemeinsamen Band mit dem Bassisten Roland Krueger.<ref Name="MSBio"/><ref Name="AMBio">{{Internetquelle|url=http://www.allmusic.com/artist/xandria-mn0000513830/biography|titel=Xandria|hrsg=Allmusic|autor=Jason Birchmeier|zugriff=2017-09-21}}</ref> Als Studioprojekt unter der musikalischen Leitung Heubaums spielten die Musiker das Demo ''Kill the Sun'' ein. ''Kill the Sun'' wurde zum Download angeboten. Die beteiligten Musiker wurden indes nicht klar benannt und durch die Namen der [[Liste ägyptischer Götter|ägyptischen Gottheiten]] Osiris, Isis, Anubis, Horus und Seth anonymisiert. Später gab die Gruppe an das Demo sei mit dem Schlagzeuger Gerit Lamm und einer regionalen Sängerin, die noch vor der Produktion des Debütalbums ausstieg, aufgenommen worden. Durch die Veröffentlichung als Download erreichte Xandria noch vor Abschluss eines Plattenvertrages ein breites Publikum.<ref Name="EMP">{{Internetquelle|url=http://www.emp.de/art_420455/|titel=Xandria: Kill the Sun|autor=|hrsg=EMP|zugriff=2017-09-21}}</ref><ref Name="MSBio"/>

[[Bild:Lisa - Xandria (Unifest 2006).jpg|mini|links|hochkant|Lisa Middelhauve mit Xandria 2006]]
Udo Zimmer
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
  <td class="diff-context"><div>=== Erste Erfolge ===</div></td>
  <td class="diff-marker"></td>
  <td class="diff-context"><div>=== Erste Erfolge ===</div></td>
</tr>
<tr>
  <td colspan="2" class="diff-empty"></td>
  <td class="diff-marker"><a class="mw-diff-movedpara-right" href="#movedpara_3_0_lhs">&#x26AB;</a></td>
  <td class="diff-addedline"><div><a name="movedpara_1_0_rhs"></a>Heubaum nahm seine musikalischen Ideen, die er nicht mit dem vorausgegangenem Projekt verwirklichen konnte und probte mit Bielefelder Musikern. Einige dieser Musiker spielten zuvor in einer gemeinsamen Band mit dem Bassisten Roland Krueger.&lt;ref Name="MSBio"/&gt;&lt;ref Name="AMBio"&gt;{{Internetquelle|url=http://www.allmusic.com/artist/xandria-mn0000513830/biography|titel=Xandria|hrsg=Allmusic|autor=Jason Birchmeier|zugriff=2017-09-21}}&lt;/ref&gt; Als Studioprojekt unter der musikalischen Leitung Heubaums spielten die Musiker das Demo ''Kill the Sun'' ein. ''Kill the Sun'' wurde zum Download angeboten. Die beteiligten Musiker wurden indes nicht klar benannt und durch die Namen der [[Liste ägyptischer Götter|ägyptischen Gottheiten]] Osiris, Isis, Anubis, Horus und Seth anonymisiert. Später gab die Gruppe an das Demo sei mit dem Schlagzeuger Gerit Lamm und einer regionalen Sängerin, die noch vor der Produktion des Debütalbums ausstieg, aufgenommen worden. Durch die Veröffentlichung als Download erreichte Xandria noch vor Abschluss eines Plattenvertrages ein breites Publikum.&lt;ref<ins class="diffchange diffchange-inline"> Name="EMP"</ins>&gt;{{Internetquelle|url=http://www.emp.de/art_420455/|titel=Xandria: Kill the Sun|autor=|hrsg=EMP|zugriff=2017-09-21}}&lt;/ref&gt;&lt;ref Name="MSBio"/&gt;</div></td>
</tr>
<tr>
  <td class="diff-marker"><a class="mw-diff-movedpara-left" href="#movedpara_5_0_rhs">&#x26AB;</a></td>
  <td class="diff-deletedline"><div><a name="movedpara_2_0_lhs"></a>[[Bild:Lisa - Xandria (Unifest 2006).jpg|mini|links|hochkant|Lisa Middelhauve mit Xandria 2006]]</div></td>
  <td colspan="2" class="diff-empty"></td>
</tr>
<tr>
  <td class="diff-marker"><a class="mw-diff-movedpara-left" href="#movedpara_1_0_rhs">&#x26AB;</a></td>
  <td class="diff-deletedline"><div><a name="movedpara_3_0_lhs"></a>Heubaum nahm seine musikalischen Ideen, die er nicht mit dem vorausgegangenem Projekt verwirklichen konnte und probte mit Bielefelder Musikern. Einige dieser Musiker spielten zuvor in einer gemeinsamen Band mit dem Bassisten Roland Krueger.&lt;ref Name="MSBio"/&gt;&lt;ref Name="AMBio"&gt;{{Internetquelle|url=http://www.allmusic.com/artist/xandria-mn0000513830/biography|titel=Xandria|hrsg=Allmusic|autor=Jason Birchmeier|zugriff=2017-09-21}}&lt;/ref&gt; Als Studioprojekt unter der musikalischen Leitung Heubaums spielten die Musiker das Demo ''Kill the Sun'' ein. ''Kill the Sun'' wurde zum Download angeboten. Die beteiligten Musiker wurden indes nicht klar benannt und durch die Namen der [[Liste ägyptischer Götter|ägyptischen Gottheiten]] Osiris, Isis, Anubis, Horus und Seth anonymisiert. Später gab die Gruppe an das Demo sei mit dem Schlagzeuger Gerit Lamm und einer regionalen Sängerin, die noch vor der Produktion des Debütalbums ausstieg, aufgenommen worden. Durch die Veröffentlichung als Download erreichte Xandria noch vor Abschluss eines Plattenvertrages ein breites Publikum.&lt;ref&gt;{{Internetquelle|url=http://www.emp.de/art_420455/|titel=Xandria: Kill the Sun|autor=|hrsg=EMP|zugriff=2017-09-21}}&lt;/ref&gt;&lt;ref Name="MSBio"/&gt;</div></td>
  <td colspan="2" class="diff-empty"></td>
</tr>
<tr>
  <td class="diff-marker"></td>
  <td class="diff-context"><br /></td>
  <td class="diff-marker"></td>
  <td class="diff-context"><br /></td>
</tr>
<tr>
  <td colspan="2" class="diff-empty"></td>
  <td class="diff-marker"><a class="mw-diff-movedpara-right" href="#movedpara_2_0_lhs">&#x26AB;</a></td>
  <td class="diff-addedline"><div><a name="movedpara_5_0_rhs"></a>[[Bild:Lisa - Xandria (Unifest 2006).jpg|mini|links|hochkant|Lisa Middelhauve mit Xandria 2006]]</div></td>
</tr>
<tr>
  <td class="diff-marker"></td>
  <td class="diff-context"><div>Udo Zimmer</div></td>
  <td class="diff-marker"></td>
  <td class="diff-context"><div>Udo Zimmer</div></td>
</tr>
