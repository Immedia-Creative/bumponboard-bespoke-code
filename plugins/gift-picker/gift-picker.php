<?php
/*
Plugin Name: Gift Picker
*/



$myoutput .= '
<form action="/wp-content/plugins/gift-picker/process.php" method="post">
<input name="GiftName" type="text" placeholder="giftname" /><br />
<input name="Price" type="text"  placeholder="price" /><br />
<input name="submit" type="submit" value="submit" />
</form>
';

if ($_GET['id']){
$myoutput .= "hooray we got the id ";

$myoutput .= $_GET['id'];
}
echo $myoutput;
?>
