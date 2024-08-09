<?php
/*
Template Name: Visit
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
                    <?php echo esc_html( get_field('visit-title-admission') ); ?> 
                </h2>

                <?php get_template_part( 'template-parts/section-prices' ); ?>
            </section>
            <section class="w-full sm:w-[calc(90%+1vw)] pb-sp8">
                <h2 class="font-dfserif text-xl/xl pb-sp1">
                    <?php echo esc_html( get_field('visit-title-annualpass') ); ?>
                </h2>
                <div class="font-superclarendon text-regular/regular">
                    <?php the_field('visit-text-annualpass'); ?>
                </div>
            </section>
            <section class="w-full sm:w-[calc(90%+1vw)] pb-sp8">
                <h2 class="font-dfserif text-xl/xl pb-sp1">
                    <?php echo esc_html( get_field('visit-title-pegasus') ); ?>
                </h2>
                <div class="font-superclarendon text-regular/regular">
                    <?php the_field('visit-text-pegasus'); ?>
                </div>
            </section>
            <section class="w-full sm:w-[calc(90%+1vw)] pb-sp8 break-after-avoid sm:break-after-column">
                <h2 class="font-dfserif text-xl/xl pb-sp1">
                    <?php echo esc_html( get_field('visit-title-rent') ); ?>
                </h2>
                <div class="font-superclarendon text-regular/regular">
                    <?php the_field('visit-text-rent'); ?>
                </div>
            </section>
            <section class="w-full sm:w-[calc(90%+1vw)] pb-sp8">
                <h2 class="font-dfserif text-xl/xl pb-sp1">
                    <?php echo esc_html( get_field('visit-title-transport') ); ?>
                </h2>
                <div class="font-superclarendon text-regular/regular">
                    <?php the_field('visit-text-transport'); ?>
                </div>
            </section>
            <section class="w-full sm:w-[calc(90%+1vw)] pb-sp8">
                <h2 class="font-dfserif text-xl/xl pb-sp1">
                    <?php echo esc_html( get_field('visit-title-openings') ); ?>
                </h2>
                <div class="font-superclarendon text-regular/regular">
                    <?php the_field('visit-text-openings'); ?>
                </div>
            </section>
            <section class="w-full sm:w-[calc(90%+1vw)]">
                <h2 class="font-dfserif text-xl/xl pb-sp1">
                    <?php echo esc_html( get_field('visit-title-info') ); ?>
                </h2>
                <div class="font-superclarendon text-regular/regular">
                    <?php the_field('visit-text-info'); ?>
                </div>
            </section>
    </article>
</main>



<?php
// Include the footer
get_footer();
?>