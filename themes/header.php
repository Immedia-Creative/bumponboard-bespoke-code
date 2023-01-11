<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Immedia
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">
<meta name="google-site-verification" content="WeLCsSK7UnpPtGVjsJVfLtyUPR1jvGITZN58HculBRQ" />
<meta name="apple-mobile-web-app-capable" content="yes">
	
<!-- stuff for clipboard and tooltip -->
<script type="text/javascript" src="/wp-content/themes/immedia-child-theme/js/tooltip/clipboard.min.js.download"></script>

<!-- Latest compiled and minified CSS -->

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap-responsive.min.css">

<!-- mailchimp css -->

<link href="//cdn-images.mailchimp.com/embedcode/classic-081711.css" rel="stylesheet" type="text/css">

<!-- Optional theme -->

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap-theme.min.css">

<!-- Latest compiled and minified JavaScript -->

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>

<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>

<!-- hamburger -->

<script src="<?php echo (get_theme_root_uri()); ?>/immedia-theme/bigSlide.js"></script>

<!-- External Fonts -->

<link rel="stylesheet" href="https://use.typekit.net/wxt5mzo.css">

<script>

$(document).ready(function() {

$('.menu-link').bigSlide();

});

</script>

<meta property="og:site_name" content="<?php bloginfo('name'); ?>" />

<meta property="og:title" content="<?php bloginfo('name'); ?>" />

<meta property="og:description" content="<?php bloginfo('description'); ?>" />

<meta property="og:url" content="<?php bloginfo('url'); ?>" />

<meta property="og:type" content="website" />



<script src="https://kit.fontawesome.com/fcc5867676.js" crossorigin="anonymous"></script>

<link href="https://fonts.googleapis.com/icon?family=Material+Icons"
      rel="stylesheet">


<?php $favicon = esc_attr( get_option( 'favicon' ) ); ?>
<?php if($favicon != ''){ ?>
<link rel="icon" href="<?php print $favicon; ?>" type="image/x-icon" />
<link rel="shortcut icon" href="<?php print $favicon; ?>" type="image/x-icon" />
<?php } ?>


<?php $customCSS = esc_attr( get_option( 'css_options' ) ); ?>
<?php $decodeCSS = html_entity_decode($customCSS); ?>
<?php if($customCSS != ''){ ?>
<style>
<?php print $decodeCSS; ?>
</style>
<?php } ?>

<?php $googleAnalytics = esc_attr( get_option( 'google_analytics' ) ); ?>
<?php $decodeAnalytics = html_entity_decode($googleAnalytics); ?>
<?php if($googleAnalytics != ''){ ?>
<script>
<?php print $decodeAnalytics; ?>
</script>
<?php } ?>

<?php $googleMaps = esc_attr( get_option( 'google_maps' ) ); ?>
<?php $decodeMaps = html_entity_decode($googleMaps); ?>
<?php if($googleMaps != ''){ ?>
<script async defer
      src="https://maps.googleapis.com/maps/api/js?key=<?php print $decodeMaps; ?>&callback=initMap">
    </script>
<?php } ?>

<?php wp_head(); ?>

</head>

<body <?php body_class(); ?>>
	
<?PHP
/*display the admin bar to staff*/
show_admin_bar( true );
?>	
	
