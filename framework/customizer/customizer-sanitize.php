<?php 

/**
 * Sanitize Checkbox
 * 
 * @since Mont Blanc 1.0.2
 * @access public
 * @param mixed $input
 * @return int|bool
 */
function montblanc_sanitize_checkbox( $input ) {
    if ( $input ) {
    $output = '1';
    } else {
    $output = false;
    }
    return $output;
}
// -----------------------------------------------------------------------------

/**
* Sanitize opacity
*
* @since Mont Blanc 1.0.2
*
* @param string $opacity opacity type.
*/
function montblanc_sanitize_opacity( $opacity ) {
    if ( empty($opacity) ) {
        $opacity = 90;
    }

    return $opacity;
}
// -----------------------------------------------------------------------------

/**
* Sanitize blog content
*
* @since Mont Blanc 1.0.2
*
* @param string $content content type.
* @return string Filtered content type (content|excerpt).
*/
function montblanc_sanitize_content( $content ) {
    if ( ! in_array( $content, array( 'content', 'excerpt' ) ) ) {
        $content = 'excerpt';
    }

    return $content;
}
// -----------------------------------------------------------------------------

/**
* Sanitize header overlay
*
* @since Mont Blanc 1.0.2
*
* @param string $header header type.
* @return string Filtered header type (yes|no).
*/
function montblanc_sanitize_header_overlay( $header ) {
    if ( ! in_array( $header, array( 'yes', 'no' ) ) ) {
        $header = 'yes';
    }

    return $header;
}
// -----------------------------------------------------------------------------


/**
* Sanitize 'show menu on single pages option'
*
* @since Mont Blanc 1.0.2
*
* @param string $show show type.
* @return string Filtered show type (yes|no).
*/
function montblanc_sanitize_menusingle( $show ) {
    if ( ! in_array( $show, array( 'yes', 'no' ) ) ) {
        $show = 'no';
    }

    return $show;
}
// -----------------------------------------------------------------------------

/**
* Sanitize layout options
*
* @since Mont Blanc 1.0.2
*
* @param string $layout Layout type.
* @return string Filtered layout type (left|full_width|right).
*/
function montblanc_sanitize_layout( $layout ) {
    if ( ! in_array( $layout, array( 'left', 'full_width', 'right' ) ) ) {
        $layout = 'right';
    }

    return $layout;
}
// -----------------------------------------------------------------------------

/**
* Sanitize color options
*
* @since Mont Blanc 1.0.2
*
* @param string $color Color type.
* @return string Filtered color type (turquoise|blue|red|yellow|green|pink|purple|beige|gray).
*/
function montblanc_sanitize_header_color( $color ) {
    if ( ! in_array( $color, array( "turquoise","blue","red","yellow","green","pink","purple","beige","gray" ) ) ) {
        $color = 'blue';
    }

    return $color;
}
// -----------------------------------------------------------------------------

/**
* Sanitize site font
*
* @since Mont Blanc 1.0.8
*
* @param string $font font type.
* @return string Filtered font type (Helvetica Neue|Open Sans|Arial|Comic Sans MS|Times New Roman|Verdana|Fantasy|Monospace|Cursive|Serif|Courier|Monaco).
*/
function montblanc_sanitize_fontfamily( $font ) {
    if ( ! in_array( $font, array( 'Helvetica Neue', 'Open Sans', 'Arial', 'Comic Sans MS', 'Times New Roman', 'Verdana', 'Fantasy', 'Monospace', 'Cursive', 'Serif', 'Courier', 'Monaco' ) ) ) {
        $font = 'Helvetica Neue';
    }

    return $font;
}
// -----------------------------------------------------------------------------

/**
* Sanitize container style
*
* @since Mont Blanc 3.1
*
* @param string $width Width type.
* @return string Filtered Width type (970px|1170px).
*/
function montblanc_sanitize_container_style( $width ) {
    if ( ! in_array( $width, array( 'full_width', 'boxed' ) ) ) {
        $width = 'full_width';
    }

    return $width;
}
// -----------------------------------------------------------------------------

/**
* Background attachement
* @param string $attachment Width type.
* @return string Filtered Width type (fixed|scroll).
*/
function montblanc_sanitize_background_attachment( $attachment ) {
    if ( ! in_array( $attachment, array( 'fixed', 'scroll' ) ) ) {
        $attachment = 'fixed';
    }

    return $attachment;
}
// -----------------------------------------------------------------------------