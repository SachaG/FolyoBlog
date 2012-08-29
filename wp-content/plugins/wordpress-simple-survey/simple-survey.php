<?php
/*
Plugin Name: WP Simple Survey
Plugin URI: http://labs.saidigital.co/products/wordpress-simple-survey/
Description: A WordPress Survey and Quiz plugin that displays basic weighted survey, and then routes user to location based on score. Survey displays one question at a time, and uses jQuery to reload the subsequent question without reloading the page. Scores, Names, and Results can be recorded, emailed, and displayed in the WordPress backend.
Version: 2.2.9
Author: Richard Royal
Author URI: http://saidigital.co/author/rroyal/
License: GPL2
*/


global $wpdb;
define('WPSS_PATH',ABSPATH.PLUGINDIR."/wordpress-simple-survey/");
#define('WPSS_URL',WP_PLUGIN_URL."/wordpress-simple-survey/");
define('WPSS_URL', plugins_url('', __FILE__).'/');
#define('WPSS_SUBMIT_RESULTS',get_bloginfo('url')."/?wpss-routing=results");
define('WPSS_SUBMIT_RESULTS',site_url()."/?wpss-routing=results");
define('WPSS_QUIZZES_DB',$wpdb->prefix.'wpss_Quizzes');
define('WPSS_QUESTIONS_DB',$wpdb->prefix.'wpss_Questions');
define('WPSS_ANSWERS_DB',$wpdb->prefix.'wpss_Answers');
define('WPSS_RESULTS_DB',$wpdb->prefix.'wpss_Results');
define('WPSS_ROUTES_DB',$wpdb->prefix.'wpss_Routes');
define('WPSS_FIELDS_DB',$wpdb->prefix.'wpss_Fields');
define('WPSS_EXTENDED_DB_VERSION','1.0');
require_once(ABSPATH.'wp-admin/includes/upgrade.php');
require_once(WPSS_PATH."functions.php");
require_once(WPSS_PATH."submit_functions.php");
require_once(WPSS_PATH."db_setup.php");
require_once(WPSS_PATH."quiz_js.php");
require_once(WPSS_PATH."output_quiz.php");
require_once(WPSS_PATH."admin/admin_functions.php");



// run setup scripts on activation
register_activation_hook(__FILE__,'wpss_plugin_install');



/**
 *  Create admin pages in WP backend
 *  Connect Each Admin page with its function
 *  which imports php script page
 */
function simpsurv_admin(){require_once("admin/admin_quizzes.php");}
function simpsurv_tracking(){require_once("admin/view_results.php");}
function simpsurv_help(){require_once("admin/admin_help.php");}
function simpsurv_global(){require_once("admin/admin_global_options.php");}
function simpsurv_admin_actions() {
  if (current_user_can('manage_options')) {
    add_menu_page("WP Simple Survey - Setup Quizzes", "WPSS - Setup", "publish_posts", "wpss-setup","simpsurv_admin");
    add_submenu_page( "wpss-setup", "WP Simple Survey - Results / Export","Results/Export" ,"publish_posts", "wpss-results", "simpsurv_tracking");
    add_submenu_page( "wpss-setup", "WP Simple Survey - Help","WPSS Help" ,"publish_posts", "wpss-help", "simpsurv_help");
    add_submenu_page( "wpss-setup", "WP Simple Survey - Global","WPSS Global Options" ,"publish_posts", "wpss-global", "simpsurv_global");    
  }
}add_action('admin_menu', 'simpsurv_admin_actions');











/**
 *  Include JS Library in HTML <head>
 *  Allowing user ability to toggle off jquery import
 *
 *  NOTE: See js/README.txt for good time
 */
