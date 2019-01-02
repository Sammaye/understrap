<?php
/**
 * The template for displaying search results pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package Admiral_jet
 */

$container_class = get_theme_mod( 'understrap_container_class' );

get_header();
?>

	<section id="primary" class="content-area <?php echo $container_class ?>">
        <div class="row">
            <?php get_sidebar('left'); ?>
            <main id="main" class="site-main<?php echo understrap_content_col_classes() ?>">

            <?php if ( have_posts() ) : ?>

                <header class="page-header">
                    <h1 class="page-title">
                        <?php
                        /* translators: %s: search query. */
                        printf( esc_html__( 'Search Results for: %s', 'understrap' ), '<span>' . get_search_query() . '</span>' );
                        ?>
                    </h1>
                </header><!-- .page-header -->

                <?php
                /* Start the Loop */
                while ( have_posts() ) :
                    the_post();

                    /**
                     * Run the loop for the search to output the results.
                     * If you want to overload this in a child theme then include a file
                     * called content-search.php and that will be used instead.
                     */
                    get_template_part( 'template-parts/content', 'search' );

                endwhile;

                understrap_posts_navigation();

            else :

                get_template_part( 'template-parts/content', 'none' );

            endif;
            ?>

            </main><!-- #main -->
            <?php get_sidebar('right'); ?>
        </div>
	</section><!-- #primary -->

<?php
get_footer();
