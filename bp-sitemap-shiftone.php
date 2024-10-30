<?php
/*
Plugin Name: BP XML Sitemap Generator for Buddypress by SHIFT1
Plugin URI: https://www.shift1.com
Description: Create a BuddyPress XML sitemap to submit your BP website to Google, Bing and other search engines. This plugin will create group and member site maps.
Version: 1.0.0
Author: Dennis Consorte
Author URI: https://staunch.biz/members/dennis/
*/
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly


define ('BPSITEMAP_VERSION', '1.0.0');
define ('BPSITEMAP_DEFAULT_NUM_PER_PAGE', 1000); //default number of links per sitemap file 


	
//load after buddypress
add_action ('bp_include', 'consorte_bpsitemap_load');
function consorte_bpsitemap_load ()
{
	include("engine/install.php");
	include("enqueue/enqueue.php");
	include("class/sitemap.class.php");
	include("admin/admin.class.php");
	include("admin/ajax.inc.php");
	include("admin/admin.inc.php");
	

	function consorte_bpsitemap_action_links( $links ) {
		$settings_link = '<a href="/wp-admin/admin.php?page=bp-xml-sitemap">' . __( 'Settings' ) . '</a>';
		array_push( $links, $settings_link );
		return $links;
	}
	$plugin = plugin_basename( __FILE__ );
	add_filter( "plugin_action_links_$plugin", 'consorte_bpsitemap_action_links' );
	

// and make sure it's called whenever WordPress loads
	add_action('wp', 'consorte_bpsitemap_cron_activation');
	register_deactivation_hook (__FILE__, 'consorte_bpsitemap_cron_deactivate');		

}//consorte_bpsitemap_load 



?>