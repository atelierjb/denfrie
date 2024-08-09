<?php
/*
Template Name: About
*/
?>

<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package denfrie
 */

get_header();
?>

<main id="primary" class="site-main">
    <article class="columns-1 sm:columns-2 gap-sp1 mx-sp3 my-sp5 pr-sp2">
            <section class="w-full sm:w-[95%] pb-sp8">
                <h2 class="font-dfserif text-xl/xl pb-sp1">
                    Contact 
                </h2>
                <div class="columns-2 font-superclarendon text-regular/regular">
                    <?php get_template_part( 'template-parts/section-contact' ); ?>
                </div>
            </section>
            <section class="w-full sm:w-[calc(90%+1vw)] pb-sp8">
                <h2 class="font-dfserif text-xl/xl pb-sp1">
                    <?php echo esc_html( get_field('about-title-about') ); ?>
                </h2>
                <div class="font-superclarendon text-regular/regular indent-sp8">
                    <?php the_field('about-text-about'); ?>
                </div>
            </section>
            <section class="w-full sm:w-[calc(90%+1vw)] pb-sp8">
                <h2 class="font-dfserif text-xl/xl pb-sp1">
                    <?php echo esc_html( get_field('about-title-oslo') ); ?>
                </h2>
                <div class="font-superclarendon text-regular/regular indent-sp8">
                    <?php the_field('about-text-oslo'); ?>
                </div>
            </section>
            <figure class="w-full sm:w-[calc(90%+1vw)] hidden sm:block break-after-avoid sm:break-after-column pb-sp8">
                <?php if( get_field('about-image-1') ): ?>
                    <img src="<?php the_field('about-image-1'); ?>" class="w-full h-auto" />
                <?php endif; ?>
                </figure>
            <figure class="w-full sm:w-[calc(90%+1vw)] hidden sm:block pb-sp8">
                <?php if( get_field('about-image-2') ): ?>
                    <img src="<?php the_field('about-image-2'); ?>" class="w-full h-auto" />
                <?php endif; ?>
            </figure>
            <section class="w-full sm:w-[calc(90%+1vw)] pb-sp8">
                <h2 class="font-dfserif text-xl/xl pb-sp1">
                    <?php echo esc_html( get_field('about-title-history') ); ?>
                </h2>
                <div class="font-superclarendon text-regular/regular indent-sp8">
                    <?php the_field('about-text-history'); ?>
                </div>
            </section>
            <section class="w-full sm:w-[calc(90%+1vw)] pb-sp8">
                <h2 class="font-dfserif text-xl/xl pb-sp1">
                    <?php echo esc_html( get_field('about-title-toaster') ); ?>
                </h2>
                <div class="font-superclarendon text-regular/regular indent-sp8">
                    <?php the_field('about-text-toaster'); ?>
                </div>
            </section>
            <figure class="w-full sm:hidden pb-sp8">
                <?php if( get_field('about-image-1') ): ?>
                    <img src="<?php the_field('about-image-1'); ?>" class="w-full h-auto" />
                <?php endif; ?>
            </figure>
    </article>

</main>



<?php
// Include the footer
get_footer();
?>