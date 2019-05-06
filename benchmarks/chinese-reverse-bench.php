<?php
foreach ( array(
	'chinese-reverse-1.txt',
	'chinese-reverse-2.txt',
	'chinese-reverse.diff'
) as $fname ) {
	$texts[] = file_get_contents( $fname );
	if ( end( $texts ) === false ) {
		die( "Missing data: {$fname}. Please unzip chinese-reverse.zip." );
	}
}
list( $a, $b, $refDiff ) = $texts;
$loops = 10;
$minTimeMs = INF;
for ( $i = 1; $i <= $loops; $i++ ) {
	$start = microtime( true );
	$diff = wikidiff2_do_diff( $a, $b, 2 );
	$end = microtime( true );
	assert( $diff === $refDiff );
	$timeMs = ( $end - $start ) * 1000;
	printf( "[%d/%d] %.2fms\n", $i, $loops, $timeMs );
	if ( $timeMs < $minTimeMs ) {
		$minTimeMs = $timeMs;
	}
}
printf( "\nMin:  %.2fms\n", $minTimeMs );
