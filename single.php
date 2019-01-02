<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
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

                get_template_part( 'template-parts/content', get_post_type() );

	            understrap_post_nav( array(
		            'title_reply_before' => '<h4 id="reply-title" class="comment-reply-title">',
		            'title_reply_after'  => '</h4>',
	            ) );

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
