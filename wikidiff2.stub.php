<?php

function wikidiff2_do_diff(string $text1, string $text2, int $numContextLines = 0): string {}
function wikidiff2_inline_diff(string $text1, string $text2, int $numContextLines = 0): string {}
function wikidiff2_inline_json_diff(string $text1, string $text2, int $numContextLines = 0): string {}
function wikidiff2_version(): string {}
