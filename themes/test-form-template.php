<?php
 /* Template Name: test-form-template
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

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">
		    
            <?php global $current_user; wp_get_current_user(); ?>
			<?php if ( is_user_logged_in() ) { 
			echo 'Username: ' . $current_user->user_login . "\n"; 
			echo 'User display name: ' . $current_user->display_name . "\n";
			echo 'User id: ' . $current_user->id . "\n";
			$idNumber = $current_user->id;
			$username1 = $current_user->user_login;} 
			else { wp_loginout(); }

			
			include_once("wp-config.php");
			include_once("wp-includes/wp-db.php");

			global $wpdb;
			// this adds the prefix which is set by the user upon instillation of wordpress
			$table_name = $wpdb->prefix . "users";
			// this will get the data from your table
			$retrieve_data = $wpdb->get_results( "SELECT * FROM $table_name WHERE user_login = '".$username1."'" );
			?>
			<br />&nbsp;<br />
			<a href="/personal-info/">Edit Personal Info</a>
			<h1>Test Page</h1>
			<ul>
				<?php foreach ($retrieve_data as $retrieved_data){ ?>
					<li>User name: <?php echo $retrieved_data->user_login;?></li>
					<li>User email: <?php echo $retrieved_data->user_email;?></li>
					<li>User display name: <?php echo $retrieved_data->display_name;?></li>
				<?php 
					}
				?>
			</ul>

            <script type="text/javascript">
            var user_id = <?php echo json_encode($idNumber) ?> ;
            console.log('hello user_id');
            </script>
            
            <?php if( function_exists("wd_form_maker") ) { wd_form_maker(9, "embedded"); } ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
//get_sidebar();
get_footer();