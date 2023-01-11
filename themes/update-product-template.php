<?php

/* Template Name: update-product-template
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
$productID = "";

$action = $_GET["action"];
//echo "action " . $action . "<br />";

$listID = $_GET["listID"];
//echo "listID " . $listID;

$productID = $_GET["productID"];
//echo "productID " . $productID;
?>

<div id="primary" class="content-area">
    <main id="main" class="site-main" role="main">

        <?php
        global $current_user;
        wp_get_current_user();
        if (is_user_logged_in()) {
            $mumid1 = $current_user->ID;
            //echo $mumid1;

            global $wpdb;

            if ($action == "update") {

                $table_name = $wpdb->prefix . "tblProductsDB";
                $table_name2 = $wpdb->prefix . "tblListsDB";
                // this will get the data from your table
                //$retrieve_data = $wpdb->get_results( "SELECT * FROM $table_name WHERE pd_id = '".$productID."'" );
                $retrieve_data = $wpdb->get_results("SELECT $table_name.*, $table_name2.ld_list_name FROM $table_name INNER JOIN $table_name2 ON $table_name.pd_ld_id = $table_name2.ld_id WHERE pd_id = '" . $productID . "'");

                foreach ($retrieve_data as $retrieved_data) {
                    $pd_prod_title = $retrieved_data->pd_prod_title;
                    $pd_price = $retrieved_data->pd_price;
                    $pd_prod_url1 = $retrieved_data->pd_prod_url1;
                    $pd_prod_image = $retrieved_data->pd_prod_image;
                    $listName = stripslashes($retrieved_data->ld_list_name);
                    $pd_price = $formattedNum = number_format($pd_price, 2);
                }
                // we need to add 'stripslashes' in the fields below, or else if there is an apostrophe in the name, we get backslashes in the inserted value
        ?>

                <form action="" method="POST" class="update-form">
                    <h2>Edit Gift</h2>
                    <p class="medium"><?php echo stripslashes($pd_prod_title); ?></p>
                    <label for="title">Product name</label>
                    <input type="text" id="productName" name="productName" value="<?php echo stripslashes($pd_prod_title); ?>" required>
                    <label for="title">Product price</label>
                    <input type="number" step="any" id="productPrice" name="productPrice" value="<?php echo $pd_price; ?>" required>
                    <label for="title">Web address of product</label>
                    <input type="text" id="productURL" name="productURL" value="<?php echo stripslashes($pd_prod_url1); ?>" required>
                    <label for="title">Web address of image</label>
                    <input type="text" id="imageURL" name="imageURL" value="<?php echo stripslashes($pd_prod_image); ?>" required>


                    <div class="update-wrap">
                        <!--<a class="cancel-update" href="/personal-info/">Cancel</a>-->

                        <input type="submit" value="Submit" name="form_submit">
                    </div>

                </form>

        <?php
                // Don't run the query unless the form has been submitted
                if (isset($_POST["form_submit"])) {

                    $tablename = $wpdb->prefix . 'tblProductsDB';
                    $wpdb->update(
                        $tablename,
                        array(
                            'pd_prod_title' => $_POST['productName'],
                            'pd_price' => $_POST['productPrice'],
                            'pd_prod_url1' => $_POST['productURL'],
                            'pd_prod_image' => $_POST['imageURL'],
                        ),
                        array(
                            'pd_id' => $productID, // the first WHERE argument
                            //'column2' => 'value2', // additional WHERE argument!
                        ),
                        array('%s', '%s', '%s', '%s'), // the format of the update value
                        array(
                            '%d', // the format of the first WHERE argument
                            //'%s' // the format of the second WHERE argument
                        )
                    );

                    //$wpdb->query($wpdb->prepare("UPDATE wp_tblMumsDB SET $fieldname = '$postedvalue' WHERE md_wp_id=$mumid1"));

                    // Redirect back to profile page after update
                    header("Location: /edit-your-list/?listID=$listID&listName=$listName");
                    exit();
                }
            } elseif ($action == "delete") {

                //echo "delete stuff";
                $table_name = $wpdb->prefix . "tblProductsDB";
                $wpdb->query(
                    "DELETE  FROM $table_name WHERE pd_id = '" . $productID . "'"
                );

                // Redirect back to profile page after update
                header("Location: /edit-your-list/?listID=$listID&listName=$listName");
                exit();
            } else {

                echo "dunno";
            }
        }

        //echo "This page is generated by the update-product-template";
        ?>
    <p class="hidden">content generated by update-product-template.php</p>
    </main><!-- #main -->

</div><!-- #primary -->

<?php

//get_sidebar();

get_footer();
