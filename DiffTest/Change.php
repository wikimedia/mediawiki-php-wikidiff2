<?php

class Change {
	public $page;
	public $prevId, $nextId;
	public $prev, $next;

	public function __construct( $page, $prevId, $nextId ) {
		$this->page = $page;
		$this->prevId = $prevId;
		$this->nextId = $nextId;
	}

	public function load() {
		$data = Api::request(
			array(
				'action' => 'query',
				'prop' => 'revisions',
				'rvprop' => 'ids|content',
				'revids' => "{$this->prevId}|{$this->nextId}",
			)
		);
		foreach( $data['query']['pages'] as $page ) {
			if ( $page['title'] != $this->page ) {
				continue;
			}
			foreach ( $page['revisions'] as $rev ) {
				$revid = $rev['revid'];
				if ( !isset( $rev['*'] ) ) {
					echo "Revision $revid not found\n";
					return false;
				}
				$text = $rev['*'];
				if ( $revid == $this->prevId ) {
					$this->prev = $text;
				} elseif ( $revid == $this->nextId ) {
					$this->next = $text;
				}
			}
		}
		return !is_null( $this->prev ) && !is_null( $this->next );
	}
}