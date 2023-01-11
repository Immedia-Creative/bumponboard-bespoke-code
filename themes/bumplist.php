<?php

/**
 /* Template Name: Bumplist Template 
 *
 
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package immedia
 */

$siteLayout = esc_attr(get_option('site_layout'));
if ($siteLayout == 'Normal') {
	get_header();
} elseif ($siteLayout == 'Linear') {
	get_header("linear");
} else {
	get_header();
}

?>

<div id="primary" class="content-area thisisbumplist">
	<main id="main" class="site-main" role="main">

		<?php
		if ($_GET['bump-id']) {
			$thebumpid = $_GET['bump-id'];
			$thepassword = $_GET['thislist'];
			$listStatus = "private";
			global $wpdb;
			$dlfresults = $wpdb->get_row("SELECT * FROM wp_tblListsDB WHERE ld_id = $thebumpid");
			$themumid = $dlfresults->ld_md_id;
			$listProtected = $dlfresults->ld_is_protected;
			$listPassword = $dlfresults->ld_password;
			$listLive = $dlfresults->ld_list_status;

			if ($listLive == 0) {
				// Redirect back to page after update
				header("Location: /item-not-found/");
				exit();
			}

			if ($thepassword == $listPassword) {
				$listStatus = "public";
			} else {

				//echo "list = " . $listStatus;
				if ($listProtected == 1 and $listStatus = "private") {
					//echo "<br />list = " . $listStatus;
					//do password stuff
		?>
					<form action="" method="POST" class="update-form">
						<h2>Please enter the password for this list</h2>
						<input type="password" id="listPassword" name="listPassword" value="">

						<div class="update-wrap">
							<input type="submit" value="View list" name="form_submit">
						</div>

					</form>
					<br />
				<?php
					// Don't run the query unless the form has been submitted
					if (isset($_POST["form_submit"])) {
						$ld_password = $_POST['listPassword'];
						//echo "pw = " . $ld_password;
						//echo "pw = " . $listPassword;
						if ($ld_password == $listPassword) {
							$listStatus = "public";
							// Redirect back to page after update
							//header("Location: /edit-your-list/?listID=$listID&listName=$listName");
							header("Location: /bumplist/?bump-id=$thebumpid&thislist=$ld_password");
							exit();
						} else {
							echo "<h3>Password incorrect, please try again</h3>";
						}
					}
				} else {
					$listStatus = "public";
				}
			}

			if ($listStatus == "public") {

				$dlfmum = $wpdb->get_row("SELECT * FROM wp_tblMumsDB WHERE md_wp_id = $themumid");

				$dlfprods = $wpdb->get_results("SELECT * FROM wp_tblProductsDB WHERE pd_ld_id = $thebumpid");
				?>
				<?php

				//print_r($dlfmum);

				//$familyName = $dlfmum->md_familyname;
				$mumid1 = $dlfmum->md_wp_id;
				$storyID = $dlfmum->md_id;
				$storyTitle = $dlfmum->md_story_title;
				$story = $dlfmum->md_story;

				$scanImage = $dlfmum->md_baby_scan_image;
				$babyName = $dlfmum->md_baby_name;
				$dueDate = $dlfmum->md_baby_due_date;
				$dueDate = strtotime($dueDate);
				$dueDate = date('d/m/Y', $dueDate);

				?>

				<?php if ($storyTitle && $story) { ?>

					<div data-vc-full-width="true" data-vc-full-width-init="true" data-vc-stretch-content="true" class="vc_row wpb_row vc_row-fluid contain-row vc_row-no-padding half-container-cont overflow-visible" style="position: relative; left: -366.5px; box-sizing: border-box; width: 1903px;">
						<div class="col-md-6 half-container">
							<div class="contain-text">
								<h1><?php echo $storyTitle; ?></h1>
								<p class="medium"><?php echo substr($story, 0, 100) . '...'; ?></p>


								<form method="post" action="/our-story/">
									<input type="hidden" name="storyID" value="<?php echo $mumid1; ?>">
									<button type="submit" class="vc_general vc_btn3 vc_btn3-size-md vc_btn3-shape-rounded vc_btn3-style-outline vc_btn3-icon-right vc_btn3-color-pink">See the full story <i class="vc_btn3-icon fas fa-angle-right" aria-hidden="true"></i></button>
								</form>


							</div>
						</div>
						<div class="col-md-6">
							<div class="polaroid-wrapper">
								<div class="polaroid">
									<img src="<?php echo $scanImage; ?>" />
									<h4><?php echo $babyName; ?></br>
										EXPECTED ARRIVAL: <?php echo $dueDate; ?></h4>
								</div>
							</div>
						</div>
					</div>

					<div class="vc_row-full-width vc_clearfix"></div>

					<div class="spacer-wrapper">
						<div class="visible-xs" style="height:35px"></div>
						<div class="visible-sm" style="height:35px"></div>
						<div class="visible-md" style="height:160px"></div>
						<div class="visible-lg" style="height:160px"></div>
					</div>

				<?php } ?>



				<div class="vc_row-full-width vc_clearfix"></div>

				<?php $listName =  $dlfresults->ld_list_name; ?>

				<div data-vc-full-width="true" data-vc-full-width-init="true" data-vc-stretch-content="true" class="vc_row wpb_row vc_row-fluid contain-row vc_row-no-padding half-container-cont overflow-visible" style="position: relative; left: -366.5px; box-sizing: border-box; width: 1903px;">
					<div class="vc_col-sm-12 text-center">
						<div class="contain-text">
							<h2><?php echo stripslashes($listName); ?></h2>
							<p>Becoming a new parent is a lot to prepare for, which is why an extended family to help along the way is so important. But putting your feelings into the perfect present is easier said than done. Bump on Board brings everyone together, so you can stay connected and show you care in all the ways they need it most.</p>


						</div>
					</div>
				</div>

				<div class="vc_row-full-width vc_clearfix"></div>

				<div class="spacer-wrapper">
					<div class="visible-xs" style="height:35px"></div>
					<div class="visible-sm" style="height:35px"></div>
					<div class="visible-md" style="height:35px"></div>
					<div class="visible-lg" style="height:35px"></div>
				</div>

				<div class="vc_row-full-width vc_clearfix"></div>

				<div data-vc-full-width="true" data-vc-full-width-init="true" data-vc-stretch-content="true" class="vc_row wpb_row vc_row-fluid contain-row vc_row-no-padding bump-filter" style="position: relative; left: -366.5px; box-sizing: border-box; width: 1903px;">

					<div class="col-md-3 filter-col">

						<h4>VIEW PRODUCTS</h4>

						<div id="product-category">


							<label class="checkbox">
								<span class="checkbox__input">
									<input type="radio" id="All" name="category" value="All" />
									<span class="checkbox__control">
										<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" aria-hidden="true" focusable="false">
											<path fill="none" stroke="currentColor" stroke-width="3" d="M1.73 12.91l6.37 6.37L22.79 4.59" />
										</svg>
									</span>
								</span>
								<label for="All"> All</label>
							</label>

							<label class="checkbox">
								<span class="checkbox__input">
									<input type="radio" id="Available" name="category" value="Available" />
									<span class="checkbox__control">
										<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" aria-hidden="true" focusable="false">
											<path fill="none" stroke="currentColor" stroke-width="3" d="M1.73 12.91l6.37 6.37L22.79 4.59" />
										</svg>
									</span>
								</span>
								<label for="Available"> Available</label>
							</label>

							<label class="checkbox">
								<span class="checkbox__input">
									<input type="radio" id="Purchased" name="category" value="Purchased" />
									<span class="checkbox__control">
										<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" aria-hidden="true" focusable="false">
											<path fill="none" stroke="currentColor" stroke-width="3" d="M1.73 12.91l6.37 6.37L22.79 4.59" />
										</svg>
									</span>
								</span>
								<label for="Purchased"> Purchased</label>
							</label>

						</div>

						<h4>PRICE RANGE</h4>
						<div id="product-price">


							<label class="checkbox">
								<span class="checkbox__input">
									<input type="checkbox" id="price1" name="price1" value="price1" />
									<span class="checkbox__control">
										<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" aria-hidden="true" focusable="false">
											<path fill="none" stroke="currentColor" stroke-width="3" d="M1.73 12.91l6.37 6.37L22.79 4.59" />
										</svg>
									</span>
								</span>
								<label for="price1"> £1 - £25</label>
							</label>

							<label class="checkbox">
								<span class="checkbox__input">
									<input type="checkbox" id="price2" name="price2" value="price2" />
									<span class="checkbox__control">
										<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" aria-hidden="true" focusable="false">
											<path fill="none" stroke="currentColor" stroke-width="3" d="M1.73 12.91l6.37 6.37L22.79 4.59" />
										</svg>
									</span>
								</span>
								<label for="price2"> £25 - £50</label>
							</label>

							<label class="checkbox">
								<span class="checkbox__input">
									<input type="checkbox" id="price3" name="price3" value="price3" />
									<span class="checkbox__control">
										<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" aria-hidden="true" focusable="false">
											<path fill="none" stroke="currentColor" stroke-width="3" d="M1.73 12.91l6.37 6.37L22.79 4.59" />
										</svg>
									</span>
								</span>
								<label for="price3"> £50 - £100</label>
							</label>

							<label class="checkbox">
								<span class="checkbox__input">
									<input type="checkbox" id="price4" name="price4" value="price4" />
									<span class="checkbox__control">
										<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" aria-hidden="true" focusable="false">
											<path fill="none" stroke="currentColor" stroke-width="3" d="M1.73 12.91l6.37 6.37L22.79 4.59" />
										</svg>
									</span>
								</span>
								<label for="price4"> £100+</label>
							</label>

						</div>

						<?php //print_r($dlfprods); 
						?>

					</div>

					<div class="col-md-9">

						<div id="myfilter"></div>

						<div id="product-filter-response" class="masonry">
							<?PHP


							//MAIN loop through each product
							foreach ($dlfprods as $dprod) {

								//display purchased products like this
								if ($dprod->pd_bought == 1) {

									echo "<div class='item'>";
									echo "<div class='product-box purchased'>";
									if ($dprod->pd_prod_image) {
										echo ("<div class='img-cont' align='center'>");
										echo "<div class='purchase-overlay'></div>";
										echo ("<img src='" . $dprod->pd_prod_image . "' />");
										echo ("</div>");
									}
									echo ("<div class='product-content'>");

									echo ("<h3>" . $dprod->pd_prod_title . "</h3>");
									//check if already bought and tag accordingly

									echo (" <h4>PURCHASED</h4>");

									echo "</div>";

									echo "</div>";
									echo "</div>";
								} else {
									//else display all available  products like this
									echo "<div class='item'>";
									echo "<div class='product-box'>";
									//display all products in this list
									if ($dprod->pd_prod_image) {
										echo ("<div class='img-cont' align='center'>");
										echo ("<img src='" . $dprod->pd_prod_image . "' />");
										echo ("</div>");
									}

									echo ("<div class='product-content'>");

									echo ("<h3>" . $dprod->pd_prod_title . "</h3>");


									$parse = parse_url($dprod->pd_prod_url1);

									echo ("<div class='medium'>Available From:</div>");
									echo ("<a class='available-from' href='#' data-toggle='modal' data-target='#host-" . $dprod->pd_id . "'>" . $parse['host'] . " - £" . $dprod->pd_price . "</a>");
									//echo ("<a class='available-from' href='#' data-toggle='modal' data-target='#host-" . $dprod->pd_id . "'>".$parse['host']." - £" . $dprod->pd_price . "</a>");

									echo ("<div class='gift-wrapper'>");
									//echo ('<a href="#" class="secondary-button"><i class="fas fa-gift"></i> Gift this</a>');
									echo ('<a href="#" class="secondary-button" data-toggle="modal" data-target="#host-' . $dprod->pd_id . '"><i class="fas fa-gift"></i> Gift this</a>');

									echo ('<a href="#" class="mark-gifted" data-toggle="modal" data-target="#gift_this-' . $dprod->pd_id . '">Mark as gifted</a>');
									//echo ('<a href="#" class="secondary-button"><i class="fas fa-gifts"></i> Group gift</a>');
									echo "</div>";

									echo "</div>";

									echo "</div>";
									echo "</div>"; ?>

									<div class="modal fade" id="<?php echo "host-" . $dprod->pd_id; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" data-backdrop="static" data-keyboard="false" aria-hidden="true">
										<div class="modal-dialog modal-dialog-centered" role="document">
											<div class="modal-content">

												<div class="modal-body">

													<h2 class="modal-title" id="exampleModalLongTitle">Gift This</h2>

													<p>Thanks for pledging to buy this gift!</p>

													<h4>To complete your purchase, follow these steps:</h4>

													<ol>
														<li>Click ‘continue’ to be taken to the payment page of your chosen website (or just

															<?php

															$parse = parse_url($dprod->pd_prod_url1);
															echo ("<a class='available-from' target='_blank' href='" . $dprod->pd_prod_url1 . "'>click here</a>");
															?>)</li>

														<li>Once you’ve placed an order, come back to this page and select the "mark as gifted" option to let other gift-givers know.</li>
													</ol>

													<div class="modal-control">
														<?php echo ("<a class='vc_general vc_btn3 vc_btn3-size-md vc_btn3-shape-rounded vc_btn3-style-classic vc_btn3-color-pink' target='_blank' href='" . $dprod->pd_prod_url1 . "'>Continue</a>"); ?>
														<a href="#" data-dismiss="modal">Cancel</a>
													</div>

												</div>



											</div>
										</div>
									</div>

									<div class="modal fade" id="<?php echo "gift_this-" . $dprod->pd_id; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" data-backdrop="static" data-keyboard="false" aria-hidden="true">
										<div class="modal-dialog modal-dialog-centered" role="document">
											<div class="modal-content">

												<div class="modal-body">

													<h2 class="modal-title" id="exampleModalLongTitle">Mark as Gifted</h2>

													<form name="gift_this_form" id="gift_this_form" action="/wp-content/themes/immedia-child-theme/gifted-sender.php" method="POST">

														<p>Thanks for buying the <strong><?php echo $dprod->pd_prod_title; ?></strong></p>

														<?php if ($dprod->pd_prod_image) {
															echo ("<div class='img-cont' align='center'>");
															echo ("<img src='" . $dprod->pd_prod_image . "' />");
															echo ("</div>");
														} ?>

														<p>Please fill your details in below so we can let the list owner know you’ve got it for them, and to stop anyone else from buying it.</p>

														<p class="gift_this_name">
															<label for="gift_name">Full Name</label>
															<input id="gift_name" name="name" type="text" class="input" value="" size="20" placeholder="Full Name" required>
														</p>
														<p class="gift_this_email">
															<label for="gift_email">Email</label>
															<input id="gift_email" type="email" name="email" class="input" value="" size="20" placeholder="Email" required>
														</p>

														<p class=" gift_this_message">
															<label for="gift_message">Message (200 Characters)</label>
															<textarea id="gift_message" name="message" placeholder="Message"></textarea>
														</p>
														<input type="hidden" name="bumpid" value="<?php echo ($_GET['bump-id']); ?>" />
														<input type="hidden" name="productid" value="<?php echo ($dprod->pd_id); ?>" />
														<input type="hidden" name="mumid" value="<?php echo ($themumid); ?>" />
														<input type="hidden" name="productname" value="<?php echo ($dprod->pd_prod_title); ?>" />
														<input type="hidden" name="listname" value="<?php echo ($dlfresults->ld_list_name); ?>" />
														<div class="modal-control">
															<input type="submit" name="wp-submit" id="wp-submit" class="button button-primary" value="Gift This">
															<a href="#" data-dismiss="modal">Cancel</a>
														</div>

													</form>



												</div>

											</div>
										</div>
									</div>


							<?php }
							} ?>

						</div>

					</div>

				<?php }
		} else { ?>
				<h1>Sorry, that list could not be found</h1>
			<?PHP } ?>

				</div>

				<div class="vc_row-full-width vc_clearfix"></div>



				<p class="hidden">these results are generated by the bumplist.php template</p>
	</main><!-- #main -->
</div><!-- #primary -->


<?php
//get_sidebar();
get_footer();
