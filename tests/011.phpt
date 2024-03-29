--TEST--
Test case for T195373 from https://en.wikipedia.org/wiki/Special:Diff/645796017
--FILE--
<?php
$before = <<<EOT
==Squads==
Athletes who did not participate in any matches
{{col-begin}}
{{Col-1-of-3}}
* {{flagIOC2athlete|[[Sarah Al-Zayani]]|BRN|2006 Asian Games}}
* {{flagIOC2athlete|[[Peng Shuai]]|CHN|2006 Asian Games}}
* {{flagIOC2athlete|[[Yan Zi]]|CHN|2006 Asian Games}}
{{Col-1-of-3}}
* {{flagIOC2athlete|[[Angelique Widjaja]]|INA|2006 Asian Games}}
* {{flagIOC2athlete|[[Asrar Abdulmajid]]|KUW|2006 Asian Games}}
* {{flagIOC2athlete|[[Sarah Behbehani]]|KUW|2006 Asian Games}}
{{Col-1-of-3}}
* {{flagIOC2athlete|[[Chan Chin-wei]]|TPE|2006 Asian Games}}
{{col-end}}
EOT;

#---------------------------------------------------

$after = <<<EOT
==Non-participating athletes==
{{columns-list|2|
*{{flagIOC2athlete|[[Sarah Al-Zayani]]|BRN|2006 Asian Games}}
*{{flagIOC2athlete|[[Peng Shuai]]|CHN|2006 Asian Games}}
*{{flagIOC2athlete|[[Yan Zi]]|CHN|2006 Asian Games}}
*{{flagIOC2athlete|[[Angelique Widjaja]]|INA|2006 Asian Games}}
*{{flagIOC2athlete|[[Asrar Abdulmajid]]|KUW|2006 Asian Games}}
*{{flagIOC2athlete|[[Sarah Behbehani]]|KUW|2006 Asian Games}}
*{{flagIOC2athlete|[[Chan Chin-wei]]|TPE|2006 Asian Games}}
}}
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
  <td class="diff-addedline diff-side-added"><div>==Non-participating athletes==</div></td>
</tr>
<tr>
  <td class="diff-marker" data-marker="−"></td>
  <td class="diff-deletedline diff-side-deleted"><div>==Squads==</div></td>
  <td colspan="2" class="diff-empty diff-side-added"></td>
