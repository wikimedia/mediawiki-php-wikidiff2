<?php
// Benchmark script for Wikidiff2. It times diffing of 50 changes sampled
// from Special:RecentChanges of several Wikipedias (en, hi, ru, th, and zh).
$num_loops = 50;
$data = json_decode( gzdecode( file_get_contents( __DIR__ . '/../data/revs.json.gz' ) ), true );

echo "loops: " . $num_loops . "\n";
foreach ( $data as $lang => $revs ) {
	$minTimeMs = INF;
	$maxTimeMs = 0;
	$times = [];
	for ( $i = 1; $i <= $num_loops; $i++ ) {
		$start = microtime( true );
		foreach ( $revs as list( $a, $b ) ) {
			$diff = wikidiff2_do_diff( $a, $b, 2 );
			$diff = wikidiff2_do_diff( $b, $a, 2 );
		}
		$end = microtime( true );
		$timeMs = ( $end - $start ) * 1000;
		if ( $timeMs < $minTimeMs ) {
			$minTimeMs = $timeMs;
		}
		if ( $timeMs > $maxTimeMs ) {
			$maxTimeMs = $timeMs;
		}
		$times[] = $timeMs;
	}
	$avgTimeMs = array_sum( $times ) / count( $times );
	printf( "[%s] best: %6.2fms   worst: %6.2fms   avg: %6.2fms\n",
		$lang, $minTimeMs, $maxTimeMs, $avgTimeMs );
}
