<?php 
/**
 * @package  SPCalculatorPlugin
 */
namespace Inc\Pages;

/**
* 
*/
class Calculator
{

    public function register()
     {
        add_action( 'init', array($this,'set_rewrite_rule' ));
        add_action( 'query_vars', array($this,'query_vars' ));
        add_action( 'template_redirect',  array($this, 'calculator_display' )); 
    }

    function set_rewrite_rule( )
    {
        add_rewrite_rule('^selling-process-calculator/?$', 'index.php?page_id=$matches[1]', 'top');
		flush_rewrite_rules();
    }


    function query_vars( $query_vars )
    {
        $query_vars[] = 'selling-process-calculator';
        return $query_vars;
    }
   
    function enqueue() {
        wp_enqueue_style( 'mypluginstyle', PLUGIN_URL . 'assets/sp-calculator.css' );
        wp_enqueue_script( 'mypluginscript', PLUGIN_URL . 'assets/sp-calculator.js' );
    }
    
    function calculator_display() {
        global $wp;
        if ($wp->request === 'selling-process-calculator') { 
            add_action( 'wp_enqueue_scripts', array( $this, 'enqueue' ) );
	        require_once PLUGIN_PATH . 'templates/calculator.php';
            exit(1);
        }
    }

}
