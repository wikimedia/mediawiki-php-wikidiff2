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
  <td class="diff-context diff-side-deleted"><div>=== Erste Erfolge ===</div></td>
  <td class="diff-marker"></td>
  <td class="diff-context diff-side-added"><div>=== Erste Erfolge ===</div></td>
</tr>
<tr>
  <td colspan="2" class="diff-empty diff-side-deleted"></td>
  <td class="diff-marker"><a class="mw-diff-movedpara-right" href="#movedpara_3_0_lhs">&#x26AB;</a></td>
  <td class="diff-addedline diff-side-added"><div><a name="movedpara_1_0_rhs"></a>Heubaum nahm seine musikalischen Ideen, die er nicht mit dem vorausgegangenem Projekt verwirklichen konnte und probte mit Bielefelder Musikern. Einige dieser Musiker spielten zuvor in einer gemeinsamen Band mit dem Bassisten Roland Krueger.&lt;ref Name="MSBio"/&gt;&lt;ref Name="AMBio"&gt;{{Internetquelle|url=http://www.allmusic.com/artist/xandria-mn0000513830/biography|titel=Xandria|hrsg=Allmusic|autor=Jason Birchmeier|zugriff=2017-09-21}}&lt;/ref&gt; Als Studioprojekt unter der musikalischen Leitung Heubaums spielten die Musiker das Demo ''Kill the Sun'' ein. ''Kill the Sun'' wurde zum Download angeboten. Die beteiligten Musiker wurden indes nicht klar benannt und durch die Namen der [[Liste ägyptischer Götter|ägyptischen Gottheiten]] Osiris, Isis, Anubis, Horus und Seth anonymisiert. Später gab die Gruppe an das Demo sei mit dem Schlagzeuger Gerit Lamm und einer regionalen Sängerin, die noch vor der Produktion des Debütalbums ausstieg, aufgenommen worden. Durch die Veröffentlichung als Download erreichte Xandria noch vor Abschluss eines Plattenvertrages ein breites Publikum.&lt;ref<ins class="diffchange diffchange-inline"> Name="EMP"</ins>&gt;{{Internetquelle|url=http://www.emp.de/art_420455/|titel=Xandria: Kill the Sun|autor=|hrsg=EMP|zugriff=2017-09-21}}&lt;/ref&gt;&lt;ref Name="MSBio"/&gt;</div></td>
</tr>
<tr>
  <td class="diff-marker"><a class="mw-diff-movedpara-left" href="#movedpara_5_0_rhs">&#x26AB;</a></td>
  <td class="diff-deletedline diff-side-deleted"><div><a name="movedpara_2_0_lhs"></a>[[Bild:Lisa - Xandria (Unifest 2006).jpg|mini|links|hochkant|Lisa Middelhauve mit Xandria 2006]]</div></td>
  <td colspan="2" class="diff-empty diff-side-added"></td>
</tr>
<tr>
  <td class="diff-marker"><a class="mw-diff-movedpara-left" href="#movedpara_1_0_rhs">&#x26AB;</a></td>
  <td class="diff-deletedline diff-side-deleted"><div><a name="movedpara_3_0_lhs"></a>Heubaum nahm seine musikalischen Ideen, die er nicht mit dem vorausgegangenem Projekt verwirklichen konnte und probte mit Bielefelder Musikern. Einige dieser Musiker spielten zuvor in einer gemeinsamen Band mit dem Bassisten Roland Krueger.&lt;ref Name="MSBio"/&gt;&lt;ref Name="AMBio"&gt;{{Internetquelle|url=http://www.allmusic.com/artist/xandria-mn0000513830/biography|titel=Xandria|hrsg=Allmusic|autor=Jason Birchmeier|zugriff=2017-09-21}}&lt;/ref&gt; Als Studioprojekt unter der musikalischen Leitung Heubaums spielten die Musiker das Demo ''Kill the Sun'' ein. ''Kill the Sun'' wurde zum Download angeboten. Die beteiligten Musiker wurden indes nicht klar benannt und durch die Namen der [[Liste ägyptischer Götter|ägyptischen Gottheiten]] Osiris, Isis, Anubis, Horus und Seth anonymisiert. Später gab die Gruppe an das Demo sei mit dem Schlagzeuger Gerit Lamm und einer regionalen Sängerin, die noch vor der Produktion des Debütalbums ausstieg, aufgenommen worden. Durch die Veröffentlichung als Download erreichte Xandria noch vor Abschluss eines Plattenvertrages ein breites Publikum.&lt;ref&gt;{{Internetquelle|url=http://www.emp.de/art_420455/|titel=Xandria: Kill the Sun|autor=|hrsg=EMP|zugriff=2017-09-21}}&lt;/ref&gt;&lt;ref Name="MSBio"/&gt;</div></td>
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
  <td class="diff-marker"><a class="mw-diff-movedpara-right" href="#movedpara_2_0_lhs">&#x26AB;</a></td>
  <td class="diff-addedline diff-side-added"><div><a name="movedpara_5_0_rhs"></a>[[Bild:Lisa - Xandria (Unifest 2006).jpg|mini|links|hochkant|Lisa Middelhauve mit Xandria 2006]]</div></td>
</tr>
<tr>
  <td class="diff-marker"></td>
  <td class="diff-context diff-side-deleted"><div>Udo Zimmer</div></td>
  <td class="diff-marker"></td>
  <td class="diff-context diff-side-added"><div>Udo Zimmer</div></td>
</tr>

----INLINE:----
<div class="mw-diff-inline-header"><!-- LINES 1,1 --></div>
<div class="mw-diff-inline-context">=== Erste Erfolge ===</div>
<div class="mw-diff-inline-moved mw-diff-inline-moved-destination mw-diff-inline-moved-downwards"><a name="movedpara_1_0_rhs"></a>Heubaum nahm seine musikalischen Ideen, die er nicht mit dem vorausgegangenem Projekt verwirklichen konnte und probte mit Bielefelder Musikern. Einige dieser Musiker spielten zuvor in einer gemeinsamen Band mit dem Bassisten Roland Krueger.&lt;ref Name="MSBio"/&gt;&lt;ref Name="AMBio"&gt;{{Internetquelle|url=http://www.allmusic.com/artist/xandria-mn0000513830/biography|titel=Xandria|hrsg=Allmusic|autor=Jason Birchmeier|zugriff=2017-09-21}}&lt;/ref&gt; Als Studioprojekt unter der musikalischen Leitung Heubaums spielten die Musiker das Demo ''Kill the Sun'' ein. ''Kill the Sun'' wurde zum Download angeboten. Die beteiligten Musiker wurden indes nicht klar benannt und durch die Namen der [[Liste ägyptischer Götter|ägyptischen Gottheiten]] Osiris, Isis, Anubis, Horus und Seth anonymisiert. Später gab die Gruppe an das Demo sei mit dem Schlagzeuger Gerit Lamm und einer regionalen Sängerin, die noch vor der Produktion des Debütalbums ausstieg, aufgenommen worden. Durch die Veröffentlichung als Download erreichte Xandria noch vor Abschluss eines Plattenvertrages ein breites Publikum.&lt;ref<ins> Name="EMP"</ins>&gt;{{Internetquelle|url=http://www.emp.de/art_420455/|titel=Xandria: Kill the Sun|autor=|hrsg=EMP|zugriff=2017-09-21}}&lt;/ref&gt;&lt;ref Name="MSBio"/&gt;<a class="mw-diff-movedpara-right" data-title-tag="new" href="#movedpara_3_0_lhs">&#9660;</a></div>
<div class="mw-diff-inline-moved mw-diff-inline-moved-source mw-diff-inline-moved-downwards"><a name="movedpara_2_0_lhs"></a>[[Bild:Lisa - Xandria (Unifest 2006).jpg|mini|links|hochkant|Lisa Middelhauve mit Xandria 2006]]<a class="mw-diff-movedpara-left" data-title-tag="old" href="#movedpara_5_0_rhs">&#9660;</a></div>
<div class="mw-diff-inline-moved mw-diff-inline-moved-source mw-diff-inline-moved-upwards"><a name="movedpara_3_0_lhs"></a><a class="mw-diff-movedpara-left" data-title-tag="old" href="#movedpara_1_0_rhs">&#9650;</a>Heubaum nahm seine musikalischen Ideen, die er nicht mit dem vorausgegangenem Projekt verwirklichen konnte und probte mit Bielefelder Musikern. Einige dieser Musiker spielten zuvor in einer gemeinsamen Band mit dem Bassisten Roland Krueger.&lt;ref Name="MSBio"/&gt;&lt;ref Name="AMBio"&gt;{{Internetquelle|url=http://www.allmusic.com/artist/xandria-mn0000513830/biography|titel=Xandria|hrsg=Allmusic|autor=Jason Birchmeier|zugriff=2017-09-21}}&lt;/ref&gt; Als Studioprojekt unter der musikalischen Leitung Heubaums spielten die Musiker das Demo ''Kill the Sun'' ein. ''Kill the Sun'' wurde zum Download angeboten. Die beteiligten Musiker wurden indes nicht klar benannt und durch die Namen der [[Liste ägyptischer Götter|ägyptischen Gottheiten]] Osiris, Isis, Anubis, Horus und Seth anonymisiert. Später gab die Gruppe an das Demo sei mit dem Schlagzeuger Gerit Lamm und einer regionalen Sängerin, die noch vor der Produktion des Debütalbums ausstieg, aufgenommen worden. Durch die Veröffentlichung als Download erreichte Xandria noch vor Abschluss eines Plattenvertrages ein breites Publikum.&lt;ref&gt;{{Internetquelle|url=http://www.emp.de/art_420455/|titel=Xandria: Kill the Sun|autor=|hrsg=EMP|zugriff=2017-09-21}}&lt;/ref&gt;&lt;ref Name="MSBio"/&gt;</div>
<div class="mw-diff-inline-context">&#160;</div>
<div class="mw-diff-inline-moved mw-diff-inline-moved-destination mw-diff-inline-moved-upwards"><a name="movedpara_5_0_rhs"></a><a class="mw-diff-movedpara-right" data-title-tag="new" href="#movedpara_2_0_lhs">&#9650;</a>[[Bild:Lisa - Xandria (Unifest 2006).jpg|mini|links|hochkant|Lisa Middelhauve mit Xandria 2006]]</div>
<div class="mw-diff-inline-context">Udo Zimmer</div>
