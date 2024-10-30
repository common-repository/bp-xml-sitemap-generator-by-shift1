<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

//https://codex.wordpress.org/Creating_Options_Pages

add_action('admin_menu', 'consorte_bpsitemap_menu');
 
function consorte_bpsitemap_menu(){
		add_menu_page('SHIFT1', 'SHIFT1', 'manage_options', 'shift1', 'consorte_shiftone_init');
		add_submenu_page( 'shift1', 'XML Sitemap for BuddyPress', 'XML Sitemap for BuddyPress', 'manage_options', 'bp-xml-sitemap', 'consorte_bpsitemap_menu_init');
	add_action( 'admin_init', 'consorte_bpsitemap_register_settings' );

}

function consorte_bpsitemap_register_settings() {
	//register our settings
	register_setting( 'bpsitemap-settings-shiftone-group', 'consorte_bpsitemap_num_per_page' );
}




 
function consorte_shiftone_init(){
?>
<h1>Free B2B Networking Profile</h1>
<p>Are you interested in networking with other business owners?<br />
Create a free profile on <a href="https://staunch.biz" target = "_BLANK">Staunch.Biz</a></p>
<h1>More Wordpress Plugins</h1>
<p>Find our other plugins at <a href="https://www.shift1.com" target = "_BLANK">SHIFT1.com</a></p>
<h1>Please Support SHIFT1</h1>
<p>If you find this plugin useful, then please consider a donation to support future development</p>
<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
<input type="hidden" name="cmd" value="_s-xclick" />
<input type="hidden" name="hosted_button_id" value="24ACFGQTEQK9A" />
<input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_donateCC_LG.gif" border="0" name="submit" title="PayPal - The safer, easier way to pay online!" alt="Donate with PayPal button" />
<img alt="" border="0" src="https://www.paypal.com/en_US/i/scr/pixel.gif" width="1" height="1" />
</form>


<?php
}

 
 
function consorte_bpsitemap_menu_init(){
	wp_enqueue_script ('jQuery');
	$menu_function = new consorte_bpsitemap_admin();
	
?>
<h1>BP XML Sitemap by SHIFT1</h1>
<p>This is the maximum number of member profiles or groups that will be listed in a single sitemap file. Files are separated by the starting letter or number of each group and member. If the total exceeds the maximum, then the file will be split. If you change this value, then it is recommended that you delete all sitemap files below, and then click the button to manually generate them again.</p>
<div class="wrap">
<form method="post" action="options.php">
    <?php settings_fields( 'bpsitemap-settings-shiftone-group' ); ?>
    <?php do_settings_sections( 'bpsitemap-settings-shiftone-group' ); ?>
    <table class="form-table">
        <tr valign="top">
        <th scope="row">Max # Links Per Sitemap File</th>
        <td><input type="text" name="consorte_bpsitemap_num_per_page" value="<?php 
		$num = intval( esc_attr( get_option('consorte_bpsitemap_num_per_page') ) ); 
		if (($num <= 0) || ($num === false)) {
			$num = BPSITEMAP_DEFAULT_NUM_PER_PAGE;
			update_option('consorte_bpsitemap_num_per_page', $num, true);
		}
		echo $num;
		?>" /></td>
        </tr>
         

    </table>
    
    <?php submit_button(); ?>

</form>
</div>




<p>The sitemap has been scheduled to be regenerated automatically on a daily basis. You do not need to do anything further on your website, but you can regenerate the sitemaps manually by clicking the button below.</p>
<?php $menu_function->print_generate_button(); ?><br />
<p>Make sure you submit BOTH URLs below to <a href="https://search.google.com/search-console/about" target = "_BLANK">Google Search Console</a> to index your groups and members:</p>

<a href="<?php echo get_site_url(); ?>/sitemap/group.xml" target = "_BLANK"><?php echo get_site_url(); ?>/sitemap/group.xml</a><br />
<a href="<?php echo get_site_url(); ?>/sitemap/member.xml" target = "_BLANK"><?php echo get_site_url(); ?>/sitemap/member.xml</a><br />
<p>We recommend installing a plugin that allows you to customize your robots.txt file. Once you do, add these two lines to robots.txt so that other crawlers can pick up the sitemaps as well:</p>
<p>Sitemap: <?php echo get_site_url(); ?>/sitemap/group.xml<br />
Sitemap: <?php echo get_site_url(); ?>/sitemap/member.xml<br />
</p>
<h1>Delete Old Sitemap Files</h1>
<p>The plugin will overwrite old files, however this utility is useful if you have deleted any members or groups, or if you have changed the default number of links per sitemap file. Make sure you back up your website before you delete any files. Then, click to select all links in each of the three sections below and delete files. You will be prompted to continue.</p>
<?php
	$path = ABSPATH . "sitemap/";
	$path_arr = array(	$path,
						$path . "group/",
						$path . "member/"
				);
	$menu_function->print_file_list($path_arr);
?>
<h1>Free B2B Networking Profile</h1>
<p>Are you interested in networking with other business owners?<br />
Create a free profile on <a href="https://staunch.biz" target = "_BLANK">Staunch.Biz</a></p>
<h1>More Wordpress Plugins</h1>
<p>Find our other plugins at <a href="https://www.shift1.com" target = "_BLANK">SHIFT1.com</a></p>
<h1>Please Support SHIFT1</h1>
<p>If you find this plugin useful, then please consider a donation to support future development</p>
<p>If there is enough interest, we will expand the functionality of this plugin during the next upgrade, and options will be available on this page.</p>
<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
<input type="hidden" name="cmd" value="_s-xclick" />
<input type="hidden" name="hosted_button_id" value="24ACFGQTEQK9A" />
<input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_donateCC_LG.gif" border="0" name="submit" title="PayPal - The safer, easier way to pay online!" alt="Donate with PayPal button" />
<img alt="" border="0" src="https://www.paypal.com/en_US/i/scr/pixel.gif" width="1" height="1" />
</form>
<?php
}



?>