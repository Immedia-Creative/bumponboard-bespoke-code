<?php
/*
Plugin Name: Immedia - Display Photo
*/

function display_photo_function(){
		
	global $current_user; wp_get_current_user();
		if ( is_user_logged_in() ) { 
		//echo 'Username: ' . $current_user->user_login . "\n"; 
		//echo 'User display name: ' . $current_user->display_name . "\n"; 
		//echo 'User email: ' . $current_user->email . "\n"; 

		// define variables
		$retrieve_data = '';
		$username1 = '';
		//$email1 = $current_user->email;
		$username1 = $current_user->user_login;} 
		else { wp_loginout(); }

		include_once("wp-config.php");
		include_once("wp-includes/wp-db.php");

		global $wpdb;
		// this adds the prefix which is set by the user upon instillation of wordpress
		// define $table_name
		$table_name = '';
		$table_name = $wpdb->prefix . "tblMumsDB";
		// this will get the data from your table
		$retrieve_data = $wpdb->get_results( "SELECT * FROM $table_name WHERE md_wp_username = '".$username1."'" );
		?>

        <?php foreach ($retrieve_data as $retrieved_data){
			
			$photo = '';
        	$photo .= '<a class="photo-wrap" title="Edit Photo" href="/personal-info/photo-upload/"><img class="profile-image" src="' . $retrieved_data->md_profile_image . '" ></a>';
			return $photo;
        }
}

function register_displayphoto_shortcode(){
   add_shortcode('display-photo', 'display_photo_function');
}
add_action( 'init', 'register_displayphoto_shortcode');
?>