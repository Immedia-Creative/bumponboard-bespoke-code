<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>

<?php


require_once('simple_html_dom.php');


//$url = 'https://www.jojomamanbebe.co.uk/ella-ragdoll-d9536.html/';
//$url = 'https://smile.amazon.co.uk/Face-Masks-Washable-Black-Mask/dp/B08KD2NNZF?ref_=Oct_DLandingS_D_3f0f5854_61&smid=A2XGI2GB9MN4VB';
$url = 'https://www.johnlewis.com/john-lewis-partners-wooden-baby-walker-and-bricks/p5131517?sku=238704765&s_ppc=2dx92700063996201075&tmad=c&tmcampid=2&gclid=CjwKCAjw95yJBhAgEiwAmRrutMHQoayhH70sMuT0CfG_8VNqO_CScfZj84_lTXh7x_4NH6IIZunayRoCuWYQAvD_BwE&gclsrc=aw.ds';

$html = file_get_html($url);

$imageURLs = "";
foreach($html->find('img') as $element) {
    //$url_to_absolute = url_to_absolute($url, $element->src), "<br />";
    $url_to_absolute = url_to_absolute($url, $element->src);
    echo $url_to_absolute. "<br />";
    //echo "<img src='" . $url_to_absolute . "' /><br />";

    //$newstring = substr($url_to_absolute, -4);

    if ((strpos($url_to_absolute, '.png') !== false) OR (strpos($url_to_absolute, '.jpg') !== false) OR (strpos($url_to_absolute, '.gif') !== false)) {

    //if(($newstring == ".png") OR ($newstring == ".jpg") OR ($newstring == ".gif")) {
        echo ' Is jpg ';
        $infos = getimagesize($url_to_absolute);
        echo $infos[0] . " x " . $infos[0] . " ";
        $imageValue = "<img width='100' height='100' src='" . $url_to_absolute . "' />";
        //$imageValue = "<img src='" . $url_to_absolute . "' />";
        $imageURLs = $imageURLs . "<label><input type='radio' id='imageURL' name='imageURL' value='" . $url_to_absolute . "'>" . $imageValue . "</label>";
        echo "<br />";
    } elseif (strpos($url_to_absolute, '.svg') !== false) {
        echo substr($url_to_absolute, 0, 5);
        echo ' Is svg ';
        $xml = simplexml_load_file($url_to_absolute);
        $attr = $xml->attributes();
        echo $attr->width . " x " . $attr->height;
        $imageValue = "<img width='100' height='100' src='" . $url_to_absolute . "' />";
        //$imageValue = "<img src='" . $url_to_absolute . "' />";
        $imageURLs = $imageURLs . "<label><input type='radio' id='imageURL' name='imageURL' value='" . $url_to_absolute . "'>" . $imageValue . "</label>";
        //printf("%s x %s", $attr->width, $attr->height);
        echo "<br />";
    } else {
        echo " webP? <br />";
        $infos = getimagesize($url_to_absolute);
        echo $infos[0] . " x " . $infos[0] . " ";
        $imageValue = "<img width='100' height='100' src='" . $url_to_absolute . "' />";
        //$imageValue = "<img src='" . $url_to_absolute . "' />";
        $imageURLs = $imageURLs . "<label><input type='radio' id='imageURL' name='imageURL' value='" . $url_to_absolute . "'>" . $imageValue . "</label>";
        echo "<br />";
    }

       //if ($infos[0] && $infos[1] > 90) {
        //   $imageValue = "<img width='100' height='100' src='" . $url_to_absolute . "' />";
        //   $imageURLs = $imageURLs . "<label><input type='radio' id='imageURL' name='imageURL' value='" . $url_to_absolute . "'>" . $imageValue . "</label>";
       //}
    
}
echo $imageURLs. "<input type='submit' value='Add' name='form_submit'>";
?>
</body>
</html>