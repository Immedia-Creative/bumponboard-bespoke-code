<?php
 /* Template Name: upload-scan-template
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
			<h2>Photo upload</h2>						<h3>Select an image</h3>
			<form class="photo-upload" action="" method="post" enctype="multipart/form-data">
				<div class="form-group">
					<label class="">Choose Image</label>
					<input type="file" name="upload_image" required />
				</div>
				
				<input type="submit" name="form_submit" class="btn btn-primary" value="Submit" />
			</form>
			
			<?php
			global $current_user; wp_get_current_user();
			    if ( is_user_logged_in() ) {
    		    $mumid1 = $current_user->ID;
    
    			if(isset($_POST["form_submit"])) {

					$imageProcess = 0;
    				if(is_array($_FILES)) {
						$fileName = $_FILES['upload_image']['tmp_name']; 
						$sourceProperties = getimagesize($fileName);
						$resizeFileName = $mumid1. time();
						$uploadPath = "wp-content/uploads/bump-on-board/scan-image/";
						$fileExt = pathinfo($_FILES['upload_image']['name'], PATHINFO_EXTENSION);
						$uploadImageType = $sourceProperties[2];
						$sourceImageWidth = $sourceProperties[0];
						$sourceImageHeight = $sourceProperties[1];

						
						$image= $fileName;
					
						list( $width,$height ) = getimagesize( $image );
						//echo "<br />width ".$width;
						//echo "<br />height ".$height;

						//imagecopyresampled(	$src, 	$dst, 	0, 	0, 	$startX, 	$start_y, 	75, 	75, 	$end_x, 	$end_y);
						//		               					a  	b  	c       	d         	e   	f   	g       	h
						//a,b - start pasting the new image into the top-left of the destination image
						//c,d - start sucking pixels out of the original image at 200,134
						//e,f - make the resized image 75x75 (fill up the thumbnail)
						//g,h - stop copying pixels at 600x402 in the original image
						
						$y1=0; //$_POST['top'];
						$x1=0; //$_POST['left'];
						$w=400; //$_POST['right'];
						$h=400; //$_POST['bottom'];
						//echo "<br />y1 ".$y1;
						//echo "<br />x1 ".$x1;
						//echo "<br />w ".$w;
						//echo "<br />h ".$h;

						$imgRatio = $width/$height;
						if ($imgRatio > 1){
							// landscape
							$imgFormat = "landscape";
							$newwidth = round(400 * $imgRatio);
							$newheight = 400;
						} else if ($imgRatio < 1){
							//portrait
							$imgFormat = "portrait";
							$newwidth = 400;
							$newheight = round(400 / $imgRatio);
						} else {
							//square
							$imgFormat = "square";
							$newwidth = 400;
							$newheight = 400;
						}

						//echo "<br />newwidth ".$newwidth;
						//echo "<br />newheight ".$newheight;

						// Create empty thumbnail image
						$thumb = imagecreatetruecolor( $newwidth, $newheight );

						// make a copy of the original file
						switch ($uploadImageType) {
    						case IMAGETYPE_JPEG:
    							$source = imagecreatefromjpeg($image);
								// Resize the original image
								imagecopyresized($thumb, $source, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
								imagejpeg($thumb,$image,100); 
    							break;
    
    						case IMAGETYPE_GIF:
    							$source = imagecreatefromgif($image);
								// Resize the original image
								imagecopyresized($thumb, $source, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
								imagegif($thumb,$image,100); 
    							break;
    
    						case IMAGETYPE_PNG:
    							$source = imagecreatefrompng($image);
								// Resize the original image
								imagecopyresized($thumb, $source, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
								// Fix image quality issue see https://stackoverflow.com/questions/7878754/creating-png-files/7878801
								$q=9/100;
								$quality = 0;
								$quality*=$q;
								imagepng($thumb,$image,$quality); 
								break;
    
    						default:
    							$imageProcess = 0;
    							break;
    					}

						// Calculate coordinates for cropping
						if ($imgFormat == "landscape"){
							$y1=0; //$_POST['top'];
							$x1=($newwidth - 400)/2; //$_POST['left'];
							$w=400; //$_POST['right'];
							$h=400; //$_POST['bottom'];
						} else if ($imgFormat == "portrait"){
							$y1=($newheight - 400)/2; //$_POST['top'];
							$x1=0; //$_POST['left'];
							$w=400; //$_POST['right'];
							$h=400; //$_POST['bottom'];
						} else {
							$y1=0; //$_POST['top'];
							$x1=0; //$_POST['left'];
							$w=400; //$_POST['right'];
							$h=400; //$_POST['bottom'];
						}
						//echo "<br />y1 ".$y1;
						//echo "<br />x1 ".$x1;
						//echo "<br />w ".$w;
						//echo "<br />h ".$h;

						switch ($uploadImageType) {
    						case IMAGETYPE_JPEG:
    							$im = imagecreatefromjpeg($image);
								$dest = imagecreatetruecolor($w,$h);
								// Crop the resized image
								imagecopyresampled($dest,$im,0,0,$x1,$y1,$w,$h,$w,$h);
								// Upload the new image
								imagejpeg($dest,$uploadPath."thumb_".$resizeFileName.'.'. $fileExt);
								$imageProcess = 1;
    							break;
    
    						case IMAGETYPE_GIF:
    							$im = imagecreatefromgif($image);
								$dest = imagecreatetruecolor($w,$h);
								// Crop the resized image
								imagecopyresampled($dest,$im,0,0,$x1,$y1,$w,$h,$w,$h);
								// Upload the new image
								imagegif($dest,$uploadPath."thumb_".$resizeFileName.'.'. $fileExt);
								$imageProcess = 1;
    							break;
    
    						case IMAGETYPE_PNG:
    							$im = imagecreatefrompng($image);
								$dest = imagecreatetruecolor($w,$h);
								// Crop the resized image
								imagecopyresampled($dest,$im,0,0,$x1,$y1,$w,$h,$w,$h);
								// Upload the new image
								imagepng($dest,$uploadPath."thumb_".$resizeFileName.'.'. $fileExt);
								$imageProcess = 1;
    							break;
    
    						default:
    							$imageProcess = 0;
    							break;
    					}

						//$imageProcess = 1;
					}
					
    				if($imageProcess == 1){
    				?>
    					<div class="alert icon-alert with-arrow alert-success form-alter" role="alert">
    						<i class="fa fa-fw fa-check-circle"></i>
    						<strong> Success ! </strong> <span class="success-message"> Image Resize Successfully </span>
    					</div>
    				<?php
    				// Update database table
    				global $wpdb;
                    
                    $image = "../../".$uploadPath."thumb_".$resizeFileName. ".". $fileExt;
					//$wpdb->query($wpdb->prepare("UPDATE wp_tblMumsDB SET md_baby_scan_image='$image' WHERE md_wp_id=$mumid1"));
    			    
					global $table_prefix;
					$table=$table_prefix.'tblMumsDB';
					$wpdb->update($table, array('md_baby_scan_image'=>$image), array('md_wp_id'=>$mumid1));

    			    // Redirect back to profile page
        			header("Location: /personal-info/");
                    exit();

    				}else{
    				?>
    					<div class="alert icon-alert with-arrow alert-danger form-alter" role="alert">
    						<i class="fa fa-fw fa-times-circle"></i>
    						<strong> Note !</strong> <span class="warning-message">Invalid Image </span>
    					</div>
    				<?php
    				}
    				$imageProcess = 0;
					
    			}
			}
			?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
//get_sidebar();
get_footer();