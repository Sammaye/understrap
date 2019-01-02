<?php
/**
 * Under Strap Theme Customizer
 *
 * @package Admiral_jet
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function understrap_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';

	if ( isset( $wp_customize->selective_refresh ) ) {
		$wp_customize->selective_refresh->add_partial( 'blogname', array(
			'selector'        => '.site-title a',
			'render_callback' => 'understrap_customize_partial_blogname',
		) );
		$wp_customize->selective_refresh->add_partial( 'blogdescription', array(
			'selector'        => '.site-description',
			'render_callback' => 'understrap_customize_partial_blogdescription',
		) );

		$wp_customize->add_section( 'understrap_settings', array(
			'title'       => __( 'Under Strap Settings', 'understrap' ),
			'description' => __( 'Customise the Under Strap theme', 'understrap' ),
			'priority'    => 160,
			'capability'  => 'edit_theme_options',
		) );

		/** todo figure out how to automate
		$wp_customize->add_setting( 'understrap_sidebar_position', array(
			'type'              => 'theme_mod',
			'capability'        => 'edit_theme_options',
			'default'           => 'right',
			'transport'         => 'refresh',
			'validate_callback' => function ( $validity, $value ) {
				if ( ! in_array( $value, [
					'left',
					'right',
					'bottom',
					'left_right',
					'left_bottom',
					'right_bottom',
					'all',
					'none',
				] ) ) {
					$validity->add( 'invalid_value', __( 'Invalid value', 'understrap' ) );
				}
				return $validity;
			},
		) );

		$wp_customize->add_control( 'understrap_sidebar_position', array(
			'type'        => 'select',
			'priority'    => 10,
			'section'     => 'understrap_settings',
			'label'       => __( 'Sidebar position', 'understrap' ),
			'description' => __( 'Choose position of the sidebar' ),
			'choices'     => array(
				'left'  => __( 'Left', 'understrap' ),
				'right' => __( 'Right', 'understrap' ),
				'bottom' => __( 'Bottom', 'understrap' ),
				'left_right' => __( 'Left and right', 'understrap' ),
				'left_bottom' => __( 'Left and Bottom', 'understrap' ),
				'right_bottom' => __( 'Right and bottom', 'understrap' ),
				'all'  => __( 'All', 'understrap' ),
				'none'  => __( 'None', 'understrap' ),
			),
		) );
		 */

		$wp_customize->add_setting( 'understrap_container_class', array(
			'type'       => 'theme_mod',
			'capability' => 'edit_theme_options',
			'default'    => 'container',
			'transport'  => 'refresh',
			'validate_callback' => function ( $validity, $value ) {
				if ( ! in_array( $value, [
					'container',
					'container-fluid',
				] ) ) {
					$validity->add( 'invalid_value', __( 'Invalid value', 'understrap' ) );
				}
				return $validity;
			},
		) );

		$wp_customize->add_control( 'understrap_container_class', array(
			'type'        => 'select',
			'priority'    => 10,
			'section'     => 'understrap_settings',
			'label'       => __( 'Container', 'understrap' ),
			'description' => __( 'Choose the type of content container', 'understrap' ),
			'choices'     => array(
				'container'       => __( 'Fix width container', 'understrap' ),
				'container-fluid' => __( 'Full width container', 'understrap' ),
			)
		) );
	}
}
add_action( 'customize_register', 'understrap_customize_register' );

/**
 * Render the site title for the selective refresh partial.
 *
 * @return void
 */
function understrap_customize_partial_blogname() {
	bloginfo( 'name' );
}

/**
 * Render the site tagline for the selective refresh partial.
 *
 * @return void
 */
function understrap_customize_partial_blogdescription() {
	bloginfo( 'description' );
}

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function understrap_customize_preview_js() {
	wp_enqueue_script(
		'understrap-customizer',
		get_template_directory_uri() . '/js/customizer.js',
		array( 'customize-preview', 'jquery' ),
		'20151215',
		true
	);
}
add_action( 'customize_preview_init', 'understrap_customize_preview_js' );
