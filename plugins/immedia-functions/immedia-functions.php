<?php
 
/*
 
Plugin Name: Immedia Functions
 
Plugin URI: https://immedia-creative.com/
 
Description: This plugin contains bespoke code.
 
Version: 1.0
 
Author: Immedia Creative

*/

add_role(

'mum',

__( 'Mum' ),

	array(

	'read' => true, // true allows this capability

	'edit_posts' => true,

	)
);



// Allow for different menus for loggedout loggedin users

function my_wp_nav_menu_args( $args = '' ) {
 
if( is_user_logged_in() ) { 
    $args['menu'] = 'logged-in';
} else { 
    $args['menu'] = 'logged-out';
} 
    return $args;
}
add_filter( 'wp_nav_menu_args', 'my_wp_nav_menu_args' );

add_filter( 'wp_nav_menu_items', 'add_loginout_link', 10, 2 );
function add_loginout_link( $items, $args ) {
    if (is_user_logged_in() && $args->theme_location == 'primary') {
        $items .= '<li><a href="'. wp_logout_url() .'">Sign Out</a></li>';
		
		global $current_user;
		wp_get_current_user();

	

		$email1 = $current_user->email;

		$username1 = $current_user->user_login;


		include_once("wp-config.php");

		include_once("wp-includes/wp-db.php");



		global $wpdb;

		// this adds the prefix which is set by the user upon instillation of wordpress

		$table_name = $wpdb->prefix . "tblMumsDB";

		// this will get the data from your table

		$retrieve_data = $wpdb->get_results( "SELECT * FROM $table_name WHERE md_wp_username = '".$username1."'" );
		
		if($retrieve_data){

		foreach ($retrieve_data as $retrieved_data){

			$items .= '<li><a class="account-link" href="/personal-info/">My Account <img title="My Account" class="profile" src="' . $retrieved_data->md_profile_image . '" ></a></li>';

        }
		
		} else {
			
			$items .= '<li><a class="account-link" href="/personal-info/">My Account <img title="My Account" class="profile" src="/wp-content/uploads/form-maker/profile/image-placeholder.jpg" ></a></li>';
			
		}
        $items .= '<li><a class="vc_general vc_btn3 vc_btn3-size-md vc_btn3-shape-rounded vc_btn3-style-classic vc_btn3-color-pink" href="'.site_url('/').'gift-picker" title="">Download gift picker</a></li>';
    }  else { 
	$items .= '<li><a class="vc_general vc_btn3 vc_btn3-size-md vc_btn3-shape-rounded vc_btn3-style-classic vc_btn3-color-pink" href="'.site_url('/').'gift-picker-instructions" title="">Download gift picker</a></li>';
	}
    return $items;
}

//function get_info_from_database_function(){
// Add $atts = array() so that we can add an attribute using the shortcode
function get_info_from_database_function( $atts = array() ){

// define variables
$fieldname = '';
$mumID1 = '';
// set up default parameters
extract(shortcode_atts(array(
	'fieldname' => 'md_id'
), $atts));

//echo $fieldname;

	global $current_user; wp_get_current_user();
		if ( is_user_logged_in() ) { 
		
		// define variable retrieve_data
		// $retrieve_data = '';
		//echo 'Username: ' . $current_user->user_login . "\n"; 
		//echo 'User display name: ' . $current_user->display_name . "\n"; 
		//echo 'User email: ' . $current_user->email . "\n"; 
		$email1 = $current_user->email;
		$username1 = $current_user->user_login;
		$mumID1 = $current_user->ID;
		//echo $mumID1;
		}
		else { wp_loginout(); }

		include_once("wp-config.php");
		include_once("wp-includes/wp-db.php");

		global $wpdb;
		// this adds the prefix which is set by the user upon instillation of wordpress
		$table_name = $wpdb->prefix . "tblMumsDB";
		// this will get the data from your table
		$retrieve_data = $wpdb->get_results( "SELECT $fieldname FROM $table_name WHERE md_wp_id = '".$mumID1."'" );
		
		foreach ($retrieve_data as $retrieved_data){
        	return $retrieved_data->$fieldname;
        }
}

add_shortcode('get-this-from-db', 'get_info_from_database_function');


// This function creates a link which then passes a fieldname to a database update script
function link_to_database_update_function( $atts = array() ){
// set up default parameters
extract(shortcode_atts(array(
	'fieldname' => 'md_id'
), $atts));

    $textblock = '';
	//$textblock .= "<div class='col-md-4'>";
			//$textblock .= "<div class=''>";
				//$textblock .= "<div class='col-md-6'>";
					$textblock .= "<a href='database-update?fieldname=".$fieldname." '>Edit</a>";
				//$textblock .= "</div>";
			//$textblock .= "</div>";
	//$textblock .= "</div>";
	
	return ($textblock);
}
add_shortcode('link_to_update_the_db', 'link_to_database_update_function');


// This function creates a link which then passes a fieldname to a database update wp user
function link_to_database_update_user_function( $atts = array() ){
// set up default parameters
extract(shortcode_atts(array(
	'fieldname' => 'md_id'
), $atts));

	$textblock = '';
	$textblock .= "<a href='update-user?fieldname=".$fieldname." '>Edit</a>";
	
	return ($textblock);
}
add_shortcode('link_to_update_the_user_db', 'link_to_database_update_user_function');


// This function updates the tblMumsDB with the Wordpress ID of the user
function update_mumsdb_table_function(){		
		
global $current_user; wp_get_current_user();
// Only run if ?logged_in=true
	if ( is_user_logged_in() ) { 

	$email1 = $current_user->email;
	$idname1 = $current_user->ID;
	$username1 = $current_user->user_login;
	
	if ( $idname1 == 0 ) {
		include_once("wp-config.php");
		include_once("wp-includes/wp-db.php");

		global $wpdb;
		// this adds the prefix which is set by the user upon installation of wordpress
		$table_name = $wpdb->prefix . "tblMumsDB";
		
		$wpdb->query($wpdb->prepare("UPDATE $table_name SET md_wp_id='.$idname1.' WHERE md_wp_username='".$username1."'"));
		}
	} 	
}

add_action( 'init', 'update_mumsdb_table_function');



// Redirect the User to the Custom Forgot Password Page

	
//add_action( 'login_form_lostpassword', array( $this, 'redirect_to_custom_lostpassword' ) );

/**
 * Redirects the user to the custom "Forgot your password?" page instead of
 * wp-login.php?action=lostpassword.
 */
 /*
public function redirect_to_custom_lostpassword() {
    if ( 'GET' == $_SERVER['REQUEST_METHOD'] ) {
        if ( is_user_logged_in() ) {
            $this->redirect_logged_in_user();
            exit;
        }
 
        wp_redirect( home_url( 'member-password-lost' ) );
        exit;
    }
}*/


//function to toggle list status live or draft
add_action('wp_ajax_toggle_live','ajax_toggle_live');
function ajax_toggle_live(){
	$arr=[];
	wp_parse_str($_POST['toggle_live'],$arr);
	global $wpdb;
	global $table_prefix;
	$table=$table_prefix.'tblListsDB';
	$result=$wpdb->update($table,[
		"ld_list_status"=>$arr['status']
	],[
		"ld_id"=>$arr['list_id']
	]);
	if ($result>0){
		//wp_send_json_success($arr['list_id'],$arr['status']);
		wp_send_json_success($arr);
	} else {
		wp_send_json_error("Please try again");
	}
	die();
}
