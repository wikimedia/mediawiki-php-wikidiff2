--TEST--
libthai basic word breaking test
--FILE--
<?php
print wikidiff2_do_diff( 'สุนัขจิ้งจอกกระโดดข้ามสุนัข', 'สุนัขจิ้งจอกกระโดดข้ามแมว', 0 );
print "\n----INLINE:----\n";
print wikidiff2_inline_diff( 'สุนัขจิ้งจอกกระโดดข้ามสุนัข', 'สุนัขจิ้งจอกกระโดดข้ามแมว', 0 );
--EXPECT--
<tr>
  <td colspan="2" class="diff-lineno"><!--LINE 1--></td>
  <td colspan="2" class="diff-lineno"><!--LINE 1--></td>
</tr>
<tr>
  <td class="diff-marker" data-marker="−"></td>
  <td class="diff-deletedline diff-side-deleted"><div>สุนัขจิ้งจอกกระโดดข้าม<del class="diffchange diffchange-inline">สุนัข</del></div></td>
  <td class="diff-marker" data-marker="+"></td>
  <td class="diff-addedline diff-side-added"><div>สุนัขจิ้งจอกกระโดดข้าม<ins class="diffchange diffchange-inline">แมว</ins></div></td>
</tr>

----INLINE:----
<div class="mw-diff-inline-header"><!-- LINES 1,1 --></div>
<div class="mw-diff-inline-changed">สุนัขจิ้งจอกกระโดดข้าม<del>สุนัข</del><ins>แมว</ins></div>
