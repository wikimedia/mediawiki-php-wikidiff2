<?php
/**
 * wikidiff2 PHP extension test suite. Loads a lot of real changes
 * from Wikipedia and generates diffs of it.
 *
 * License: WTFPL
 */


if ( !function_exists( 'wikidiff2_inline_diff' ) ) {
	die( "wikidiff2 not found, nothing to test\n" );
}
if ( !function_exists( 'wikidiff2_inline_json_diff' ) ) {
	die( "wikidiff2 not found, nothing to test\n" );
}
ini_set( 'user_agent', 'Hi, Domas!' );
// Bail out early in case of any problems
error_reporting( E_ALL | E_STRICT );
set_error_handler( function( $errno , $errstr ) {
	echo htmlspecialchars( $errstr );
	die ( 1 );
} );

echo <<<HTML
<!DOCTYPE html>
<html>
<title>Diff changes</title>
<meta charset="UTF-8"/>
<style>
body {
	font-family: sans-serif;
}

table,
td {
	border:1px solid #000
}

ins,
del {
	padding-left: 0;
	color: black;
	text-decoration: none;
}

span {
	margin-right: 2px;
}

ins {
	background-color: #75C877;
}

del {
	background-color: #E07076;
}
</style>
<body>
HTML;


require 'Api.php';
require 'Change.php';
require 'Differ.php';

$differ = new AllDiffer;

$site = "http://en.wikipedia.org/w";
$apiUrl = "$site/api.php";
$indexUrl = "$site/index.php";

$recentChanges = Api::request( array(
	'action' => 'query',
	'list' => 'recentchanges',
	'rctype' => 'edit',
	'rclimit' => 'max',
) );

$changes = array();
foreach ( $recentChanges['query']['recentchanges'] as $rc ) {
	$changes[] = new Change( $rc['title'], $rc['old_revid'], $rc['revid'] );
}

$count = count( $changes );
echo "<h1>Found $count changes</h1>\n";

$count = 0;
$numProcessed = 0;
$totalTime = 0;
foreach ( $changes as $change ) {
	$id = sprintf( "%04d", $count );
	$page = htmlspecialchars( $change->page );
	echo "\n<h2>[$id] {$page}</h2>\n";
	if ( !$change->load() ) {
		echo "<b>Not all content loaded, skipping</b><br>\n";
	}
	$time = microtime( true );
	$diff = $differ->diff( $change->prev, $change->next );
	$time = microtime( true ) - $time;
	$totalTime += $time;
	$numProcessed++;
	echo "Diffed in {$time}s<br>\n";
	$url = htmlspecialchars( "$indexUrl?diff={$change->nextId}&oldid={$change->prevId}" );
	echo "<a href='$url'>$url</a>";

	echo $diff;

	$count++;
}

$avg = $numProcessed ? $totalTime / $numProcessed : 0;

echo <<<HTML
<table>
<tr><td>Total processed</td><td>$numProcessed</td></tr>
<tr><td>Average diff time</td><td>$avg</td></tr>
</table>
</html>
HTML;
