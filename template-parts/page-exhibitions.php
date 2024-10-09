<?php
/*
Template Name: Exhibitions
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

<main data-barba="container" data-barba-namespace="exhibitions" class="mx-sp3 my-sp5" id="main-content">
    <section class="w-full">
        <h2 class="font-dfserif text-xl/xl pb-sp5 sm:pb-sp7">
            <?php echo pll__('Current Exhibitions', 'tailpress'); ?>
        </h2>
        <?php get_template_part( 'template-parts/section-current-exhibitions' ); ?>
    </section>
    <section class="w-full pb-sp7 sm:pb-sp9">
        <h2 class="font-dfserif text-xl/xl pb-sp5 sm:pb-sp7">
            <?php echo pll__('Upcoming Exhibitions', 'tailpress'); ?>
        </h2>
        <?php get_template_part( 'template-parts/section-upcoming-exhibitions' ); ?>
    </section>
    <section class="w-full">
        <div class="flex justify-between">
            <h2 class="font-dfserif text-xl/xl pb-sp5 sm:pb-sp7">
                <?php echo pll__('Latest Exhibitions', 'tailpress'); ?>
            </h2>
            <h2 class="font-dfserif text-xl/xl pb-sp7 text-df-grey">
                <a href="<?php echo get_permalink(pll_get_post(159)); ?>" class="hover:text-df-red">
                    <?php echo pll__('Go to archive', 'tailpress'); ?> →
                </a>
            </h2>
        </div>
        <hr class="border-df-black">
        <?php get_template_part( 'template-parts/section-latest-exhibitions' ); ?>
        <p class="font-dfserif text-xl/xl py-sp7">
            <a href="<?php echo get_permalink(pll_get_post(159)); ?>" class="hover:text-df-red">
                <?php echo pll__('Show more archive', 'tailpress'); ?> →
            </a>
        </p>
    </section>
</main>    



<?php
// Include the footer
get_footer();
?>