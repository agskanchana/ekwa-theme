<?php
/**
 * EKWA Customizer Front-End Output
 *
 * Outputs all theme CSS variables via wp_head at priority 1,
 * ensuring variables are declared before any stylesheet uses them.
 *
 * @package ekwa
 */

add_action( 'wp_head', 'ekwa_output_theme_css_variables', 1 );

function ekwa_output_theme_css_variables() {

    // --- Brand Colors ---
    $color_one        = sanitize_hex_color( get_theme_mod( 'color_one',        '#000000' ) );
    $color_two        = sanitize_hex_color( get_theme_mod( 'color_two',        '#1e73be' ) );
    $color_three      = sanitize_hex_color( get_theme_mod( 'color_three',      '#30475e' ) );
    $color_four       = sanitize_hex_color( get_theme_mod( 'color_four',       '#f2a365' ) );
    $color_five       = sanitize_hex_color( get_theme_mod( 'color_five',       '#639a67' ) );
    $color_text       = sanitize_hex_color( get_theme_mod( 'color_text',       '#000000' ) );
    $color_link       = sanitize_hex_color( get_theme_mod( 'color_link',       '#1b315e' ) );
    $color_link_hover = sanitize_hex_color( get_theme_mod( 'color_link_hover', '#000000' ) );
    $color_headings   = sanitize_hex_color( get_theme_mod( 'color_headings',   '#000000' ) );
    $color_invert     = sanitize_hex_color( get_theme_mod( 'color_invert',     '#ffffff' ) );

    // --- Font Sizes ---
    $h1_size   = absint( get_theme_mod( 'font_size_h1',   36 ) );
    $h2_size   = absint( get_theme_mod( 'font_size_h2',   24 ) );
    $h3_size   = absint( get_theme_mod( 'font_size_h3',   20 ) );
    $body_size = absint( get_theme_mod( 'body_font_size', 16 ) );

    // --- Heading & Body Colors ---
    $h1_color   = sanitize_hex_color( get_theme_mod( 'headings_h1_color', '#000000' ) );
    $h2_color   = sanitize_hex_color( get_theme_mod( 'headings_h2_color', '#000000' ) );
    $h3_color   = sanitize_hex_color( get_theme_mod( 'headings_h3_color', '#000000' ) );
    $body_color = sanitize_hex_color( get_theme_mod( 'body_color',        '#404040' ) );

    // --- Font Families ---
    // Kirki 3.x stores weight as 'font-weight'; Kirki 4.x uses 'variant'. Check both.
    $font_default = array( 'font-family' => 'Helvetica', 'variant' => 'normal', 'font-style' => 'normal' );

    $body_font   = get_theme_mod( 'font_body',        $font_default );
    $mobile_font = get_theme_mod( 'font_mobile',      $font_default );
    $h1_font     = get_theme_mod( 'typo_h1_fonts',    $font_default );
    $h2_font     = get_theme_mod( 'typo_h2_fonts',    $font_default );
    $h3_font     = get_theme_mod( 'typo_h3_fonts',    $font_default );
    $add_font_1  = get_theme_mod( 'addtional_font_1', $font_default );
    $add_font_2  = get_theme_mod( 'addtional_font_2', $font_default );

    // Named font slots
    $font_two   = get_theme_mod( 'font_two',   array() );
    $font_three = get_theme_mod( 'font_three', array() );
    $font_four  = get_theme_mod( 'font_four',  array() );
    $font_five  = get_theme_mod( 'font_five',  array() );

    // Helpers
    $get_family = function( $font ) use ( $font_default ) {
        return esc_attr( ! empty( $font['font-family'] ) ? $font['font-family'] : $font_default['font-family'] );
    };
    $get_weight = function( $font ) {
        if ( ! empty( $font['font-weight'] ) ) return esc_attr( $font['font-weight'] );
        if ( ! empty( $font['variant'] ) )     return esc_attr( $font['variant'] );
        return 'normal';
    };
    $get_style = function( $font ) {
        return esc_attr( ! empty( $font['font-style'] ) ? $font['font-style'] : 'normal' );
    };

    ?>
<style id="ekwa-css-variables">
    :root {
        /* Brand Colors */
        --color_one:        <?php echo $color_one; ?>;
        --color_two:        <?php echo $color_two; ?>;
        --color_three:      <?php echo $color_three; ?>;
        --color_four:       <?php echo $color_four; ?>;
        --color_five:       <?php echo $color_five; ?>;

        /* Text / Link Colors */
        --color_text:       <?php echo $color_text; ?>;
        --color_link:       <?php echo $color_link; ?>;
        --color_link_hover: <?php echo $color_link_hover; ?>;
        --color_headings:   <?php echo $color_headings; ?>;
        --color_invert:     <?php echo $color_invert; ?>;

        /* Body Typography */
        --font_body:      <?php echo $get_family( $body_font ); ?>;
        --body_variant:   <?php echo $get_weight( $body_font ); ?>;
        --body_style:     <?php echo $get_style( $body_font ); ?>;
        --body-font-size: <?php echo $body_size; ?>px;
        --body-color:     <?php echo $body_color; ?>;

        /* Mobile Typography */
        --mobile_body:    <?php echo $get_family( $mobile_font ); ?>;
        --mobile_variant: <?php echo $get_weight( $mobile_font ); ?>;
        --mobile_style:   <?php echo $get_style( $mobile_font ); ?>;

        /* Heading H1 */
        --heading_h1:         <?php echo $get_family( $h1_font ); ?>;
        --heading_h1_variant: bold;
        --heading_h1_style:   <?php echo $get_style( $h1_font ); ?>;
        --heading-h1-size:    <?php echo $h1_size; ?>px;
        --heading_h1_color:   <?php echo $h1_color; ?>;

        /* Heading H2 */
        --heading_h2:         <?php echo $get_family( $h2_font ); ?>;
        --heading_h2_variant: bold;
        --heading_h2_style:   <?php echo $get_style( $h2_font ); ?>;
        --heading-h2-size:    <?php echo $h2_size; ?>px;
        --heading_h2_color:   <?php echo $h2_color; ?>;

        /* Heading H3 */
        --heading_h3:         <?php echo $get_family( $h3_font ); ?>;
        --heading_h3_variant: bold;
        --heading_h3_style:   <?php echo $get_style( $h3_font ); ?>;
        --heading-h3-size:    <?php echo $h3_size; ?>px;
        --heading_h3_color:   <?php echo $h3_color; ?>;

        /* Additional Fonts */
        --font-1:   <?php echo $get_family( $add_font_1 ); ?>;
        --font-w-1: <?php echo $get_weight( $add_font_1 ); ?>;
        --font-s-1: <?php echo $get_style( $add_font_1 ); ?>;

        --font-2:   <?php echo $get_family( $add_font_2 ); ?>;
        --font-w-2: <?php echo $get_weight( $add_font_2 ); ?>;
        --font-s-2: <?php echo $get_style( $add_font_2 ); ?>;

        <?php if ( ! empty( $font_two['font-family'] ) ) : ?>
        --font_two:    <?php echo esc_attr( $font_two['font-family'] ); ?>;
        --varient_two: <?php echo esc_attr( ! empty( $font_two['font-weight'] ) ? $font_two['font-weight'] : ( ! empty( $font_two['variant'] ) ? $font_two['variant'] : 'normal' ) ); ?>;
        <?php endif; ?>
        <?php if ( ! empty( $font_three['font-family'] ) ) : ?>
        --font_three:    <?php echo esc_attr( $font_three['font-family'] ); ?>;
        --varient_three: <?php echo esc_attr( ! empty( $font_three['font-weight'] ) ? $font_three['font-weight'] : ( ! empty( $font_three['variant'] ) ? $font_three['variant'] : 'normal' ) ); ?>;
        <?php endif; ?>
        <?php if ( ! empty( $font_four['font-family'] ) ) : ?>
        --font_four:    <?php echo esc_attr( $font_four['font-family'] ); ?>;
        --varient_four: <?php echo esc_attr( ! empty( $font_four['font-weight'] ) ? $font_four['font-weight'] : ( ! empty( $font_four['variant'] ) ? $font_four['variant'] : 'normal' ) ); ?>;
        <?php endif; ?>
        <?php if ( ! empty( $font_five['font-family'] ) ) : ?>
        --font_five:    <?php echo esc_attr( $font_five['font-family'] ); ?>;
        --varient_five: <?php echo esc_attr( ! empty( $font_five['font-weight'] ) ? $font_five['font-weight'] : ( ! empty( $font_five['variant'] ) ? $font_five['variant'] : 'normal' ) ); ?>;
        <?php endif; ?>
    }
    .kirki-customizer-loading-wrapper {
        background-image: none !important;
    }
</style>
<script>
    var EnableservicesCarousel    = false;
    var EnablereviewCarousel      = false;
    var EnablearticlesCarousel    = false;
    var enableBeforeAfterCarousel = false;
</script>
    <?php
}