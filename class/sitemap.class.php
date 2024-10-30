<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class consorte_bpsitemap
{     
    public $num_per_page = BPSITEMAP_DEFAULT_NUM_PER_PAGE;
      
    // Constructor is being implemented. 
    public function __construct($num_per_page) 
    { 
        $this->num_per_page = $num_per_page; 
    } 
	

	
/****************************************************
public function count_items
INPUT:	$type - "group" or "member"
		$alpha - a-z or 0-9
OUTPUT:	total number of active groups or active members that begin with $alpha

****************************************************/	
	public function count_items($type, $alpha){
		global $wpdb;
		$prefix = $wpdb->prefix;
		switch ($type){
			case "group":	$sql = "select count(name) ct from ${prefix}bp_groups where name like '${alpha}%';";
							break;
			case "member":	$sql = "select count(user_login) ct from ${prefix}users where user_login like '${alpha}%' and user_status = 0;";
							break;
			default:		$sql = "select 0";
		}
		$ct = $wpdb->get_var($sql);
		return $ct;
	}


/****************************************************
public function get_results
INPUT:	$type		"group" or "member"
		$alpha		a-z or 0-9
		$page		which page of results we're returning for $alpha results, calculated by total number of items
		$format		"xml"	xml sitemap - complete with header & footer as a string
					"html"	html sitemap - to be inserted into a div or HTML page
					"csv"	csv of id, creator_id, name, slug, description, status, parent_id, enable_forum, date_created
					
OUTPUT:	all active groups or all active members that start with $alpha

****************************************************/	


	public function get_results($type, $alpha, $page, $format = "xml"){

		
		global $wpdb;
		$site_url = ABSPATH;
		$results_arr = array();
		$prefix = $wpdb->prefix;
		
		$limit = $this->num_per_page;
		$start = ($page-1) * $limit;
		$date = date("Y-m-d");
		$field_arr = array("id", "creator_id", "name", "url", "description", "status", "parent_id", "enable_forum", "date_created", "date");
		
		if ($type == "group"){
			$sql = "select id, creator_id, name, slug, description, status, parent_id, enable_forum, date_created from ${prefix}bp_groups where name like '${alpha}%' order by name limit $start,$limit";
			switch($format){
				case "xml":		$template = "	<url>
		<loc>{{url}}</loc>
		<lastmod>{{date}}</lastmod>
	</url>";
								break;
							
				case "html":	$template = "<a href='{{url}}'>{{name}}</a><br />";
								break;
							
				case "csv":		$template = "{{id}},{{creator_id}},{{name}},{{url}},{{description}},{{status}},{{parent_id}},{{enable_forum}},{{date_created}}" . PHP_EOL;
								break;
				default:
								break;
			}
		}//if ($type == "group")
		elseif ($type == "member"){
			$sql = "select ID from ${prefix}users where user_login like '${alpha}%' and user_status = 0 order by user_login limit $start,$limit";
			switch($format){
				case "xml":		$template = "	<url>
		<loc>{{url}}</loc>
		<lastmod>{{date}}</lastmod>
	</url>";
								break;
							
				case "html":	$template = "<a href='{{url}}'>{{name}}</a><br />";
								break;
							
				case "csv":		$template = "{{id}},{{creator_id}},{{name}},{{url}},{{description}},{{status}},{{parent_id}},{{enable_forum}},{{date_created}}" . PHP_EOL;
								break;
				default:
								break;
			}
		}
		else return false;
		$results = $wpdb->get_results($sql);
		foreach($results as $row){
			
			$record = $template;
			foreach($field_arr as $field){
//				echo "$field $type<br />";
				if (($field == "url") && ($type == "group")) {
					$url = bp_get_group_permalink(groups_get_group($row->id));
					$record = str_replace("{{url}}", $url, $record);
//					echo "$url $record<br />";
				}
				elseif (($field == "url") && ($type == "member")) {
					$url = bp_core_get_userlink( $row->ID, false, true );
					$record = str_replace("{{url}}", $url, $record);
				}
				elseif ($field == "date") {
					$record = str_replace("{{date}}", $date, $record);
				}
				else {
					if (property_exists($row, $field)){
						$record = str_replace("{{" . $field . "}}", $row->{$field}, $record);
					}
				}
			}

			$results_arr[] = $record;
		}
		return $results_arr;
	}
	
	
	
/****************************************************************
input: $type	"member" or "group"
****************************************************************/	
	public function get_menu($type)
	{
		$site_url = get_site_url();
		$menu = "";
		$letters_numbers = array_merge(range("a","z"), range("0","9"));
		$date = date("Y-m-d");
		foreach($letters_numbers as $alpha) {

			$ct = $this->count_items($type, $alpha);
			$num_pages = ceil($ct / $this->num_per_page);
			if ($num_pages >= 1) {
				for($p = 1; $p <=$num_pages; $p++) {
						$url = "${site_url}/sitemap/${type}/$alpha";
						if ($p !== 1) $url .= "-$p";
						$url .= ".xml";
						$menu .= "	<sitemap>
		<loc>${url}</loc>
		<lastmod>${date}</lastmod>
	</sitemap>";
				}
			}
		}
		
		$menu = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>
<sitemapindex xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\">
${menu}
</sitemapindex>";
		
		return $menu;
	}
}//buddypress_sitemap_shiftone 