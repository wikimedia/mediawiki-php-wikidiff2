<?php
/**
 * Fuzz test.
 */

require 'random.php';

if ( !function_exists( 'wikidiff2_inline_diff' ) ) {
	die( "wikidiff2 not found, nothing to test\n" );
}

$wikidiff2Version = phpversion( 'wikidiff2' );
if ( $wikidiff2Version !== false &&
	version_compare( $wikidiff2Version, '0.3', '>=' ) ) {
	echo "wikidiff2 version: $wikidiff2Version (with moved-paragraphs patch)\n";
	$hasMovedParagraphDetection = true;
} else {
	echo "wikidiff2 version: $wikidiff2Version (without moved-paragraphs patch)\n";
	$hasMovedParagraphDetection = false;
}

// Bail out early in case of any problems
error_reporting( E_ALL | E_STRICT );
/*set_error_handler( function( $errno , $errstr ) {
	echo htmlspecialchars( $errstr );
	die ( 1 );
} );//*/

echo "Performing an infinite fuzz test, press Ctrl+C to end...\n";

$count = 0;
$totalTime = 0;
$chunkTime = 0;

while ( true ) {
	list( $left, $right ) = Random::randomData();

	$contextLines = mt_rand( 0, 10 );
	$detectionCutoff = mt_rand( 0, 100 );

	$time = microtime( true );
	if ( $hasMovedParagraphDetection ) {
		wikidiff2_do_diff( $left, $right, $contextLines, $detectionCutoff );
	} else {
		wikidiff2_do_diff( $left, $right, $contextLines );
	}
	wikidiff2_inline_diff( $left, $right, $contextLines );
	$time = microtime( true ) - $time;

	$totalTime += $time;
	$chunkTime += $time;

	if ( ++$count % 100 == 0 ) {
		$perIteration = round( $totalTime / $count, 3 );
		$perIterationInChunk = round( $chunkTime / 100, 3 );
		$chunkTime = 0;
		echo "  $count iterations, avg. iteration time $perIteration ($perIterationInChunk last 100 iterations)\n";
	}
}
