<?php
/**
 * @package  SpCalculatorPlugin
 */
namespace Inc\Base;

class Deactivate
{
	public static function deactivate() {
		global $wpdb;
		$wpdb->query( "TRUNCATE TABLE wp_sp_calculator_settings" );
		flush_rewrite_rules();
	}
}