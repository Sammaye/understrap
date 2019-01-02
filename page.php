<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Admiral_jet
 */

get_header();

$container_class = get_theme_mod( 'understrap_container_class' );
?>

	<div id="primary" class="content-area <?php echo $container_class ?>">
        <div class="row">
            <?php get_sidebar('left'); ?>
            <main id="main" class="site-main<?php echo understrap_content_col_classes() ?>">

            <?php
            while ( have_posts() ) :
                the_post();

                get_template_part( 'template-parts/content', 'page' );

                // If comments are open or we have at least one comment, load up the comment template.
                if ( comments_open() || get_comments_number() ) :
                    comments_template();
                endif;

            endwhile; // End of the loop.
            ?>

            </main><!-- #main -->
            <?php get_sidebar('right'); ?>
        </div>
	</div><!-- #primary -->

<?php
get_footer();
