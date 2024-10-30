<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

//https://codex.wordpress.org/AJAX_in_Plugins

add_action( 'wp_ajax_consorte_bpsitemap_admin_action', 'consorte_bpsitemap_admin_action' );

function consorte_bpsitemap_admin_action() {
	$sitemap_directory_path = ABSPATH . "sitemap/";
	$sdplen = strlen($sitemap_directory_path);
	
	if(!current_user_can('administrator')){
		echo "not logged in";
		wp_die();
	}
	else {
		$files = $_POST["files"];
		foreach($files as $file){
		   $path = str_replace("\\\\","\\",$file);

			//make sure we're only working with the sitemap directory before deleting
			if (substr($path, 0, $sdplen) !== $sitemap_directory_path){
			   echo "wrong directory";
			   wp_die();
			}
			else {
				if(is_file($path)){
					unlink($path); // delete file
					//echo $path . PHP_EOL;
				}
				else {
					echo "path invalid";
					wp_die();
				}
			}
		}
	}
	
	//return an array of the remaining files in the directory
	$menu_function = new consorte_bpsitemap_admin();
	$path_arr = array( str_replace("\\\\","\\",$_POST["directory"]) );
	$menu_function->print_file_list($path_arr, false);
	
	wp_die(); // this is required to terminate immediately and return a proper response
}



add_action ('wp_ajax_consorte_bpsitemap_admin_make_action', 'consorte_bpsitemap_admin_make_action'); 

function consorte_bpsitemap_admin_make_action() {
	consorte_bpsitemap_make_function();
}



?>