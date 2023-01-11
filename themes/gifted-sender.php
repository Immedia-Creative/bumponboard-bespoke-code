<?php
//this script takes the 'gifted' form submission and does four things:
//1) marks product as gifted on the database
//2) sends email to list owner
//3) sends thank you email to gift giver
//4) returns gift giver to the list page 

//still need to add some security.  check where it came from
// If this file is called directly, bail out!

// get the core wp functionality using shortinit
define('SHORTINIT', true);
$path = $_SERVER['DOCUMENT_ROOT'];
include_once $path . '/wp-config.php';
include_once $path . '/wp-includes/wp-db.php';
include_once $path . '/wp-includes/pluggable.php';
global $wpdb;

// get form variables if they exist
//clean them up too
if ($_POST["bumpid"]) {
	$listid = $_POST["bumpid"];
}
if ($_POST["productid"]) {
	$productid = $_POST["productid"];
}
if ($_POST["mumid"]) {
	$mumid = $_POST["mumid"];
}
if ($_POST["productname"]) {
	$productname = $_POST["productname"];
}
if ($_POST["listname"]) {
	$listname = $_POST["listname"];
}
if ($_POST["name"]) {
	$name = $_POST["name"];
}
if ($_POST["email"]) {
	$email = $_POST["email"];
}
if ($_POST["message"]) {
	$themessage = $_POST["message"];
}
//1 - marks product as gifted  (need prod id)

//UPDATE table_name SET column1=value WHERE some_column=some_value 

//$table = "wp_tblProductsDB";
//$data = "pd_bought = 1";
//$where="pd_id = ".$productid;
//$thesequel ="wp_tblProductsDB SET pd_bought=1 WHERE PD_id=".$productid;
//$updated = $wpdb->update($table,$data,$where);

$tablename = $wpdb->prefix . 'tblProductsDB';
$wpdb->update(
	$tablename,
	array(
		'pd_bought' => 1,
	),
	array(
		'pd_id' => $productid,
	),
	array('%s'),
	array(
		'%d',
	)
);


if (false === $updated) {
	echo "There was an error.";
	die();
} else {
	// No error.
}

//2 sends email to mum with details

//use mumid to get email address

$mum = $wpdb->get_row("SELECT * FROM wp_tblMumsDB WHERE md_wp_id = $mumid");
//$mumsemail = $mum->md_wp_username;
$mumsemail = $mum->md_email;



//send an email to list owner
$to = $mumsemail;
$subject = 'Bump on board - Get excited...one of the items on your wishlist has been gifted to you!';
$message = '<p>Here’s the beautiful gift on its way to you: ';
$message .= $productname . '</p>';
$message .= '<p>This has been gifted by: ';
$message .= $name . '</p>';
$message .= '<p>They have added the following message: </p>';
$message .= '<p>' . $themessage . '</p>';
$headers = array('Content-Type: text/html; charset=UTF-8', 'From: Bump on Board <webmaster@immedia-creative.com>');

wp_mail($to, $subject, $message, $headers);


//3 send thank you email to gifter

$to = $email;
$subject = 'Bump on board - Thanks for gifting an item!';
$message = '<p>Thanks for gifting an item for the "';
$message .= $listname;
$message .= '" list - they’re now one step closer to getting everything they wanted!</p>';
$message .= '<p>We’ve marked the item as gifted so that no one else can purchase the same product.</p>';
$message .= '<p>We hope they enjoy your gift!</p>';
$headers = array('Content-Type: text/html; charset=UTF-8', 'From: Bump on Board <webmaster@immedia-creative.com>');


wp_mail($to, $subject, $message, $headers);

//4 redirects back to https://www.bumponboard.co.uk/bumplist/?bump-id={whaterver id was]
//productid added to url below just for testing
$headout = 'Location:https://www.bumponboard.co.uk/bumplist/?bump-id=' . $listid . '&mumid=' . $mumid;
header($headout);
exit();
?>.