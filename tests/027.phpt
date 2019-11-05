--TEST--
Integer conversion of section offsets in wikidiff2_inline_json_diff()
--FILE--
<?php
print wikidiff2_inline_json_diff('x','y', 5);
--EXPECT--
{"diff": [{"type": 1, "lineNumber": 1, "text": "y", "offset": {"from": null,"to": 0}},{"type": 2, "text": "x", "offset": {"from": 0,"to": null}}]}