</tr>
<tr>
  <td colspan="2" class="diff-empty diff-side-deleted"></td>
  <td class="diff-marker" data-marker="+"></td>
  <td class="diff-addedline diff-side-added"><div>{{columns-list|2|</div></td>
</tr>
<tr>
  <td class="diff-marker" data-marker="−"></td>
  <td class="diff-deletedline diff-side-deleted"><div>Athletes who did not participate in any matches</div></td>
  <td colspan="2" class="diff-empty diff-side-added"></td>
</tr>
<tr>
  <td colspan="2" class="diff-empty diff-side-deleted"></td>
  <td class="diff-marker"><a class="mw-diff-movedpara-right" href="#movedpara_14_0_lhs">&#x26AB;</a></td>
  <td class="diff-addedline diff-side-added"><div><a name="movedpara_4_0_rhs"></a>*{{flagIOC2athlete|[[Sarah <ins class="diffchange diffchange-inline">Al-Zayani</ins>]]|<ins class="diffchange diffchange-inline">BRN</ins>|2006 Asian Games}}</div></td>
</tr>
<tr>
  <td class="diff-marker" data-marker="−"></td>
  <td class="diff-deletedline diff-side-deleted"><div>{{col-begin}}</div></td>
  <td colspan="2" class="diff-empty diff-side-added"></td>
</tr>
<tr>
  <td colspan="2" class="diff-empty diff-side-deleted"></td>
  <td class="diff-marker"><a class="mw-diff-movedpara-right" href="#movedpara_14_2_lhs">&#x26AB;</a></td>
  <td class="diff-addedline diff-side-added"><div><a name="movedpara_6_0_rhs"></a>*{{flagIOC2athlete|[[<ins class="diffchange diffchange-inline">Peng</ins> <ins class="diffchange diffchange-inline">Shuai</ins>]]|<ins class="diffchange diffchange-inline">CHN</ins>|2006 Asian Games}}</div></td>
</tr>
<tr>
  <td class="diff-marker" data-marker="−"></td>
  <td class="diff-deletedline diff-side-deleted"><div>{{Col-1-of-3}}</div></td>
  <td colspan="2" class="diff-empty diff-side-added"></td>
</tr>
<tr>
  <td class="diff-marker" data-marker="−"></td>
  <td class="diff-deletedline diff-side-deleted"><div>*<del class="diffchange diffchange-inline"> </del>{{flagIOC2athlete|[[<del class="diffchange diffchange-inline">Sarah</del> <del class="diffchange diffchange-inline">Al-Zayani</del>]]|<del class="diffchange diffchange-inline">BRN</del>|2006 Asian Games}}</div></td>
  <td class="diff-marker" data-marker="+"></td>
  <td class="diff-addedline diff-side-added"><div>*{{flagIOC2athlete|[[<ins class="diffchange diffchange-inline">Yan</ins> <ins class="diffchange diffchange-inline">Zi</ins>]]|<ins class="diffchange diffchange-inline">CHN</ins>|2006 Asian Games}}</div></td>
</tr>
<tr>
  <td class="diff-marker" data-marker="−"></td>
  <td class="diff-deletedline diff-side-deleted"><div>*<del class="diffchange diffchange-inline"> </del>{{flagIOC2athlete|[[<del class="diffchange diffchange-inline">Peng</del> <del class="diffchange diffchange-inline">Shuai</del>]]|<del class="diffchange diffchange-inline">CHN</del>|2006 Asian Games}}</div></td>
  <td class="diff-marker" data-marker="+"></td>
  <td class="diff-addedline diff-side-added"><div>*{{flagIOC2athlete|[[<ins class="diffchange diffchange-inline">Angelique</ins> <ins class="diffchange diffchange-inline">Widjaja</ins>]]|<ins class="diffchange diffchange-inline">INA</ins>|2006 Asian Games}}</div></td>
</tr>
<tr>
  <td class="diff-marker" data-marker="−"></td>
  <td class="diff-deletedline diff-side-deleted"><div>*<del class="diffchange diffchange-inline"> </del>{{flagIOC2athlete|[[<del class="diffchange diffchange-inline">Yan</del> <del class="diffchange diffchange-inline">Zi</del>]]|<del class="diffchange diffchange-inline">CHN</del>|2006 Asian Games}}</div></td>
  <td class="diff-marker" data-marker="+"></td>
  <td class="diff-addedline diff-side-added"><div>*{{flagIOC2athlete|[[<ins class="diffchange diffchange-inline">Asrar</ins> <ins class="diffchange diffchange-inline">Abdulmajid</ins>]]|<ins class="diffchange diffchange-inline">KUW</ins>|2006 Asian Games}}</div></td>
</tr>
<tr>
  <td colspan="2" class="diff-empty diff-side-deleted"></td>
  <td class="diff-marker"><a class="mw-diff-movedpara-right" href="#movedpara_13_0_lhs">&#x26AB;</a></td>
  <td class="diff-addedline diff-side-added"><div><a name="movedpara_9_0_rhs"></a>*{{flagIOC2athlete|[[<ins class="diffchange diffchange-inline">Sarah</ins> <ins class="diffchange diffchange-inline">Behbehani</ins>]]|KUW|2006 Asian Games}}</div></td>
</tr>
<tr>
  <td class="diff-marker" data-marker="−"></td>
  <td class="diff-deletedline diff-side-deleted"><div>{{Col-1-of-3}}</div></td>
  <td colspan="2" class="diff-empty diff-side-added"></td>
</tr>
<tr>
  <td class="diff-marker" data-marker="−"></td>
  <td class="diff-deletedline diff-side-deleted"><div>*<del class="diffchange diffchange-inline"> </del>{{flagIOC2athlete|[[<del class="diffchange diffchange-inline">Angelique</del> <del class="diffchange diffchange-inline">Widjaja</del>]]|<del class="diffchange diffchange-inline">INA</del>|2006 Asian Games}}</div></td>
  <td class="diff-marker" data-marker="+"></td>
  <td class="diff-addedline diff-side-added"><div>*{{flagIOC2athlete|[[<ins class="diffchange diffchange-inline">Chan</ins> <ins class="diffchange diffchange-inline">Chin-wei</ins>]]|<ins class="diffchange diffchange-inline">TPE</ins>|2006 Asian Games}}</div></td>
</tr>
<tr>
  <td colspan="2" class="diff-empty diff-side-deleted"></td>
  <td class="diff-marker" data-marker="+"></td>
  <td class="diff-addedline diff-side-added"><div>}}</div></td>
