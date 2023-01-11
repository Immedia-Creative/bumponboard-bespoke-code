<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>


<?php 

//$the_site = "https://www.windsor-berkshire.co.uk/";
//$the_site = "https://www.johnlewis.com/peter-rabbit-push-along-toy/p1717264";
//$the_site = "https://www.amazon.co.uk/FOCO-Manchester-BRXLZ-Football-Building/dp/B07NMKQ63M/ref=sr_1_3_sspa?dchild=1&keywords=toys&qid=1629795174&sr=8-3-spons&psc=1&spLa=ZW5jcnlwdGVkUXVhbGlmaWVyPUEyTzdRNElBUkVLS0gxJmVuY3J5cHRlZElkPUEwMTM0NzA3TjVTVU1OMkNBVllSJmVuY3J5cHRlZEFkSWQ9QTA3Mjk0MTkyOThQNUVST1BVR1JWJndpZGdldE5hbWU9c3BfYXRmJmFjdGlvbj1jbGlja1JlZGlyZWN0JmRvTm90TG9nQ2xpY2s9dHJ1ZQ==/";
//$the_site = "https://www.jojomamanbebe.co.uk/duck-embroidered-baby-footie-b5964.html?nosto=landing-nosto-3";
//$the_site = "https://www.amazon.co.uk/FOCO-Manchester-BRXLZ-Football-Building/dp/B07NMKQ63M/";
$the_site = "https://www.boots.com/baby-child/mothercare-clothing/mothercare-baby-clothes-0-24-months/mothercare-five-piece-flannel-set-10288651";
//$the_site = "https://www.immedia-creative.com/";

$html = file_get_contents($the_site);

//Get the page's HTML source using file_get_contents.
//$html = file_get_contents('https://en.wikipedia.org');

//Instantiate the DOMDocument class.
$htmlDom = new DOMDocument;

//Parse the HTML of the page using DOMDocument::loadHTML
@$htmlDom->loadHTML($html);

//Extract the links from the HTML.
$links = $htmlDom->getElementsByTagName('a');

//Array that will contain our extracted links.
$extractedLinks = array();

//Loop through the DOMNodeList.
//We can do this because the DOMNodeList object is traversable.
foreach($links as $link){

    //Get the link text.
    $linkText = $link->nodeValue;
    //Get the link in the href attribute.
    $linkHref = $link->getAttribute('href');

    //If the link is empty, skip it and don't
    //add it to our $extractedLinks array
    if(strlen(trim($linkHref)) == 0){
        continue;
    }

    //Skip if it is a hashtag / anchor link.
    if($linkHref[0] == '#'){
        continue;
    }

    echo $linkHref. "<br />";

    //Add the link to our $extractedLinks array.
    $extractedLinks[] = array(
        'text' => $linkText,
        'href' => $linkHref
    );

}

//var_dump the array for example purposes
//var_dump($extractedLinks);

?>
</body>
</html>