<div id="page" class="site">
	<div class="container">
	<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'immedia' ); ?></a>
	</div>
	<header id="masthead" class="site-header sticky" role="banner">
	
		<?php $topBar = esc_attr( get_option( 'top_bar' ) );?>
		<?php if($topBar == 'Yes'){	?>
		<?php $containTopbar = esc_attr( get_option( 'contain_topbar' ) ); ?>
		<div class="top-bar-cont dark-blue-swatch hidden-xs">
			<?php if($containTopbar == 'Yes' || $containTopbar == ''){?><div class="container"><?php } ?>	
			<div class="row">	
				<div class="col-md-12">
					<?php
					wp_nav_menu( array(
						'menu'              => '',
						'theme_location'    => 'top-bar-menu',
						'depth'             => 2,
						'container'         => '',
						'container_class'   => 'collapse navbar-collapse',
						'container_id'      => 'bs-example-navbar-collapse-1',
						'menu_class'        => 'nav navbar-nav',
						'fallback_cb'       => 'wp_bootstrap_navwalker::fallback',
						'walker'            => new wp_bootstrap_navwalker())
					);
					?>
				</div>			
			</div>
			<?php if($containTopbar == 'Yes' || $containTopbar == ''){?></div><?php } ?>
		</div>
	<?php } ?>
	
		<div class="top-content">
		
			<?php
			$verticalNav = esc_attr( get_option( 'vertical_nav' ) );
			if($verticalNav == 'On'){ ?>
				<div id="body_overlay"></div>
			<?php } ?>
		
			<?php $containHeader = esc_attr( get_option( 'contain_header' ) ); ?>
			<?php if($containHeader == 'Yes' || $containHeader == ''){?><div class="container"><?php } ?>
			<div class="row">
			
		 		<div class="logo col-lg-2 col-md-2 col-sm-3 col-xs-6 head-left">
				<?php $logo = esc_attr( get_option( 'logo' ) ); ?>
				<?php $logoWidth = esc_attr( get_option( 'logo_width' ) ); ?>
				<?php $logoAltText = esc_attr( get_option( 'logo_alt_text' ) );?>
					<a href="/">
						<img src="<?php print $logo; ?>" <?php if($logoWidth != ''){ ?> style="width:100%; max-width:<?php print $logoWidth; ?>px;" <?php }?> alt="Bump on Board" />
					</a>
					
				<?php $logoText = esc_attr( get_option( 'logo_text' ) ); ?>
				<?php if($logoText != ''){ ?>
					<div class="logo-text-band"><?php print $logoText; ?></div>
				<?php } ?>
				</div>
				
				<div class="col-lg-10 col-md-10  col-xs-6 col-sm-9 head-right">
					<?php dynamic_sidebar( 'header-content' ); ?>
					        <!-- Brand and toggle get grouped for better mobile display -->
<nav class="navbar navbar-default " role="navigation">
	
    <?php $containNavigation = esc_attr( get_option( 'contain_navigation' ) ); ?>
	<?php if($containNavigation == 'Yes' || $containNavigation == ''){?><div class="container"><?php } ?>
	<div class="row">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button"  class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
        </div><!--end navbar-header-->
        <div class="collapse navbar-collapse menu-primary" id="bs-example-navbar-collapse-1">
		
		<?php
		$verticalNav = esc_attr( get_option( 'vertical_nav' ) );
		if($verticalNav == 'On'){ ?>
			<div class="text-right visible-xs visible-sm">
				<div class="modal-close-cont vertical-navbar-close" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
					<span class="material-icons">close</span>
				</div>
			</div>
		<?php } ?>
		
            <?php
            wp_nav_menu( array(
                'menu'              => '',
                'theme_location'    => 'primary',
                'depth'             => 2,
                'container'         => '',
                'container_class'   => 'collapse navbar-collapse',
                'container_id'      => 'bs-example-navbar-collapse-1',
                'menu_class'        => 'nav navbar-nav',
                'fallback_cb'       => 'wp_bootstrap_navwalker::fallback',
                'walker'            => new wp_bootstrap_navwalker())
            );
            ?>
        </div><!--end navbar-colapse-->
	</div>
    <?php if($containNavigation == 'Yes' || $containNavigation == ''){?></div><?php } ?><!--end container-->
</nav>
				</div>
				
			</div>
			<?php if($containHeader == 'Yes' || $containHeader == ''){?></div><?php } ?>
		</div>
		


	</header><!-- #masthead -->
	
	<?php
	$verticalNav = esc_attr( get_option( 'vertical_nav' ) );
		if($verticalNav == 'On'){ ?>
	<div id="body_overlay"></div>
	<?php } ?>
	
	<?php $containBody = esc_attr( get_option( 'contain_body' ) ); ?>
	<?php if($containBody == 'Yes' || $containBody == ''){?><div class="container"><?php } ?>
	<div id="content" class="site-content">
