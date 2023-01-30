<?php

function wikidiff2_do_diff(string $text1, string $text2, int $numContextLines): string {}
function wikidiff2_inline_diff(string $text1, string $text2, int $numContextLines): string {}
function wikidiff2_inline_json_diff(string $text1, string $text2, int $numContextLines): string {}
function wikidiff2_multi_format_diff(string $text1, string $text2, array $options = []): array {}
function wikidiff2_version(): string {}
