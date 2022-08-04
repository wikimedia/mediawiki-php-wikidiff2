--TEST--
Diff test A
--FILE--
<?php
$x = <<<EOT
== Added line ==

== Removed line ==

kjahegwnygw
== Moved text ==
a
---line---
a
a
a
a
a
a
a
a
== Two moved lines ==
a
a
a
--line1--
--line2--
a
a
a
a
a
a
a
a
a
a
a
a
a
== Shortest sequence in Y ==
x1
x2
x1
x2
x1
x2
x1
x2
context
context
context
context
context
== Changed line ==
blah blah blah 1


EOT;

#---------------------------------------------------

$y = <<<EOT
== Added line ==

sjgfkdjfgb
== Removed line ==

== Moved text ==
a
a
a
a
a
a
a
---line---
a
a
== Two moved lines ==
a
a
a
a
a
a
a
a
a
a
a
--line1--
--line2--
a
a
a
a
a
== Shortest sequence in Y ==
x2
x1
x2
x1
context
context
context
context
context
== Changed line ==
blah blah blah 2


EOT;

#---------------------------------------------------

print wikidiff2_do_diff( $x, $y, 2 );
print "\n----INLINE:----\n";
print wikidiff2_inline_diff( $x, $y, 2 );

?>
--EXPECT--
<tr>
  <td colspan="2" class="diff-lineno"><!--LINE 1--></td>
  <td colspan="2" class="diff-lineno"><!--LINE 1--></td>
</tr>
<tr>
  <td class="diff-marker"></td>
  <td class="diff-context diff-side-deleted"><div>== Added line ==</div></td>
  <td class="diff-marker"></td>
  <td class="diff-context diff-side-added"><div>== Added line ==</div></td>
</tr>
<tr>
  <td class="diff-marker"></td>
  <td class="diff-context diff-side-deleted"><br /></td>
  <td class="diff-marker"></td>
  <td class="diff-context diff-side-added"><br /></td>
</tr>
<tr>
  <td colspan="2" class="diff-empty diff-side-deleted"></td>
  <td class="diff-marker" data-marker="+"></td>
  <td class="diff-addedline diff-side-added"><div>sjgfkdjfgb</div></td>
</tr>
<tr>
  <td class="diff-marker"></td>
  <td class="diff-context diff-side-deleted"><div>== Removed line ==</div></td>
  <td class="diff-marker"></td>
  <td class="diff-context diff-side-added"><div>== Removed line ==</div></td>
</tr>
<tr>
  <td class="diff-marker"></td>
  <td class="diff-context diff-side-deleted"><br /></td>
  <td class="diff-marker"></td>
  <td class="diff-context diff-side-added"><br /></td>
</tr>
<tr>
  <td class="diff-marker" data-marker="−"></td>
  <td class="diff-deletedline diff-side-deleted"><div>kjahegwnygw</div></td>
  <td colspan="2" class="diff-empty diff-side-added"></td>
</tr>
<tr>
  <td class="diff-marker"></td>
  <td class="diff-context diff-side-deleted"><div>== Moved text ==</div></td>
  <td class="diff-marker"></td>
  <td class="diff-context diff-side-added"><div>== Moved text ==</div></td>
</tr>
<tr>
  <td class="diff-marker"></td>
  <td class="diff-context diff-side-deleted"><div>a</div></td>
  <td class="diff-marker"></td>
  <td class="diff-context diff-side-added"><div>a</div></td>
</tr>
<tr>
  <td class="diff-marker"><a class="mw-diff-movedpara-left" href="#movedpara_7_0_rhs">&#x26AB;</a></td>
  <td class="diff-deletedline diff-side-deleted"><div><a name="movedpara_5_0_lhs"></a>---line---</div></td>
  <td colspan="2" class="diff-empty diff-side-added"></td>
</tr>
<tr>
  <td class="diff-marker"></td>
  <td class="diff-context diff-side-deleted"><div>a</div></td>
  <td class="diff-marker"></td>
  <td class="diff-context diff-side-added"><div>a</div></td>
</tr>
<tr>
  <td class="diff-marker"></td>
  <td class="diff-context diff-side-deleted"><div>a</div></td>
  <td class="diff-marker"></td>
  <td class="diff-context diff-side-added"><div>a</div></td>
</tr>
<tr>
  <td colspan="2" class="diff-lineno"><!--LINE 13--></td>
  <td colspan="2" class="diff-lineno"><!--LINE 12--></td>
</tr>
<tr>
  <td class="diff-marker"></td>
  <td class="diff-context diff-side-deleted"><div>a</div></td>
  <td class="diff-marker"></td>
  <td class="diff-context diff-side-added"><div>a</div></td>
