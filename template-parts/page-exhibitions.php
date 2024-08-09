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

<main id="primary" class="site-main">

<article class="mx-sp3 my-sp5">
    <section class="w-full">
        <h2 class="font-dfserif text-xl/xl pb-sp7">
            Current Exhibitions
        </h2>
        <?php get_template_part( 'template-parts/section-current-exhibitions' ); ?>
    </section>
    <section class="w-full pb-sp9">
        <h2 class="font-dfserif text-xl/xl pb-sp7">
            Upcoming Exhibitions
        </h2>
        <?php get_template_part( 'template-parts/section-upcoming-exhibitions' ); ?>
    </section>
    <section class="w-full">
        <h2 class="font-dfserif text-xl/xl pb-sp7">
            <a href="<?php echo get_permalink(159); ?>" class="hover:text-df-grey">Archive</a>
        </h2>
        <hr class="border-df-black">
        <?php get_template_part( 'template-parts/section-latest-exhibitions' ); ?>
        <p class="font-dfserif text-xl/xl py-sp7">
        <a href="<?php echo get_permalink(159); ?>" class="hover:text-df-grey">Show more archive →</a>
        </p>
    </section>
</article>

</main>



<?php
// Include the footer
get_footer();
?>