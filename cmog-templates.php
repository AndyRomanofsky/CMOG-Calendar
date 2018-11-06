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
require 'cmog-helper.php';
/** load calsses for list table pages */
require 'classes/template_list.php';
require 'classes/movable_list.php';
require 'classes/events_list.php';
/** define functions displaying pages */
require 'views/list_pages.php';
require 'views/edit_pages.php';
require 'views/edit_event_page.php';
/** ************************ REGISTER THE admin pages  ****************************
 *******************************************************************************
 * Now we just need to define an admin page. For this template, we'll add a top-level
 * menu item to the bottom of the admin menus.
 *
 * add_submenu_page(   $parent_slug,   $page_title,   $menu_title,   $capability,   $menu_slug,  $function = '' )
 */
function cmog_add_menu_items(){
	global $cmog_plugin_hook;
	//global $cmog_plugin_hook_luke;
    add_menu_page('Template Plugin List Table', 'CMOG Templates', 'activate_plugins', 'cmog_list_test', 'cmog_render_list_page');
	add_submenu_page('cmog_list_test', 'Add Template', '- Add Template',  'activate_plugins', 'cmog_list_test&action=add&template=0', 'cmog_render_add_page');
	add_submenu_page('cmog_list_test', 'Luke Templates', 'Luke Templates',  'activate_plugins', 'cmog_list_luke', 'cmog_render_luke_list_page');
	add_submenu_page('cmog_list_test', 'Add Luke Template', '- Add Luke Template',  'activate_plugins', 'cmog_list_luke&action=add&template=0', 'cmog_render_add_luke_page');
	add_submenu_page('cmog_list_test', 'Pentecost Templates', 'Pentecost Templates',  'activate_plugins', 'cmog_list_pentecos', 'cmog_render_pentecost_list_page');
	add_submenu_page('cmog_list_test', 'Pascha Templates', 'Pascha Templates',  'activate_plugins', 'cmog_list_pascha', 'cmog_render_pascha_list_page');
	add_submenu_page('cmog_list_test', 'Triodion Templates', 'Triodion Templates',  'activate_plugins', 'cmog_list_triodion', 'cmog_render_triodion_list_page');
	add_submenu_page('cmog_list_test', 'Movable Templates', 'Movable  Templates',  'activate_plugins', 'cmog_list_movable', 'cmog_render_movable_list_page');
	add_submenu_page('cmog_list_test', 'Add Movable', '- Add Movable',  'activate_plugins', 'cmog_list_movable&action=add&template=0', 'cmog_render_edit_Movable_page');
	add_submenu_page('cmog_list_test', 'Events', 'Events',  'activate_plugins', 'cmog_list_events', 'cmog_render_events_list_page');
	add_submenu_page('cmog_list_test', 'Add new Event', '- Add new Event',  'activate_plugins', 'cmog_list_events&action=add&event=0', 'cmog_render_edit_event_page');
	add_submenu_page('cmog_list_test', 'Calender', 'Calender',  'activate_plugins', 'cmog_month_calendaer', 'cmog_render_events_calendar_page');
	}
add_action('admin_menu', 'cmog_add_menu_items');

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
