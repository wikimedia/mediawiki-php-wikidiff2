--TEST--
Diff test G: moved paragraphs
--SKIPIF--
<?php if (!extension_loaded("wikidiff2")) print "skip"; ?>
--FILE--
<?php
$x = <<<EOT
Substance, in the truest and primary and most definite sense of the word, is that which is neither predicable of a subject nor present in a subject; for instance, the individual man or horse. But in a secondary sense those things are called substances within which, as species, the primary substances are included; also those which, as genera, include the species. For instance, the individual man is included in the species 'man', and the genus to which the species belongs is 'animal'; these, therefore—that is to say, the species 'man' and the genus 'animal,-are termed secondary substances.

It is plain from what has been said that both the name and the definition of the predicate must be predicable of the subject. For instance, 'man' is predicated of the individual man. Now in this case the name of the species 'man' is applied to the individual, for we use the term 'man' in describing the individual; and the definition of 'man' will also be predicated of the individual man, for the individual man is both man and animal. Thus, both the name and the definition of the species are predicable of the individual.

With regard, on the other hand, to those things which are present in a subject, it is generally the case that neither their name nor their definition is predicable of that in which they are present. Though, however, the definition is never predicable, there is nothing in certain cases to prevent the name being used. For instance, 'white' being present in a body is predicated of that in which it is present, for a body is called white: the definition, however, of the colour 'white' is never predicable of the body.

Everything except primary substances is either predicable of a primary substance or present in a primary substance. This becomes evident by reference to particular instances which occur. 'Animal' is predicated of the species 'man', therefore of the individual man, for if there were no individual man of whom it could be predicated, it could not be predicated of the species 'man' at all. Again, colour is present in body, therefore in individual bodies, for if there were no individual body in which it was present, it could not be present in body at all. Thus everything except primary substances is either predicated of primary substances, or is present in them, and if these last did not exist, it would be impossible for anything else to exist.

Lawns are very important. Never underestimate lawns. Never underestimate the power of hot rollers for your hair and eyelash curlers for your eyelashes. You can never underestimate the stupidity of the general public.

EOT;

#---------------------------------------------------

$y = <<<EOT
It is plain from what has been said that both the name and the definition of the predicate must be predicable of the subject. For instance, 'man' is predicated of the individual man. Now in this case the name of the species 'man' is applied to the individual, for we use the term 'man' in describing the individual; and the definition of 'man' will also be predicated of the individual man, for the individual man is both man and animal. Thus, both the name and the definition of the species are predicable of the individual.

Everything except primary substances is either predicable of a primary substance or present in a primary substance. This becomes evident by reference to particular instances which occur. 'Animal' is predicated of the species 'man', therefore of the individual man, for if there were no individual man of whom it could be predicated, it could not be predicated of the species 'man' at all. Again, colour is present in body, therefore in individual bodies, for if there were no individual body in which it was present, it could not be present in body at all. Thus everything except primary substances is either predicated of primary substances, or is present in them, and if these last did not exist, it would be impossible for anything else to exist. Never underestimate lawns.

With regard, on the other hand, to those things which are present in a subject, it is generally the case that neither their name nor their definition is predicable of that in which they are present. Though, however, the definition is never predicable, there is nothing in certain cases to prevent the name being used. For instance, 'white' being present in a body is predicated of that in which it is present, for a body is called white: the definition, however, of the colour 'white' is never predicable of the body.

Lawns are very important. Never underestimate lawns. Never underestimate the power of hot rollers for your hair and eyelash curlers for your eyelashes. You can never underestimate the stupidity of the general public.

Substance, in the truest and most definite sense of the word, is that which is neither predicable of a subject nor present in a subject; for instance, the individual man or horse. But in a secondary sense those things are called substances within which, as species, the primary substances are included; also those which, as genera, include the species. For instance, the individual man is included in the species 'man', and the genus to which the species belongs is 'animal'; these, therefore—that is to say, the species 'man' and the genus 'animal,-are termed secondary substances.

EOT;

#---------------------------------------------------

print wikidiff2_do_diff( $x, $y, 2 );

?>
--EXPECT--
<tr>
  <td colspan="2" class="diff-lineno"><!--LINE 1--></td>
  <td colspan="2" class="diff-lineno"><!--LINE 1--></td>
</tr>
<tr>
  <td class="diff-marker"><a href="#movedpara_6_1_rhs">&hookrightarrow;</a></td>
  <td class="diff-deletedline"><div><a name="movedpara_0_0_lhs"></a>Substance, in the truest<del class="diffchange diffchange-inline"> and primary</del> and most definite sense of the word, is that which is neither predicable of a subject nor present in a subject; for instance, the individual man or horse. But in a secondary sense those things are called substances within which, as species, the primary substances are included; also those which, as genera, include the species. For instance, the individual man is included in the species 'man', and the genus to which the species belongs is 'animal'; these, therefore—that is to say, the species 'man' and the genus 'animal,-are termed secondary substances.</div></td>
  <td colspan="2" class="diff-empty">&#160;</td>
</tr>
<tr>
  <td class="diff-marker">−</td>
  <td class="diff-deletedline"></td>
  <td colspan="2" class="diff-empty">&#160;</td>
