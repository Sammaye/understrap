<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package Admiral_jet
 */

/**
 * Adds the custom social menu widget
 */
function understrap_add_social_menu_widget() {
	return register_widget( 'Social_Menu_Widget' );
}
add_action( 'widgets_init', 'understrap_add_social_menu_widget' );

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function understrap_body_classes( $classes ) {
	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	// Adds a class of no-sidebar when there is no sidebar present.
	if ( ! is_active_sidebar( 'sidebar-1' ) ) {
		$classes[] = 'no-sidebar';
	}

	return $classes;
}
add_filter( 'body_class', 'understrap_body_classes' );

/**
 * Add a pingback url auto-discovery header for single posts, pages, or attachments.
 */
function understrap_pingback_header() {
	if ( is_singular() && pings_open() ) {
		printf( '<link rel="pingback" href="%s">', esc_url( get_bloginfo( 'pingback_url' ) ) );
	}
}
add_action( 'wp_head', 'understrap_pingback_header' );

/**
 * Adds Bootstrap classes to the bottom sidebar
 * This is a very vague function mostly because the footer is likely
 * to change in a custom theme and this function rendered obsolete, but
 * it might help in some cases.
 *
 * @param $params
 * @return mixed
 */
function understrap_sidebar_params( $params ) {
	if ( $params[0]['id'] !== 'sidebar-bottom' ) {
		return $params;
	}

	$params[0]['before_widget'] = str_replace( 'custom-classes', 'col-sm-16', $params[0]['before_widget'] );

	return $params;
}
add_filter('dynamic_sidebar_params', 'understrap_sidebar_params', 10, 1);

/**
 * Creates the comments form.
 *
 * @param string $fields Form fields.
 * @return array
 */
function understrap_bootstrap_comment_form_fields( $fields ) {
	$commenter = wp_get_current_commenter();
	$req       = get_option( 'require_name_email' );
	$aria_req  = ( $req ? " aria-required='true'" : '' );
	$html5     = current_theme_supports( 'html5', 'comment-form' ) ? 1 : 0;
	$consent   = empty( $commenter['comment_author_email'] ) ? '' : ' checked="checked"';
	$fields    = array(
		'author'  => '<div class="form-group comment-form-author"><label for="author">' . __( 'Name',
				'understrap' ) . ( $req ? ' <span class="required">*</span>' : '' ) . '</label> ' .
		             '<input class="form-control" id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30"' . $aria_req . '></div>',
		'email'   => '<div class="form-group comment-form-email"><label for="email">' . __( 'Email',
				'understrap' ) . ( $req ? ' <span class="required">*</span>' : '' ) . '</label> ' .
		             '<input class="form-control" id="email" name="email" ' . ( $html5 ? 'type="email"' : 'type="text"' ) . ' value="' . esc_attr( $commenter['comment_author_email'] ) . '" size="30"' . $aria_req . '></div>',
		'url'     => '<div class="form-group comment-form-url"><label for="url">' . __( 'Website',
				'understrap' ) . '</label> ' .
		             '<input class="form-control" id="url" name="url" ' . ( $html5 ? 'type="url"' : 'type="text"' ) . ' value="' . esc_attr( $commenter['comment_author_url'] ) . '" size="30"></div>',
		'cookies' => '<div class="form-group form-check comment-form-cookies-consent"><input class="form-check-input" id="wp-comment-cookies-consent" name="wp-comment-cookies-consent" type="checkbox" value="yes"' . $consent . ' /> ' .
		             '<label class="form-check-label" for="wp-comment-cookies-consent">' . __( 'Save my name, email, and website in this browser for the next time I comment', 'understrap' ) . '</label></div>',
	);

	return $fields;
}
add_filter( 'comment_form_default_fields', 'understrap_bootstrap_comment_form_fields' );

/**
 * Builds the form.
 *
 * @param string $args Arguments for form's fields.
 * @return mixed
 */
