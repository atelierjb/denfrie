<?php get_header(); ?>
<main data-barba="wrapper" class="mx-sp3 my-sp5" id="main-content">
    <article data-barba="container">

	<?php if ( have_posts() ) : ?>

		<?php
		while ( have_posts() ) :
			the_post();
			?>

			<?php get_template_part( 'template-parts/content', 'single' ); ?>

		<?php endwhile; ?>

	<?php endif; ?>
	</article>
</main>

<?php
get_footer();
