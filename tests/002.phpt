--TEST--
Diff test B
--FILE--
<?php
$x = <<<EOT
== Shortest sequence in X ==
x2
x1
x2
x1
context
context
context
context
context


EOT;

#---------------------------------------------------

$y = <<<EOT
== Shortest sequence in X ==
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
  <td class="diff-context diff-side-deleted"><div>== Shortest sequence in X ==</div></td>
  <td class="diff-marker"></td>
  <td class="diff-context diff-side-added"><div>== Shortest sequence in X ==</div></td>
</tr>
<tr>
  <td colspan="2" class="diff-empty diff-side-deleted"></td>
  <td class="diff-marker" data-marker="+"></td>
  <td class="diff-addedline diff-side-added"><div>x1</div></td>
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
  <td colspan="2" class="diff-empty diff-side-deleted"></td>
  <td class="diff-marker" data-marker="+"></td>
  <td class="diff-addedline diff-side-added"><div>x2</div></td>
</tr>
<tr>
  <td colspan="2" class="diff-empty diff-side-deleted"></td>
  <td class="diff-marker" data-marker="+"></td>
  <td class="diff-addedline diff-side-added"><div>x1</div></td>
</tr>
<tr>
  <td colspan="2" class="diff-empty diff-side-deleted"></td>
  <td class="diff-marker" data-marker="+"></td>
  <td class="diff-addedline diff-side-added"><div>x2</div></td>
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

----INLINE:----
<div class="mw-diff-inline-header"><!-- LINES 1,1 --></div>
<div class="mw-diff-inline-context">== Shortest sequence in X ==</div>
<div class="mw-diff-inline-added"><ins>x1</ins></div>
<div class="mw-diff-inline-context">x2</div>
<div class="mw-diff-inline-context">x1</div>
<div class="mw-diff-inline-context">x2</div>
<div class="mw-diff-inline-context">x1</div>
<div class="mw-diff-inline-added"><ins>x2</ins></div>
<div class="mw-diff-inline-added"><ins>x1</ins></div>
<div class="mw-diff-inline-added"><ins>x2</ins></div>
<div class="mw-diff-inline-context">context</div>
<div class="mw-diff-inline-context">context</div>