</tr>
<tr>
  <td class="diff-marker"></td>
  <td class="diff-context diff-side-deleted"><div>a</div></td>
  <td class="diff-marker"></td>
  <td class="diff-context diff-side-added"><div>a</div></td>
</tr>
<tr>
  <td colspan="2" class="diff-empty diff-side-deleted"></td>
  <td class="diff-marker"><a class="mw-diff-movedpara-right" href="#movedpara_5_0_lhs">&#x26AB;</a></td>
  <td class="diff-addedline diff-side-added"><div><a name="movedpara_7_0_rhs"></a>---line---</div></td>
</tr>
<tr>
  <td class="diff-marker"></td>
  <td class="diff-context diff-side-deleted"><div>a</div></td>
  <td class="diff-marker"></td>
  <td class="diff-context diff-side-added"><div>a</div></td>
</tr>
<tr>
  <td class="diff-marker"></td>
  <td class="diff-context diff-side-deleted"><div>a</div></td>
  <td class="diff-marker"></td>
  <td class="diff-context diff-side-added"><div>a</div></td>
</tr>
<tr>
  <td colspan="2" class="diff-lineno"><!--LINE 19--></td>
  <td colspan="2" class="diff-lineno"><!--LINE 19--></td>
</tr>
<tr>
  <td class="diff-marker"></td>
  <td class="diff-context diff-side-deleted"><div>a</div></td>
  <td class="diff-marker"></td>
  <td class="diff-context diff-side-added"><div>a</div></td>
</tr>
<tr>
  <td class="diff-marker"></td>
  <td class="diff-context diff-side-deleted"><div>a</div></td>
  <td class="diff-marker"></td>
  <td class="diff-context diff-side-added"><div>a</div></td>
</tr>
<tr>
  <td class="diff-marker"><a class="mw-diff-movedpara-left" href="#movedpara_11_0_rhs">&#x26AB;</a></td>
  <td class="diff-deletedline diff-side-deleted"><div><a name="movedpara_9_0_lhs"></a>--line1--</div></td>
  <td colspan="2" class="diff-empty diff-side-added"></td>
</tr>
<tr>
  <td class="diff-marker"><a class="mw-diff-movedpara-left" href="#movedpara_11_1_rhs">&#x26AB;</a></td>
  <td class="diff-deletedline diff-side-deleted"><div><a name="movedpara_9_1_lhs"></a>--line2--</div></td>
  <td colspan="2" class="diff-empty diff-side-added"></td>
</tr>
<tr>
  <td class="diff-marker"></td>
  <td class="diff-context diff-side-deleted"><div>a</div></td>
  <td class="diff-marker"></td>
  <td class="diff-context diff-side-added"><div>a</div></td>
</tr>
<tr>
  <td class="diff-marker"></td>
  <td class="diff-context diff-side-deleted"><div>a</div></td>
  <td class="diff-marker"></td>
  <td class="diff-context diff-side-added"><div>a</div></td>
</tr>
<tr>
  <td colspan="2" class="diff-lineno"><!--LINE 29--></td>
  <td colspan="2" class="diff-lineno"><!--LINE 27--></td>
</tr>
<tr>
  <td class="diff-marker"></td>
  <td class="diff-context diff-side-deleted"><div>a</div></td>
  <td class="diff-marker"></td>
  <td class="diff-context diff-side-added"><div>a</div></td>
</tr>
<tr>
  <td class="diff-marker"></td>
  <td class="diff-context diff-side-deleted"><div>a</div></td>
  <td class="diff-marker"></td>
  <td class="diff-context diff-side-added"><div>a</div></td>
</tr>
<tr>
  <td colspan="2" class="diff-empty diff-side-deleted"></td>
  <td class="diff-marker"><a class="mw-diff-movedpara-right" href="#movedpara_9_0_lhs">&#x26AB;</a></td>
  <td class="diff-addedline diff-side-added"><div><a name="movedpara_11_0_rhs"></a>--line1--</div></td>
</tr>
<tr>
  <td colspan="2" class="diff-empty diff-side-deleted"></td>
  <td class="diff-marker"><a class="mw-diff-movedpara-right" href="#movedpara_9_1_lhs">&#x26AB;</a></td>
  <td class="diff-addedline diff-side-added"><div><a name="movedpara_11_1_rhs"></a>--line2--</div></td>
</tr>
<tr>
  <td class="diff-marker"></td>
  <td class="diff-context diff-side-deleted"><div>a</div></td>
  <td class="diff-marker"></td>
  <td class="diff-context diff-side-added"><div>a</div></td>
