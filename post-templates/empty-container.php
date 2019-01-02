<?php
/*
 * Template Name: Empty container, no sidebars
 * Template Post Type: post
 */

get_header();
?>

	<div id="primary" class="content-area container">
		<div class="row">
			<main id="main" class="site-main col-sm">
				<?php get_template_part('post-templates/post-template-content'); ?>
			</main><!-- #main -->
		</div>
	</div><!-- #primary -->

<?php
get_footer();
