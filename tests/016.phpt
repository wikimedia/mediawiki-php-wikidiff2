--TEST--
Test case for T215293 derived from https://ru.wikipedia.org/w/index.php?title=MediaWiki:Gadget-markadmins.json&diff=0&oldid=97533626
--SKIPIF--
<?php if (!extension_loaded("wikidiff2")) print "skip"; ?>
--FILE--
<?php
$before = <<<EOT
{
    "userSet": {
        "A": [
            "Wulfson",
            "Zanka",
            "АлександрВв",
            "Андрей Романенко",
            "Всеслав Чародей"
        ],
        "B": [
            "Oleksiy.golubov",
            "Postoronniy-13",
            "Saramag",
            "Stormare.henk",
        ],
        "K": [
            "Biathlon",
            "Q-bit array"
        ],
        "Ar": [
            "Drbug",
            "Michgrig",
            "Sir Shurf",
            "TenBaseT",
            "Alexander Roumega",
            "Deltahead"
        ]
    }
}
EOT;

#---------------------------------------------------

$after = <<<EOT
{
    "userSet": {
        "A": [
            "Wulfson",
            "Zanka",
            "Андрей Романенко",
            "Всеслав Чародей"
        ],
        "B": [
            "Oleksiy.golubov",
            "Postoronniy-13",
            "Saint Johann",
            "Saramag",
            "Stormare.henk",
        ],
        "K": [
            "Biathlon",
            "Michgrig",
            "TenBaseT",
            "Q-bit array"
        ],
        "Ar": [
            "Alexander Roumega",
            "Deltahead"
        ]
    }
}
EOT;

#---------------------------------------------------

print wikidiff2_do_diff( $before, $after, 2 );

?>
--EXPECT--
<tr>
  <td colspan="2" class="diff-lineno"><!--LINE 4--></td>
  <td colspan="2" class="diff-lineno"><!--LINE 4--></td>
</tr>
<tr>
  <td class="diff-marker">&#160;</td>
  <td class="diff-context"><div>            "Wulfson",</div></td>
  <td class="diff-marker">&#160;</td>
  <td class="diff-context"><div>            "Wulfson",</div></td>
</tr>
<tr>
  <td class="diff-marker">&#160;</td>
  <td class="diff-context"><div>            "Zanka",</div></td>
  <td class="diff-marker">&#160;</td>
  <td class="diff-context"><div>            "Zanka",</div></td>
</tr>
<tr>
  <td class="diff-marker"><a class="mw-diff-movedpara-left" href="#movedpara_3_0_rhs">&#x26AB;</a></td>
  <td class="diff-deletedline"><div><a name="movedpara_1_0_lhs"></a>            "<del class="diffchange diffchange-inline">АлександрВв</del>",</div></td>
  <td colspan="2" class="diff-empty">&#160;</td>
</tr>
<tr>
  <td class="diff-marker">&#160;</td>
  <td class="diff-context"><div>            "Андрей Романенко",</div></td>
  <td class="diff-marker">&#160;</td>
  <td class="diff-context"><div>            "Андрей Романенко",</div></td>
</tr>
<tr>
  <td class="diff-marker">&#160;</td>
  <td class="diff-context"><div>            "Всеслав Чародей"</div></td>
  <td class="diff-marker">&#160;</td>
  <td class="diff-context"><div>            "Всеслав Чародей"</div></td>
</tr>
<tr>
  <td colspan="2" class="diff-lineno"><!--LINE 11--></td>
  <td colspan="2" class="diff-lineno"><!--LINE 10--></td>
</tr>
<tr>
  <td class="diff-marker">&#160;</td>
  <td class="diff-context"><div>            "Oleksiy.golubov",</div></td>
  <td class="diff-marker">&#160;</td>
  <td class="diff-context"><div>            "Oleksiy.golubov",</div></td>
</tr>
<tr>
  <td class="diff-marker">&#160;</td>
  <td class="diff-context"><div>            "Postoronniy-13",</div></td>
  <td class="diff-marker">&#160;</td>
  <td class="diff-context"><div>            "Postoronniy-13",</div></td>
</tr>
<tr>
  <td colspan="2" class="diff-empty">&#160;</td>
  <td class="diff-marker"><a class="mw-diff-movedpara-right" href="#movedpara_1_0_lhs">&#x26AB;</a></td>
  <td class="diff-addedline"><div><a name="movedpara_3_0_rhs"></a>            "<ins class="diffchange diffchange-inline">Saint Johann</ins>",</div></td>
