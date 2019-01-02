<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Admiral_jet
 */

$container_class = get_theme_mod('understrap_container_class', 'container');

get_header('blank');
?>
<div id="page" class="site">
	<a class="skip-link sr-only" href="#content"><?php esc_html_e( 'Skip to content', 'understrap' ); ?></a>

	<header id="masthead" class="site-header" role="banner">
        <div class="sr-only">
            <?php if ( is_front_page() && is_home() ) : ?>
                <h1 class="site-title">
                    <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a>
                </h1>
            <?php else : ?>
                <p class="site-title">
                    <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a>
                </p>
            <?php endif; ?>
            <?php $understrap_description = get_bloginfo( 'description', 'display' );
            if ( $understrap_description || is_customize_preview() ) : ?>
                <p class="site-description"><?php echo $understrap_description; /* WPCS: xss ok. */ ?></p>
            <?php endif; ?>
        </div>
        <nav class="site-navbar navbar navbar-expand-lg navbar-light bg-light" id="site-navigation">
            <div class="<?php echo $container_class ?>">
                <!-- Brand and toggle get grouped for better mobile display -->
                <?php if ( $custom_logo_id = has_custom_logo() ) : ?>
                    <a class="navbar-brand custom-logo-link" href="<?php echo esc_url(home_url('/')); ?>">
                        <?php echo wp_get_attachment_image( $custom_logo_id, 'full', false, array( 'class' => 'custom-logo', 'itemprop' => 'logo', 'alt' => get_bloginfo( 'name', 'display' ) ) ) ?>
                    </a>
                <?php else : ?>
                    <a class="navbar-brand" href="<?php echo esc_url(home_url('/')); ?>">
                        <img
                            src="<?php echo get_template_directory_uri() ?>/images/alogo_main.png"
                            alt="<?php echo get_bloginfo( 'name', 'display' ) ?>"
                        />
                    </a>
                <?php endif; ?>
                <?php if ( has_nav_menu('primary') ) : ?>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#primaryNav" aria-controls="primaryNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <?php wp_nav_menu( array(
                        'menu'              => 'primary',
                        'theme_location'    => 'primary',
                        'depth'             => 2,
                        'container'         => 'div',
                        'container_class'   => 'collapse navbar-collapse',
                        'container_id'      => 'primaryNav',
                        'menu_class'        => 'navbar-nav ml-auto',
                        'walker'            => new Custom_Walker_Nav_Menu()
                    ) ); ?>
                <?php endif; ?>
            </div>
        </nav>
	</header><!-- #masthead -->

	<div id="content" class="site-content">
