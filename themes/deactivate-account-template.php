<?php

/* Template Name: deactivate-account-template
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

$action = "";

$action = $_GET["action"];
//echo $action . "<br />";
?>

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
        }
        ?>

        <h2>Deactivate Account</h2>
        If you deactivate your account all your lists will be hidden from the front of the website and from search engines. You can still sign back in later and make further lists without having to sign up again.<br />

        <a class="vc_general vc_btn3 vc_btn3-size-md vc_btn3-shape-rounded vc_btn3-style-classic vc_btn3-color-pink" href="/personal-info/deactivate-account/?action=deactivate">Deactivate Account</a><br />

        &nbsp;<br />
        If you change your mind.<br />

        <a class="vc_general vc_btn3 vc_btn3-size-md vc_btn3-shape-rounded vc_btn3-style-classic vc_btn3-color-pink" href="/personal-info/deactivate-account/?action=reactivate">Reactivate Account</a><br />
        &nbsp;<br />

        <?php
        if ($action == "deactivate") {
            //echo "set to draft";
            $tablename = $wpdb->prefix . 'tblListsDB';
            $wpdb->update(
                $tablename,
                array(
                    'ld_list_status' => 0,
                ),
                array(
                    'ld_md_id' => $mumid1, // the first WHERE argument
                    //'column2' => 'value2', // additional WHERE argument!
                ),
                array('%d'), // the format of the update value
                array(
                    '%d', // the format of the first WHERE argument
                    //'%s' // the format of the second WHERE argument
                )
            );
        } elseif ($action == "reactivate") {
            //echo "set live";
            $tablename = $wpdb->prefix . 'tblListsDB';
            $wpdb->update(
                $tablename,
                array(
                    'ld_list_status' => 1,
                ),
                array(
                    'ld_md_id' => $mumid1, // the first WHERE argument
                    //'column2' => 'value2', // additional WHERE argument!
                ),
                array('%d'), // the format of the update value
                array(
                    '%d', // the format of the first WHERE argument
                    //'%s' // the format of the second WHERE argument
                )
            );
        } else {
            //take no action
        }
        ?>

    </main><!-- #main -->

</div><!-- #primary -->

<?php

//get_sidebar();

get_footer();
