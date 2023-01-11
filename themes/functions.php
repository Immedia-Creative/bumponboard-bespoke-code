<?php //

add_action('wp_enqueue_scripts', 'enqueue_parent_styles');
function enqueue_parent_styles()
{
    wp_enqueue_style('parent-style', get_template_directory_uri() . '/style.css');
}

add_action('wp_enqueue_scripts', 'enqueue_child_js');
function enqueue_child_js()
{
    wp_register_script('custom_script', get_stylesheet_directory_uri() . '/js/custom.js',   array('jquery'),   '1.0', true);
    wp_enqueue_script('custom_script');
}
//hide admin bar from mums

add_action('after_setup_theme', 'remove_admin_bar');
function remove_admin_bar()
{
    if (!current_user_can('administrator') && !is_admin()) {
        show_admin_bar(false);
    }
}

//add options page (acf)

if( function_exists('acf_add_options_page') ) {
	
	acf_add_options_page();
	
}



//Add ability to click parent menu items
function immedia_get_navwalker()
{
    require get_stylesheet_directory() . '/inc/wp_bootstrap_navwalker.php';
}
add_action('after_setup_theme', 'immedia_get_navwalker');



// generate bookmarklet button with user id attached
function generate_bmbutton()
{

    // Things that you want to do. 
    // $message = '<a class="button" href="javascript:(function(){document.body.appendChild(document.createElement(\'script\')).src=\'https://bumponboard.co.uk/wp-content/plugins/gift-picker/bookmarklet-page.js?id=';
    // $message .= get_current_user_id();
    // $message .= '\';})();">Bump On Board</a>';

    $message = '<div class="gift-picker-cont">';
		$message .= '<a class="bm-button vc_general vc_btn3 vc_btn3-size-md vc_btn3-shape-rounded vc_btn3-style-classic vc_btn3-color-pink" href="javascript:(function() { var jsCode = document.createElement(\'script\'); var parameter =';
		$message .= get_current_user_id();
		$message .= '; jsCode.onload = function() { if(typeof special_func == \'function\') special_func(parameter); }; jsCode.setAttribute(\'src\', \'';
		$message .= site_url('/');
		//$message .= 'wp-content/plugins/gift-picker/bookmarklet-page.js\'); document.body.appendChild(jsCode); }) ();">Add To Bump List</a>';
		$message .= 'wp-content/plugins/gift-picker/bookmarklet-page.js\'); document.body.appendChild(jsCode); }) ();">Add To Gift Picker</a>';
        $message .= '<img class="button-instructions" src="/wp-content/uploads/2021/08/drag-me-up.png" alt="Drag me up" />';
    $message .= '</div>';

    // $message = '<a class="button" href="javascript:(function(){document.body.appendChild(document.createElement(\'script\')).src=\'http://localhost/bumponboard/wp-content/plugins/gift-picker/bookmarklet-page.js?id=';
    // $message .= get_current_user_id();
    // $message .= '\';})();">Bump On Board</a>';

    // Output needs to be return
    return $message;
}

function generate_login()
{

    $message = '<p class="text-center">Please <a class="button" href="';
    $message .= site_url('/');
    $message .= 'member-login">login here</a> to download the gift picker.</p>';
    //$message .= 'member-login?redirect_to=https://www.bumponboard.co.uk/gift-picker/">Login here </a>';
    // Output needs to be return
    return $message;
}
// register shortcode
if (is_user_logged_in()) {
    add_shortcode('bmbutton', 'generate_bmbutton');
} else {
    add_shortcode('bmbutton', 'generate_login');
}



//Change mobile nav to work at 991 rather than 768
function immedia_get_verticalnav()
{
    $verticalNav = esc_attr(get_option('vertical_nav'));
    if ($verticalNav == 'On') {
        //includes change @media to 991 and custom css to call nav hamburger earlier
        wp_enqueue_style('immedia-vertical-nav-css', get_stylesheet_directory_uri() . '/inc/vertical-nav/vertical-nav.css');
        wp_enqueue_script('immedia-vertical-nav-js', get_stylesheet_directory_uri() . '/inc/vertical-nav/vertical-nav.js', array(), '20151215', true);
    }
}
add_action('wp_enqueue_scripts', 'immedia_get_verticalnav');


// Owl slider
function owl_slider()
{
    wp_enqueue_script('owl-slider-js', get_stylesheet_directory_uri() . '/js/owlcarousel/owl.carousel.min.js', array(), '20151215', true);
    wp_enqueue_style('owl-slider-css', get_stylesheet_directory_uri() . '/js/owlcarousel/owl.carousel.min.css');
    wp_enqueue_style('owl-slider-theme', get_stylesheet_directory_uri() . '/js/owlcarousel/owl.theme.default.min.css');
}
add_action('wp_enqueue_scripts', 'owl_slider');

	
	//Fetch match height js library
 function match_height() {
			wp_enqueue_script( 'match_height-js', get_stylesheet_directory_uri() . '/js/jquery-match-height/jquery.matchHeight.js', array(), '20151215', true );
    }
	add_action('wp_enqueue_scripts', 'match_height');