function wpss_includeScripts(){
  $jquery = get_option('wpss_queue_jquery');
  if(!$jquery) update_option('wpss_queue_jquery','checked');
  $jquery = get_option('wpss_queue_jquery');

  if(!is_admin()){
    if($jquery == 'checked'){
      wp_enqueue_script('jquery-ui-core',array('jquery'));
      wp_enqueue_script('jquery-ui-widget', WPSS_URL.'js/ui.widget.min.js',array('jquery','jquery-ui-core'),'1.8.12');
      wp_enqueue_script('jquery-ui-progressbar', WPSS_URL.'js/ui.progressbar.min.js',array('jquery','jquery-ui-core','jquery-ui-widget'), '1.8.14');
      wp_enqueue_script('wpss_custom', WPSS_URL.'js/custom.js',array('jquery','jquery-ui-core','jquery-ui-widget','jquery-ui-progressbar'), '2.1.2');
    }
    elseif($jquery == 'unchecked'){
#      wp_enqueue_script('jquery-ui-core');
#      wp_register_script('jquery-ui-widget', WPSS_URL.'js/ui.widget.min.js',array(),'1.8.12');
      wp_register_script('jquery-ui-progressbar', WPSS_URL.'js/ui.progressbar.min.js', '1.8.14');
      wp_enqueue_script('wpss_custom', WPSS_URL.'js/custom.js',array('jquery-ui-progressbar'), '2.1.2');
    }
  }
}add_action('wp_print_scripts', 'wpss_includeScripts');







/**
 *  Register CSS's for plugin
 */
function wpss_stylesheets() {
  if(!is_admin()){
    wp_enqueue_style('wpss_style', WPSS_URL.'style.css');  
    wp_enqueue_style('wpss_uicore', WPSS_URL.'css/ui.core.css');
    wp_enqueue_style('wpss_uitheme', WPSS_URL.'css/ui.theme.css');
    wp_enqueue_style('wpss_probar', WPSS_URL.'css/ui.progressbar.css');
  } 
}add_action('wp_print_styles', 'wpss_stylesheets');





/**
 *  Register CSS for Admin Pages
 */
function wpss_admin_register_init(){
  wp_enqueue_style('wpss_style', WPSS_URL.'style.css');
  wp_enqueue_style('wpss_jquery_ui', WPSS_URL.'css/jquery-ui.css');
}add_action('admin_init', 'wpss_admin_register_init');






/**
 *  Output JS for Admin Pages, admin_enqueue_scripts buggy 
 */
function wpss_admin_register_head(){
  // NOTE:  wp_register_script doesnt want to work for admin pages
  //        admin_enqueue_scripts doesnt exist on admin_init or admin_head
  //        #wp_register_script('wpss_tip',WPSS_URL.'js/jquery.tools.min.js');    
  //        #wp_enqueue_scripts('wpss_tip');

  // only import tooltip when needed to avoid conflict with widget dragging js
  $wpss_pages = array('wpss-results','wpss-setup');
  if (!empty($_GET['page']) && in_array($_GET['page'],$wpss_pages)){ 
    echo '<script type="text/javascript" src="'.WPSS_URL.'js/jquery.tools.min.js"></script>';
    echo '<script type="text/javascript" src="'.WPSS_URL.'js/jquery-ui-full.min.js"></script>';  
    echo '<script type="text/javascript" src="'.WPSS_URL.'js/custom_backend.js"></script>';        
  }      
}add_action('admin_head', 'wpss_admin_register_head');






/**
 *  Setup custom URL for plugin to POST quiz results to,
 *  Allows for proper access to 'global worpress' scope
 *  including database settings needed for tracking
 */
function wpss_parse_request($wp) {
    // only process requests POST'ed to "/?wpss-routing=results"
    if (array_key_exists('wpss-routing', $wp->query_vars) && $wp->query_vars['wpss-routing'] == 'results') {
      include('submit_quiz.php');  
    }
}add_action('parse_request', 'wpss_parse_request');

function wpss_parse_query_vars($vars) {
    $vars[] = 'wpss-routing';
    return $vars;
}add_filter('query_vars', 'wpss_parse_query_vars');




?>
