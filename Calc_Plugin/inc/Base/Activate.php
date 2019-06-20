<?php
/**
 * @package  SPCalculatorPlugin
 */
namespace Inc\Base;

class Activate
{
	public static function activate() {
		global $wpdb;
		$wpdb->query( "CREATE TABLE IF NOT EXISTS wp_sp_calculator_settings(id int primary key, heading text, instruction text)" );
		$wpdb->query( "INSERT INTO wp_sp_calculator_settings VALUES (1, '', '')" );
		flush_rewrite_rules();
	}
}