<?php
 /* Template Name: update-database-template
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

//$fieldname = get_query_var('fieldname');
$fieldname = $_GET["fieldname"];
//echo $fieldname;

global $current_user; wp_get_current_user();
if ( is_user_logged_in() ) {
    $mumid1 = $current_user->ID;
    //echo $mumid1;
    
    global $wpdb;
    
    $table_name = $wpdb->prefix . "tblMumsDB";
		// this will get the data from your table
		$retrieve_data = $wpdb->get_results( "SELECT $fieldname FROM $table_name WHERE md_wp_id = '".$mumid1."'" );
		
		foreach ($retrieve_data as $retrieved_data){
        	$resultFromDB = $retrieved_data->$fieldname;
        }
        
        //echo $resultFromDB;
    ?>
    
    <div id="primary" class="content-area">
    	<main id="main" class="site-main" role="main">
    	
    	<form action="" method="POST" class="update-form">
    	    
    	<?php
        switch ($fieldname) {
            case "md_firstname":
                ?>
                <label for="fname">First Name</label>
    		    <input type="text" id="fname" name="postedvalue" value="<?php echo $resultFromDB; ?>">
    		    <?php
                break;
            case "md_familyname":
                ?>
                <label for="familyname">Last Name</label>
    		    <input type="text" id="familyname" name="postedvalue" value="<?php echo $resultFromDB; ?>">
    		    <?php
                break;
            case "md_email":
                ?>
                <label for="email">Email</label>
    		    <input type="text" id="email" name="postedvalue" value="<?php echo $resultFromDB; ?>">
    		    <?php
                break;
            case "md_story_title":
                ?>
                <label for="title">Story Title</label>
    		    <input type="text" id="title" name="postedvalue" value="<?php echo $resultFromDB; ?>">
    		    <?php
                break;
            case "md_story":
                ?>
                <label for="story">My Story</label>
    		    <textarea id="story" name="postedvalue" style="height:200px"><?php echo $resultFromDB; ?></textarea>
    		    <?php
                break;
            case "green":
                echo "Your favorite color is green!";
                break;
            case "md_baby_name":
                ?>
                <label for="babyname">Baby Name</label>
    		    <input type="text" id="babyname" name="postedvalue" value="<?php echo $resultFromDB; ?>">
    		    <?php
                break;
            case "md_gender":
                ?>
                <label for="gender">Gender</label>
            		<select id="gender" name="postedvalue">
            		<option value="Boy" <?php if ($resultFromDB == 'boy'){ echo "selected"; } ?>>Boy</option>
            		<option value="Girl" <?php if ($resultFromDB == 'girl'){ echo "selected"; } ?>>Girl</option>
            		<option value="Don't yet know" <?php if ($resultFromDB == 'Don\'t yet know'){ echo "selected"; } ?>>Don't yet know</option>
            		</select>
    		    <?php
                break;
            case "md_baby_due_date":
                ?><label for="duedate">Expected arrival</label>
                <input type="date" id="duedate" name="postedvalue" value="<?php echo $resultFromDB; ?>">
    		    <?php
                break;
            default:
                echo "No field specified";
        }
    	?>		<div class="update-wrap">		<a class="cancel-update" href="/personal-info/">Cancel</a>
    	<input type="submit" value="Update" name="form_submit">		</div>
    	</form>
        		
        	<?php
        	
        	// Don't run the query unless the form has been submitted
        	if(isset($_POST["form_submit"])) {
        	    
        	    $postedvalue = $_POST['postedvalue'];
        	    
        		$wpdb->query($wpdb->prepare("UPDATE wp_tblMumsDB SET $fieldname = '$postedvalue' WHERE md_wp_id=$mumid1"));
        		
        		// Redirect back to profile page after update
        		header("Location: /personal-info/");
        		exit();
        
            	}
    		}
    		echo "<!--This page is generated by the update-database-template //-->";
    		?>
    
    	</main><!-- #main -->
    </div><!-- #primary -->

<?php
//get_sidebar();
get_footer();