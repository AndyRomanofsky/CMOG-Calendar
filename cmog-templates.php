<?php
/*
Plugin Name: CMOG Templates
Plugin URI: http://andyromanofsky.github.io/CMOG-Calendar/
Version: 0.0.1 
License: GPL2
*/
defined( 'ABSPATH' ) or die( 'Do not!' );
/*************************** LOAD THE BASE CLASS *******************************
 * IMPORTANT:
 * Please note that the WP_List_Table class technically isn't an official API,
 * and it could change at some point in the distant future. 
 */
if(!class_exists('WP_List_Table')){
    require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
}
/** load calsses for list table pages */
require 'classes/template_list.php';
require 'classes/movable_list.php';
require 'classes/events_list.php';
/** define functions displaying pages */
require 'views/list_pages.php';
require 'views/edit_pages.php';
/** ************************ REGISTER THE admin pages  ****************************
 *******************************************************************************
 * Now we just need to define an admin page. For this template, we'll add a top-level
 * menu item to the bottom of the admin menus.
 */
function cmog_add_menu_items(){
	global $cmog_plugin_hook;
	global $cmog_plugin_hook_luke;
    $cmog_plugin_hook = add_menu_page('Template Plugin List Table', 'CMOG Templates', 'activate_plugins', 'cmog_list_test', 'cmog_render_list_page');
	add_submenu_page('cmog_list_test', 'All Templates', 'All Templates',  'activate_plugins', 'cmog_list_test', 'cmog_render_list_page');
	add_submenu_page('cmog_list_test', 'Add Template', 'Add Template',  'activate_plugins', 'cmog_list_test&action=add&template=0', 'cmog_render_add_page');
	$cmog_plugin_hook_luke = add_submenu_page('cmog_list_test', 'Luke Templates', 'Luke Templates',  'activate_plugins', 'cmog_list_luke', 'cmog_render_luke_list_page');
	add_submenu_page('cmog_list_test', 'Pentecost Templates', 'Pentecost Templates',  'activate_plugins', 'cmog_list_pentecos', 'cmog_render_pentecost_list_page');
	add_submenu_page('cmog_list_test', 'Pascha Templates', 'Pascha Templates',  'activate_plugins', 'cmog_list_pascha', 'cmog_render_pascha_list_page');
	add_submenu_page('cmog_list_test', 'Triodion Templates', 'Triodion Templates',  'activate_plugins', 'cmog_list_triodion', 'cmog_render_triodion_list_page');
	add_submenu_page('cmog_list_test', 'Movable Templates', 'Movable  Templates',  'activate_plugins', 'cmog_list_movable', 'cmog_render_movable_list_page');
	add_submenu_page('cmog_list_test', 'Events', 'Events',  'activate_plugins', 'cmog_list_events', 'cmog_render_events_list_page');
//var_dump($cmog_plugin_hook); var_dump($cmog_plugin_hook_luke); var_dump($cmog_plugin_hook); var_dump($cmog_plugin_hook_luke); 
	
	}
add_action('admin_menu', 'cmog_add_menu_items');



function my_plugin_add_help()
{
	// We are in the correct screen because we are taking advantage of the load-* action (below)

	$screen = get_current_screen(); var_dump($screen);
	//$screen->remove_help_tabs();
	$screen->add_help_tab( array(
		'id'       => 'cmog_list_test-default',
		'title'    => __( 'Default' ),
		'content'  => 'This is where I would provide tabbed help to the user on how everything in my admin panel works. Formatted HTML works fine in here too'
	));
	//add more help tabs as needed with unique id's

	// Help sidebars are optional
	$screen->set_help_sidebar(
		'<p><strong>' . __( 'For more information:' ) . '</strong></p>' .
		'<p><a href="http://wordpress.org/support/" target="_blank">' . _( 'Support Forums' ) . '</a></p>'
	);
}

global $cmog_plugin_hook_luke ;
//if ( $cmog_plugin_hook_luke ) {
	add_action( 'load-' . $cmog_plugin_hook_luke , 'my_plugin_add_help' );
//}


//Notice: Undefined variable: cmog_plugin_hook_luke in C:\wamp64a\www\cmog\wp-content\plugins\CMOG-templates\cmog-templates.php on line 70
