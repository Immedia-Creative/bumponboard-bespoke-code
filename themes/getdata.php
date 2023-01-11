<?PHP
function check_input($data)
{
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	return $data;
}

if ($_REQUEST["ajax"]) {
	include("../../../wp-load.php");
}
$category = "";
if ($_REQUEST["category"]) {
	$category = check_input($_REQUEST["category"]);
}
//Change string to array
$categoryArray = [];
$categoryArray = explode(',', $category);

$price = "";
if ($_REQUEST["price"]) {
	$price = check_input($_REQUEST["price"]);
}
//Change string to array
$priceArray = [];
$priceArray = explode(',', $price);

$bumpID = "";
if ($_REQUEST["bumpID"]) {
	$bumpID = check_input($_REQUEST["bumpID"]);
}

//Used for testing PHP variables

/*
echo  '<div>';
echo '<div>PHP Variables</div>';
echo '<div>category value is ' . $category. '</div>';
echo '<div>price value is ' . $price . '</div>';
echo '<div>bumpID value is ' . $bumpID . '</div>';
echo  '</div>';
*/

//sanitize
if (strlen($category) >= 100) {
	echo ("Error: Sorry, category not found");
	die;
}
if (strlen($price) >= 100) {
	echo ("Error: Sorry, price not found");
	die;
}

$thebumpid = $bumpID;
global $wpdb;
$dlfresults = $wpdb->get_row("SELECT * FROM wp_tblListsDB WHERE ld_id = $thebumpid");

//Functions to find price range if it is selected
if (($priceArray[0] != '') or ($categoryArray[0] != '')) {

	//Create array for holding actual price values
	$allPrices = [];

	// Assign prices to newly defined array based on checkbox values
	if (in_array("price1", $priceArray)) {
		array_push($allPrices, "1", "25");
	}
	if (in_array("price2", $priceArray)) {
		array_push($allPrices, "25", "50");
	}
	if (in_array("price3", $priceArray)) {
		array_push($allPrices, "50", "100");
	}
	if (in_array("price4", $priceArray)) {
		array_push($allPrices, "100", "9999");
	}


	$min = min($allPrices);
	$max = max($allPrices);

	if ((!$min) and (!$max)) {
		$min = 1;
		$max = 9999;
	}

	if ($category == "Available") {
		//echo '<div>available</div>';
		//echo '<br />'. $min;
		//echo '<br />'. $max;
		$dlfprods = $wpdb->get_results("SELECT * FROM wp_tblProductsDB WHERE pd_ld_id = $thebumpid AND pd_bought = 0 AND pd_price BETWEEN $min AND $max");
	} elseif ($category == "Purchased") {
		//echo '<div>purchased</div>';
		//echo '<br />'. $min;
		//echo '<br />'. $max;
		$dlfprods = $wpdb->get_results("SELECT * FROM wp_tblProductsDB WHERE pd_ld_id = $thebumpid AND pd_bought = 1 AND pd_price BETWEEN $min AND $max");
	} else {
		//echo '<div>all or others</div>';
		//echo '<br />'. $min;
		//echo '<br />'. $max;
		$dlfprods = $wpdb->get_results("SELECT * FROM wp_tblProductsDB WHERE pd_ld_id = $thebumpid AND pd_price BETWEEN $min AND $max");
	}
} else {

	$dlfprods = $wpdb->get_results("SELECT * FROM wp_tblProductsDB WHERE pd_ld_id = $thebumpid");
}



$prodCount = 0;
foreach ($dlfprods as $dprod) {
	$prodCount++;

	if ($dprod->pd_bought == 1) {
		echo "<div class='item'>";
		echo "<div class='product-box purchased'>";

		//display all products in this list
		if ($dprod->pd_prod_image) {
			echo ("<div class='img-cont'>");
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
			echo ("<div class='img-cont'>");
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
								echo ("<div class='img-cont'>");
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
}
//echo $prodCount;
if ($prodCount < 1) {
	echo "<h3>There are no results matching your search. Please try again.</h3>";
}
