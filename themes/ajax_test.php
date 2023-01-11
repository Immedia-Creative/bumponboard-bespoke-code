<?php
require_once('simple_html_dom.php');

if ($_GET["url"]){

    $the_site = $_GET["url"];

    //$myhtml = file_get_contents($the_site);
    $myhtml = file_get_html($the_site);

    $imgURL = "";
    $imageURLs = "";
    $url = "";
    
    foreach($myhtml->find('img') as $element) {
        $imgURL = $element->src;
        $imgURL = str_replace("'", "", $imgURL);
        //echo $imgURL. "<br />";
    
        if ((strpos($imgURL, '.png') !== false) OR (strpos($imgURL, '.jpg') !== false) OR (strpos($imgURL, '.gif') !== false)) {
            //echo ' Is jpg ';
            $infos = getimagesize($imgURL);
            //echo $infos[0] . " x " . $infos[1] . " ";
            if ($infos[0]> 50) {
                //$imageValue = "<div class='imageCont'><img width='100' height='100' src='" . $imgURL . "' /></div>";
                $imageValue = "<div class='imageCont' style=background-image:url('" . $imgURL . "')></div>";

                //$imageValue = "<img src='" . $imgURL . "' />";
                $imageURLs = $imageURLs . "<div class='col-md-2'><label><input type='radio' id='imageURL' name='imageURL' value='" . $imgURL . "'>" . $imageValue . "</label></div>";
                //echo "<br />";
                }
        } elseif (strpos($imgURL, '.svg') !== false) {
            //echo substr($imgURL, 0, 5);
                //echo ' Is svg ';
                
                if (file_exists($imgURL)) {
                    //if ($imgURL) {
                        //if ($imgURL <> "") {
                        $xml = simplexml_load_file($imgURL);
                        $attr = $xml->attributes();
                        echo $attr->width . " x " . $attr->height;
                        if($attr->width > 99) {
                        //$imageValue = "<div class='imageCont'><img width='100' height='100' src='" . $imgURL . "' /></div>";
                        $imageValue = "<div class='imageCont' style=background-image:url('" . $imgURL . "')></div>";
                        //$imageValue = "<img src='" . $imgURL . "' />";
                        $imageURLs = $imageURLs . "<div class='col-md-2'><label><input type='radio' id='imageURL' name='imageURL' value='" . $imgURL . "'>" . $imageValue . "</label></div>";
                        //printf("%s x %s", $attr->width, $attr->height);
                        //echo "<br />";
                    }
                } else {}
                    
        } else {
            //echo " webP? <br />";
            //if ($imgURL) {
            $infos = getimagesize($imgURL);
            //echo $infos[0] . " x " . $infos[0] . " ";
            //$imageValue = "<div class='imageCont'><img width='100' height='100' src='" . $imgURL . "' /></div>";
            $imageValue = "<div class='imageCont' style=background-image:url('" . $imgURL . "')></div>";
            //$imageValue = "<img src='" . $imgURL . "' />";
            $imageURLs = $imageURLs . "<div class='results-col col-xs-6 col-sm-3 col-md-2'><label><input type='radio' id='imageURL' name='imageURL' value='" . $imgURL . "'>" . $imageValue . "</label></div>";
            //echo "<br />";
            //}
        }
    }
    
    if ($imageURLs) {
        echo "<div class='row'><div class='col-md-12'><p>Select your item image from the selection below. Then click Add Item.</p></div></div><div class='row'>".$imageURLs."</div><div class='row'><div class='col-md-12'><div class='vc_separator wpb_content_element vc_separator_align_center vc_sep_width_100 vc_sep_pos_align_center vc_separator_no_text vc_sep_color_black'><span class='vc_sep_holder vc_sep_holder_l'><span class='vc_sep_line'></span></span><span class='vc_sep_holder vc_sep_holder_r'><span class='vc_sep_line'></span></span>
</div><input type='submit' value='Add Item' name='form_submit'></div></div></div>";
    } else {
        echo "<p>Sorry, there are no images available</p>";
    }

}
?>
