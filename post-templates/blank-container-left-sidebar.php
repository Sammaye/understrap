<?php
/*
 * Template Name: Blank container, left sidebar
 * Template Post Type: post
 */

get_header( 'blank' );
?>

	<div id="primary" class="content-area container">
		<div class="row">
			<?php get_sidebar('left'); ?>
			<main id="main" class="site-main<?php echo understrap_content_col_classes( true, false ) ?>">
				<?php get_template_part('post-templates/post-template-content'); ?>
			</main><!-- #main -->
		</div>
	</div><!-- #primary -->

<?php
get_footer( 'blank' );
