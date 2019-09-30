--TEST--
Inline JSON - Test case for T197157 from https://ru.wikipedia.org/wiki/Special:Diff/93301102
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

print wikidiff2_inline_json_diff( $before, $after, "", 2 );

?>
--EXPECT--
{"diff": [{"type": 3, "lineNumber": 1, "text": "<includeonly>{{#switch: {{{статус|}}}", "highlightRanges": [{"start": 0, "length": 13, "type": 1 },{"start": 23, "length": 1, "type": 0 }]},{"type": 1, "lineNumber": 2, "text": "| администратора = {{#invoke: Votes | count"},{"type": 4, "moveInfo": {"id": "movedpara_2_0_lhs", "linkId": "movedpara_8_1_rhs", "linkDirection": 0}, "text": "|администратора={{#invoke:Votes|count|page={{#if:{{{1|}}}|Википедия:Заявки на статус администратора/{{{1}}}}}{{#if: {{{номер|}}}|_{{{номер}}}}}|template=Шаблон:Результат выборов администратора}}"},{"type": 3, "lineNumber": 3, "text": "  |бюрократа={{#invoke:Votes|count| page     = {{#if: {{{1|}}} | Википедия:Заявки на статус бюрократаадминистратора/{{{1}}}}}{{#if: {{{номер|}}} | _{{{номер}}} }}|template=Шаблон:Результат выборов бюрократа}}", "highlightRanges": [{"start": 0, "length": 2, "type": 0 },{"start": 3, "length": 41, "type": 1 },{"start": 44, "length": 1, "type": 0 },{"start": 49, "length": 5, "type": 0 },{"start": 55, "length": 1, "type": 0 },{"start": 62, "length": 1, "type": 0 },{"start": 71, "length": 1, "type": 0 },{"start": 73, "length": 1, "type": 0 },{"start": 124, "length": 18, "type": 1 },{"start": 142, "length": 28, "type": 0 },{"start": 175, "length": 2, "type": 1 },{"start": 204, "length": 1, "type": 0 },{"start": 206, "length": 1, "type": 0 },{"start": 224, "length": 1, "type": 0 },{"start": 227, "length": 56, "type": 1 },{"start": 284, "length": 18, "type": 1 }]},{"type": 1, "lineNumber": 4, "text": "  | template = Шаблон:Результат выборов администратора"},{"type": 2, "text": "|{{#invoke:Votes|count|page={{{на странице|}}}|template={{{шаблон|}}}}}"},{"type": 1, "lineNumber": 5, "text": "  }}"},{"type": 4, "moveInfo": {"id": "movedpara_7_0_lhs", "linkId": "movedpara_8_8_rhs", "linkDirection": 0}, "text": "}}</includeonly><noinclude>{{doc}}</noinclude>"},{"type": 1, "lineNumber": 6, "text": "| бюрократа = {{#invoke: Votes | count"},{"type": 5, "lineNumber": 7, "moveInfo": {"id": "movedpara_8_1_rhs", "linkId": "movedpara_2_0_lhs", "linkDirection": 1}, "text": "  |администратора={{#invoke:Votes|count| page     = {{#if: {{{1|}}} | Википедия:Заявки на статус администраторабюрократа/{{{1}}}}}{{#if: {{{номер|}}} | _{{{номер}}} }}|template=Шаблон:Результат выборов администратора}}", "highlightRanges": [{"start": 0, "length": 2, "type": 0 },{"start": 3, "length": 51, "type": 1 },{"start": 54, "length": 1, "type": 0 },{"start": 59, "length": 5, "type": 0 },{"start": 65, "length": 1, "type": 0 },{"start": 72, "length": 1, "type": 0 },{"start": 81, "length": 1, "type": 0 },{"start": 83, "length": 1, "type": 0 },{"start": 134, "length": 28, "type": 1 },{"start": 162, "length": 18, "type": 0 },{"start": 185, "length": 2, "type": 1 },{"start": 214, "length": 1, "type": 0 },{"start": 216, "length": 1, "type": 0 },{"start": 234, "length": 1, "type": 0 },{"start": 237, "length": 56, "type": 1 },{"start": 294, "length": 28, "type": 1 }]},{"type": 1, "lineNumber": 8, "text": "  | template = Шаблон:Результат выборов бюрократа"},{"type": 1, "lineNumber": 9, "text": "  }}"},{"type": 1, "lineNumber": 10, "text": "| {{#invoke: Votes | count"},{"type": 1, "lineNumber": 11, "text": "  | page     = {{{на странице|}}}"},{"type": 1, "lineNumber": 12, "text": "  | template = {{{шаблон|}}}"},{"type": 1, "lineNumber": 13, "text": "  }}"},{"type": 5, "lineNumber": 14, "moveInfo": {"id": "movedpara_8_8_rhs", "linkId": "movedpara_7_0_lhs", "linkDirection": 1}, "text": "}}</includeonly><noinclude>{{doc}}</noinclude>", "highlightRanges": [{"start": 2, "length": 14, "type": 1 }]}], "sectionTitles": []}
