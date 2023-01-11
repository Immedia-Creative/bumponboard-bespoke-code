<?php

/**
* Adds new shortcode "spacer-shortcode" and registers it to
* the WPBakery Visual Composer plugin
*
*/


// If this file is called directly, abort

if ( ! defined( 'ABSPATH' ) ) {
    die ('Silly human what are you doing here');
}


if ( ! class_exists( 'vcspacer' ) ) {

	class vcspacer {


		/**
		* Main constructor
		*
		*/
		public function __construct() {

			// Registers the shortcode in WordPress
			add_shortcode( 'spacer-shortcode', array( 'vcspacer', 'output' ) );

			// Map shortcode to Visual Composer
			if ( function_exists( 'vc_lean_map' ) ) {
				vc_lean_map( 'spacer-shortcode', array( 'vcspacer', 'map' ) );
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
				'name'        => esc_html__( 'Spacer', 'text-domain' ),
				'description' => esc_html__( 'Add new spacer', 'text-domain' ),
				'base'        => 'vc_spacer',
				'category' => __('Immedia', 'text-domain'),
				'icon' => plugin_dir_path( __FILE__ ) . 'assets/img/note.png',
				'params'      => array(
				
					array(
                        'type' => 'textfield',
                        'heading' => __( 'Mobile Height ', 'text-domain' ),
                        'param_name' => 'mobile_height',
                        'value' => __( '', 'text-domain' ),
						"description" => __( "Height of divider on mobile displays (<768px).", "my-text-domain" ),
                        'admin_label' => false,
                        'weight' => 0,
                    ),

                    array(
                        'type' => 'textfield',
                        'heading' => __( 'Tablet Height ', 'text-domain' ),
                        'param_name' => 'tablet_height',
                        'value' => __( '', 'text-domain' ),
						"description" => __( "Height of divider on tablet displays (>768px <992px).", "my-text-domain" ),
                        'admin_label' => false,
                        'weight' => 0,
                    ),
					
                    array(
                        'type' => 'textfield',
                        'heading' => __( 'Desktop Height', 'text-domain' ),
                        'param_name' => 'desktop_height',
                        'value' => __( '', 'text-domain' ),
						"description" => __( "Height of divider on desktop displays (>992px <1200px).", "my-text-domain" ),
                        'admin_label' => false,
                        'weight' => 0,
                    ),
					
                    array(
                        'type' => 'textfield',
                        'heading' => __( 'Large Desktop Height', 'text-domain' ),
                        'param_name' => 'large_desktop_height',
                        'value' => __( '', 'text-domain' ),
						"description" => __( "Height of divider on mobile displays (>1200px).", "my-text-domain" ),
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
						'mobile_height'   => '',
						'tablet_height'   => '',
						'desktop_height'   => '',
						'large_desktop_height' => '',
					),
					$atts
				)
			);
		
			
			

        // Fill $html var with data
	
		$html = '<div class="spacer-wrapper">';
			$html .= '<div class="visible-xs" style="height:' . $mobile_height . '"></div>';
			$html .= '<div class="visible-sm" style="height:' . $tablet_height . '"></div>';
			$html .= '<div class="visible-md" style="height:' . $desktop_height . '"></div>';
			$html .= '<div class="visible-lg" style="height:' . $large_desktop_height . '"></div>';
		$html .= '</div>';


        return $html;
		}

	}

}
new vcspacer;