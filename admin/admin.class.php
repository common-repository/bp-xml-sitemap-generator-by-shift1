<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class consorte_bpsitemap_admin {
      
    public function __construct() 
    { 

    } 


	/*****************************************************
	output: create a button to manually generate the sitemap files 
	*****************************************************/
	public function print_generate_button(){
	?>
		<input type = 'button' id = 'generate_sitemaps_submit' value = 'Generate Sitemap Files' />
		<script type="text/javascript" >
			jQuery(document).ready(
				function($){		
					$('#generate_sitemaps_submit').click(
						function(){
							var r = confirm('Press OK to regenerate the sitemap files');
							if (r == true) {

								jQuery(document).ready(function($) {

										var data = {
											'action': 'consorte_bpsitemap_admin_make_action'
										};

										jQuery.post(ajaxurl, data, function(response) {
											//alert('Files Deleted: ' + response);
											//console.log(response);
											//$('#${form_id}_div').html(response);
											location.reload();
										});
									});

							} 
							else {
							}
						}
					)
				}
			);
		</script>		
		
	<?php	
	}




	
	/*****************************************************
	input: $directory path - path to directory containing files to delete
	output: form on admin page with checkboxes to select files to delete
			no recursion in this version, not needed for this purpose
			used for deleting old sitemap files
	*****************************************************/
	public function get_file_list($path, $wrap = true){
		$path = trailingslashit($path); //add a slash to the end of the path if it's missing
		$files = glob($file = "${path}*"); // get all file names
		$ct = 0;
		
		$form_id = preg_replace('/[^a-z\d]+/i', '_', untrailingslashit($path));
		
		if ($wrap) {
			$form = "<h2>${path}</h2>
			<input type = 'checkbox' name = '${form_id}_selectall' id = '${form_id}_selectall'> <b>Select All</b><br />
		
			<form name = '${form_id}' id = '${form_id}'>
			<div id = '${form_id}_div'>
			";
		}
		else {
			$form = "";
		}
		
		
		foreach($files as $file){ // iterate files
		  if(is_file($file)) {
			  $form .= "<input type = 'checkbox' class = '${form_id}_checkbox' name = '${form_id}_files_to_delete' value = '${file}'> $file<br />";
			  $ct++;
		  }
		}	
		if ($wrap) $form .= "
			</div>
			<input type = 'button' id = '${form_id}_submit' value = 'Delete Files' />
			
			
			</form>
		
		<script>
		
			//select all 
			jQuery(document).ready(function ($) {
				$('#${form_id}_selectall').click(function () {
					$('.${form_id}_checkbox').prop('checked', $(this).prop('checked'));
				});
			});
			
			//add selected files to array
			jQuery(document).ready(
				function($){		
					$('#${form_id}_submit').click(
						function(){
							var file_arr = [];
							$.each($(\"input[name='${form_id}_files_to_delete']:checked\"), 
								function(){            
									file_arr.push($(this).val());
								}
							);
							var r = confirm('Press OK to delete these files: ' + file_arr.join(', '));
							if (r == true) {

								jQuery(document).ready(function($) {

										var data = {
											'action': 'consorte_bpsitemap_admin_action',
											'files': file_arr,
											'directory': '" . addslashes($path) . "'
										};

										// since 2.8 ajaxurl is always defined in the admin header and points to admin-ajax.php
										jQuery.post(ajaxurl, data, function(response) {
											//alert('Files Deleted: ' + response);
											//console.log(response);
											$('#${form_id}_div').html(response);
										});
									});

							} 
							else {
							}
						}
					)
				}
			);
			</script>			
";
		
		if ($ct == 0) $form = "No files to delete in this directory.<br />";
		return $form;
	}
	
	/*****************************************************
	input: $path_arr - array of paths to directories containing files to delete
	output: print out html for form on admin page with checkboxes to select files to delete
			no recursion in this version, not needed for this purpose
			used for deleting old sitemap files
	*****************************************************/
	public function print_file_list($path_arr, $wrap = true){
		foreach($path_arr as $path) {
			echo $this->get_file_list($path, $wrap);
		}
	}
}

?>

