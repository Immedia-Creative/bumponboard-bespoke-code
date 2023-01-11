<?php
/* Template Name: your-account-template
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
} ?>

<div id="primary" class="content-area">
	<main id="main" class="site-main" role="main">

		<?php global $current_user;
		wp_get_current_user(); ?>
		<?php if (is_user_logged_in()) {
			//echo 'Username: ' . $current_user->user_login . "\n"; 
			//echo 'User display name: ' . $current_user->display_name . "\n"; 
			$username1 = $current_user->user_login;
			$mumid1 = $current_user->ID;

			include_once("wp-config.php");
			include_once("wp-includes/wp-db.php");

			global $wpdb;
			// open tblMumsDB and see if the md_wp_id is greater than 0, if not INSERT $current_user->ID into table

			$table_name = $wpdb->prefix . "tblMumsDB";
			$theResult = $wpdb->get_row("SELECT md_wp_id FROM $table_name WHERE md_wp_username = '" . $username1 . "'");
			if ($theResult) {
				$mumIDfound = $theResult->md_wp_id;
			} else {
				$mumIDfound = 0;
			}
			//echo $mumIDfound."<br />";

			if ($mumIDfound < 1) {
				//echo "updateDB<br />";
				// this adds the prefix which is set by the user upon installation of wordpress
				$table_name = $wpdb->prefix . "tblMumsDB";
				$wpdb->query("UPDATE $table_name SET md_wp_id='.$mumid1.' WHERE md_wp_username='" . $username1 . "'");
			} else {
				//echo "DB OK<br />";
			}

			//connect to database
			//$dlfresults = $wpdb->get_results( "SELECT * FROM wp_tblListsDB WHERE (ld_list_status = 1 AND ld_md_id = $mumid1)");					
			$dlfresults = $wpdb->get_results("SELECT * FROM wp_tblListsDB WHERE (ld_md_id = $mumid1) ORDER BY ld_id DESC");

		?>

			<div class="row">
				<div class="col-md-6">
					<h1 class="h2">My Lists</h1>
				</div>
				<div class="col-md-6 text-right">
					<a href="/list/" class="secondary-button">Create new list</a>
				</div>
			</div>


			<?php
			if ($dlfresults) {
				$countID = '1';
				foreach ($dlfresults as $dlfblock) {
					$countID = $countID + 1;

					$blockout = "";
					$blockout .= "<div class='owl-carousel list-row'>";

					$listID = $dlfblock->ld_id;
					$listName = $dlfblock->ld_list_name;
					$listStatus = $dlfblock->ld_list_status;
					$listPassword = $dlfblock->ld_password;
					$listProtected = $dlfblock->ld_is_protected;

					$dlfprods = $wpdb->get_results("SELECT * FROM wp_tblProductsDB WHERE pd_ld_id = $listID ORDER BY pd_id DESC");
					//$dlfprods = $wpdb->get_results( "SELECT * FROM wp_tblProductsDB WHERE pd_ld_id = 37");

					//$blockout .= "list ID is ".$listID;

					$pd_prod_bought = 0;
					$pd_prod_total = 0;
					$i = 0;
					foreach ($dlfprods as $dprod) {
						//print_r($dprod);
						if ($dprod->pd_bought == 1) {
							$pd_prod_bought = $pd_prod_bought + 1;
						}
						$pd_prod_total = $pd_prod_total + 1;

						//display all products in this list			


						//$blockout .= "<div class='slide' data-slide-index='". $i ."'>";
						$blockout .= "<div data-slide-index='" . $i . "'>";

						$blockout .= "<div class='slide-inner'>";
						if ($dprod->pd_bought == 1) {
							if ($dprod->pd_prod_image) {
								$blockout .= "<div class='product-image bought' style='background-image:url(" . $dprod->pd_prod_image . ");' ></div>";
							} else {

								$str = $dprod->pd_prod_title;
								if (strlen($str) > 50) {
									$str = substr($str, 0, 50) . '...';
								}
								$blockout .= "<div class='product-image prod_title bought' ><p>" . $str . "</p></div>";
							}
						} else {
							$blockout .= "<a target='_blank' href='" . $dprod->pd_prod_url1 . "'>";
							if ($dprod->pd_prod_image) {
								$blockout .= "<div class='product-image' style='background-image:url(" . $dprod->pd_prod_image . ");' ></div>";
							} else {

								$str = $dprod->pd_prod_title;
								if (strlen($str) > 50) {
									$str = substr($str, 0, 50) . '...';
								}
								$blockout .= "<div class='product-image prod_title'><p>" . $str . "</p></div>";
							}
							$blockout .= "</a>";
						}

						$blockout .= "</div>";
						$blockout .= "</div>";
						$i++;
					}

					$blockout .= "</div>";
			?>
					<div class="white-block">
						<div class="row">
							<div class="col-md-6 list-info">
								<?php if ($listName) { ?>
									<h3><?php echo stripslashes($listName); ?></h3>
								<?php } ?>


								<?php if ($listStatus == 1) { ?>
									<form id="frmToggleLive<?php echo $listID; ?>">
										<input type="hidden" id="resultStatus<?php echo $listID; ?>" class="statusOn" name="status" value="0">
										<input type="hidden" name="list_id" value="<?php echo $listID; ?>">
										<button name="status" id="result_msg<?php echo $listID; ?>" class="live-tag" value="0" type="button">Live</button>
									</form>

								<?php } else { ?>
									<form id="frmToggleLive<?php echo $listID; ?>">
										<input type="hidden" id="resultStatus<?php echo $listID; ?>" class="statusOff" name="status" value="1">
										<input type="hidden" name="list_id" value="<?php echo $listID; ?>">
										<button name="status" id="result_msg<?php echo $listID; ?>" class="draft-tag" value="1" type="button">Draft</button>
									</form>
								<?php } ?>


							</div>
							<div class="col-md-6 text-right medium list-edit">
								<?php echo $pd_prod_bought . "/" . $pd_prod_total . " bought"; ?>
								<a class='available-from' title="Share This" href='#' data-toggle='modal' data-target='#shareList-<?php echo $listID; ?>'><i class="far fa-share-square"></i></a>
								<a href="/edit-your-list/?listID=<?php echo $listID; ?>&listName=<?php echo stripslashes($listName); ?>" title="Edit List"><i class="far fa-edit"></i></a>
							</div>
						</div>
						<div class="spacer-wrapper">
							<div class="visible-xs" style="height:15px">
							</div>
							<div class="visible-sm" style="height:15px">
							</div>
							<div class="visible-md" style="height:15px">
							</div>
							<div class="visible-lg" style="height:15px">
							</div>
						</div>

						<?php
						echo $blockout;
						$blockout = "";
						?>
					</div>

					<div class="share-modal modal fade" id="<?php echo "shareList-" . $listID; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
						<div class="modal-dialog modal-dialog-centered" role="document">
							<div class="modal-content">

								<div class="modal-body">

									<h2 class="modal-title" id="exampleModalLongTitle">Share your list</h2>

									<?php // echo "count id = ".$countID; 
									?>

									<?php // echo "listid = ".$listID; 

									if ($listProtected == 1) {
									?>
										<div id="example-target1<?php echo $listID; ?>" class="example">
											<div class="input-group">
												<p>Your password:</p>
												<input size="60" id="foo1<?php echo $listID; ?>" type="text" value="<?php echo $listPassword; ?>">
												<span class="input-group-button">
													<button id="button1<?php echo $listID; ?>" class="test" type="button" data-clipboard-demo="" data-clipboard-target="#foo1<?php echo $listID; ?>">
														<img class="clippy" src="/wp-content/uploads/2021/10/clippy.svg" width="13" alt="Copy to clipboard">
													</button>
												</span>
											</div>
										</div>
									<?php
									}
									?>
									<br />&nbsp;<br />
									<div id="example-target2<?php echo $listID; ?>" class="example">
										<div class="input-group">
											<p>Your list link:</p>
											<input size="60" id="foo2<?php echo $listID; ?>" type="text" value="/bumplist/?bump-id=<?php echo $listID; ?>">
											<span class="input-group-button">
												<button id="button2<?php echo $listID; ?>" class="test" type="button" data-clipboard-demo="" data-clipboard-target="#foo2<?php echo $listID; ?>">
													<img class="clippy" src="/wp-content/uploads/2021/10/clippy.svg" width="13" alt="Copy to clipboard">
												</button>
											</span>
										</div>
									</div>



									<!-- old copy to clipboard code below -->
									<!-- The text field -->
									<!--<input size="60" type="text" value="https://www.bumponboard.co.uk/bumplist/?bump-id=<?php echo $listID; ?>" id="inputURL<?php echo $countID; ?>">-->

									<!--<input size="60" type="text" value="https://www.bumponboard.co.uk/bumplist/?bump-id=<?php echo $listID; ?>" id="inputURL<?php echo $listID; ?>">-->

									<!-- The button used to copy the text -->

									<!--<div id="tag-id<?php //echo $listID; 
														?>"></div>-->

									<!--
									<script>
										function copyURLFunction(btn) {
											/* Get the text field */
											var copyTextID = btn.id;
											var copyText = document.getElementById("inputURL" + copyTextID);

											/* Select the text field */
											copyText.select();
											copyText.setSelectionRange(0, 99999); /* For mobile devices */

											/* Copy the text inside the text field */
											document.execCommand("copy");

											/* Alert the copied text */
											//alert(btn.id);
											//alert('tag-id' + copyTextID);
											//alert("Copied the web address: " + copyText.value);
											document.getElementById('tag-id' + copyTextID).innerHTML = '<p>Copied! You can now paste this into your browser.</p>';
										}

										function confirmCopyClear(btn) {
											// This function removes the copied confirmation message when the modal is closed.
											var copyTextID = btn.id;
											//alert('tag-id' + copyTextID);
											document.getElementById('tag-id' + copyTextID).innerHTML = '<p></p>';
										}
									</script>
									-->

									<div class="modal-control">
										<br />
										<!--<button id="<?php echo $listID; ?>" class="vc_general vc_btn3 vc_btn3-size-md vc_btn3-shape-rounded vc_btn3-style-classic vc_btn3-color-pink" onclick="copyURLFunction(this)">Copy web address</button>-->
										<a id="<?php echo $listID; ?>" data-dismiss="modal" onclick="confirmCopyClear(this)">Close</a>
									</div>

								</div>
							</div>
						</div>
					</div>

					<br />&nbsp;<br />
				<?php
				}
				?>

				<p class="hidden">these results from My Lists (Your Account - your-account-template) page</p>

			<?php
			} else {
				// If there are no lists
			?>

				<!--
				<div class="row">
					<div class="col-md-6">
						<h1 class="h2">My Lists</h1>
					</div>	
				</div>
				-->

				<div class="row">
					<div class="col-md-6">

						<a href="/list/" class="create-list">
							<i class="fas fa-plus"></i>
							<div class="create-text">Create your first wish list</div>
						</a>

					</div>
				</div>

			<?php }
		} else {
			?><p>Please login</p><?php
									wp_loginout();
								}
									?>


		<script>
			//jQuery('[id^=frmToggleLive]').submit(function() {
			jQuery('[id^=frmToggleLive]').on('click', function(event) {

				event.preventDefault();
				jQuery('#result_msg').html('');
				var link = "<?php echo admin_url('admin-ajax.php') ?>";

				var user_id = $(this).closest("form").attr('id');

				var form = jQuery('#' + user_id).serialize();
				var formData = new FormData;
				formData.append('action', 'toggle_live');
				formData.append('toggle_live', form);
				jQuery.ajax({
					url: link,
					data: formData,
					processData: false,
					contentType: false,
					type: 'post',
					success: function(result) {

						if (result.data['status'] == 0) {
							jQuery('#result_msg' + result.data['list_id']).addClass('draft-tag').removeClass('live-tag').text("Draft").addClass('statusData').val("1");
							jQuery('#resultStatus' + result.data['list_id']).addClass('statusOff').val("1").removeClass('statusOn');
						} else if (result.data['status'] == 1) {
							jQuery('#result_msg' + result.data['list_id']).addClass('live-tag').removeClass('draft-tag').text("Live").addClass('statusData').val("0");
							jQuery('#resultStatus' + result.data['list_id']).addClass('statusOn').val("0").removeClass('statusOff');
						}
					},
				});
			});
		</script>

		<script type="text/javascript">
			//<![CDATA[


			$('.test').tooltip({
				trigger: 'click',
				placement: 'bottom'
			});

			function setTooltip(btn, message) {
				btn.tooltip('hide')
					.attr('data-original-title', message)
					.tooltip('show');
			}

			function hideTooltip(btn) {
				setTimeout(function() {
					btn.tooltip('hide');
				}, 2000);
			}

			// Clipboard

			var clipboard = new Clipboard('.test');

			clipboard.on('success', function(e) {
				var btn = $(e.trigger);
				setTooltip(btn, 'Copied!');
				hideTooltip(btn);
			});


			//]]>
		</script>

	</main><!-- #main -->
</div><!-- #primary -->

<?php
//get_sidebar();
get_footer();