</tr>
<tr>
  <td class="diff-marker"><a class="mw-diff-movedpara-left" href="#movedpara_9_0_rhs">&#x26AB;</a></td>
  <td class="diff-deletedline diff-side-deleted"><div><a name="movedpara_13_0_lhs"></a>*<del class="diffchange diffchange-inline"> </del>{{flagIOC2athlete|[[<del class="diffchange diffchange-inline">Asrar</del> <del class="diffchange diffchange-inline">Abdulmajid</del>]]|KUW|2006 Asian Games}}</div></td>
  <td colspan="2" class="diff-empty diff-side-added"></td>
</tr>
<tr>
  <td class="diff-marker"><a class="mw-diff-movedpara-left" href="#movedpara_4_0_rhs">&#x26AB;</a></td>
  <td class="diff-deletedline diff-side-deleted"><div><a name="movedpara_14_0_lhs"></a>*<del class="diffchange diffchange-inline"> </del>{{flagIOC2athlete|[[Sarah <del class="diffchange diffchange-inline">Behbehani</del>]]|<del class="diffchange diffchange-inline">KUW</del>|2006 Asian Games}}</div></td>
  <td colspan="2" class="diff-empty diff-side-added"></td>
</tr>
<tr>
  <td class="diff-marker" data-marker="−"></td>
  <td class="diff-deletedline diff-side-deleted"><div>{{Col-1-of-3}}</div></td>
  <td colspan="2" class="diff-empty diff-side-added"></td>
</tr>
<tr>
  <td class="diff-marker"><a class="mw-diff-movedpara-left" href="#movedpara_6_0_rhs">&#x26AB;</a></td>
  <td class="diff-deletedline diff-side-deleted"><div><a name="movedpara_14_2_lhs"></a>*<del class="diffchange diffchange-inline"> </del>{{flagIOC2athlete|[[<del class="diffchange diffchange-inline">Chan</del> <del class="diffchange diffchange-inline">Chin-wei</del>]]|<del class="diffchange diffchange-inline">TPE</del>|2006 Asian Games}}</div></td>
  <td colspan="2" class="diff-empty diff-side-added"></td>
</tr>
<tr>
  <td class="diff-marker" data-marker="−"></td>
  <td class="diff-deletedline diff-side-deleted"><div>{{col-end}}</div></td>
  <td colspan="2" class="diff-empty diff-side-added"></td>
</tr>