</tr>
<tr>
  <td class="diff-marker">&#160;</td>
  <td class="diff-context"><div>It is plain from what has been said that both the name and the definition of the predicate must be predicable of the subject. For instance, 'man' is predicated of the individual man. Now in this case the name of the species 'man' is applied to the individual, for we use the term 'man' in describing the individual; and the definition of 'man' will also be predicated of the individual man, for the individual man is both man and animal. Thus, both the name and the definition of the species are predicable of the individual.</div></td>
  <td class="diff-marker">&#160;</td>
  <td class="diff-context"><div>It is plain from what has been said that both the name and the definition of the predicate must be predicable of the subject. For instance, 'man' is predicated of the individual man. Now in this case the name of the species 'man' is applied to the individual, for we use the term 'man' in describing the individual; and the definition of 'man' will also be predicated of the individual man, for the individual man is both man and animal. Thus, both the name and the definition of the species are predicable of the individual.</div></td>
</tr>
<tr>
  <td colspan="2" class="diff-empty">&#160;</td>
  <td class="diff-marker">+</td>
  <td class="diff-addedline"></td>
</tr>
<tr>
  <td colspan="2" class="diff-empty">&#160;</td>
  <td class="diff-marker"><a href="#movedpara_4_1_lhs">&hookleftarrow;</a></td>
  <td class="diff-addedline"><div><a name="movedpara_2_1_rhs"></a>Everything except primary substances is either predicable of a primary substance or present in a primary substance. This becomes evident by reference to particular instances which occur. 'Animal' is predicated of the species 'man', therefore of the individual man, for if there were no individual man of whom it could be predicated, it could not be predicated of the species 'man' at all. Again, colour is present in body, therefore in individual bodies, for if there were no individual body in which it was present, it could not be present in body at all. Thus everything except primary substances is either predicated of primary substances, or is present in them, and if these last did not exist, it would be impossible for anything else to exist<ins class="diffchange diffchange-inline">. Never underestimate lawns</ins>.</div></td>
</tr>
<tr>
  <td class="diff-marker">&#160;</td>
  <td class="diff-context"></td>
  <td class="diff-marker">&#160;</td>
  <td class="diff-context"></td>
</tr>
<tr>
  <td class="diff-marker">&#160;</td>
  <td class="diff-context"><div>With regard, on the other hand, to those things which are present in a subject, it is generally the case that neither their name nor their definition is predicable of that in which they are present. Though, however, the definition is never predicable, there is nothing in certain cases to prevent the name being used. For instance, 'white' being present in a body is predicated of that in which it is present, for a body is called white: the definition, however, of the colour 'white' is never predicable of the body.</div></td>
  <td class="diff-marker">&#160;</td>
  <td class="diff-context"><div>With regard, on the other hand, to those things which are present in a subject, it is generally the case that neither their name nor their definition is predicable of that in which they are present. Though, however, the definition is never predicable, there is nothing in certain cases to prevent the name being used. For instance, 'white' being present in a body is predicated of that in which it is present, for a body is called white: the definition, however, of the colour 'white' is never predicable of the body.</div></td>
</tr>
<tr>
  <td class="diff-marker">−</td>
  <td class="diff-deletedline"></td>
  <td colspan="2" class="diff-empty">&#160;</td>
</tr>
<tr>
  <td class="diff-marker"><a href="#movedpara_2_1_rhs">&hookrightarrow;</a></td>
  <td class="diff-deletedline"><div><a name="movedpara_4_1_lhs"></a>Everything except primary substances is either predicable of a primary substance or present in a primary substance. This becomes evident by reference to particular instances which occur. 'Animal' is predicated of the species 'man', therefore of the individual man, for if there were no individual man of whom it could be predicated, it could not be predicated of the species 'man' at all. Again, colour is present in body, therefore in individual bodies, for if there were no individual body in which it was present, it could not be present in body at all. Thus everything except primary substances is either predicated of primary substances, or is present in them, and if these last did not exist, it would be impossible for anything else to exist.</div></td>
  <td colspan="2" class="diff-empty">&#160;</td>
</tr>
<tr>
  <td class="diff-marker">&#160;</td>
  <td class="diff-context"></td>
  <td class="diff-marker">&#160;</td>
  <td class="diff-context"></td>
</tr>
<tr>
  <td class="diff-marker">&#160;</td>
  <td class="diff-context"><div>Lawns are very important. Never underestimate lawns. Never underestimate the power of hot rollers for your hair and eyelash curlers for your eyelashes. You can never underestimate the stupidity of the general public.</div></td>
  <td class="diff-marker">&#160;</td>
  <td class="diff-context"><div>Lawns are very important. Never underestimate lawns. Never underestimate the power of hot rollers for your hair and eyelash curlers for your eyelashes. You can never underestimate the stupidity of the general public.</div></td>
</tr>
<tr>
  <td colspan="2" class="diff-empty">&#160;</td>
  <td class="diff-marker">+</td>
  <td class="diff-addedline"></td>
</tr>
<tr>
  <td colspan="2" class="diff-empty">&#160;</td>
  <td class="diff-marker"><a href="#movedpara_0_0_lhs">&hookleftarrow;</a></td>
  <td class="diff-addedline"><div><a name="movedpara_6_1_rhs"></a>Substance, in the truest and most definite sense of the word, is that which is neither predicable of a subject nor present in a subject; for instance, the individual man or horse. But in a secondary sense those things are called substances within which, as species, the primary substances are included; also those which, as genera, include the species. For instance, the individual man is included in the species 'man', and the genus to which the species belongs is 'animal'; these, therefore—that is to say, the species 'man' and the genus 'animal,-are termed secondary substances.</div></td>
</tr>