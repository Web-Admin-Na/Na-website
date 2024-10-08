<?php

class WPML_PO_Parser {

	public static function create_po( $strings, $pot_only = false ) {
		global $wpdb;

		$po = self::get_po_file_header();

		foreach ( $strings as $s ) {
			$ids[ ] = $s[ 'string_id' ];
		}
		if ( ! empty( $ids ) ) {
			$sql_prepared = $wpdb->prepare( "SELECT string_id, position_in_page
	            			 				 FROM {$wpdb->prefix}icl_string_positions
	            			 				 WHERE kind=%d AND string_id IN(%s)", ICL_STRING_TRANSLATION_STRING_TRACKING_TYPE_SOURCE, implode( ',', $ids ));
			$res = $wpdb->get_results( $sql_prepared );
			foreach ( $res as $row ) {
				$positions[ $row->string_id ] = $row->position_in_page;
			}
		}
		foreach ( $strings as $s ) {
			$po .= PHP_EOL;
			if ( ! $pot_only && isset( $s[ 'translations' ] ) && isset( $s[ 'translations' ][ key( $s[ 'translations' ] ) ][ 'value' ] ) ) {
				$translation = $s[ 'translations' ][ key( $s[ 'translations' ] ) ][ 'value' ];
				if ( $translation != '' && $s[ 'translations' ][ key( $s[ 'translations' ] ) ][ 'status' ] != ICL_TM_COMPLETE ) {
					$po .= '#, fuzzy' . PHP_EOL;
				}
			} else {
				$translation = '';
			}
			if ( isset( $positions[ $s[ 'string_id' ] ] ) ) {
				$exp  = @explode( '::', $positions[ $s[ 'string_id' ] ] );
				$file = @file( $exp[ 0 ] );
			} else {
				unset( $file );
				unset( $exp );
			}

			$po_single = '';
			if ( isset( $file ) && isset( $exp ) ) {
				$line_number = (int) $exp[ 1 ];
				$line_number--; // Make it 0 base
				$line_number -= 2; // Go back 2 lines
				if ( $line_number < 0 ) {
					$line_number = 0;
				}
				for ( $line = 0; $line < 3; $line++ ) {
					$po_single .= '#: ' . @trim( $file[ $line_number + $line ] ) . PHP_EOL;
				}
			}

			$po_single .= '# wpml-name: ' . $s[ 'name' ] . PHP_EOL;

			if ( $s[ 'gettext_context' ] ) {
				$po_single .=
					'msgctxt "'
					. $s[ 'gettext_context' ]
					. '"'
					. PHP_EOL;
			}
			$po_single .= 'msgid ' . self::output_string( $s[ 'value' ] ) . PHP_EOL;
			$po_single .= 'msgstr ' . self::output_string( $translation ) . PHP_EOL;
			$po .= $po_single;
		}

		return $po;
	}

	public static function get_po_file_header() {
		$po_title             = 'WPML_EXPORT';
		$translation_language = 'en';

		if ( isset( $_GET['context'] ) ) {
			$sanitizedSuffix = \WPML\API\Sanitize::string( $_GET['context'] );
			$po_title .= '_' . $sanitizedSuffix;
		}

		if ( isset( $_GET['translation_language'] ) ) {
			$translation_language = (string) \WPML\API\Sanitize::string( $_GET['translation_language'] );
		}

		$po = "";
		$po .= '# This file was generated by WPML' . PHP_EOL;
		$po .= '# WPML is a WordPress plugin that can turn any WordPress or WordPressMU site into a full featured multilingual content management system.' . PHP_EOL;
		$po .= '# https://wpml.org' . PHP_EOL;
		$po .= 'msgid ""' . PHP_EOL;
		$po .= 'msgstr ""' . PHP_EOL;
		$po .= '"Content-Type: text/plain; charset=utf-8\n"' . PHP_EOL;
		$po .= '"Content-Transfer-Encoding: 8bit\n"' . PHP_EOL;

		$po .= '"Project-Id-Version:' . $po_title . '\n"' . PHP_EOL;
		$po .= '"POT-Creation-Date: \n"' . PHP_EOL;
		$po .= '"PO-Revision-Date: \n"' . PHP_EOL;
		$po .= '"Last-Translator: \n"' . PHP_EOL;
		$po .= '"Language-Team: \n"' . PHP_EOL;

		$po .= '"Language:' . $translation_language . '\n"' . PHP_EOL;

		$po .= '"MIME-Version: 1.0\n"' . PHP_EOL;

		return $po;
	}

	private static function output_string( $str ) {
		if ( strstr( $str, "\n" ) ) {
			$str = str_replace( "\r", "", $str );
			$lines = explode( "\n", $str );
			$str = '""';
			foreach ( $lines as $line ) {
				$str .= PHP_EOL . '"' . self::addslashes( $line ) . '\n"' ;
			}
		} else {
			$str = '"' . self::addslashes( $str ) . '"';
		}

		return $str;
	}

	private static function addslashes ( $str ) {
		$str = str_replace( '\\', '\\\\', $str );
		$str = str_replace( '"', '\"', $str );

		return $str;
	}

}
