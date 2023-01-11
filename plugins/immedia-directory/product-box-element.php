<?php

/**
* Adds new shortcode "product-box-shortcode" and registers it to
* the WPBakery Visual Composer plugin
*
*/


// If this file is called directly, abort

if ( ! defined( 'ABSPATH' ) ) {
    die ('Silly human what are you doing here');
}


if ( ! class_exists( 'vcproductBox' ) ) {

	class vcproductBox {


		/**
		* Main constructor
		*
		*/
		public function __construct() {

			// Registers the shortcode in WordPress
			add_shortcode( 'product-box-shortcode', array( 'vcproductBox', 'output' ) );

			// Map shortcode to Visual Composer
			if ( function_exists( 'vc_lean_map' ) ) {
				vc_lean_map( 'product-box-shortcode', array( 'vcproductBox', 'map' ) );
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
				'name'        => esc_html__( 'Product Box', 'text-domain' ),
				'description' => esc_html__( 'Add new product box', 'text-domain' ),
				'base'        => 'vc_productbox',
				'category' => __('Immedia', 'text-domain'),
				'icon' => plugin_dir_path( __FILE__ ) . 'assets/img/note.png',
				'params'      => array(
				
		
					array(
                        'type' => 'textfield',
                        'heading' => __( 'product box title', 'text-domain' ),
                        'param_name' => 'title',
                        'value' => __( '', 'text-domain' ),
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
						"heading" => __( "Box link", "text-domain" ),
						"param_name" => "url",
						"description" => __( "Add link to Product box", "text-domain" ),
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
						'image'   => '',
						'background_color' => '',
						'extra_class' => '',
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
		
		$imgStat = wp_get_attachment_image_src($image, 'smallproductimage');
		$imgURL = $imgStat[0];
			

        // Fill $html var with data
		
		if ($url) {
		$html = '<a class="product-box-link" href="'.$a_link. '" '.$a_title.' '.$a_target.'>';
		}
		
		$html .= '<div class="product-box-cont wpb_content_element '. $extra_class .'">';
			
			$html .= '<div class="vc_col-sm-6 product-box-col text-center" style="background-color:'.$background_color.'">';
			
				$html .= '<div class="divider-wrapper" style="visibility:hidden;">';
					$html .= '<div class="vc_hidden-sm vc_hidden-md vc_hidden-lg" style="height:70px;"></div>';
					$html .= '<div class="vc_hidden-xs vc_hidden-md vc_hidden-lg" style="height:80px;"></div>';
					$html .= '<div class="vc_hidden-xs vc_hidden-sm vc_hidden-lg" style="height:80px;"></div>';
					$html .= '<div class="vc_hidden-xs vc_hidden-sm vc_hidden-md" style="height:80px;"></div>';
				$html .= '</div>';
			
				if ($title) {
					$html .= '<div class="product-heading-cont">';
						$html .= '<h2>' . $title . '</h2>';
					$html .= '</div>';
				}
				
				$html .= '<div class="divider-wrapper" style="visibility:hidden;">';
					$html .= '<div class="vc_hidden-sm vc_hidden-md vc_hidden-lg" style="height:70px;"></div>';
					$html .= '<div class="vc_hidden-xs vc_hidden-md vc_hidden-lg" style="height:80px;"></div>';
					$html .= '<div class="vc_hidden-xs vc_hidden-sm vc_hidden-lg" style="height:80px;"></div>';
					$html .= '<div class="vc_hidden-xs vc_hidden-sm vc_hidden-md" style="height:80px;"></div>';
				$html .= '</div>';
			
			$html .= '</div>';
			
			
				if ($imgURL) {
				$html .= '<div class="vc_col-sm-6 product-box-col product-image" style="background-image:url(' . $imgURL . ');">';
				$html .= '</div>';
				}


		$html .= '</div>';
		
		if ($url) {
		$html .= '</a>';
		}
		
		
	
		
		
		
		

        return $html;
		}

	}

}
new vcproductBox;