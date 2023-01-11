<?php

/**
* Adds new shortcode "service-box-shortcode" and registers it to
* the WPBakery Visual Composer plugin
*
*/


// If this file is called directly, abort

if ( ! defined( 'ABSPATH' ) ) {
    die ('Silly human what are you doing here');
}


if ( ! class_exists( 'vcserviceBox' ) ) {

	class vcserviceBox {


		/**
		* Main constructor
		*
		*/
		public function __construct() {

			// Registers the shortcode in WordPress
			add_shortcode( 'service-box-shortcode', array( 'vcserviceBox', 'output' ) );

			// Map shortcode to Visual Composer
			if ( function_exists( 'vc_lean_map' ) ) {
				vc_lean_map( 'service-box-shortcode', array( 'vcserviceBox', 'map' ) );
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
				'name'        => esc_html__( 'Service Box', 'text-domain' ),
				'description' => esc_html__( 'Add new service box', 'text-domain' ),
				'base'        => 'vc_servicebox',
				'category' => __('Immedia', 'text-domain'),
				'icon' => plugin_dir_path( __FILE__ ) . 'assets/img/note.png',
				'params'      => array(
				
					array(
						"type" => "vc_link",
						//"holder" => "div",
						"heading" => __( "Service box link", "text-domain" ),
						"param_name" => "url",
						"description" => __( "Link for Key Message", "text-domain" ),
					),
					array(
                        'type' => 'textfield',
                        'holder' => 'h3',
                        'heading' => __( 'Service box title', 'text-domain' ),
                        'param_name' => 'title',
                        'value' => __( '', 'text-domain' ),
                        'admin_label' => false,
                        'weight' => 0,
                    ),

                    array(
                        'type' => 'textarea_html',
                        'holder' => 'div',
                        'heading' => __( 'Service box content', 'text-domain' ),
                        'param_name' => 'content',
                        'value' => __( '', 'text-domain' ),
                        'description' => __( 'To add link highlight text or url and click the chain to apply hyperlink', 'text-domain' ),
                        // 'admin_label' => false,
                        // 'weight' => 0,
                    ),
					
					array(
						"type" => "attach_image",
						"heading" => __( "Image", "text-domain" ),
						"param_name" => "image",
						"description" => __( "Choose image", "text-domain" )
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
						'extra_class' => '',
					),
					$atts
				)
			);
			
		 $selectTheme = $atts['theme'];
			
			
		//construct link
		$url = ($url=='||') ? '' : $url;
		$url = vc_build_link( $url );
		$a_link = $url['url'];
		$a_title = ($url['title'] == '') ? '' : 'title="'.$url['title'].'"';
		$a_target = ($url['target'] == '') ? '' : 'target="'.$url['target'].'"';
		$imgStat = wp_get_attachment_image_src($image, 'full');
		$imgURL = $imgStat[0];
			

        // Fill $html var with data
		if ($a_link) {
			$html = '<a class="service-box-link" href="'.$a_link. '" '.$a_title.' '.$a_target.'>';
		}
				$html .= '<div class="service-box-cont wpb_content_element '. $extra_class .'">';
			
					if ( $imgURL != ""){
					$html .= '<div class="service-box-image" style="background-image:url(' . $imgURL . ');"></div>';
					}
					$html .= '<div class="service-box">';
					
						$html .= '<div class="service-box-content">';
						if ($title) {
							$html .= '<h3>' . $title . '</h3>';
						}
						if ($content) {
							$html .= '<p>'. $content .'</p>';
						}
						$html .= '</div>';
					
					$html .= '</div>';
		
				$html .= '</div>';
		
		if ($a_link) {
			$html .= '</a>';
		}


        return $html;
		}

	}

}
new vcserviceBox;