<?php
// Benchmark script for Wikidiff2. It times diffing of 50 changes sampled
// from Special:RecentChanges of several Wikipedias (en, hi, ru, th, and zh).

$opt = getopt( '', [ 'count:', 'split:' ] );

$num_loops = $opt['count'] ?? 50;
$data = json_decode( gzdecode( file_get_contents( __DIR__ . '/../data/revs.json.gz' ) ), true );

$options = [
	'maxSplitSize' => $opt['split'] ?? 1,
];

echo "loops: " . $num_loops . "\n";
foreach ( $data as $lang => $revs ) {
	$minTimeMs = INF;
	$maxTimeMs = 0;
	$worstCase = -1;
	$times = [];
	foreach ( $revs as $revIndex => list( $a, $b ) ) {
		$start = microtime( true );
		for ( $i = 1; $i <= $num_loops; $i++ ) {
			$diff = wikidiff2_multi_format_diff( $a, $b, $options );
			$diff = wikidiff2_multi_format_diff( $b, $a, $options );
		}
		$end = microtime( true );
		$timeMs = ( $end - $start ) * 1000;
		if ( $timeMs < $minTimeMs ) {
			$minTimeMs = $timeMs;
		}
		if ( $timeMs > $maxTimeMs ) {
			$maxTimeMs = $timeMs;
			$worstCase = $revIndex;
		}
		$times[] = $timeMs;
	}
	$avgTimeMs = array_sum( $times ) / count( $times );
	printf( "[%s] best: %6.2fms   worst: %6.2fms (rev #$worstCase)   avg: %6.2fms\n",
		$lang, $minTimeMs, $maxTimeMs, $avgTimeMs );
}