function understrap_bootstrap_comment_form( $args ) {
	$args['comment_field']      = '<div class="form-group comment-form-comment">
    <label for="comment">' . _x( 'Comment', 'noun', 'understrap' ) . ( ' <span class="required">*</span>' ) . '</label>
    <textarea class="form-control" id="comment" name="comment" aria-required="true" cols="45" rows="8"></textarea>
    </div>';
	$args['class_submit']       = 'btn btn-primary'; // since WP 4.1.
	$args['title_reply_before'] = '<h4 id="reply-title" class="comment-reply-title">';
	$args['title_reply_after']  = '</h4>';

	return $args;
}
add_filter( 'comment_form_defaults', 'understrap_bootstrap_comment_form' );

/**
 * Add mobile-web-app meta.
 */
function understrap_mobile_web_app_meta() {
	echo '<meta name="mobile-web-app-capable" content="yes">' . "\n";
	echo '<meta name="apple-mobile-web-app-capable" content="yes">' . "\n";
	echo '<meta name="apple-mobile-web-app-title" content="' . esc_attr( get_bloginfo( 'name' ) ) . ' - ' . esc_attr( get_bloginfo( 'description' ) ) . '">' . "\n";
}
add_action( 'wp_head', 'understrap_mobile_web_app_meta' );

/**
 * This function adds the icon to our social menu
 *
 * @param  string  $item_output The menu item output.
 * @param  WP_Post $item        Menu item object.
 * @param  int     $depth       Depth of the menu.
 * @param  array   $args        wp_nav_menu() arguments.
 * @return string  $item_output The menu item output with social icon.
 */
function understrap_nav_menu_social_icons( $item_output, $item, $depth, $args ) {
	if ( 'social' === $args->theme_location ) {
		$classes      = $item->classes;
		$icon_classes = array();
		foreach ( $classes as $k => $class ) {
			if ( preg_match( '/
				^fa-(\S*)?|^fa(s|r|l|b)-(\S*)?$     # Font Awesome
				|^oi-(\S*)?|^oi(\s?)$               # open-iconic
				|^octicon-(\S*)?|^octicon(\s?)$     # octicons
				|^material-(\S*)?|^material(\s?)$   # Material icons
			/ix', $class ) ) {
				$icon_classes[] = $class;
				unset( $classes[ $k ] );
			}
		}

		// icons
		$icon = '';
		foreach ( $icon_classes as $k => $class ) {

			$icon_parts = explode( '-', $class );
			if ( 2 < count( $icon_parts ) ) {
				// Skip this since there is something odd here
				continue;
			}

			if ( in_array( $icon_parts[0], [ 'fa', 'fas', 'fab', 'far', 'fal' ] ) ) {
				$icon_parts[1] = 'fa-' . $icon_parts[1];
				$icon          = '<span class="' . $icon_parts[0] . ' ' . $icon_parts[1] . '" aria-hidden="true"></span>';
			} else if ( $icon_parts[0] === 'oi' ) {
				$icon_parts[1] = 'oi-' . $icon_parts[1];
				$icon          = '<span class="' . $icon_parts[0] . ' ' . $icon_parts[1] . '" aria-hidden="true"></span>';
			} else if ( $icon_parts[0] === 'octicon' ) {
				$icon_parts[1] = 'octicon-' . $icon_parts[1];
				$icon          = '<span class="' . $icon_parts[0] . ' ' . $icon_parts[1] . '" aria-hidden="true"></span>';
			} else if ( $icon_parts[0] === 'material' ) {
				$icon_parts[0] = $icon_parts[0] . '-icons';
				$icon          = '<span class="' . $icon_parts[0] . '" aria-hidden="true">' . $icon_parts[1] . '</span>';
			}

			// Only one icon allowed here
			break;
		}

		$name = strtolower( $item->post_name );

		if ( ! $icon ) {
			// Then let's pick an icon from default fontawesome
			switch ( $name ) {
				case 'instagram':
					$icon = '<span class="fab fa-instagram"></span>';
					break;
				case 'twitter':
					$icon = '<span class="fab fa-twitter"></span>';
					break;
				case 'facebook':
					$icon = '<span class="fab fa-facebook"></span>';
					break;
				default:
					break;
			}
		}

		$item_output = str_replace( $args->link_after, '</span>' . $icon, $item_output );
	}

	return $item_output;
}
add_filter( 'walker_nav_menu_start_el', 'understrap_nav_menu_social_icons', 10, 4 );
