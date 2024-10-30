<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

register_activation_hook( __FILE__, 'consorte_bpsitemap_install' );
register_activation_hook( __FILE__, 'consorte_bpsitemap_install_data' );

/*************************************************
create directories for bp sitemap 
*************************************************/

function consorte_bpsitemap_install() {

}

function consorte_bpsitemap_install_data() {


}










// create a scheduled event (if it does not exist already)
function consorte_bpsitemap_cron_activation() {
	if( !wp_next_scheduled( 'consorte_bpsitemap_cron' ) ) {  
	   wp_schedule_event( time(), 'daily', 'consorte_bpsitemap_cron' );  
	}
}
add_action( 'consorte_bpsitemap_cron', 'consorte_bpsitemap_cron_function' );



// unschedule event upon plugin deactivation
function consorte_bpsitemap_cron_deactivate() {	
	// find out when the last event was scheduled
	$timestamp = wp_next_scheduled ('consorte_bpsitemap_cron');
	// unschedule previous event if any
	wp_unschedule_event ($timestamp, 'consorte_bpsitemap_cron');
} 


function consorte_bpsitemap_cron_function(){
	consorte_bpsitemap_make_function();
}

	
function consorte_bpsitemap_make_function(){
	$path = ABSPATH;
/*	$test = $path . "temp.txt";
	$info = "hello dude" . date("YmdHis");
	file_put_contents($test, $info);
*/	
	//make directory if doesn't exist
	$file = "${path}sitemap/group/"; 
	if (!file_exists($file)) {
		mkdir($file, 0777, true);
	}
	$file = "${path}sitemap/member/"; 
	if (!file_exists($file)) {
		mkdir($file, 0777, true);
	}
	
	global $wpdb;
	$prefix = $wpdb->prefix;
	
	$num_per_page = intval( esc_attr( get_option('consorte_bpsitemap_num_per_page') ) ); 
	if (($num_per_page === 0) || ($num_per_page === false)) {
		$num_per_page = BPSITEMAP_DEFAULT_NUM_PER_PAGE;
		update_option('consorte_bpsitemap_num_per_page', $num_per_page, true);
	}
	
	
	
	
	$letters_numbers = array_merge(range("a","z"), range("0","9"));
	
	$sitemap = new consorte_bpsitemap($num_per_page);

	// make groups
	$url_arr = array();
	$map = "";
	

	foreach($letters_numbers as $alpha) {
		$ct = $sitemap->count_items("group",$alpha);
		$ct_pages = ceil($ct / $num_per_page);
		

		for($page = 1; $page <= $ct_pages; $page++) {
			$url_arr = $sitemap->get_results("group", $alpha, $page, "xml");
			if (count($url_arr)>0){
				$map = implode("\n", $url_arr);
				$map = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>
		<urlset xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\">
		${map}
		</urlset>";
				$file = "${path}sitemap/group/$alpha";
				if ($page !== 1) $file .= "-$page";
				$file .= ".xml";
				file_put_contents($file, $map, LOCK_EX);
			}
		}
	}

	$menu = $sitemap->get_menu("group");
	$file = "${path}/sitemap/group.xml";
	file_put_contents($file, $menu, LOCK_EX);

	/*************************************************************************/

	// make members

	$url_arr = array();
	$map = "";
	$date = date("Y-m-d");
		
	foreach($letters_numbers as $alpha) {
		$ct = $sitemap->count_items("member", $alpha);
		$ct_pages = ceil($ct / $num_per_page);
		for($page = 1; $page <= $ct_pages; $page++) {
			$url_arr = $sitemap->get_results("member", $alpha, $page, "xml");
			if (count($url_arr)>0){
				$map = implode("\n", $url_arr);
				$map = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>
		<urlset xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\">
		${map}
		</urlset>";
				$file = "${path}/sitemap/member/$alpha";
				if ($page !== 1) $file .= "-$page";
				$file .= ".xml";
				file_put_contents($file, $map, LOCK_EX);	
			}
		}
	}

	$menu = $sitemap->get_menu("member");
	$file = "${path}/sitemap/member.xml";
	file_put_contents($file, $menu, LOCK_EX);	
}
 
