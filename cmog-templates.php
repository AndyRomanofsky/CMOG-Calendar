<?php
/*
Plugin Name: CMOG Templates
Plugin URI: http://andyromanofsky.github.io/CMOG-Calendar/
Version: 0.0.1 
License: GPL2
*/
defined( 'ABSPATH' ) or die( 'Do not!' );
require_once 'cmog-helper.php';

require_once 'shortcodes/monthly-calendar.php';
require_once 'shortcodes/daily-calendar.php';
require_once 'shortcodes/allfixedreadings.php';

require_once 'shortcodes/tridion-readings.php';
require_once 'shortcodes/readings_by_date.php';
require_once 'shortcodes/pascha-to-pentecost-readings.php';
require_once 'shortcodes/movable-feast-by-year.php';
require_once 'shortcodes/luke-readings.php';
require_once 'shortcodes/fixed-feasts-by-month.php';
require_once 'shortcodes/after-pentecost-readings.php';
require_once 'shortcodes/monthly-calendar.php';
require_once 'shortcodes/small.php';
require_once 'classes/lib/core.lib.php'; 



/** ************************ REGISTER THE admin pages  ****************************
 *******************************************************************************
 * Now we just need to define an admin page. For this template, we'll add a top-level
 * menu item to the bottom of the admin menus.
 *
 * add_submenu_page(   $parent_slug,   $page_title,   $menu_title,   $capability,   $menu_slug,  $function = '' )
 */
function cmog_add_menu_items(){
	global $cmog_admin_pages;
	//global $cmog_plugin_hook_luke;
	$cmog_admin_pages['top'] = add_menu_page('Template Plugin List Table', 'CMOG Templates', 'activate_plugins', 'cmog_list_test', 'cmog_render_list_page');
								add_submenu_page('cmog_list_test', 'Add Template', '- Add Template',  'activate_plugins', 'cmog_list_test&action=add&template=0', 'cmog_render_add_page');
	$cmog_admin_pages['luke'] = add_submenu_page('cmog_list_test', 'Luke Templates', 'Luke Templates',  'activate_plugins', 'cmog_list_luke', 'cmog_render_luke_list_page');
								add_submenu_page('cmog_list_test', 'Add Luke Template', '- Add Luke Template',  'activate_plugins', 'cmog_list_test&action=add&template=0&gmd=-3', 'cmog_render_add_page');
	$cmog_admin_pages['pentecos'] = add_submenu_page('cmog_list_test', 'Pentecost Templates', 'Pentecost Templates',  'activate_plugins', 'cmog_list_pentecos', 'cmog_render_pentecost_list_page');
	$cmog_admin_pages['pascha'] = add_submenu_page('cmog_list_test', 'Pascha Templates', 'Pascha Templates',  'activate_plugins', 'cmog_list_pascha', 'cmog_render_pascha_list_page');
	$cmog_admin_pages['triodion'] = add_submenu_page('cmog_list_test', 'Triodion Templates', 'Triodion Templates',  'activate_plugins', 'cmog_list_triodion', 'cmog_render_triodion_list_page');
	$cmog_admin_pages['movable'] = add_submenu_page('cmog_list_test', 'Movable Templates', 'Movable  Templates',  'activate_plugins', 'cmog_list_movable', 'cmog_render_movable_list_page');
	                             add_submenu_page('cmog_list_test', 'Add Movable', '- Add Movable',  'activate_plugins', 'cmog_list_movable&action=add&template=0', 'cmog_render_edit_Movable_page');
	$cmog_admin_pages['events'] = add_submenu_page('cmog_list_test', 'Events', 'Events',  'activate_plugins', 'cmog_list_events', 'cmog_render_events_list_page');
	                          add_submenu_page('cmog_list_test', 'Add new Event', '- Add new Event',  'activate_plugins', 'cmog_list_events&action=add&event=0', 'cmog_render_edit_event_page');
	$cmog_admin_pages['calendaer'] = add_submenu_page('cmog_list_test', 'Calender', 'Calender',  'activate_plugins', 'cmog_month_calendaer', 'cmog_render_events_calendar_page');
	
	add_action("load-" .$cmog_admin_pages['top'] , "cmog_top_screen_options");
	add_action("load-" .$cmog_admin_pages['luke'] , "cmog_luke_screen_options");
	add_action("load-" .$cmog_admin_pages['pentecos'] , "cmog_pentecost_screen_options");
	add_action("load-" .$cmog_admin_pages['pascha'] , "cmog_pascha_screen_options");
	add_action("load-" .$cmog_admin_pages['triodion'] , "cmog_triodion_screen_options");
	add_action("load-" .$cmog_admin_pages['movable'] , "cmog_movable_screen_options");
	add_action("load-" .$cmog_admin_pages['events'] , "cmog_events_screen_options");
	//add_action("load-" .$cmog_admin_pages['calendaer'] , "cmog_calendaer_screen_options");
	}
add_action('admin_menu', 'cmog_add_menu_items');


if (isset($_REQUEST['page'])) {
	$cmog_page = $_REQUEST['page'];
}
if (empty($cmog_page)) return;
if (substr_compare($cmog_page , 'cmog_' ,0, 5))  { // if not our page end it here.
	RETURN;
}
	


