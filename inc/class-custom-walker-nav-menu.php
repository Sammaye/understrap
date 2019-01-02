<?php

/**
 * Class Name: Custom_Walker_Nav_Menu
 * Description: A Bootstrap 4 nav walker
 * Version: fuck only knows, it's 1am
 * Author: Sammaye
 * Author URI: https://sammaye.com
 * License: Who cares?
 */

class Custom_Walker_Nav_Menu extends Walker_Nav_Menu {

	public $item;

	/**
	 * Starts the list before the elements are added.
	 *
	 * @since 3.0.0
	 *
	 * @see Walker::start_lvl()
	 *
	 * @param string $output Used to append additional content (passed by reference).
	 * @param int $depth Depth of menu item. Used for padding.
	 * @param stdClass $args An object of wp_nav_menu() arguments.
	 */
	public function start_lvl( &$output, $depth = 0, $args = array() ) {
		if ( 1 < $depth ) {
			return;
		}

		if ( isset( $args->item_spacing ) && 'discard' === $args->item_spacing ) {
			$t = '';
			$n = '';
		} else {
			$t = "\t";
			$n = "\n";
		}
		$indent = str_repeat( $t, $depth );

		// Default class.
		$classes = array( 'dropdown-menu' );

		/**
		 * Filters the CSS class(es) applied to a menu list element.
		 *
		 * @since 4.8.0
		 *
		 * @param array $classes The CSS classes that are applied to the menu `<ul>` element.
		 * @param stdClass $args An object of `wp_nav_menu()` arguments.
		 * @param int $depth Depth of menu item. Used for padding.
		 */
		$class_names = implode( ' ', apply_filters( 'nav_menu_submenu_css_class', $classes, $args, $depth ) );

		$atts                    = array();
		$atts['class']           = $class_names;
		$atts['aria-labelledby'] = 'navbarDropdown-' . $this->item->ID;

		$attributes = $this->html_attributes( $atts );
		$attributes = $attributes ? ' ' . $attributes : '';

		$output .= "$n$indent<div$attributes>$n";
	}

	public function end_lvl( &$output, $depth = 0, $args = array() ) {
		if ( 1 < $depth ) {
			return;
		}

		if ( isset( $args->item_spacing ) && 'discard' === $args->item_spacing ) {
			$t = '';
			$n = '';
		} else {
			$t = "\t";
			$n = "\n";
		}

		$indent = str_repeat( $t, $depth );
		$output .= "$indent</div>$n";
	}

	/**
	 * Starts the element output.
	 *
	 * @since 3.0.0
	 * @since 4.4.0 The {@see 'nav_menu_item_args'} filter was added.
	 *
	 * @see Walker::start_el()
	 *
	 * @param string $output Used to append additional content (passed by reference).
	 * @param WP_Post $item Menu item data object.
	 * @param int $depth Depth of menu item. Used for padding.
	 * @param stdClass $args An object of wp_nav_menu() arguments.
	 * @param int $id Current item ID.
	 */
	public function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
		if ( 1 < $depth ) {
			return;
		}

		$this->item = $item;

		if ( isset( $args->item_spacing ) && 'discard' === $args->item_spacing ) {
			$t = '';
			$n = '';
		} else {
			$t = "\t";
			$n = "\n";
		}
		$indent = $depth ? str_repeat( $t, $depth ) : '';

		/**
		 * Filters the arguments for a single nav menu item.
		 *
		 * @since 4.4.0
		 *
		 * @param stdClass $args An object of wp_nav_menu() arguments.
		 * @param WP_Post $item Menu item data object.
		 * @param int $depth Depth of menu item. Used for padding.
		 */
		$args = apply_filters( 'nav_menu_item_args', $args, $item, $depth );

		/**
		 * Filters the ID applied to a menu item's list item element.
		 *
		 * @since 3.0.1
		 * @since 4.1.0 The `$depth` parameter was added.
		 *
		 * @param string $menu_id The ID that is applied to the menu item's `<li>` element.
		 * @param WP_Post $item The current menu item.
		 * @param stdClass $args An object of wp_nav_menu() arguments.
		 * @param int $depth Depth of menu item. Used for padding.
		 */
		$id = apply_filters( 'nav_menu_item_id', 'menu-item-' . $item->ID, $item, $args, $depth );

