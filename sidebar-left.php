<?php
/**
 * The sidebar containing the main widget area
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Admiral_jet
 */

if ( ! is_active_sidebar( 'sidebar-left' ) ) {
	return;
}
?>

<aside id="sidebar-left" class="widget-area col-md-14 col-lg-12" role="complementary">
    <?php dynamic_sidebar( 'sidebar-left' ); ?>
</aside>