/*************************** LOAD THE BASE CLASS *******************************
 * IMPORTANT:
 * Please note that the WP_List_Table class technically isn't an official API,
 * and it could change at some point in the distant future. 
 */
if(!class_exists('WP_List_Table')){
    require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
}
if (isset($_REQUEST['page'])) {
	$cmog_page = $_REQUEST['page'];
}
//require 'cmog-helper.php';
/** load calsses for list table pages */

if ($cmog_page == "cmog_list_test" ) {   
/** load calsses for list table pages */
require 'classes/template_list.php';
/**load views*/
require 'views/list_pages.php';
require 'views/edit_pages.php';
} elseif ($cmog_page == "cmog_list_luke" ) {
/** load calsses for list table pages */
require 'classes/template_list.php';
/**load views*/
require 'views/list_pages.php';
require 'views/edit_pages.php';
require 'views/edit_event_page.php';
} elseif ($cmog_page == "cmog_list_pentecos" ) {
/** load calsses for list table pages */
require 'classes/template_list.php';
/**load views*/
require 'views/list_pages.php';
require 'views/edit_pages.php';
require 'views/edit_event_page.php';
} elseif ($cmog_page == "cmog_list_pascha" ) {
/** load calsses for list table pages */
require 'classes/template_list.php';
/**load views*/
require 'views/list_pages.php';
require 'views/edit_pages.php';
require 'views/edit_event_page.php';
} elseif ($cmog_page == "cmog_list_triodion" ) {
/** load calsses for list table pages */
require 'classes/template_list.php';
/**load views*/
require 'views/list_pages.php';
require 'views/edit_pages.php';
require 'views/edit_event_page.php';
} elseif ($cmog_page == "cmog_list_movable" ) {
/** load calsses for list table pages */
require 'classes/movable_list.php';
/**load views*/
require 'views/list_pages.php';
require 'views/edit_pages.php';
require 'views/edit_event_page.php';
} elseif ($cmog_page == "cmog_list_events" ) {
/** load calsses for list table pages */
require 'classes/events_list.php';
/**load views*/
require 'views/list_pages.php';
require 'views/edit_pages.php';
require 'views/edit_event_page.php';
} elseif ($cmog_page == "cmog_month_calendaer" ) {
/** load calsses for list table pages */
require 'classes/events_list.php';
/**load views*/
require 'views/list_pages.php';
require 'views/edit_pages.php';
require 'views/edit_event_page.php';
	
}
/*************************** LOAD THE Option tabs ********************************/
//Option  tab for top
function cmog_top_screen_options() {
 	global $cmog_admin_pages;
	$screen = get_current_screen();
 	// get out of here if we are not on our settings page
	if(!is_object($screen) || $screen->id != $cmog_admin_pages['top'])
		return;
 	$args = array(
		'label' => __('Templates per page', 'cmog'),
		'default' => 1,
		'option' => 'cmog_templates_per_page',
	);
	add_screen_option( 'per_page', $args );
}

 function cmog_set_top_screen_option($status, $option, $value) {
 	if ( 'cmog_templates_per_page' == $option ) return $value;
 }
//Option  tab for luke
function cmog_luke_screen_options() {
 	global $cmog_admin_pages;
	$screen = get_current_screen();
 	// get out of here if we are not on our settings page
	if(!is_object($screen) || $screen->id != $cmog_admin_pages['luke'])
		return;
 	$args = array(
		'label' => __('Templates per page', 'cmog'),
		'default' => 2,
		'option' => 'cmog_lukes_per_page',
	);
	add_screen_option( 'per_page', $args );
}

 function cmog_set_luke_screen_option($status, $option, $value) { 
 	if ( 'cmog_lukes_per_page' == $option ) return $value;
 }
//Option  tab for pentecost
function cmog_pentecost_screen_options() {
 	global $cmog_admin_pages;
	$screen = get_current_screen();
 	// get out of here if we are not on our settings page
	if(!is_object($screen) || $screen->id != $cmog_admin_pages['pentecos'])
		return;
 	$args = array(
		'label' => __('Templates per page', 'cmog'),
		'default' => 3,
		'option' => 'cmog_pentecosts_per_page',
	);
	add_screen_option( 'per_page', $args );
}

 function cmog_set_pentecost_screen_option($status, $option, $value) {
 	if ( 'cmog_pentecosts_per_page' == $option ) return $value;
 }
//Option  tab for pascha
function cmog_pascha_screen_options() {
 	global $cmog_admin_pages;
	$screen = get_current_screen();
 	// get out of here if we are not on our settings page
	if(!is_object($screen) || $screen->id != $cmog_admin_pages['pascha'])
		return;
 	$args = array(
		'label' => __('Templates per page', 'cmog'),
		'default' => 4,
		'option' => 'cmog_paschas_per_page',
	);
	add_screen_option( 'per_page', $args );
}

 function cmog_set_pascha_screen_option($status, $option, $value) {
 	if ( 'cmog_paschas_per_page' == $option ) return $value;
 }
