<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>


<?php 
//echo ("hello");

require_once('simple_html_dom.php');
//require_once('url_to_absolute.php');

//$the_site = "https://www.windsor-berkshire.co.uk/";
//$the_site = "https://www.immedia-creative.com/";
//$the_site = "https://www.amazon.co.uk/FOCO-Manchester-BRXLZ-Football-Building/dp/B07NMKQ63M/ref=sr_1_3_sspa?dchild=1&keywords=toys&qid=1629795174&sr=8-3-spons&psc=1&spLa=ZW5jcnlwdGVkUXVhbGlmaWVyPUEyTzdRNElBUkVLS0gxJmVuY3J5cHRlZElkPUEwMTM0NzA3TjVTVU1OMkNBVllSJmVuY3J5cHRlZEFkSWQ9QTA3Mjk0MTkyOThQNUVST1BVR1JWJndpZGdldE5hbWU9c3BfYXRmJmFjdGlvbj1jbGlja1JlZGlyZWN0JmRvTm90TG9nQ2xpY2s9dHJ1ZQ==/";
//$the_site = "https://www.johnlewis.com/peter-rabbit-push-along-toy/p1717264";
$the_site = "https://www.jojomamanbebe.co.uk/jellycat-fuddlewuddle-elephant-medium-b1974.html?msclkid=2e6f16de5da6145e9cef77f84c34cb1f&utm_source=bing&utm_medium=cpc&utm_campaign=Shopping%20-%20Mixed&utm_term=4575136608494324&utm_content=Mixed%20-%20All";
//$the_site = "https://www.boots.com/baby-child/mothercare-clothing/mothercare-baby-clothes-0-24-months/blue-ditsy-floral-organic-cotton-all-in-one-10290644";

$myhtml = file_get_html($the_site);

$imgURL = "";
$imageURLs = "";
$url = "";

foreach($myhtml->find('img') as $element) {
    $imgURL = $element->src;
    echo $imgURL. "<br />";

    if ((strpos($imgURL, '.png') !== false) OR (strpos($imgURL, '.jpg') !== false) OR (strpos($imgURL, '.gif') !== false)) {
        echo ' Is jpg ';
        $infos = getimagesize($imgURL);
        //echo $infos[0] . " x " . $infos[1] . " ";
        if ($infos[0]> 50) {
            $imageValue = "<img width='100' height='100' src='" . $imgURL . "' />";
            //$imageValue = "<img src='" . $imgURL . "' />";
            $imageURLs = $imageURLs . "<label><input type='radio' id='imageURL' name='imageURL' value='" . $imgURL . "'>" . $imageValue . "</label>";
            //echo "<br />";
            }
    } elseif (strpos($imgURL, '.svg') !== false) {
        //echo substr($imgURL, 0, 5);
            echo ' Is svg ';
            if (file_exists($imgURL)) {
                $xml = simplexml_load_file($imgURL);
                $attr = $xml->attributes();
                //echo $attr->width . " x " . $attr->height;
                //$imageValue = "<img width='100' height='100' src='" . $imgURL . "' />";
                $imageValue = "<img src='" . $imgURL . "' />";
                $imageURLs = $imageURLs . "<label><input type='radio' id='imageURL' name='imageURL' value='" . $imgURL . "'>" . $imageValue . "</label>";
                //printf("%s x %s", $attr->width, $attr->height);
                //echo "<br />";
                } else {}
    } else {
        echo " webP? <br />";
        $infos = getimagesize($imgURL);
        //echo $infos[0] . " x " . $infos[0] . " ";
        $imageValue = "<img width='100' height='100' src='" . $imgURL . "' />";
        //$imageValue = "<img src='" . $imgURL . "' />";
        $imageURLs = $imageURLs . "<label><input type='radio' id='imageURL' name='imageURL' value='" . $imgURL . "'>" . $imageValue . "</label>";
        //echo "<br />";
    }
}

echo $imageURLs. "<input type='submit' value='Add' name='form_submit'>";

?>
</body>
</html>