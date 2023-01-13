<?php

class Random {
	const MAX_CONTENT_LENGTH = 2000000;
	const MAX_LINE_LENGTH = 75000;
	const MAX_LINES = 50000;
	const MAX_WORD_LENGTH = 25;

	private static $tables = [
		// Numbers
		0 => '0123456789.-',
		// Latin
		1 => 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRTSTUVWXYZ-',
		// Russian
		2 => 'АБВГДЕЁЖЗИЙКЛМНОПРСТУФХЦЧШЩЪЫЬЭЮЯабвгдеёжзийклмнопрстуфхцчшщъыьэюя-',
		// Thai
		3 => 'กขฃคฅฆงจฉชซฌญฎฏฐฑฒณดตถทธนบปผฝพฟภมยรฤลฦวศษสหฬอฮฯะัาำิีึืฺุู',
	];

	private static $separators;

	public static function randomData() {
		self::init();

		switch ( mt_rand( 0, 4 ) ) {
			// Diff binary garbage with binary garbage
			case 0:
				$left = self::randomBinaryString( mt_rand( 0, self::MAX_CONTENT_LENGTH ) );
				$right = self::randomBinaryString( mt_rand( 0, self::MAX_CONTENT_LENGTH ) );
				break;
			// Diff binary garbage with text
			case 1:
				$left = self::randomBinaryString( mt_rand( 0, self::MAX_CONTENT_LENGTH ) );
				$right = self::randomText();
				break;
			case 2:
				$left = self::randomText();
				$right = self::randomBinaryString( mt_rand( 0, self::MAX_CONTENT_LENGTH ) );
				break;
			// Diff text against text
			case 3:
				$left = self::randomText();
				$right = self::randomText();
				break;
			// Diff text against shuffled text
			case 4:
				$left = self::randomText();
				$right = self::randomShuffledText( $left );
				break;
			default:
				throw new Exception( 'This should not happen' );
		}

		return [ $left, $right ];
	}

	private static function init() {
		static $initd = false;
		if ( $initd ) {
			return;
		}

		self::$separators = self::split( '.,?!:;。．！？｡\'' );

		foreach ( self::$tables as $index => $table ) {
			self::$tables[$index] = self::split( $table );
		}

		$initd = true;
	}

	private static function split( $str ) {
		$result = preg_split( '//u', $str );
		array_shift( $result );
		array_pop( $result );

		return $result;
	}

	private static function randomText( $length = 0 ) {
		if ( !$length ) {
			$length = mt_rand( 0, self::MAX_CONTENT_LENGTH );
		}

		$str = '';
		do {
			$str .= self::randomLine();
			$str .= str_repeat( "\n", mt_rand( 1, 4 ) );
		} while ( mb_strlen( $str ) < $length );

		return $str;
	}

	private static function randomShuffledText($source) {
		$sourceLines = explode( "\n", $source );
		$sourceLineCount = count( $sourceLines );
		$outputLineCount = $sourceLineCount * 2;
		$ret = "";
		for ( $i = 0; $i < $outputLineCount; $i++ ) {
			$ret .= $sourceLines[ mt_rand( 0, $sourceLineCount - 1 ) ];
			$ret .= str_repeat( "\n", mt_rand( 1, 4 ) );
		}
		return $ret;
	}

	private static function randomLine( $length = 0 ) {
		if ( !$length ) {
			$length = mt_rand( 1, self::MAX_LINE_LENGTH );
		}
		$line = '';
		do {
			$line .= self::randomWord();
			$line .= self::randomSeparator( mt_rand( 0, 3 ) );
			$line .= str_repeat( ' ', mt_rand( 1, 10 ) );
		} while ( strlen( $line ) < $length );

		return trim( $line );
	}

	private static function randomWord( $length = 0 ) {
		if ( !$length ) {
			$length = mt_rand( 1, self::MAX_WORD_LENGTH );
		}

		$charset = self::$tables[mt_rand( 0, count( self::$tables ) - 1 )];
		$str = '';
		$chars = count( $charset );
		for ( $i = 0; $i < $length; $i++ ) {
			$str .= $charset[mt_rand( 0, $chars - 1 )];
		}
		return $str;
	}

	private static function randomSeparator( $count = 1 ) {
		$separatorCount = count( self::$separators );

		$str = '';
		for ( $i = 0; $i < $count; $i++ ) {
			$str .= self::$separators[mt_rand( 0, $separatorCount - 1 )];
		}

		return $str;
	}

	private static function randomBinaryString( $length ) {
		$str = '';
		for ( $i = 0; $i < $length; $i++ ) {
			$str .= chr( mt_rand( 0, 255 ) );
		}

		return $str;
	}
}