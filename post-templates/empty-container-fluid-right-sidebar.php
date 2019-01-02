<?php
/*
 * Template Name: Empty container fluid, right sidebar
 * Template Post Type: post
 */

get_header();
?>

	<div id="primary" class="content-area container-fluid">
		<div class="row">
			<main id="main" class="site-main<?php echo understrap_content_col_classes( false, true ) ?>">
				<?php get_template_part('post-templates/post-template-content'); ?>
			</main><!-- #main -->
			<?php get_sidebar( 'right' ); ?>
		</div>
	</div><!-- #primary -->

<?php
get_footer();
