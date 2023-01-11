<?php
/* Template Name: edit-list-template
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
// get list name?
$listName = $_GET["listName"];
$listName = stripslashes($listName);
$listID = $_GET["listID"];
//echo $listID;
global $current_user;
wp_get_current_user();
?>
<div id="primary" class="content-area">
	<main id="main" class="site-main" role="main">

		<?php
		if (is_user_logged_in()) {
			$mumid1 = $current_user->ID;
			global $wpdb;

			//connect to database				
			$theResult = $wpdb->get_row("SELECT * FROM wp_tblListsDB WHERE (ld_id = $listID)");
			$listStatus = $theResult->ld_list_status;
			$listName = $theResult->ld_list_name;
			$listName = stripslashes($listName);

			echo "<h1>" . $listName . "</h1>";
			echo "<div class='edit-list-options'>";


			if ($listStatus == 1) { ?>
				<form style="display:inline-block;" id="frmToggleLive<?php echo $listID; ?>">
					<input type="hidden" id="resultStatus<?php echo $listID; ?>" class="statusOn" name="status" value="0">
					<input type="hidden" name="list_id" value="<?php echo $listID; ?>">
					<button name="status" id="result_msg<?php echo $listID; ?>" class="live-tag" value="0" type="button">Live</button>
				</form>

			<?php } else { ?>
				<form style="display:inline-block;" id="frmToggleLive<?php echo $listID; ?>">
					<input type="hidden" id="resultStatus<?php echo $listID; ?>" class="statusOff" name="status" value="1">
					<input type="hidden" name="list_id" value="<?php echo $listID; ?>">
					<button name="status" id="result_msg<?php echo $listID; ?>" class="draft-tag" value="1" type="button">Draft</button>
				</form>
			<?php }

			echo "<a href='/edit-your-list/list-update/?listID=" . $listID . "&listName=" . stripslashes($listName) . "&action=update'>Edit list name</a>";
			echo "&nbsp;";
			echo "<a href='/edit-your-list/list-update/?listID=" . $listID . "&listName=" . stripslashes($listName) . "&action=delete' onclick='return confirm(\"Are you sure to delete?\")'>Delete list</a>";
			echo "&nbsp;";
			echo "<a href='/edit-your-list/password-protect/?listID=" . $listID . "&listName=" . stripslashes($listName) . "'>Make Private</a>";

			echo "</div>";


			// The form below toggles live/draft on or off

			echo "<div class='imgResults'>";

			echo "<h3>Add an item to your list</h3>";
			echo "<p>Or try our in-browser <a href='/gift-picker/'>gift picker</a>.</p>";
			// The form below add a product to the list
			?>
			<form action="" method="POST" class="edit-list-form">
				<input type="text" id="productName" name="productName" value="" placeholder="Name your product" required>
				<span class="price-cont">
					<input type="text" step="any" id="productPrice" name="productPrice" placeholder="Price of product" value="" required>
				</span>
				<input type="text" id="productURL" name="productURL" value="" placeholder="Web address of product" required>
				<!--<input type="text" id="imageURL" name="imageURL" value="" placeholder="Web address of image" required>-->
				<button type="button" onclick="loadimages()">Load Images</button>
				<div id="image-picker-results">
					<!-- //ajax results will appear here //-->
				</div>

			</form>

			<script>
				function loadimages() {

					document.getElementById("image-picker-results").innerHTML = "<p>Looking for Images.</p>";

					let inputVal = document.getElementById("productURL").value;
					// Displaying the value
					var params = inputVal;
					var delayInMilliseconds = 2000;
					var xhttp = new XMLHttpRequest();
					xhttp.onreadystatechange = function() {
						if (this.readyState == 4 && this.status == 200) {
							document.getElementById("image-picker-results").innerHTML =
								this.responseText;
							//console.log('Log: ', xhttp.status);
						} else if (this.readyState == 4 && this.status != 200) {
							//setTimeout(function() {
							document.getElementById("image-picker-results").innerHTML = "<p>Sorry, it has not been possible to download images from this website. You can either go back and try the <a href='/gift-picker/'>gift picker</a>, or contine and add the item without an image. You can still come back and add an image manually by clicking the EDIT button on the added item. </p><input type='submit' value='Continue' name='form_submit'>";
							//}, delayInMilliseconds);
							//console.log('Log: ', xhttp.status);
						}
					};
					xhttp.open("GET", "/wp-content/themes/immedia-child-theme/ajax_test.php?url=" + params, true);
					xhttp.send();
				}
			</script>

			<?php

			// Don't run the insert query below unless the form has been submitted
			if (isset($_POST["form_submit"])) {
				$tablename = $wpdb->prefix . 'tblProductsDB';
				$wpdb->insert(
					$tablename,
					array(
						'pd_user_id' => $mumid1,
						'pd_ld_id' => $listID,
						'pd_prod_title' => $_POST['productName'],
						'pd_price' => $_POST['productPrice'],
						'pd_prod_url1' => $_POST['productURL'],
						'pd_prod_image' => $_POST['imageURL']
					),
					array('%d', '%d', '%s', '%s', '%s', '%s')
				);
			} ?>

</div>

<?php

			$dlfprods = $wpdb->get_results("SELECT * FROM wp_tblProductsDB WHERE pd_ld_id = $listID ORDER BY pd_id DESC");

			echo "<div class='masonry'>";

			foreach ($dlfprods as $dprod) {


				if ($dprod->pd_bought == 1) {
					echo "<div class='item'>";
					echo "<div class='product-box purchased'>";

					//display all products in this list
					if ($dprod->pd_prod_image) {
						echo ("<div class='img-cont' align='center'>");
						echo "<div class='purchase-overlay'></div>";
						echo ("<img style='width: 100%;' src='" . $dprod->pd_prod_image . "' />");
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

					echo "<div class='item'>";
					echo "<div class='product-box'>";
					//display all products in this list
					if ($dprod->pd_prod_image) {
						echo ("<div class='img-cont' align='center'>");
						echo ("<img style='width: 100%;' src='" . $dprod->pd_prod_image . "' />");
						echo ("</div>");
					}

					echo ("<div class='product-content'>");

					echo ("<h3>" . $dprod->pd_prod_title . "</h3>");
					//check if already bought and tag accordingly

					$parse = parse_url($dprod->pd_prod_url1);

					echo ("<div class='medium'>Available From:</div>");
					echo ("<a class='available-from' target='_blank' href='" . $dprod->pd_prod_url1 . "'>" . $parse['host'] . " - £" . $dprod->pd_price . "</a>");

					echo ("<div class='gift-wrapper'>");
					echo "<a href='/edit-your-list/product-update/?listID=" . $dprod->pd_ld_id . "&productID=" . $dprod->pd_id . "&action=update'>Edit</a>";
					echo "<div class=''>";
					echo "<a href='/edit-your-list/product-update/?listID=" . $dprod->pd_ld_id . "&productID=" . $dprod->pd_id . "&action=delete' onclick='return confirm(\"Are you sure to delete?\")'>Delete</a>";
					echo "</div>";
					echo "</div>";

					echo "</div>";

					echo "</div>";
					echo "</div>"; ?>


<?php }
			}

			echo "</div>";

			echo '<div class="spacer-wrapper">';
			echo '<div class="visible-xs" style="height:30px"></div>';
			echo '<div class="visible-sm" style="height:30px"></div>';
			echo '<div class="visible-md" style="height:30px"></div>';
			echo '<div class="visible-lg" style="height:30px"></div>';
			echo '</div>';
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
<p class="hidden">these results are generated by the edit-list-template.php template</p>
</main><!-- #main -->
</div><!-- #primary -->
<?php
//get_sidebar();
get_footer();