</tr>
<tr>
  <td class="diff-marker">&#160;</td>
  <td class="diff-context"><div>            "Saramag",</div></td>
  <td class="diff-marker">&#160;</td>
  <td class="diff-context"><div>            "Saramag",</div></td>
</tr>
<tr>
  <td class="diff-marker">&#160;</td>
  <td class="diff-context"><div>            "Stormare.henk",</div></td>
  <td class="diff-marker">&#160;</td>
  <td class="diff-context"><div>            "Stormare.henk",</div></td>
</tr>
<tr>
  <td colspan="2" class="diff-lineno"><!--LINE 16--></td>
  <td colspan="2" class="diff-lineno"><!--LINE 16--></td>
</tr>
<tr>
  <td class="diff-marker">&#160;</td>
  <td class="diff-context"><div>        "K": [</div></td>
  <td class="diff-marker">&#160;</td>
  <td class="diff-context"><div>        "K": [</div></td>
</tr>
<tr>
  <td class="diff-marker">&#160;</td>
  <td class="diff-context"><div>            "Biathlon",</div></td>
  <td class="diff-marker">&#160;</td>
  <td class="diff-context"><div>            "Biathlon",</div></td>
</tr>
<tr>
  <td colspan="2" class="diff-empty">&#160;</td>
  <td class="diff-marker"><a class="mw-diff-movedpara-right" href="#movedpara_7_1_lhs">&#x26AB;</a></td>
  <td class="diff-addedline"><div><a name="movedpara_5_0_rhs"></a>            "Michgrig",</div></td>
</tr>
<tr>
  <td colspan="2" class="diff-empty">&#160;</td>
  <td class="diff-marker"><a class="mw-diff-movedpara-right" href="#movedpara_7_3_lhs">&#x26AB;</a></td>
  <td class="diff-addedline"><div><a name="movedpara_5_1_rhs"></a>            "TenBaseT",</div></td>
</tr>
<tr>
  <td class="diff-marker">&#160;</td>
  <td class="diff-context"><div>            "Q-bit array"</div></td>
  <td class="diff-marker">&#160;</td>
  <td class="diff-context"><div>            "Q-bit array"</div></td>
</tr>
<tr>
  <td class="diff-marker">&#160;</td>
  <td class="diff-context"><div>        ],</div></td>
  <td class="diff-marker">&#160;</td>
  <td class="diff-context"><div>        ],</div></td>
</tr>
<tr>
  <td class="diff-marker">&#160;</td>
  <td class="diff-context"><div>        "Ar": [</div></td>
  <td class="diff-marker">&#160;</td>
  <td class="diff-context"><div>        "Ar": [</div></td>
</tr>
<tr>
  <td class="diff-marker">−</td>
  <td class="diff-deletedline"><div>            "Drbug",</div></td>
  <td colspan="2" class="diff-empty">&#160;</td>
</tr>
<tr>
  <td class="diff-marker"><a class="mw-diff-movedpara-left" href="#movedpara_5_0_rhs">&#x26AB;</a></td>
  <td class="diff-deletedline"><div><a name="movedpara_7_1_lhs"></a>            "Michgrig",</div></td>
  <td colspan="2" class="diff-empty">&#160;</td>
</tr>
<tr>
  <td class="diff-marker">−</td>
  <td class="diff-deletedline"><div>            "Sir Shurf",</div></td>
  <td colspan="2" class="diff-empty">&#160;</td>
</tr>
<tr>
  <td class="diff-marker"><a class="mw-diff-movedpara-left" href="#movedpara_5_1_rhs">&#x26AB;</a></td>
  <td class="diff-deletedline"><div><a name="movedpara_7_3_lhs"></a>            "TenBaseT",</div></td>
  <td colspan="2" class="diff-empty">&#160;</td>
</tr>
<tr>
  <td class="diff-marker">&#160;</td>
  <td class="diff-context"><div>            "Alexander Roumega",</div></td>
  <td class="diff-marker">&#160;</td>
  <td class="diff-context"><div>            "Alexander Roumega",</div></td>
</tr>
<tr>
  <td class="diff-marker">&#160;</td>
  <td class="diff-context"><div>            "Deltahead"</div></td>
  <td class="diff-marker">&#160;</td>
  <td class="diff-context"><div>            "Deltahead"</div></td>
</tr>