</tr>
<tr>
  <td class="diff-marker"></td>
  <td class="diff-context diff-side-deleted"><div>a</div></td>
  <td class="diff-marker"></td>
  <td class="diff-context diff-side-added"><div>a</div></td>
</tr>
<tr>
  <td colspan="2" class="diff-lineno"><!--LINE 35--></td>
  <td colspan="2" class="diff-lineno"><!--LINE 35--></td>
</tr>
<tr>
  <td class="diff-marker"></td>
  <td class="diff-context diff-side-deleted"><div>a</div></td>
  <td class="diff-marker"></td>
  <td class="diff-context diff-side-added"><div>a</div></td>
</tr>
<tr>
  <td class="diff-marker"></td>
  <td class="diff-context diff-side-deleted"><div>== Shortest sequence in Y ==</div></td>
  <td class="diff-marker"></td>
  <td class="diff-context diff-side-added"><div>== Shortest sequence in Y ==</div></td>
</tr>
<tr>
  <td class="diff-marker" data-marker="−"></td>
  <td class="diff-deletedline diff-side-deleted"><div>x1</div></td>
  <td colspan="2" class="diff-empty diff-side-added"></td>
</tr>
<tr>
  <td class="diff-marker"></td>
  <td class="diff-context diff-side-deleted"><div>x2</div></td>
  <td class="diff-marker"></td>
  <td class="diff-context diff-side-added"><div>x2</div></td>
</tr>
<tr>
  <td class="diff-marker"></td>
  <td class="diff-context diff-side-deleted"><div>x1</div></td>
  <td class="diff-marker"></td>
  <td class="diff-context diff-side-added"><div>x1</div></td>
</tr>
<tr>
  <td class="diff-marker"></td>
  <td class="diff-context diff-side-deleted"><div>x2</div></td>
  <td class="diff-marker"></td>
  <td class="diff-context diff-side-added"><div>x2</div></td>
</tr>
<tr>
  <td class="diff-marker"></td>
  <td class="diff-context diff-side-deleted"><div>x1</div></td>
  <td class="diff-marker"></td>
  <td class="diff-context diff-side-added"><div>x1</div></td>
</tr>
<tr>
  <td class="diff-marker" data-marker="−"></td>
  <td class="diff-deletedline diff-side-deleted"><div>x2</div></td>
  <td colspan="2" class="diff-empty diff-side-added"></td>
</tr>
<tr>
  <td class="diff-marker" data-marker="−"></td>
  <td class="diff-deletedline diff-side-deleted"><div>x1</div></td>
  <td colspan="2" class="diff-empty diff-side-added"></td>
</tr>
<tr>
  <td class="diff-marker" data-marker="−"></td>
  <td class="diff-deletedline diff-side-deleted"><div>x2</div></td>
  <td colspan="2" class="diff-empty diff-side-added"></td>
</tr>
<tr>
  <td class="diff-marker"></td>
  <td class="diff-context diff-side-deleted"><div>context</div></td>
  <td class="diff-marker"></td>
  <td class="diff-context diff-side-added"><div>context</div></td>
</tr>
<tr>
  <td class="diff-marker"></td>
  <td class="diff-context diff-side-deleted"><div>context</div></td>
  <td class="diff-marker"></td>
  <td class="diff-context diff-side-added"><div>context</div></td>
</tr>
<tr>
  <td colspan="2" class="diff-lineno"><!--LINE 49--></td>
  <td colspan="2" class="diff-lineno"><!--LINE 45--></td>
</tr>
<tr>
  <td class="diff-marker"></td>
  <td class="diff-context diff-side-deleted"><div>context</div></td>
  <td class="diff-marker"></td>
  <td class="diff-context diff-side-added"><div>context</div></td>
</tr>
<tr>
  <td class="diff-marker"></td>
  <td class="diff-context diff-side-deleted"><div>== Changed line ==</div></td>
  <td class="diff-marker"></td>
  <td class="diff-context diff-side-added"><div>== Changed line ==</div></td>
</tr>
<tr>
  <td class="diff-marker" data-marker="−"></td>
  <td class="diff-deletedline diff-side-deleted"><div>blah blah blah <del class="diffchange diffchange-inline">1</del></div></td>
  <td class="diff-marker" data-marker="+"></td>
  <td class="diff-addedline diff-side-added"><div>blah blah blah <ins class="diffchange diffchange-inline">2</ins></div></td>
</tr>
<tr>
  <td class="diff-marker"></td>
  <td class="diff-context diff-side-deleted"><br /></td>
  <td class="diff-marker"></td>
  <td class="diff-context diff-side-added"><br /></td>
