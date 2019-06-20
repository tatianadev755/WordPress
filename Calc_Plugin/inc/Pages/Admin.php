<?php 
/**
 * @package  SPCalculatorPlugin
 */
namespace Inc\Pages;

/**
* 
*/
class Admin
{

	public function register() {
		add_action( 'admin_menu', array( $this, 'add_admin_pages' ) );
		add_action( 'admin_init', array($this,'update_sp_calculator_instruction' ));
	}

	public function add_admin_pages() {
		add_menu_page( 'Sp Calculator Plugin', 'SP Calculator', 'manage_options', 'sp_calculator', array( $this, 'admin_index' ), 'dashicons-layout', 110 );
	}

	public function update_sp_calculator_instruction() {
		if($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['sp_calculator_settings'])){
			$heading = $_POST['sp_calculator_page_heading'];
			$instruction = $_POST['sp_calculator_instruction'];	
			$heading_ = stripslashes($heading);
			$instruction_ = stripslashes($instruction);
			global $wpdb;
			$wpdb->update('wp_sp_calculator_settings', array('heading' => $heading_,  'instruction' => $instruction_), array('id' => 1));
			header('Location: admin.php?page=sp_calculator');
			exit(1);
		}
	}

	public function admin_index() {
		require_once PLUGIN_PATH . 'templates/admin.php';
	}

}
