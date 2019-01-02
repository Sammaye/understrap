<?php
/*
 * Template Name: Empty container fluid, left sidebar
 * Template Post Type: post
 */

get_header();
?>

	<div id="primary" class="content-area container-fluid">
		<div class="row">
			<?php get_sidebar( 'left' ); ?>
			<main id="main" class="site-main<?php echo understrap_content_col_classes( true, false ) ?>">
				<?php get_template_part('post-templates/post-template-content'); ?>
			</main><!-- #main -->
		</div>
	</div><!-- #primary -->

<?php
get_footer();
