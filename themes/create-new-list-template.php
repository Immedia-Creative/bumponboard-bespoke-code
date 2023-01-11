<?php
 /* Template Name: create-new-list-template
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

global $current_user; wp_get_current_user();

$timeSubmitted = '';$timeIsNow = '';
?>
<div id="primary" class="content-area">
	<main id="main" class="site-main" role="main">
		<?php
		if ( is_user_logged_in() ) {
		// Get the user ID
		$mumid1 = $current_user->ID;
		global $wpdb;
		
		// The form below will start a new list
		?>
			<h2>Create your list</h2>
			
			<h3>What do you want to call this list?</h3>
			
			<form class="create-list" action="" method="POST">
					<label for="listname">Name your list</label>
					<input type="text" id="listName" name="listName" value="">
					<input type="hidden" id="mumID" name="mumID" placeholder="Name your list" value="<?php echo $mumid1; ?>">
					<input type="hidden" id="submitTime" name="submitTime" value="<?php echo $timeIsNow; ?>">
			<input type="submit" value="Submit" name="form_submit">
			</form>

		<?php
			// Don't run the insert query below unless the form has been submitted
			if(isset($_POST["form_submit"])) {
			$timeIsNow = current_time('timestamp');
			$tablename = $wpdb->prefix.'tblListsDB';
			$wpdb->insert( $tablename, array(
				'ld_list_name' => $_POST['listName'],
				'ld_md_id' => $_POST['mumID'],
				'ld_time_created' => $timeIsNow ),
				array( '%s', '%d', '%d' )
			);
			
			// We want the ID of the list we just created, but we need to allow for database lag, just in case the select query below runs before the insert query above
			// The loop below will keep running until the list ID is found, or it gets to 99
			$recordCount = 0;
			while($recordCount <= 99) {
				if ($recordCount > 0) {
					break;
				}
				// Get the ID of the list we just created
				$retrieve_data = $wpdb->get_results( "SELECT * FROM $tablename WHERE ld_time_created = ".$timeIsNow." AND ld_md_id = ".$mumid1."" );
				foreach ($retrieve_data as $retrieved_data){
				$resultFromDB = $retrieved_data->ld_id;
				// we need to add 'stripslashes' below, or else if there is an apostrophe in the name, we get backslashes in the inserted value
				$nameFromDB = $retrieved_data->ld_list_name;
				$nameFromDB = stripslashes($nameFromDB);
				$recordCount++;
				}
				//echo "list name is ".$nameFromDB;
			}

			// Redirect to Edit your list page and pass the list ID as a querystring
			header("Location: /edit-your-list/?listID=$resultFromDB&listName=$nameFromDB");
			exit();
			}
			//echo "time submitted ".$timeIsNow;
		}
		//echo "This is not included in the design, but this page could contain the following: a list of previous lists, an option to edit the name of a list, an option to delete a list. If there is a delete option, should we delete products first?<br />";
		//echo "This page is generated by create-new-list-template";
		?>
	</main><!-- #main -->
</div><!-- #primary -->
<?php
//get_sidebar();
get_footer();