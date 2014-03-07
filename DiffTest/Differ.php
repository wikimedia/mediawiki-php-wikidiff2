<?php

interface Differ {
	function diff( $a, $b );
}

class TableDiffer implements Differ {
	public function diff( $a, $b ) {
		return '<table>'
			. wikidiff2_do_diff( $a, $b, 2 )
			. '</table>';
	}
}

class InlineDiffer implements Differ {
	public function diff( $a, $b ) {
		return wikidiff2_inline_diff( $a, $b, 2 );
	}
}

class BothDiffer implements Differ {
	private $table, $inline;

	public function __construct() {
		$this->table = new TableDiffer;
		$this->inline = new InlineDiffer;
	}

	public function diff( $a, $b ) {
		return $this->table->diff( $a, $b )
			. $this->inline->diff( $a, $b );
	}
}

