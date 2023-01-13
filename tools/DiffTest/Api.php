<?php

class Api {
	public static function request( array $params ) {
		global $apiUrl;

		$params['format'] = 'json';
		$query = http_build_query( $params );
		$url = "$apiUrl?$query";
		$response = file_get_contents( $url );
		return json_decode( $response, true );
	}
}