<?php
/**
 * Plugin Name: Edit Parents Admin
 * Description: Admins can delete parents and associated lists and products
 */

 function edit_parents_admin()
 {
     add_menu_page('Edit Parents','Edit Parents','manage_options','edit-parents-admin','edit_parents_admin_main',get_template_directory_uri().'/images/bonb-menu-icon.png',4);
 }
 add_action('admin_menu','edit_parents_admin');

function edit_parents_admin_main()
{
    $action = "";
    $parentID = "";

    if (isset($_GET["action"])) {
        $action = $_GET["action"];
        //echo $action."<br />";
    }
    if (isset($_GET["user"])) {
        $parentID = $_GET["user"];
        //echo $parentID;
    }

    echo '<div class="wrap"><h2>Delete Parents, lists and products</h2><br /></div>';

    require_once( ABSPATH.'wp-admin/includes/user.php' );

    global $wpdb;

    $nonce = wp_create_nonce( 'my-nonce' );

    if ((isset($_GET["action"])) && (isset($_GET["user"]))) {
        //echo "delete user";
        //echo '<br>';

        if ( ! wp_verify_nonce( $nonce, 'my-nonce' ) ) {
            die( __( 'Security check', 'textdomain' ) );
            echo "nonce not recognised";
        } else {

            // Find all associated lists and products
            $table_name = $wpdb->prefix . "tblListsDB";
            //$retrieve_dataset = $wpdb->get_results( "SELECT $table_name.*, $table_name2.* FROM $table_name INNER JOIN $table_name2 ON $table_name.ld_id = $table_name2.pd_ld_id WHERE $table_name.ld_md_id = $parentID" );
            $retrieve_dataset = $wpdb->get_results( "SELECT ld_id FROM $table_name WHERE $table_name.ld_md_id = $parentID" );
            
            foreach ($retrieve_dataset as $retrieved_dataset){
                $ld_id = $retrieved_dataset->ld_id;
                //echo $ld_id.'<br />';

                $table3 = $wpdb->prefix . "tblProductsDB";
                $wpdb->delete( $table3, array( 'pd_ld_id' => $ld_id ) );
            }

            $table4 = $wpdb->prefix . "tblListsDB";
            $wpdb->delete( $table4, array( 'ld_md_id' => $parentID ) );
            
            if (wp_delete_user($parentID)) {
            $table5 = $wpdb->prefix . "tblMumsDB";
            $wpdb->delete( $table5, array( 'md_wp_id' => $parentID ) );
                echo 'User deleted ' . $parentID;
                echo '<br>';
            }
            
        }

    } else {
        //echo "dont delete user";
        //echo '<br>';
    }

    $table_name = $wpdb->prefix . "tblMumsDB";
    $table_name2 = $wpdb->prefix . "users";
    // this will get the data from your table
    $retrieve_data = $wpdb->get_results( "SELECT $table_name.*, DATE_FORMAT(md_created_on,'%d %M %Y') AS niceDate, $table_name2.* FROM $table_name INNER JOIN $table_name2 ON $table_name.md_wp_id = $table_name2.ID" );
    
    foreach ($retrieve_data as $retrieved_data){
        $md_firstname = $retrieved_data->md_firstname;
        $md_familyname = $retrieved_data->md_familyname;
        $md_wp_id = $retrieved_data->md_wp_id;
        $md_created_on = $retrieved_data->niceDate;
        //$md_created_on = date_format($md_created_on,"d F Y");
        $mainURL = "/wp-admin/admin.php?page=edit-parents-admin&_wpnonce={$nonce}&action=delete&amp;user={$md_wp_id}";

        echo $md_firstname.' '.$md_familyname.' - Created On: '.$md_created_on.' - <a href="'.$mainURL.'" onclick="return confirm(\'Are you sure to delete? This will also delete all lists and associated products.\')">Delete</a><br />&nbsp;<br />';
    }

}

?>