// Masonry
function masonry()
{
    wp_enqueue_script('custom_masonry',  get_stylesheet_directory_uri() . '/js/masonry.pkgd.min.js', array('jquery'),   '1.0', false);
    wp_enqueue_script('custom_imagesLoaded',  get_stylesheet_directory_uri() . '/js/imagesloaded.pkgd.min.js', array('jquery'),   '1.0', false);
}
add_action('wp_enqueue_scripts', 'masonry');

//Ajax grid filter
function product_enqueue_script()
{
    wp_enqueue_script('productajax', get_stylesheet_directory_uri() . '/js/productajax.js', array(), '20151215', true);
}
add_action('wp_enqueue_scripts', 'product_enqueue_script');


// Custom WordPress login form add placeholder

if (!function_exists('load_theme_scripts')) {
    function load_theme_scripts()
    {
        wp_register_script('theme_js', get_stylesheet_directory_uri() . '/js/theme.js', array('jquery'), '1.0', true); // register theme.js script
        // add localize support for our placeholder
        $translation_placeholder = array(
            'usernamePlaceholder' => __('Email', 'SHOMTek'), // variable for username placeholder
            'passwordPlaceholder' => __('Password', 'SHOMTek'), // variable for password placeholder
            'newPasswordPlaceholder' => __('New password', 'SHOMTek'), // variable for password placeholder
            'repeatPasswordPlaceholder' => __('Repeat new password', 'SHOMTek'), // variable for password placeholder
        );
        wp_localize_script('theme_js', 'placeHolderForTopBar', $translation_placeholder); // hook wp_localize_script

        wp_enqueue_script('theme_js'); // load our theme.js script
    }
}
add_action('wp_enqueue_scripts', 'load_theme_scripts');



// stop wordpress removing a tags
function uncoverwp_tiny_mce_fix($init)
{
    // html elements being stripped
    $init['extended_valid_elements'] = 'a[*]';

    // pass back to wordpress
    return $init;
}
add_filter('tiny_mce_before_init', 'uncoverwp_tiny_mce_fix');

add_action('rest_api_init', 'gift_picker_backend_api', 99999);

function apiResponse($status, $success, $message = '', $data = []){
    $response = [];
    $response['data']       = $data;
    $response['status']     = $status;
    $response['message']    = $message;
    $response['success']    = $success;
    wp_send_json($response);
}

function gift_picker_backend_api()
{
    register_rest_route('gift-picker/api/v1', 'create', array(
        'methods' => 'POST',
        'callback' => 'wp_add_new_product',
    ));
}

$base_url = site_url('/');
wp_register_script('my-script', "$base_url/wp-content/plugins/gift-picker/bookmarklet-page.js");
$translation_array = array('baseUrl' => site_url('/'));
wp_localize_script('my-script', 'object_name', $translation_array);
wp_enqueue_script('my-script');


function wp_add_new_product($request)
{

    try {
        // var_dump(is_user_logged_in());
        $headers = $request->get_headers();
        // print_r($headers);
        //         die;
        // if($headers['api_key'][0]  !== 'alksdjflksadjflksadjflsakdfj'){
        //     return apiResponse(401, false, '401 Unauthorized');     
        // }
        if (!isset($_POST['user_id'])) {
            return apiResponse(422, false, 'title is required');
        }
        if (!isset($_POST['title'])) {
            return apiResponse(422, false, 'title is required');
        }
        // if(!isset($_POST['price'])){
        //     return apiResponse( 422, false, 'price is required');     
        // }
        if (!isset($_POST['category'])) {
            return apiResponse(422, false, 'category is required');
        }
        if (!isset($_POST['location'])) {
            return apiResponse(422, false, 'location is required');
        }
        if (!isset($_POST['image'])) {
            return apiResponse(422, false, 'image is required');
        }
        global $wpdb;

        // $inputValue = $_POST['newValue'];
        $data = $wpdb->insert(
            'wp_tblProductsDB',
            array(
                'pd_user_id'   => $_POST['user_id'],
                'pd_prod_title'     => $_POST['title'],
                'pd_price'     => $_POST['price'],
                'pd_ld_id'  => $_POST['category'],
                'pd_prod_url1'  => $_POST['location'],
                'pd_prod_image'     => $_POST['image']
            )
        );

        // echo site_url('/');
        if ($data) {
            return apiResponse(200, true, 'data saved');
        } else {
            return apiResponse(400, false, 'Unable to save data');
        }
    } catch (\Exception $ex) {
        return apiResponse(500, false, $ex->getMessage());
    }
}

// Redirect gift-picker to gift-picker-instructions if not logged in

add_action ( 'template_redirect', 'redirect_gift_picker' );
function redirect_gift_picker(){
    if ( !is_user_logged_in() && is_page('gift-picker') ) {
        wp_redirect('/gift-picker-instructions/') ;
        exit();
    }
}
