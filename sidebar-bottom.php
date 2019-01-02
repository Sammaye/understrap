<?php
/**
 * The sidebar containing the main widget area
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Admiral_jet
 */

$container_class = get_theme_mod( 'understrap_container_class' );

if ( ! is_active_sidebar( 'sidebar-bottom' ) ) {
	return;
}
?>
<div class="sidebar-footer-wrapper">
    <section id="sidebar-bottom" class="widget-area <?php echo $container_class ?>" role="complementary">
        <div class="row">
            <?php dynamic_sidebar( 'sidebar-bottom' ); ?>
        </div>
    </section>
</div>
