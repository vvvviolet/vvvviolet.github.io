jQuery(document).ready(function($) {

	$( "#accordion-section-montblanc_header_section" ).append( '<span class="newFeature">New</span>' );
	$( "#customize-control-montblanc_header_background_position" ).append( '<span class="newFeature">New</span>' );

	$( "#accordion-panel-montblanc_layout_panel" ).append( '<span class="newFeature">New</span>' );
	$( "#accordion-section-montblanc_site_layout" ).append( '<span class="newFeature">New</span>' );
	$( "#customize-control-montblanc_option_container_style" ).append( '<span class="newFeature">New</span>' );
	$( "#customize-control-montblanc_outer_background_color" ).append( '<span class="newFeature">New</span>' );

	// Hide options
	if( $('#customize-control-montblanc_option_container_style input[value="boxed"]').is(':checked') ) {
		$('#customize-control-montblanc_outer_background_color').css('display', 'block');
	}
	if( $('#customize-control-montblanc_option_container_style input[value="full_width"]').is(':checked') ) {
		$('#customize-control-montblanc_outer_background_color').css('display', 'none');
	}

	$('#customize-control-montblanc_option_container_style input[value="boxed"]').change(function(){
		if(this.checked) {
			$('#customize-control-montblanc_outer_background_color').fadeIn('slow');
		} else {
			$('#customize-control-montblanc_outer_background_color').fadeOut('slow');
		}
	});

	$('#customize-control-montblanc_option_container_style input[value="full_width"]').change(function(){
		if(this.checked) {
			$('#customize-control-montblanc_outer_background_color').fadeOut('slow');
		} else {
			$('#customize-control-montblanc_outer_background_color').fadeIn('slow');
		}
	});

});