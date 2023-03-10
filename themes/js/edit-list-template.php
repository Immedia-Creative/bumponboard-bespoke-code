<?php
 /* Template Name: edit-list-template
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
}
// get list name?
$listName = $_GET["listName"];
$listID = $_GET["listID"];
//echo $listID;
global $current_user; wp_get_current_user();
?>
<div id="primary" class="content-area">
	<main id="main" class="site-main" role="main">

	

		<?php
		if ( is_user_logged_in() ) {
			global $wpdb;

			echo "<h1>".stripslashes($listName)."</h1>";					
			echo "<h3>Add an item to your list</h3>";

			// The form below add a product to the list
			?>
			<form action="" method="POST">
					<input type="text" id="productName" name="productName" value="" placeholder="Name your product" required>
					<label for="productPrice">£</label>
					<input type="number" step="any" id="productPrice" name="productPrice" placeholder="Price of product" value="" required>
					<input type="text" id="productURL" name="productURL" value="" placeholder="Web address of product" required>
					<input type="text" id="imageURL" name="imageURL" value="" placeholder="Web address of image" required>
			<input type="submit" value="Add item" name="form_submit">
			</form>
			&nbsp;<br />&nbsp;

			<?php
				// Don't run the insert query below unless the form has been submitted
				if(isset($_POST["form_submit"])) {
				$tablename = $wpdb->prefix.'tblProductsDB';
				$wpdb->insert( $tablename, array(
					'pd_ld_id' => $listID,
					'pd_prod_title' => $_POST['productName'],
					'pd_price' => $_POST['productPrice'],
					'pd_prod_url1' => $_POST['productURL'],
					'pd_prod_image' => $_POST['imageURL'] ),
					array( '%d', '%s', '%d', '%s', '%s' )
				);
			}
								
			$dlfprods = $wpdb->get_results( "SELECT * FROM wp_tblProductsDB WHERE pd_ld_id = $listID");
// echo stripslashes($str);
			foreach ($dlfprods as $dprod){
				echo "<div class=''>";
					echo "<div class=''>";
						// we need to add 'stripslashes' below, or else if there is an apostrophe in the name, we get backslashes in the inserted value
						echo stripslashes($dprod->pd_prod_title);
					echo "</div>";
					echo "<div class=''>";
						echo "<img style='width: 100px;height: 100px;' src='".$dprod->pd_prod_image."'/>";
					echo "</div>";
					echo "<div class=''>";
						echo "<a href='/edit-your-list/product-update/?listID=".$dprod->pd_ld_id."&productID=".$dprod->pd_id."&action=update'>Update</a>";
					echo "</div>";
					echo "<div class=''>";
						echo "<a href='/edit-your-list/product-update/?listID=".$dprod->pd_ld_id."&productID=".$dprod->pd_id."&action=delete' onclick='showDeleteAlert()'>Delete</a>";
						//echo "<a href='' onclick='showDeleteAlert()')>Delete</a>";
					echo "</div>";
				echo "</div>";
			}
		}
		echo "This page is generated by the edit-list-template";
		?>
	</main><!-- #main -->
</div><!-- #primary -->
<?php
//get_sidebar();
get_footer();