/**
 * This file adds some LIVE to the Theme Customizer live preview. To leverage
 * this, set your custom settings to 'postMessage' and then add your handling
 * here. Your javascript should grab settings from customizer controls, and 
 * then make any necessary changes to the page using jQuery.
 */
( function( $ ) {

	// Update the site title in real time...
	wp.customize( 'blogname', function( value ) {
		value.bind( function( newval ) {
			$( '.site-title a' ).html( newval );
		} );
	} );
	
	//Update the site description in real time...
	wp.customize( 'blogdescription', function( value ) {
		value.bind( function( newval ) {
			$( '.blog-description' ).html( newval );
		} );
	} );

	//Update site font in real time...
	wp.customize( 'headings_font', function( value ) {
		value.bind( function( newval ) {
			$('.blog-description, h1 a, .h1 a, h2 a, .h2 a, h3 a, .h3 a, h4 a, .h4 a, h5 a, .h5 a, h6 a, .h6 a, h1, .h1, h2, .h2, h3, .h3, h4, .h4, h5, .h5, h6, .h6').css('font-family', newval );
		} );
	} );

	//Update site font in real time...
	wp.customize( 'body_font', function( value ) {
		value.bind( function( newval ) {
			$('body').css('font-family', newval );
		} );
	} );

	wp.customize( 'outer_background_color', function( value ) {
		value.bind( function( newval ) {
			$('body').css('background', newval );
		} );
	});

} )( jQuery );