		/** This filter is documented in wp-includes/post-template.php */
		$title = apply_filters( 'the_title', $item->title, $item->ID );

		/**
		 * Filters a menu item's title.
		 *
		 * @since 4.4.0
		 *
		 * @param string $title The menu item's title.
		 * @param WP_Post $item The current menu item.
		 * @param stdClass $args An object of wp_nav_menu() arguments.
		 * @param int $depth Depth of menu item. Used for padding.
		 */
		$title = esc_html( apply_filters( 'nav_menu_item_title', $title, $item, $args, $depth ) );

		$classes   = empty( $item->classes ) ? array() : (array) $item->classes;
		$classes[] = 'menu-item-' . $item->ID;

		$state_classes = array();
		$icon_classes  = array();
		foreach ( $classes as $k => $class ) {
			// If any special classes are found, store the class in it's
			// holder array and and unset the item from $classes.
			if ( preg_match( '/^disabled|^sr-only/i', $class ) ) {
				// Test for .disabled or .sr-only classes.
				$state_classes[] = $class;
				unset( $classes[ $k ] );
			} elseif ( preg_match( '/
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
		$icon = array();
		foreach ( $icon_classes as $k => $class ) {

			$icon_parts = explode( '-', $class );
			if ( 2 < count( $icon_parts ) ) {
				// Skip this since there is something odd here
				continue;
			}

			if ( in_array( $icon_parts[0], [ 'fa', 'fas', 'fab', 'far', 'fal' ] ) ) {
				$icon_parts[1] = 'fa-' . $icon_parts[1];
				$icon[]        = '<span class="' . $icon_parts[0] . ' ' . $icon_parts[1] . '" aria-hidden="true"></span>';
			} else if ( $icon_parts[0] === 'oi' ) {
				$icon_parts[1] = 'oi-' . $icon_parts[1];
				$icon[]        = '<span class="' . $icon_parts[0] . ' ' . $icon_parts[1] . '" aria-hidden="true"></span>';
			} else if ( $icon_parts[0] === 'octicon' ) {
				$icon_parts[1] = 'octicon-' . $icon_parts[1];
				$icon[]        = '<span class="' . $icon_parts[0] . ' ' . $icon_parts[1] . '" aria-hidden="true"></span>';
			} else if ( $icon_parts[0] === 'material' ) {
				$icon_parts[0] = $icon_parts[0] . '-icons';
				$icon[]        = '<span class="' . $icon_parts[0] . '" aria-hidden="true">' . $icon_parts[1] . '</span>';
			}
		}
		$icon = ltrim( implode( '&nbsp;', $icon ), '&nbsp;' );

		foreach ( $classes as $class ) {
			if ( in_array( $class, [
				'current-menu-parent',
				'current-menu-ancestor',
				'current-menu-item',
				'current-page-item'
			] ) ) {
				$classes[] = 'active';
			}
		}

		$link_atts = array(
			'title'  => ! empty( $item->attr_title ) ? $item->attr_title : $title,
			'target' => ! empty( $item->target ) ? $item->target : '',
			'rel'    => ! empty( $item->xfn ) ? $item->xfn : '',
			'href'   => ! empty( $item->url ) ? $item->url : '',
		);

		if ( in_array( 'sr-only', $state_classes, true ) ) {
			// We don't need the title variable now that it is saved to the <a> attributes above
			$title = $this->sr_wrap( $title );
		}

		if ( 1 === $depth ) {

			if ( in_array( array( 'dropdown-header', 'dropdown-divider', 'dropdown-item-text' ), $classes, true ) ) {

				$this->item->tag = 'div';
				if ( in_array( 'dropdown-item-text', $classes, true ) ) {
					$this->item->tag = 'span';
				}

				/**
				 * Filters the CSS class(es) applied to a menu item's list item element.
				 *
				 * @since 3.0.0
				 * @since 4.1.0 The `$depth` parameter was added.
				 *
				 * @param array $classes The CSS classes that are applied to the menu item's `<li>` element.
				 * @param WP_Post $item The current menu item.
				 * @param stdClass $args An object of wp_nav_menu() arguments.
				 * @param int $depth Depth of menu item. Used for padding.
				 */
				$classes_string = implode( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args, $depth ) );

				$html_attributes = $this->html_attributes( array(
					'id'    => $id,
					'class' => $classes_string
				) );

				$item_output = "$args->before$indent<{$this->item->tag} $html_attributes>$args->link_before";

				if ( in_array( array( 'dropdown-item-text', 'dropdown-header' ), $classes, true ) ) {
					$item_output .= ltrim( implode( '&nbsp;', array( $icon, $title ) ), '&nbsp;' );
				}

				$item_output .= $args->link_after . $args->after;

				/**
				 * Filters a menu item's starting output.
				 *
				 * The menu item's starting output only includes `$args->before`, the opening `<a>`,
				 * the menu item's title, the closing `</a>`, and `$args->after`. Currently, there is
				 * no filter for modifying the opening and closing `<li>` for a menu item.
				 *
				 * @since 3.0.0
				 *
				 * @param string $item_output The menu item's starting HTML output.
				 * @param WP_Post $item Menu item data object.
				 * @param int $depth Depth of menu item. Used for padding.
				 * @param stdClass $args An object of wp_nav_menu() arguments.
				 */
				$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );

				return;

			}

			$this->item->tag = 'a';

			$classes = array_merge( $classes, array( 'dropdown-item' ) );

			if ( in_array( 'disabled', $state_classes, true ) ) {
				$classes[] = 'disabled';

				$link_atts['aria-disabled'] = 'true';
				$link_atts['tabindex']      = '-1';
			}

			/**
			 * Filters the CSS class(es) applied to a menu item's list item element.
			 *
			 * @since 3.0.0
			 * @since 4.1.0 The `$depth` parameter was added.
			 *
			 * @param array $classes The CSS classes that are applied to the menu item's `<li>` element.
			 * @param WP_Post $item The current menu item.
			 * @param stdClass $args An object of wp_nav_menu() arguments.
			 * @param int $depth Depth of menu item. Used for padding.
			 */
			$link_atts['class'] = implode( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args, $depth ) );

			$html_attributes = $this->html_attributes( array_filter( $link_atts ) );

			$item_output = "$args->before$indent<{$this->item->tag} $html_attributes>$args->link_before";
			$item_output .= ltrim( implode( '&nbsp;', array( $icon, $title ) ), '&nbsp;' );

			if ( in_array( 'active', $classes ) ) {
				$item_output .= ' ' . $this->sr_wrap( '(current)' );
			}

			$item_output .= $args->link_after . $args->after;

			/**
			 * Filters a menu item's starting output.
			 *
			 * The menu item's starting output only includes `$args->before`, the opening `<a>`,
			 * the menu item's title, the closing `</a>`, and `$args->after`. Currently, there is
			 * no filter for modifying the opening and closing `<li>` for a menu item.
			 *
			 * @since 3.0.0
			 *
			 * @param string $item_output The menu item's starting HTML output.
			 * @param WP_Post $item Menu item data object.
			 * @param int $depth Depth of menu item. Used for padding.
			 * @param stdClass $args An object of wp_nav_menu() arguments.
			 */
			$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );

