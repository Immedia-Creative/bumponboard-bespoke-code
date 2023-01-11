<?php

/*
Plugin Name: Immedia - VC Blocks
Description: An extension for Visual Composer that displays Immedia custom blocks
Author: Immedia Creative
Version: 1.0.0
Author URI: https://immedia-creative.com/
*/


// If this file is called directly, abort

if ( ! defined( 'ABSPATH' ) ) {
     die ('Silly human what are you doing here');
}


// Before VC Init

add_action( 'vc_before_init', 'immedia_vc_before_init_actions' );

function immedia_vc_before_init_actions() {

// Require new custom Element

//include( plugin_dir_path( __FILE__ ) . 'service-box-element.php');
//include( plugin_dir_path( __FILE__ ) . 'profile-box-element.php');
//include( plugin_dir_path( __FILE__ ) . 'product-box-element.php');
include( plugin_dir_path( __FILE__ ) . 'spacer-element.php');

}

// Link directory stylesheet

/*function immedia_community_directory_scripts() {
    wp_enqueue_style( 'get_stylesheet_directory',  plugin_dir_url( __FILE__ ) . 'styling/directory-styling.css' );
}
add_action( 'wp_enqueue_scripts', 'immedia_community_directory_scripts' );*/