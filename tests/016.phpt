--TEST--
Test case for T215293 derived from https://ru.wikipedia.org/w/index.php?title=MediaWiki:Gadget-markadmins.json&diff=0&oldid=97533626
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
print "\n----INLINE:----\n";
print wikidiff2_inline_diff( $before, $after, 2 );

?>
--EXPECT--
<tr>
  <td colspan="2" class="diff-lineno"><!--LINE 4--></td>
  <td colspan="2" class="diff-lineno"><!--LINE 4--></td>
</tr>
<tr>
  <td class="diff-marker"></td>
  <td class="diff-context diff-side-deleted"><div>            "Wulfson",</div></td>
  <td class="diff-marker"></td>
  <td class="diff-context diff-side-added"><div>            "Wulfson",</div></td>
</tr>
<tr>
  <td class="diff-marker"></td>
  <td class="diff-context diff-side-deleted"><div>            "Zanka",</div></td>
  <td class="diff-marker"></td>
  <td class="diff-context diff-side-added"><div>            "Zanka",</div></td>
</tr>
<tr>
  <td class="diff-marker"><a class="mw-diff-movedpara-left" href="#movedpara_3_0_rhs">&#x26AB;</a></td>
  <td class="diff-deletedline diff-side-deleted"><div><a name="movedpara_1_0_lhs"></a>            "<del class="diffchange diffchange-inline">АлександрВв</del>",</div></td>
  <td colspan="2" class="diff-empty diff-side-added"></td>
</tr>
<tr>
  <td class="diff-marker"></td>
  <td class="diff-context diff-side-deleted"><div>            "Андрей Романенко",</div></td>
  <td class="diff-marker"></td>
  <td class="diff-context diff-side-added"><div>            "Андрей Романенко",</div></td>
</tr>
<tr>
  <td class="diff-marker"></td>
  <td class="diff-context diff-side-deleted"><div>            "Всеслав Чародей"</div></td>
  <td class="diff-marker"></td>
  <td class="diff-context diff-side-added"><div>            "Всеслав Чародей"</div></td>
</tr>
<tr>
  <td colspan="2" class="diff-lineno"><!--LINE 11--></td>
  <td colspan="2" class="diff-lineno"><!--LINE 10--></td>
</tr>
<tr>
  <td class="diff-marker"></td>
  <td class="diff-context diff-side-deleted"><div>            "Oleksiy.golubov",</div></td>
  <td class="diff-marker"></td>
  <td class="diff-context diff-side-added"><div>            "Oleksiy.golubov",</div></td>
</tr>
<tr>
  <td class="diff-marker"></td>
  <td class="diff-context diff-side-deleted"><div>            "Postoronniy-13",</div></td>
  <td class="diff-marker"></td>
  <td class="diff-context diff-side-added"><div>            "Postoronniy-13",</div></td>
</tr>
<tr>
  <td colspan="2" class="diff-empty diff-side-deleted"></td>
  <td class="diff-marker"><a class="mw-diff-movedpara-right" href="#movedpara_1_0_lhs">&#x26AB;</a></td>
  <td class="diff-addedline diff-side-added"><div><a name="movedpara_3_0_rhs"></a>            "<ins class="diffchange diffchange-inline">Saint Johann</ins>",</div></td>
</tr>
<tr>
  <td class="diff-marker"></td>
  <td class="diff-context diff-side-deleted"><div>            "Saramag",</div></td>
  <td class="diff-marker"></td>
  <td class="diff-context diff-side-added"><div>            "Saramag",</div></td>
</tr>
<tr>
  <td class="diff-marker"></td>
  <td class="diff-context diff-side-deleted"><div>            "Stormare.henk",</div></td>
  <td class="diff-marker"></td>
  <td class="diff-context diff-side-added"><div>            "Stormare.henk",</div></td>
</tr>
<tr>
  <td colspan="2" class="diff-lineno"><!--LINE 16--></td>
  <td colspan="2" class="diff-lineno"><!--LINE 16--></td>
</tr>
<tr>
  <td class="diff-marker"></td>
  <td class="diff-context diff-side-deleted"><div>        "K": [</div></td>
  <td class="diff-marker"></td>
  <td class="diff-context diff-side-added"><div>        "K": [</div></td>
</tr>
<tr>
  <td class="diff-marker"></td>
  <td class="diff-context diff-side-deleted"><div>            "Biathlon",</div></td>
  <td class="diff-marker"></td>
  <td class="diff-context diff-side-added"><div>            "Biathlon",</div></td>
</tr>
<tr>
  <td colspan="2" class="diff-empty diff-side-deleted"></td>
  <td class="diff-marker"><a class="mw-diff-movedpara-right" href="#movedpara_7_1_lhs">&#x26AB;</a></td>
  <td class="diff-addedline diff-side-added"><div><a name="movedpara_5_0_rhs"></a>            "Michgrig",</div></td>
</tr>
<tr>
  <td colspan="2" class="diff-empty diff-side-deleted"></td>
  <td class="diff-marker"><a class="mw-diff-movedpara-right" href="#movedpara_7_3_lhs">&#x26AB;</a></td>
  <td class="diff-addedline diff-side-added"><div><a name="movedpara_5_1_rhs"></a>            "TenBaseT",</div></td>
</tr>
<tr>
  <td class="diff-marker"></td>
  <td class="diff-context diff-side-deleted"><div>            "Q-bit array"</div></td>
  <td class="diff-marker"></td>
  <td class="diff-context diff-side-added"><div>            "Q-bit array"</div></td>
</tr>
<tr>
  <td class="diff-marker"></td>
  <td class="diff-context diff-side-deleted"><div>        ],</div></td>
  <td class="diff-marker"></td>
  <td class="diff-context diff-side-added"><div>        ],</div></td>