			return;

		}

		$this->item->tag = 'li';

		$classes[]          = 'nav-item';
		$link_atts['class'] = [ 'nav-link' ];

		if ( in_array( 'disabled', $state_classes ) ) {
			$link_atts['classs'][] = 'disabled';

			$link_atts['aria-disabled'] = 'true';
			$link_atts['tabindex']      = '-1';
		}

		if ( $this->has_children ) {
			$classes[] = 'dropdown';

			$link_atts['id']            = 'navbarDropdown-' . $item->ID;
			$link_atts['role']          = 'button';
			$link_atts['href']          = '#';
			$link_atts['data-toggle']   = 'dropdown';
			$link_atts['class'][]       = 'dropdown-toggle';
			$link_atts['aria-haspopup'] = 'true';
			$link_atts['aria-expanded'] = 'false';
		}
		$link_atts['class'] = implode( ' ', $link_atts['class'] );

		/**
		 * Filters the HTML attributes applied to a menu item's anchor element.
		 *
		 * @since 3.6.0
		 * @since 4.1.0 The `$depth` parameter was added.
		 *
		 * @param array $link_atts {
		 *     The HTML attributes applied to the menu item's `<a>` element, empty strings are ignored.
		 *
		 * @type string $title Title attribute.
		 * @type string $target Target attribute.
		 * @type string $rel The rel attribute.
		 * @type string $href The href attribute.
		 * }
		 *
		 * @param WP_Post $item The current menu item.
		 * @param stdClass $args An object of wp_nav_menu() arguments.
		 * @param int $depth Depth of menu item. Used for padding.
		 */
		$link_atts = apply_filters( 'nav_menu_link_attributes', array_filter( $link_atts ), $item, $args, $depth );

		/**
		 * Filters the CSS class(es) applied to a menu item's list item element.
		 *
		 * @since 3.0.0
		 * @since 4.1.0 The `$depth` parameter was added.
		 *
		 * @param array $classes The CSS classes that are applied to the menu item's `<li>` element.
		 * @param WP_Post $item The current menu item.
		 * @param stdClass $args An object of wp_nav_menu() arguments.
		 * @param int $depth Depth of menu item. Used for padding.
		 */
		$classes_string = implode( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args, $depth ) );

		$item_output = $args->before;

		$html_attributes = $this->html_attributes( array(
			'id'    => $id,
			'class' => $classes_string
		) );
		$item_output     .= "$indent<li $html_attributes>";

		$link_html_attributes = $this->html_attributes( $link_atts );

		$item_output .= "<a $link_html_attributes>";
		$item_output .= $args->link_before;
		$item_output .= ltrim( implode( '&nbsp;', array( $icon, $title ) ), '&nbsp;' );

		if ( in_array( 'active', $classes ) ) {
			$item_output .= ' ' . $this->sr_wrap( '(current)' );
		}

		$item_output .= "$args->link_after</a>$args->after";

		/**
		 * Filters a menu item's starting output.
		 *
		 * The menu item's starting output only includes `$args->before`, the opening `<a>`,
		 * the menu item's title, the closing `</a>`, and `$args->after`. Currently, there is
		 * no filter for modifying the opening and closing `<li>` for a menu item.
		 *
		 * @since 3.0.0
		 *
		 * @param string $item_output The menu item's starting HTML output.
		 * @param WP_Post $item Menu item data object.
		 * @param int $depth Depth of menu item. Used for padding.
		 * @param stdClass $args An object of wp_nav_menu() arguments.
		 */
		$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
	}

	/**
	 * Ends the element output, if needed.
	 *
	 * @since 3.0.0
	 *
	 * @see Walker::end_el()
	 *
	 * @param string $output Used to append additional content (passed by reference).
	 * @param WP_Post $item Page data object. Not used.
	 * @param int $depth Depth of page. Not Used.
	 * @param stdClass $args An object of wp_nav_menu() arguments.
	 */
	public function end_el( &$output, $item, $depth = 0, $args = array() ) {
		if ( 1 < $depth ) {
			return;
		}

		if ( isset( $args->item_spacing ) && 'discard' === $args->item_spacing ) {
			$t = '';
			$n = '';
		} else {
			$t = "\t";
			$n = "\n";
		}

		$output .= '</' . $this->item->tag . ">{$n}";
	}

	private function sr_wrap( $text ) {
		if ( $text ) {
			return '<span class="sr-only">' . $text . '</span>';
		}

		return $text;
	}

	private function html_attributes( array $atts ) {
		$attributes = array();

		foreach ( $atts as $k => $v ) {
			$attributes[] = $k . '="' . ( $k === 'href' ? esc_url( $v ) : esc_attr( $v ) ) . '"';
		}

		return implode( ' ', $attributes );
	}
}