//Option  tab for triodion
function cmog_triodion_screen_options() {
 	global $cmog_admin_pages;
	$screen = get_current_screen();
 	// get out of here if we are not on our settings page
	if(!is_object($screen) || $screen->id != $cmog_admin_pages['triodion'])
		return;
 	$args = array(
		'label' => __('Templates per page', 'cmog'),
		'default' => 5,
		'option' => 'cmog_triodions_per_page',
	);
	add_screen_option( 'per_page', $args );
}

 function cmog_set_triodion_screen_option($status, $option, $value) {
 	if ( 'cmog_triodions_per_page' == $option ) return $value;
 }
//Option  tab for movable
function cmog_movable_screen_options() {
 	global $cmog_admin_pages;
	$screen = get_current_screen();
 	// get out of here if we are not on our settings page
	if(!is_object($screen) || $screen->id != $cmog_admin_pages['movable'])
		return;
 	$args = array(
		'label' => __('Movable events per page', 'cmog'),
		'default' => 10,
		'option' => 'cmog_movables',
	);
	add_screen_option( 'per_page', $args );
}

 function cmog_set_movable_screen_option($status, $option, $value) {
 	if ( 'cmog_movables' == $option ) return $value;
 }
//Option  tab for events
function cmog_events_screen_options() {
 	global $cmog_admin_pages;
	$screen = get_current_screen();
 	// get out of here if we are not on our settings page
	if(!is_object($screen) || $screen->id != $cmog_admin_pages['events'])
		return;
 	$args = array(
		'label' => __('Events per page', 'cmog'),
		'default' => 10,
		'option' => 'cmog_per_page',
	);
	add_screen_option( 'per_page', $args );
}

 function cmog_set_event_screen_option($status, $option, $value) {
 	if ( 'cmog_per_page' == $option ) return $value;
 }
//Option  tab for calendaer  (not called)
function cmog_calendaer_screen_options() {
 	global $cmog_admin_pages;
	$screen = get_current_screen();
 	// get out of here if we are not on our settings page
	if(!is_object($screen) || $screen->id != $cmog_admin_pages['calendaer'])
		return;
 	$args = array(
		'label' => __('Events per page', 'cmog'),
		'default' => 10,
		'option' => 'cmog_per_page',
	);
	add_screen_option( 'per_page', $args );
}

 //function cmog_set_calendaer_screen_option($status, $option, $value) {
 //	if ( 'cmog_per_page' == $option ) return $value;
// }
 
 
 
 
function cmog_load_setfilters (){
	
if (isset($_REQUEST['page'])) {
	$cmog_page = $_REQUEST['page'];	
}
switch ($cmog_page) {	
case "cmog_list_events":
 add_filter('set-screen-option', 'cmog_set_event_screen_option', 10, 3);
 break;
case "cmog_list_test":
 add_filter('set-screen-option', 'cmog_set_top_screen_option', 10, 3); 
 break;
case "cmog_list_luke":
 add_filter('set-screen-option', 'cmog_set_luke_screen_option', 10, 3); 
 break;
case "cmog_list_pentecos":
 add_filter('set-screen-option', 'cmog_set_pentecost_screen_option', 10, 3); 
 break;
case "cmog_list_pascha":
 add_filter('set-screen-option', 'cmog_set_pascha_screen_option', 10, 3); 
 break;
case "cmog_list_triodion":
 add_filter('set-screen-option', 'cmog_set_triodion_screen_option', 10, 3); 
 break;
case "cmog_list_movable":
 add_filter('set-screen-option', 'cmog_set_movable_screen_option', 10, 3); 
 break;
 default:
}
}
add_action( 'init', 'cmog_load_setfilters' );


/*************************** LOAD THE Help tabs ********************************///Help tab
function cmog_plugin_add_help(){
    global $my_admin_page;
    $screen = get_current_screen();
    if ( $screen->id != "toplevel_page_cmog_list_test" )
        return;
    $screen->add_help_tab( array(
        'id'	=> 'my_help_tab',
        'title'	=> __('My Help Tab'),
        'content'	=> '<p>' . __( 'Descriptive content that will show in My Help Tab-body goes here.' ) . '</p>',
    ) );
}
global $cmog_plugin_hook;
    add_action('load-toplevel_page_cmog_list_test' , 'cmog_plugin_add_help');
	
function cmog_plugin_add_calendaer_help(){
    global $my_admin_page;
    $screen = get_current_screen();
    if ( $screen->id != "cmog-templates_page_cmog_month_calendaer" )
        return;
    $screen->add_help_tab( array(
        'id'	=> 'calendaer_tab',
        'title'	=> __('Calendaer'),
        'content'	=> '<p>' . __( 'Descriptive content that will show in My Help Tab-body goes here.' ) . '</p>',
    ) );
	//apply_filters( 'screen_options_show_screen', true, $screen )
//	$screen->add_option( "XXXX", array('LINKS', TRUE) );
//	$screen-> show_screen_options();
	$screen->render_screen_options();
}
global $cmog_plugin_hook;
    add_action('load-cmog-templates_page_cmog_month_calendaer' , 'cmog_plugin_add_calendaer_help');
	

?>