</tr>
<tr>
  <td class="diff-marker"></td>
  <td class="diff-context diff-side-deleted"><div>        "Ar": [</div></td>
  <td class="diff-marker"></td>
  <td class="diff-context diff-side-added"><div>        "Ar": [</div></td>
</tr>
<tr>
  <td class="diff-marker" data-marker="−"></td>
  <td class="diff-deletedline diff-side-deleted"><div>            "Drbug",</div></td>
  <td colspan="2" class="diff-empty diff-side-added"></td>
</tr>
<tr>
  <td class="diff-marker"><a class="mw-diff-movedpara-left" href="#movedpara_5_0_rhs">&#x26AB;</a></td>
  <td class="diff-deletedline diff-side-deleted"><div><a name="movedpara_7_1_lhs"></a>            "Michgrig",</div></td>
  <td colspan="2" class="diff-empty diff-side-added"></td>
</tr>
<tr>
  <td class="diff-marker" data-marker="−"></td>
  <td class="diff-deletedline diff-side-deleted"><div>            "Sir Shurf",</div></td>
  <td colspan="2" class="diff-empty diff-side-added"></td>
</tr>
<tr>
  <td class="diff-marker"><a class="mw-diff-movedpara-left" href="#movedpara_5_1_rhs">&#x26AB;</a></td>
  <td class="diff-deletedline diff-side-deleted"><div><a name="movedpara_7_3_lhs"></a>            "TenBaseT",</div></td>
  <td colspan="2" class="diff-empty diff-side-added"></td>
</tr>
<tr>
  <td class="diff-marker"></td>
  <td class="diff-context diff-side-deleted"><div>            "Alexander Roumega",</div></td>
  <td class="diff-marker"></td>
  <td class="diff-context diff-side-added"><div>            "Alexander Roumega",</div></td>
</tr>
<tr>
  <td class="diff-marker"></td>
  <td class="diff-context diff-side-deleted"><div>            "Deltahead"</div></td>
  <td class="diff-marker"></td>
  <td class="diff-context diff-side-added"><div>            "Deltahead"</div></td>
</tr>

----INLINE:----
<div class="mw-diff-inline-header"><!-- LINES 4,4 --></div>
<div class="mw-diff-inline-context">            "Wulfson",</div>
<div class="mw-diff-inline-context">            "Zanka",</div>
<div class="mw-diff-inline-moved mw-diff-inline-moved-source mw-diff-inline-moved-downwards"><a name="movedpara_1_0_lhs"></a>            "АлександрВв",<a class="mw-diff-movedpara-left" data-title-tag="old" href="#movedpara_3_0_rhs">&#9660;</a></div>
<div class="mw-diff-inline-context">            "Андрей Романенко",</div>
<div class="mw-diff-inline-context">            "Всеслав Чародей"</div>
<div class="mw-diff-inline-header"><!-- LINES 11,10 --></div>
<div class="mw-diff-inline-context">            "Oleksiy.golubov",</div>
<div class="mw-diff-inline-context">            "Postoronniy-13",</div>
<div class="mw-diff-inline-moved mw-diff-inline-moved-destination mw-diff-inline-moved-upwards"><a name="movedpara_3_0_rhs"></a><a class="mw-diff-movedpara-right" data-title-tag="new" href="#movedpara_1_0_lhs">&#9650;</a>            "<del>АлександрВв</del><ins>Saint Johann</ins>",</div>
<div class="mw-diff-inline-context">            "Saramag",</div>
<div class="mw-diff-inline-context">            "Stormare.henk",</div>
<div class="mw-diff-inline-header"><!-- LINES 16,16 --></div>
<div class="mw-diff-inline-context">        "K": [</div>
<div class="mw-diff-inline-context">            "Biathlon",</div>
<div class="mw-diff-inline-moved mw-diff-inline-moved-destination mw-diff-inline-moved-downwards"><a name="movedpara_5_0_rhs"></a>            "Michgrig",<a class="mw-diff-movedpara-right" data-title-tag="new" href="#movedpara_7_1_lhs">&#9660;</a></div>
<div class="mw-diff-inline-moved mw-diff-inline-moved-destination mw-diff-inline-moved-downwards"><a name="movedpara_5_1_rhs"></a>            "TenBaseT",<a class="mw-diff-movedpara-right" data-title-tag="new" href="#movedpara_7_3_lhs">&#9660;</a></div>
<div class="mw-diff-inline-context">            "Q-bit array"</div>
<div class="mw-diff-inline-context">        ],</div>
<div class="mw-diff-inline-context">        "Ar": [</div>
<div class="mw-diff-inline-deleted"><del>            "Drbug",</del></div>
<div class="mw-diff-inline-moved mw-diff-inline-moved-source mw-diff-inline-moved-upwards"><a name="movedpara_7_1_lhs"></a><a class="mw-diff-movedpara-left" data-title-tag="old" href="#movedpara_5_0_rhs">&#9650;</a>            "Michgrig",</div>
<div class="mw-diff-inline-deleted"><del>            "Sir Shurf",</del></div>
<div class="mw-diff-inline-moved mw-diff-inline-moved-source mw-diff-inline-moved-upwards"><a name="movedpara_7_3_lhs"></a><a class="mw-diff-movedpara-left" data-title-tag="old" href="#movedpara_5_1_rhs">&#9650;</a>            "TenBaseT",</div>
<div class="mw-diff-inline-context">            "Alexander Roumega",</div>
<div class="mw-diff-inline-context">            "Deltahead"</div>