</tr>

----INLINE:----
<div class="mw-diff-inline-header"><!-- LINES 1,1 --></div>
<div class="mw-diff-inline-context">== Added line ==</div>
<div class="mw-diff-inline-context">&#160;</div>
<div class="mw-diff-inline-added"><ins>sjgfkdjfgb</ins></div>
<div class="mw-diff-inline-context">== Removed line ==</div>
<div class="mw-diff-inline-context">&#160;</div>
<div class="mw-diff-inline-deleted"><del>kjahegwnygw</del></div>
<div class="mw-diff-inline-context">== Moved text ==</div>
<div class="mw-diff-inline-context">a</div>
<div class="mw-diff-inline-moved mw-diff-inline-moved-source mw-diff-inline-moved-downwards"><a name="movedpara_5_0_lhs"></a>---line---<a class="mw-diff-movedpara-left" data-title-tag="old" href="#movedpara_7_0_rhs">&#9660;</a></div>
<div class="mw-diff-inline-context">a</div>
<div class="mw-diff-inline-context">a</div>
<div class="mw-diff-inline-header"><!-- LINES 13,12 --></div>
<div class="mw-diff-inline-context">a</div>
<div class="mw-diff-inline-context">a</div>
<div class="mw-diff-inline-moved mw-diff-inline-moved-destination mw-diff-inline-moved-upwards"><a name="movedpara_7_0_rhs"></a><a class="mw-diff-movedpara-right" data-title-tag="new" href="#movedpara_5_0_lhs">&#9650;</a>---line---</div>
<div class="mw-diff-inline-context">a</div>
<div class="mw-diff-inline-context">a</div>
<div class="mw-diff-inline-header"><!-- LINES 19,19 --></div>
<div class="mw-diff-inline-context">a</div>
<div class="mw-diff-inline-context">a</div>
<div class="mw-diff-inline-moved mw-diff-inline-moved-source mw-diff-inline-moved-downwards"><a name="movedpara_9_0_lhs"></a>--line1--<a class="mw-diff-movedpara-left" data-title-tag="old" href="#movedpara_11_0_rhs">&#9660;</a></div>
<div class="mw-diff-inline-moved mw-diff-inline-moved-source mw-diff-inline-moved-downwards"><a name="movedpara_9_1_lhs"></a>--line2--<a class="mw-diff-movedpara-left" data-title-tag="old" href="#movedpara_11_1_rhs">&#9660;</a></div>
<div class="mw-diff-inline-context">a</div>
<div class="mw-diff-inline-context">a</div>
<div class="mw-diff-inline-header"><!-- LINES 29,27 --></div>
<div class="mw-diff-inline-context">a</div>
<div class="mw-diff-inline-context">a</div>
<div class="mw-diff-inline-moved mw-diff-inline-moved-destination mw-diff-inline-moved-upwards"><a name="movedpara_11_0_rhs"></a><a class="mw-diff-movedpara-right" data-title-tag="new" href="#movedpara_9_0_lhs">&#9650;</a>--line1--</div>
<div class="mw-diff-inline-moved mw-diff-inline-moved-destination mw-diff-inline-moved-upwards"><a name="movedpara_11_1_rhs"></a><a class="mw-diff-movedpara-right" data-title-tag="new" href="#movedpara_9_1_lhs">&#9650;</a>--line2--</div>
<div class="mw-diff-inline-context">a</div>
<div class="mw-diff-inline-context">a</div>
<div class="mw-diff-inline-header"><!-- LINES 35,35 --></div>
<div class="mw-diff-inline-context">a</div>
<div class="mw-diff-inline-context">== Shortest sequence in Y ==</div>
<div class="mw-diff-inline-deleted"><del>x1</del></div>
<div class="mw-diff-inline-context">x2</div>
<div class="mw-diff-inline-context">x1</div>
<div class="mw-diff-inline-context">x2</div>
<div class="mw-diff-inline-context">x1</div>
<div class="mw-diff-inline-deleted"><del>x2</del></div>
<div class="mw-diff-inline-deleted"><del>x1</del></div>
<div class="mw-diff-inline-deleted"><del>x2</del></div>
<div class="mw-diff-inline-context">context</div>
<div class="mw-diff-inline-context">context</div>
<div class="mw-diff-inline-header"><!-- LINES 49,45 --></div>
<div class="mw-diff-inline-context">context</div>
<div class="mw-diff-inline-context">== Changed line ==</div>
<div class="mw-diff-inline-changed">blah blah blah <del>1</del><ins>2</ins></div>
<div class="mw-diff-inline-context">&#160;</div>
