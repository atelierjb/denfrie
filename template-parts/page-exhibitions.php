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

<article class="mx-[calc(0.25rem+2vw)] my-[calc(0.5rem+1vw)]">
    <section class="w-full">
        <h2 class="font-dfserif text-xl/xl pb-[calc(1rem+0.5vw)]">
            Current Exhibitions
        </h2>
        <?php get_template_part( 'template-parts/section-current-exhibitions' ); ?>
    </section>
    <section class="w-full pb-[calc(2rem+2vw)]">
        <h2 class="font-dfserif text-xl/xl pb-[calc(1rem+0.5vw)]">
            Upcoming Exhibitions
        </h2>
        <?php get_template_part( 'template-parts/section-upcoming-exhibitions' ); ?>
    </section>
    <section class="w-full">
        <h2 class="font-dfserif text-xl/xl pb-[calc(1rem+0.5vw)]">
            Archive
        </h2>
        <?php get_template_part( 'template-parts/section-latest-exhibitions' ); ?>
        <p class="font-dfserif text-[calc(0.8rem+1.15vw)]/[0.95] py-[calc(1rem+0.5vw)]">
        <a href="<?php echo get_permalink(159); ?>" class="hover:text-df-grey">Show more archive →</a>
        </p>
    </section>
</article>

</main>



<?php
// Include the footer
get_footer();
?>