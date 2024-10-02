<?php get_header(); ?>

<main data-barba="container" data-barba-namespace="single" class="mx-sp3 my-sp5" id="main-content">

	<?php if ( have_posts() ) : ?>

		<?php
		while ( have_posts() ) :
			the_post();
			?>

			<?php get_template_part( 'template-parts/content', 'single' ); ?>

		<?php endwhile; ?>

	<?php endif; ?>

</main>

<?php
get_footer();
