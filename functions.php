<?php

/**
 * Combine the contents of this file with your child theme's functions.php.
 */


/**
 * This class adds functionality to this theme to display vehicles managed by
 * the Inventory Presser dealership plugin.
 */
class Inventory_Presser_Lift_Kit {

	const CUSTOM_POST_TYPE = 'inventory_vehicle';

	var $settings; //a place to hold the core plugin's option full of settings

	//Add featured image support to vehicles
	function add_thumbnail_support() {
		add_theme_support( 'post-thumbnails', array( self::CUSTOM_POST_TYPE ) );
	}

	//Enqueue scripts and styles.
	function css_and_javascript_includes() {

		$this_theme = wp_get_theme();
		$theme_version = $this_theme->get( 'Version' );

		//FlexSlider Javascript
		wp_enqueue_script(
			'_dealer-flexslider',
			get_stylesheet_directory_uri() . '/js/jquery.flexslider.min.js',
			array('jquery'),
			$theme_version
		);

		//Our FlexSlider initialization JavaScript
		wp_enqueue_script(
			'_dealer-scripts',
			get_stylesheet_directory_uri() . '/js/_dealer.js',
			array('_dealer-flexslider'),
			$theme_version,
			true
		);

		//More FlexSlider JavaScript
		if ( is_singular( self::CUSTOM_POST_TYPE ) ) {
			wp_localize_script(
				'_dealer-scripts',
				'flexslider_opts',
				array(
					'hover_nav' => false,
				)
			);
		}
	}

	function hooks() {
		add_action( 'after_setup_theme', array( $this, 'add_thumbnail_support' ) );
		add_action( 'after_setup_theme', array( $this, 'get_settings' ) );
		add_action( 'widgets_init', array( $this, 'single_vehicle_sidebars' ) );
		if( is_child_theme() ) {
			add_action( 'wp_enqueue_scripts', array( $this, 'include_parent_theme_styles' ) );
		}
		add_action( 'wp_enqueue_scripts', array( $this, 'css_and_javascript_includes' ) );
	}

	//Include the parent theme's stylesheet
	function include_parent_theme_styles() {
	    wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );
	}

	function get_settings() {
		$this->settings = get_option( '_dealer_settings' ); //this is where the plugin Inventory Presser stores its settings
	}

	function have_multiple_locations() {
		$location_info = get_terms( 'location', array(
			'fields'     => 'id=>name',
			'hide_empty' => false
		) );
		return ( count( $location_info ) > 1 );
	}

	//Register widget areas used on vehicle details pages
	function single_vehicle_sidebars() {
		register_sidebar( array(
			'name'          => esc_html__( 'Single Vehicle Right Col', '_dealer' ),
			'id'            => 'sidebar-single-vehicle-right-column',
			'description'   => '',
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		));

		register_sidebar( array(
			'name'          => esc_html__( 'Below Single Vehicle', '_dealer' ),
			'id'            => 'sidebar-below-single-vehicle',
			'description'   => '',
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		));
	}
}
$invp_lift_kit = new Inventory_Presser_Lift_Kit();
$invp_lift_kit->hooks();
