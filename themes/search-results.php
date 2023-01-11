<?php
/**
 /* Template Name: Search Results
 *
 
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package immedia
 */

$siteLayout = esc_attr( get_option( 'site_layout' ) );
if($siteLayout == 'Normal'){
get_header();
}
elseif($siteLayout == 'Linear'){
get_header("linear");
}
else{
get_header();	
}?>

<div id="primary" class="content-area thisisour-story">
	<main id="main" class="site-main" role="main">
		<div class="vc_row-full-width vc_clearfix"></div>
		<div data-vc-full-width="true" data-vc-full-width-init="true" data-vc-stretch-content="true" class="vc_row wpb_row vc_row-fluid contain-row vc_row-no-padding" style="position: relative; left: -686.333px; box-sizing: border-box; width: 2543px;">
			<div class="row bump-filter">
				<div class="vc_col-sm-12 text-center">

				<h1 class="big" style='margin-bottom:35px;'>Search Results</h1>
				<?php
				if (isset($_GET['q'])){
					$thequery = sanitize_text_field($_GET['q']);
					global $wpdb;

					$table_name = $wpdb->prefix . "tblListsDB";
					$table_name2 = $wpdb->prefix . "tblMumsDB";
					$qresults = $wpdb->get_results( "SELECT $table_name.*, $table_name2.* FROM $table_name RIGHT JOIN $table_name2 ON $table_name.ld_md_id = $table_name2.md_wp_id WHERE ($table_name2.md_familyname LIKE '%%$thequery%%' OR $table_name2.md_baby_name LIKE '%%$thequery%%' OR $table_name2.md_firstname LIKE '%%$thequery%%' OR wp_tblListsDB.ld_list_name LIKE '%%$thequery%%' OR $table_name2.md_fullname LIKE '%%$thequery%%') AND $table_name.ld_list_status = 1 AND '$thequery' != ''");
					
					echo ('<div class="contain-text">');
						echo ('<p>If you are unable to find the list you are looking for in the results below, try searching with parent name, baby name or list name. Alternatively you can ask the list owener to send you a direct link.</p>');
					echo ('</div>');
					
					echo('<div class="wpb_column vc_column_container vc_col-sm-3">');
						echo('<div class="vc_column-inner">');
							echo('<div class="wpb_wrapper"></div>');
						echo('</div>');
					echo('</div>');
					
					echo('<div class="wpb_column vc_column_container vc_col-sm-6">');
						echo('<div class="vc_column-inner">');
							echo('<div class="wpb_wrapper">');
								echo('<div class="wpb_raw_code wpb_content_element wpb_raw_html">');
									echo('<div class="wpb_wrapper">');
										echo('<form class="form-search" action="/search-results/" method="GET">');

											echo('<input type="text" id="" name="q" placeholder="Who are you looking for?">');

											echo('<input type="submit" value="Submit">');

										echo('</form>');
									echo('</div>');
								echo('</div>');
							echo('</div>');
						echo('</div>');
					echo('</div>');
					
					echo('<div class="wpb_column vc_column_container vc_col-sm-3">');
						echo('<div class="vc_column-inner">');
							echo('<div class="wpb_wrapper"></div>');
						echo('</div>');
					echo('</div>');
										
					echo('<h2>Search Term: ');
					echo esc_html($thequery);
					echo ('</h2>');
					

				
				

					$blockout = "";
					$blockout .= "<div class='row list-row text-left' style='margin-bottom:30px;'>";
					if($qresults){
						
						//start loop
						foreach($qresults as $qresult){

							$listID = $qresult->ld_id;
				
							if ($qresult->md_wp_id) {
							
								$scanImage = $qresult->md_baby_scan_image;
						
								$dlfprods = $wpdb->get_results( "SELECT * FROM wp_tblProductsDB WHERE pd_ld_id = $listID");
								$pd_prod_bought = 0;
								$pd_prod_total = 0;
								foreach ($dlfprods as $dprod){
									if($dprod->pd_bought == 1){
										$pd_prod_bought = $pd_prod_bought + 1;
									}
									$pd_prod_total = $pd_prod_total + 1;
								}
								if ($pd_prod_total==$pd_prod_bought) {
									$pdComplete = 1;
								} else {
									$pdComplete = 0;
								}
								
								$blockout .= "<div class='col-sm-12 col-md-6 col-lg-4'>";
										$blockout .= "<a href='/bumplist/?bump-id=".$qresult->ld_id."'>";
											$blockout .= "<div class='bumplistbox'>";
												$blockout .= "<div class='col-xs-8 col-sm-6 text-col'>";
													$blockout .= "<h3>". stripslashes($qresult->ld_list_name) ."</h3>";		
													$blockout .= "<p>From ".$qresult->md_firstname." ".$qresult->md_familyname . "</p>";
													if ($pdComplete==1)	{
														$blockout .= "<div class='list-complete'><i class='far fa-check-circle'></i> COMPLETED</div>";
													} else {
														$blockout .= "<button href='/bumplist/?bump-id=".$qresult->ld_id."'>View list</button>";
													}
												$blockout .= "</div>";
												
												$blockout .= "<div class='col-xs-4 col-sm-6 text-right'>";
												if($scanImage){
													$blockout .= "<img src='" . $scanImage . "' />";
												} else {
													$blockout .= "<img src='/wp-content/uploads/2021/08/list-placeholder.jpg' />";
												}
												$blockout .= "</div>";
											$blockout .= "</div>";
										$blockout .= "</a>";
								$blockout .= "</div>";
							}
				
						//echo "<div>".esc_html ($qresult->md_firstname)." ".esc_html ($qresult->md_familyname).": ".esc_html ($qresult->ld_list_name)." - ".esc_html ($qresult->md_baby_name). "<a href='/bumplist/?bump-id=".esc_html ($qresult->ld_id)."'>View list</a> ".$pdComplete."</div>";
						}
						//end loop

					} else {
						// If there are no results
						$blockout .= "<p style='text-align:center;'>Sorry, no results found</p>";
					}
					$blockout .= "</div>";

					echo $blockout;

				} else {
					// If there is no query
					echo "<h1>Sorry, that story could not be found</h1>";
				} 	
				?>
				</div>
			</div>
		</div>
		<div class="vc_row-full-width vc_clearfix"></div>
	</main><!-- #main -->
</div><!-- #primary -->

<?php
//get_sidebar();
get_footer();
