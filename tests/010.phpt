--TEST--
Test case for T197157 from https://ru.wikipedia.org/wiki/Special:Diff/93301102
--FILE--
<?php
$before = <<<EOT
<includeonly>{{#switch:{{{статус|}}}
|администратора={{#invoke:Votes|count|page={{#if:{{{1|}}}|Википедия:Заявки на статус администратора/{{{1}}}}}{{#if: {{{номер|}}}|_{{{номер}}}}}|template=Шаблон:Результат выборов администратора}}
|бюрократа={{#invoke:Votes|count|page={{#if:{{{1|}}}|Википедия:Заявки на статус бюрократа/{{{1}}}}}{{#if: {{{номер|}}}|_{{{номер}}}}}|template=Шаблон:Результат выборов бюрократа}}
|{{#invoke:Votes|count|page={{{на странице|}}}|template={{{шаблон|}}}}}
}}</includeonly><noinclude>{{doc}}</noinclude>
EOT;

#---------------------------------------------------

$after = <<<EOT
{{#switch: {{{статус|}}}
| администратора = {{#invoke: Votes | count
  | page     = {{#if: {{{1|}}} | Википедия:Заявки на статус администратора/{{{1}}}{{#if: {{{номер|}}} | _{{{номер}}} }} }}
  | template = Шаблон:Результат выборов администратора
  }}
| бюрократа = {{#invoke: Votes | count
  | page     = {{#if: {{{1|}}} | Википедия:Заявки на статус бюрократа/{{{1}}}{{#if: {{{номер|}}} | _{{{номер}}} }} }}
  | template = Шаблон:Результат выборов бюрократа
  }}
| {{#invoke: Votes | count
  | page     = {{{на странице|}}}
  | template = {{{шаблон|}}}
  }}
}}<noinclude>{{doc}}</noinclude>
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
  <td class="diff-marker" data-marker="−"></td>
  <td class="diff-deletedline diff-side-deleted"><div><del class="diffchange diffchange-inline">&lt;includeonly&gt;</del>{{#switch:{{{статус|}}}</div></td>
  <td class="diff-marker" data-marker="+"></td>
  <td class="diff-addedline diff-side-added"><div>{{#switch:<ins class="diffchange diffchange-inline"> </ins>{{{статус|}}}</div></td>
</tr>
<tr>
  <td colspan="2" class="diff-empty diff-side-deleted"></td>
  <td class="diff-marker" data-marker="+"></td>
  <td class="diff-addedline diff-side-added"><div>| администратора = {{#invoke: Votes | count</div></td>
</tr>
<tr>
  <td class="diff-marker"><a class="mw-diff-movedpara-left" href="#movedpara_8_1_rhs">&#x26AB;</a></td>
  <td class="diff-deletedline diff-side-deleted"><div><a name="movedpara_2_0_lhs"></a>|<del class="diffchange diffchange-inline">администратора={{#invoke:Votes|count|</del>page={{#if:{{{1|}}}|Википедия:Заявки на статус <del class="diffchange diffchange-inline">администратора</del>/{{{1<del class="diffchange diffchange-inline">}}</del>}}}{{#if: {{{номер|}}}|_{{{номер}}}}}<del class="diffchange diffchange-inline">|template=Шаблон:Результат выборов</del> <del class="diffchange diffchange-inline">администратора</del>}}</div></td>
  <td colspan="2" class="diff-empty diff-side-added"></td>
</tr>
<tr>
  <td class="diff-marker" data-marker="−"></td>
  <td class="diff-deletedline diff-side-deleted"><div>|<del class="diffchange diffchange-inline">бюрократа={{#invoke:Votes|count|</del>page={{#if:{{{1|}}}|Википедия:Заявки на статус <del class="diffchange diffchange-inline">бюрократа</del>/{{{1<del class="diffchange diffchange-inline">}}</del>}}}{{#if: {{{номер|}}}|_{{{номер}}}}}<del class="diffchange diffchange-inline">|template=Шаблон:Результат выборов</del> <del class="diffchange diffchange-inline">бюрократа</del>}}</div></td>
  <td class="diff-marker" data-marker="+"></td>
  <td class="diff-addedline diff-side-added"><div><ins class="diffchange diffchange-inline">  </ins>|<ins class="diffchange diffchange-inline"> </ins>page<ins class="diffchange diffchange-inline">     </ins>=<ins class="diffchange diffchange-inline"> </ins>{{#if:<ins class="diffchange diffchange-inline"> </ins>{{{1|}}}<ins class="diffchange diffchange-inline"> </ins>|<ins class="diffchange diffchange-inline"> </ins>Википедия:Заявки на статус <ins class="diffchange diffchange-inline">администратора</ins>/{{{1}}}{{#if: {{{номер|}}}<ins class="diffchange diffchange-inline"> </ins>|<ins class="diffchange diffchange-inline"> </ins>_{{{номер}}}<ins class="diffchange diffchange-inline"> </ins>}} }}</div></td>
</tr>
<tr>
  <td colspan="2" class="diff-empty diff-side-deleted"></td>
  <td class="diff-marker" data-marker="+"></td>
  <td class="diff-addedline diff-side-added"><div>  | template = Шаблон:Результат выборов администратора</div></td>
</tr>
<tr>
  <td class="diff-marker" data-marker="−"></td>
  <td class="diff-deletedline diff-side-deleted"><div>|{{#invoke:Votes|count|page={{{на странице|}}}|template={{{шаблон|}}}}}</div></td>
  <td colspan="2" class="diff-empty diff-side-added"></td>
</tr>
<tr>
  <td colspan="2" class="diff-empty diff-side-deleted"></td>
  <td class="diff-marker" data-marker="+"></td>
  <td class="diff-addedline diff-side-added"><div>  }}</div></td>
</tr>
<tr>
  <td class="diff-marker"><a class="mw-diff-movedpara-left" href="#movedpara_8_8_rhs">&#x26AB;</a></td>
  <td class="diff-deletedline diff-side-deleted"><div><a name="movedpara_7_0_lhs"></a>}}<del class="diffchange diffchange-inline">&lt;/includeonly&gt;</del>&lt;noinclude&gt;{{doc}}&lt;/noinclude&gt;</div></td>
  <td colspan="2" class="diff-empty diff-side-added"></td>
</tr>
<tr>
  <td colspan="2" class="diff-empty diff-side-deleted"></td>
  <td class="diff-marker" data-marker="+"></td>
  <td class="diff-addedline diff-side-added"><div>| бюрократа = {{#invoke: Votes | count</div></td>
</tr>
<tr>
  <td colspan="2" class="diff-empty diff-side-deleted"></td>
  <td class="diff-marker"><a class="mw-diff-movedpara-right" href="#movedpara_2_0_lhs">&#x26AB;</a></td>
  <td class="diff-addedline diff-side-added"><div><a name="movedpara_8_1_rhs"></a><ins class="diffchange diffchange-inline">  </ins>|<ins class="diffchange diffchange-inline"> </ins>page<ins class="diffchange diffchange-inline">     </ins>=<ins class="diffchange diffchange-inline"> </ins>{{#if:<ins class="diffchange diffchange-inline"> </ins>{{{1|}}}<ins class="diffchange diffchange-inline"> </ins>|<ins class="diffchange diffchange-inline"> </ins>Википедия:Заявки на статус <ins class="diffchange diffchange-inline">бюрократа</ins>/{{{1}}}{{#if: {{{номер|}}}<ins class="diffchange diffchange-inline"> </ins>|<ins class="diffchange diffchange-inline"> </ins>_{{{номер}}}<ins class="diffchange diffchange-inline"> </ins>}} }}</div></td>
</tr>
<tr>
  <td colspan="2" class="diff-empty diff-side-deleted"></td>
  <td class="diff-marker" data-marker="+"></td>
  <td class="diff-addedline diff-side-added"><div>  | template = Шаблон:Результат выборов бюрократа</div></td>
</tr>
<tr>
  <td colspan="2" class="diff-empty diff-side-deleted"></td>
  <td class="diff-marker" data-marker="+"></td>
  <td class="diff-addedline diff-side-added"><div>  }}</div></td>
</tr>
<tr>
  <td colspan="2" class="diff-empty diff-side-deleted"></td>
  <td class="diff-marker" data-marker="+"></td>
  <td class="diff-addedline diff-side-added"><div>| {{#invoke: Votes | count</div></td>
</tr>
<tr>
  <td colspan="2" class="diff-empty diff-side-deleted"></td>
  <td class="diff-marker" data-marker="+"></td>
  <td class="diff-addedline diff-side-added"><div>  | page     = {{{на странице|}}}</div></td>
</tr>
<tr>
  <td colspan="2" class="diff-empty diff-side-deleted"></td>
  <td class="diff-marker" data-marker="+"></td>
  <td class="diff-addedline diff-side-added"><div>  | template = {{{шаблон|}}}</div></td>
</tr>
<tr>
  <td colspan="2" class="diff-empty diff-side-deleted"></td>
  <td class="diff-marker" data-marker="+"></td>
  <td class="diff-addedline diff-side-added"><div>  }}</div></td>
</tr>
<tr>
  <td colspan="2" class="diff-empty diff-side-deleted"></td>
  <td class="diff-marker"><a class="mw-diff-movedpara-right" href="#movedpara_7_0_lhs">&#x26AB;</a></td>
  <td class="diff-addedline diff-side-added"><div><a name="movedpara_8_8_rhs"></a>}}&lt;noinclude&gt;{{doc}}&lt;/noinclude&gt;</div></td>
</tr>

----INLINE:----
<div class="mw-diff-inline-header"><!-- LINES 1,1 --></div>
<div class="mw-diff-inline-changed"><del>&lt;includeonly&gt;</del>{{#switch:<ins> </ins>{{{статус|}}}</div>
<div class="mw-diff-inline-added"><ins>| администратора = {{#invoke: Votes | count</ins></div>
<div class="mw-diff-inline-moved mw-diff-inline-moved-source mw-diff-inline-moved-downwards"><a name="movedpara_2_0_lhs"></a>|администратора={{#invoke:Votes|count|page={{#if:{{{1|}}}|Википедия:Заявки на статус администратора/{{{1}}}}}{{#if: {{{номер|}}}|_{{{номер}}}}}|template=Шаблон:Результат выборов администратора}}<a class="mw-diff-movedpara-left" data-title-tag="old" href="#movedpara_8_1_rhs">&#9660;</a></div>
<div class="mw-diff-inline-changed"><ins>  </ins>|<del>бюрократа={{#invoke:Votes|count|</del><ins> </ins>page<ins>     </ins>=<ins> </ins>{{#if:<ins> </ins>{{{1|}}}<ins> </ins>|<ins> </ins>Википедия:Заявки на статус <del>бюрократа</del><ins>администратора</ins>/{{{1<del>}}</del>}}}{{#if: {{{номер|}}}<ins> </ins>|<ins> </ins>_{{{номер}}}<ins> </ins>}}<del>|template=Шаблон:Результат выборов</del> <del>бюрократа</del>}}</div>
<div class="mw-diff-inline-added"><ins>  | template = Шаблон:Результат выборов администратора</ins></div>
<div class="mw-diff-inline-deleted"><del>|{{#invoke:Votes|count|page={{{на странице|}}}|template={{{шаблон|}}}}}</del></div>
<div class="mw-diff-inline-added"><ins>  }}</ins></div>
<div class="mw-diff-inline-moved mw-diff-inline-moved-source mw-diff-inline-moved-downwards"><a name="movedpara_7_0_lhs"></a>}}&lt;/includeonly&gt;&lt;noinclude&gt;{{doc}}&lt;/noinclude&gt;<a class="mw-diff-movedpara-left" data-title-tag="old" href="#movedpara_8_8_rhs">&#9660;</a></div>
<div class="mw-diff-inline-added"><ins>| бюрократа = {{#invoke: Votes | count</ins></div>
<div class="mw-diff-inline-moved mw-diff-inline-moved-destination mw-diff-inline-moved-upwards"><a name="movedpara_8_1_rhs"></a><a class="mw-diff-movedpara-right" data-title-tag="new" href="#movedpara_2_0_lhs">&#9650;</a><ins>  </ins>|<del>администратора={{#invoke:Votes|count|</del><ins> </ins>page<ins>     </ins>=<ins> </ins>{{#if:<ins> </ins>{{{1|}}}<ins> </ins>|<ins> </ins>Википедия:Заявки на статус <del>администратора</del><ins>бюрократа</ins>/{{{1<del>}}</del>}}}{{#if: {{{номер|}}}<ins> </ins>|<ins> </ins>_{{{номер}}}<ins> </ins>}}<del>|template=Шаблон:Результат выборов</del> <del>администратора</del>}}</div>
<div class="mw-diff-inline-added"><ins>  | template = Шаблон:Результат выборов бюрократа</ins></div>
<div class="mw-diff-inline-added"><ins>  }}</ins></div>
<div class="mw-diff-inline-added"><ins>| {{#invoke: Votes | count</ins></div>
<div class="mw-diff-inline-added"><ins>  | page     = {{{на странице|}}}</ins></div>
<div class="mw-diff-inline-added"><ins>  | template = {{{шаблон|}}}</ins></div>
<div class="mw-diff-inline-added"><ins>  }}</ins></div>
<div class="mw-diff-inline-moved mw-diff-inline-moved-destination mw-diff-inline-moved-upwards"><a name="movedpara_8_8_rhs"></a><a class="mw-diff-movedpara-right" data-title-tag="new" href="#movedpara_7_0_lhs">&#9650;</a>}}<del>&lt;/includeonly&gt;</del>&lt;noinclude&gt;{{doc}}&lt;/noinclude&gt;</div>
