jQuery(document).ready(function($){
	
$( ".vertical-navbar-close, .navbar-toggle" ).click(function() {
  $( "#body_overlay" ).toggleClass( "on" );
  $( "body" ).toggleClass( "shunt-left" );
});

});