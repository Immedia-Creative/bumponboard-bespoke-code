<?php

/**
* Adds new shortcode "profile-box-shortcode" and registers it to
* the WPBakery Visual Composer plugin
*
*/


// If this file is called directly, abort

if ( ! defined( 'ABSPATH' ) ) {
    die ('Silly human what are you doing here');
}


if ( ! class_exists( 'vcprofileBox' ) ) {

	class vcprofileBox {


		/**
		* Main constructor
		*
		*/
		public function __construct() {

			// Registers the shortcode in WordPress
			add_shortcode( 'profile-box-shortcode', array( 'vcprofileBox', 'output' ) );

			// Map shortcode to Visual Composer
			if ( function_exists( 'vc_lean_map' ) ) {
				vc_lean_map( 'profile-box-shortcode', array( 'vcprofileBox', 'map' ) );
			}

		}


		/**
		* Map shortcode to VC
    *
    * This is an array of all your settings which become the shortcode attributes ($atts)
		* for the output.
		*
		*/
		public static function map() {
			return array(
				'name'        => esc_html__( 'Profile Box', 'text-domain' ),
				'description' => esc_html__( 'Add new profile box', 'text-domain' ),
				'base'        => 'vc_profilebox',
				'category' => __('Immedia', 'text-domain'),
				'icon' => plugin_dir_path( __FILE__ ) . 'assets/img/note.png',
				'params'      => array(
				
		
					array(
					  "type" => "checkbox",
					  "class" => "",
					  "heading" => __( "Reverse profile box order", "my-text-domain" ),
					  "param_name" => "reverse",
					  "value" => __( "", "text-domain" ),
					  "description" => __( "Reverse profile box layout", "text-domain" )
					),
		
					array(
                        'type' => 'textfield',
                        'heading' => __( 'Profile box title', 'text-domain' ),
                        'param_name' => 'title',
                        'value' => __( '', 'text-domain' ),
                        'admin_label' => false,
                        'weight' => 0,
                    ),
					
					array(
                        'type' => 'dropdown',
                        'heading' => __( 'Profile box title heading type', 'text-domain' ),
                        'param_name' => 'title_holder',
                        'value'       => array(
									'h1'   => 'H1',
									'h2'   => 'H2',
									'h3'   => 'H3',
								  ),
                        'admin_label' => false,
                        'weight' => 0,
                    ),

                    array(
                        'type' => 'textarea_html',
                        'holder' => 'div',
                        'heading' => __( 'Profile box content', 'text-domain' ),
                        'param_name' => 'content',
                        'value' => __( '', 'text-domain' ),
                        'description' => __( 'To add link highlight text or url and click the chain to apply hyperlink', 'text-domain' ),
                        'admin_label' => false,
                        'weight' => 0,
                    ),
					
					array(
						"type" => "attach_image",
						"heading" => __( "Image", "text-domain" ),
						"param_name" => "image",
						"description" => __( "Choose background image", "text-domain" ),
                        'admin_label' => false,
                        'weight' => 0,
					),
					
					array(
						"type" => "vc_link",
						//"holder" => "div",
						"heading" => __( "Image link", "text-domain" ),
						"param_name" => "url_img",
						"description" => __( "Add link to image", "text-domain" ),
                        'admin_label' => false,
                        'weight' => 0,
					),
					
					array(
						"type" => "colorpicker",
						"class" => "",
						"heading" => __( "Background colour", "my-text-domain" ),
						"param_name" => "background_color",
						"value" => '', //Default Red color
						"description" => __( "Choose background colour", "my-text-domain" ),
                        'admin_label' => false,
                        'weight' => 0,
					),
					
					array(
                        'type' => 'textfield',
                        'heading' => __( 'Button text', 'text-domain' ),
                        'param_name' => 'button_text',
                        'value' => __( '', 'text-domain' ),
						"description" => __( "Text on the button", "text-domain" ),
                        'admin_label' => false,
                        'weight' => 0,
                    ),
					
					array(
						"type" => "vc_link",
						//"holder" => "div",
						"heading" => __( "profile box button link", "text-domain" ),
						"param_name" => "url",
						"description" => __( "Link for Key Message", "text-domain" ),
                        'admin_label' => false,
                        'weight' => 0,
					),
					
					array(
						"type" => "colorpicker",
						"class" => "",
						"heading" => __( "Button colour", "my-text-domain" ),
						"param_name" => "button_color",
						"value" => '', //Default Red color
						"description" => __( "Choose button colour", "my-text-domain" ),
                        'admin_label' => false,
                        'weight' => 0,
					),
					
					array(
                        'type' => 'textfield',
                        'heading' => __( 'Extra classes', 'text-domain' ),
                        'param_name' => 'extra_class',
                        'value' => __( '', 'text-domain' ),
						"description" => __( "Extra classes separated by spaces", "my-text-domain" ),
                        'admin_label' => false,
                        'weight' => 0,
                    ),

				),
			);
		}


		/**
		* Shortcode output
		*
		*/
		public static function output( $atts, $content = null ) {

			extract(
				shortcode_atts(
					array(
						'title'   => '',
						'url'   => '',
						//'content'   => '',
						'image'   => '',
						'background_color' => '',
						'button_text' => '',
						'button_color' => '',
						'reverse' => 'false',
						'extra_class' => '',
						'url_img' => '',
						'title_holder' => 'h2'
					),
					$atts
				)
			);

			
			
		//construct link
		$url = ($url=='||') ? '' : $url;
		$url = vc_build_link( $url );
		$a_link = $url['url'];
		$a_title = ($url['title'] == '') ? '' : 'title="'.$url['title'].'"';
		$a_target = ($url['target'] == '') ? '' : 'target="'.$url['target'].'"';
		
		$url_img = ($url_img=='||') ? '' : $url_img;
		$url_img = vc_build_link( $url_img );
		$a_link_img = $url_img['url'];
		$a_title_img = ($url_img['title'] == '') ? '' : 'title="'.$url_img['title'].'"';
		$a_target_img = ($url_img['target'] == '') ? '' : 'target="'.$url_img['target'].'"';
		
		$imgStat = wp_get_attachment_image_src($image, 'full');
		$imgURL = $imgStat[0];
			

        // Fill $html var with data
		
		
		$html = '<div class="profile-box-cont wpb_content_element '. $extra_class .'">';
		
			
			
			$html .= '<div class="vc_col-md-6 profile-box-col text-center';
			if ($reverse == 'true'){
				$html .= ' col-md-push-6';
			}
			$html .= '" style="background-color:'.$background_color.'">';
			
				$html .= '<div class="divider-wrapper" style="visibility:hidden;">';
					$html .= '<div class="vc_hidden-sm vc_hidden-md vc_hidden-lg" style="height:24px;"></div>';
					$html .= '<div class="vc_hidden-xs vc_hidden-md vc_hidden-lg" style="height:24px;"></div>';
					$html .= '<div class="vc_hidden-xs vc_hidden-sm vc_hidden-lg" style="height:100px;"></div>';
					$html .= '<div class="vc_hidden-xs vc_hidden-sm vc_hidden-md" style="height:100px;"></div>';
				$html .= '</div>';
			
				if ($title) {
					$html .= '<' . $title_holder . '>' . $title . '</' . $title_holder . '>';
				}
				if ($content) {
					$html .= '<p>'. $content .'</p>';
				}
				
				if ($url) {
					$html .= '<div class="vc_btn3-container">';
						$html .= '<a class="vc_general vc_btn3 vc_btn3-size-md vc_btn3-shape-square vc_btn3-style-classic" style="color:'.$background_color.'; background:'.$button_color.';" href="'.$a_link. '" '.$a_title.' '.$a_target.'>'.$button_text.'</a>';
					$html .= '</div>';
				}
				
				$html .= '<div class="divider-wrapper" style="visibility:hidden;">';
					$html .= '<div class="vc_hidden-sm vc_hidden-md vc_hidden-lg" style="height:24px;"></div>';
					$html .= '<div class="vc_hidden-xs vc_hidden-md vc_hidden-lg" style="height:24px;"></div>';
					$html .= '<div class="vc_hidden-xs vc_hidden-sm vc_hidden-lg" style="height:100px;"></div>';
					$html .= '<div class="vc_hidden-xs vc_hidden-sm vc_hidden-md" style="height:100px;"></div>';
				$html .= '</div>';
			
			$html .= '</div>';
			
			
				if ($imgURL) {
				$html .= '<div class="vc_col-md-6 profile-box-col profile-image';
				if ($reverse == 'true'){
					$html .= ' col-md-pull-6';
				}
				$html .= '" style="background-image:url(' . $imgURL . ');">';
					if ($a_link_img) {
						$html .= '<a class="profile-image-link" href="'.$a_link_img. '" title="'.$a_title_title.'" target="'.$a_target_target.'"></a>';	
					}
				$html .= '</div>';
				}


		$html .= '</div>';
		
		
		
	
		
		
		
		

        return $html;
		}

	}

}
new vcprofileBox;