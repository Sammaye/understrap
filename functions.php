<?php
/**
 * Under Strap functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Admiral_jet
 */

if ( ! function_exists( 'understrap_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function understrap_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on Under Strap, use a find and replace
		 * to change 'understrap' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'understrap', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus( array(
			'primary' => esc_html__( 'Primary', 'understrap' ),
			'social'  => esc_html__('Social Links Menu', 'understrap'),
		) );

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );

		// Set up the WordPress core custom background feature.
		add_theme_support( 'custom-background', apply_filters( 'understrap_custom_background_args', array(
			'default-color' => 'ffffff',
			'default-image' => '',
		) ) );

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		add_theme_support( 'custom-logo', array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		) );
	}
endif;
add_action( 'after_setup_theme', 'understrap_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function understrap_content_width() {
	// This variable is intended to be overruled from themes.
	// Open WPCS issue: {@link https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards/issues/1043}.
	// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
	$GLOBALS['content_width'] = apply_filters( 'understrap_content_width', 1170 );
}
add_action( 'after_setup_theme', 'understrap_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function understrap_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Left sidebar', 'understrap' ),
		'id'            => 'sidebar-left',
		'description'   => esc_html__( 'Add widgets here.', 'understrap' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h4 class="widget-title">',
		'after_title'   => '</h4>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Right sidebar', 'understrap' ),
		'id'            => 'sidebar-right',
		'description'   => esc_html__( 'Add widgets here.', 'understrap' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h4 class="widget-title">',
		'after_title'   => '</h4>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Bottom sidebar', 'understrap' ),
		'id'            => 'sidebar-bottom',
		'description'   => esc_html__( 'Add widgets here.', 'understrap' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s custom-classes">',
		'after_widget'  => '</section>',
		'before_title'  => '<h4 class="widget-title">',
		'after_title'   => '</h4>',
	) );
}
add_action( 'widgets_init', 'understrap_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function understrap_scripts() {
	wp_enqueue_style( 'understrap-bootstrap-css', get_stylesheet_directory_uri() . '/bootstrap.min.css' );
	wp_enqueue_style( 'understrap-fontawesome-css', get_stylesheet_directory_uri() . '/fontawesome.min.css' );
	wp_enqueue_style( 'understrap-blueimp-gallery', get_stylesheet_directory_uri() . '/blueimp-gallery.min.css' );

	wp_enqueue_style( 'understrap-style', get_stylesheet_uri() );

	wp_enqueue_script('jquery');
	/*
	wp_deregister_script('jquery');
	wp_enqueue_script('jquery', 'https://code.jquery.com/jquery-3.3.1.min.js');
	wp_script_add_data(
		'jquery',
		array( 'integrity', 'crossorigin' ),
		array( 'sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=', 'anonymous' )
	);
	*/

	wp_enqueue_script( 'jquery-ui-core' );

	wp_enqueue_script(
		'understrap-bootstrap-js',
		get_template_directory_uri() . '/js/bootstrap.bundle.min.js',
		array( 'jquery', 'jquery-ui-core' ),
		'20151215',
		true
	);

	wp_enqueue_script(
		'understrap-skip-link-focus-fix',
		get_template_directory_uri() . '/js/skip-link-focus-fix.js',
		array(),
		'20151215',
		true
	);

	wp_enqueue_script(
		'understrap-blueimp-gallery',
		get_template_directory_uri() . '/js/jquery.blueimp-gallery.min.js',
		array( 'jquery', 'jquery-ui-core' )
	);

	wp_enqueue_script(
		'understrap-autosize',
		get_template_directory_uri() . '/js/autosize.min.js',
		array(),
		'20151215',
		true
	);

	wp_enqueue_script(
		'understrap-theme-helpers-js',
		get_template_directory_uri() . '/js/theme-helpers.js',
		array( 'jquery', 'jquery-ui-core' ),
		'20151215',
		true
	);

	wp_localize_script( 'understrap-theme-helpers-js', 'params', array(
		'ajaxurl'        => admin_url( 'admin-ajax.php' ),
		'home'           => home_url(),
		'loadingmessage' => __( 'Sending info, please wait...', 'understrap' ),
	) );

	wp_enqueue_script(
		'understrap-theme-js',
		get_template_directory_uri() . '/js/theme.js',
		array( 'jquery', 'jquery-ui-core' ),
		'20151215',
		true
	);

	wp_localize_script( 'understrap-theme-js', 'params', array(
		'ajaxurl' => admin_url( 'admin-ajax.php' ),
		'home'    => home_url(),
	) );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}

add_action( 'wp_enqueue_scripts', 'understrap_scripts' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Custom nav walker for bootstrap nav menus
 */
require get_template_directory() . '/inc/class-custom-walker-nav-menu.php';

/**
 * Custom widget for the social men
 */
require get_template_directory() . '/inc/class-social-menu-widget.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}

/**
 * Load WooCommerce compatibility file.
 */
if ( class_exists( 'WooCommerce' ) ) {
	require get_template_directory() . '/inc/woocommerce.php';
}