----INLINE:----
<div class="mw-diff-inline-header"><!-- LINES 1,1 --></div>
<div class="mw-diff-inline-added"><ins>==Non-participating athletes==</ins></div>
<div class="mw-diff-inline-deleted"><del>==Squads==</del></div>
<div class="mw-diff-inline-added"><ins>{{columns-list|2|</ins></div>
<div class="mw-diff-inline-deleted"><del>Athletes who did not participate in any matches</del></div>
<div class="mw-diff-inline-moved mw-diff-inline-moved-destination mw-diff-inline-moved-downwards"><a name="movedpara_4_0_rhs"></a>*<del> </del>{{flagIOC2athlete|[[Sarah <del>Behbehani</del><ins>Al-Zayani</ins>]]|<del>KUW</del><ins>BRN</ins>|2006 Asian Games}}<a class="mw-diff-movedpara-right" data-title-tag="new" href="#movedpara_14_0_lhs">&#9660;</a></div>
<div class="mw-diff-inline-deleted"><del>{{col-begin}}</del></div>
<div class="mw-diff-inline-moved mw-diff-inline-moved-destination mw-diff-inline-moved-downwards"><a name="movedpara_6_0_rhs"></a>*<del> </del>{{flagIOC2athlete|[[<del>Chan</del><ins>Peng</ins> <del>Chin-wei</del><ins>Shuai</ins>]]|<del>TPE</del><ins>CHN</ins>|2006 Asian Games}}<a class="mw-diff-movedpara-right" data-title-tag="new" href="#movedpara_14_2_lhs">&#9660;</a></div>
<div class="mw-diff-inline-deleted"><del>{{Col-1-of-3}}</del></div>
<div class="mw-diff-inline-changed">*<del> </del>{{flagIOC2athlete|[[<del>Sarah</del><ins>Yan</ins> <del>Al-Zayani</del><ins>Zi</ins>]]|<del>BRN</del><ins>CHN</ins>|2006 Asian Games}}</div>
<div class="mw-diff-inline-changed">*<del> </del>{{flagIOC2athlete|[[<del>Peng</del><ins>Angelique</ins> <del>Shuai</del><ins>Widjaja</ins>]]|<del>CHN</del><ins>INA</ins>|2006 Asian Games}}</div>
<div class="mw-diff-inline-changed">*<del> </del>{{flagIOC2athlete|[[<del>Yan</del><ins>Asrar</ins> <del>Zi</del><ins>Abdulmajid</ins>]]|<del>CHN</del><ins>KUW</ins>|2006 Asian Games}}</div>
<div class="mw-diff-inline-moved mw-diff-inline-moved-destination mw-diff-inline-moved-downwards"><a name="movedpara_9_0_rhs"></a>*<del> </del>{{flagIOC2athlete|[[<del>Asrar</del><ins>Sarah</ins> <del>Abdulmajid</del><ins>Behbehani</ins>]]|KUW|2006 Asian Games}}<a class="mw-diff-movedpara-right" data-title-tag="new" href="#movedpara_13_0_lhs">&#9660;</a></div>
<div class="mw-diff-inline-deleted"><del>{{Col-1-of-3}}</del></div>
<div class="mw-diff-inline-changed">*<del> </del>{{flagIOC2athlete|[[<del>Angelique</del><ins>Chan</ins> <del>Widjaja</del><ins>Chin-wei</ins>]]|<del>INA</del><ins>TPE</ins>|2006 Asian Games}}</div>
<div class="mw-diff-inline-added"><ins>}}</ins></div>
<div class="mw-diff-inline-moved mw-diff-inline-moved-source mw-diff-inline-moved-upwards"><a name="movedpara_13_0_lhs"></a><a class="mw-diff-movedpara-left" data-title-tag="old" href="#movedpara_9_0_rhs">&#9650;</a>* {{flagIOC2athlete|[[Asrar Abdulmajid]]|KUW|2006 Asian Games}}</div>
<div class="mw-diff-inline-moved mw-diff-inline-moved-source mw-diff-inline-moved-upwards"><a name="movedpara_14_0_lhs"></a><a class="mw-diff-movedpara-left" data-title-tag="old" href="#movedpara_4_0_rhs">&#9650;</a>* {{flagIOC2athlete|[[Sarah Behbehani]]|KUW|2006 Asian Games}}</div>
<div class="mw-diff-inline-deleted"><del>{{Col-1-of-3}}</del></div>
<div class="mw-diff-inline-moved mw-diff-inline-moved-source mw-diff-inline-moved-upwards"><a name="movedpara_14_2_lhs"></a><a class="mw-diff-movedpara-left" data-title-tag="old" href="#movedpara_6_0_rhs">&#9650;</a>* {{flagIOC2athlete|[[Chan Chin-wei]]|TPE|2006 Asian Games}}</div>
<div class="mw-diff-inline-deleted"><del>{{col-end}}</del></div>
