<?php

/**
 * Trigger this file on Plugin uninstall
 *
 * @package  SPcalculatorPlugin
 */

if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	die;
}

// Access the database via SQL
global $wpdb;
$wpdb->query( "DROP TABLE IF EXISTS wp_sp_calculator_settings" );