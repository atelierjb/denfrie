<?php
/*
Template Name: Social
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

<main id="primary" class="mx-[calc(0.25rem+2vw)] my-[calc(0.5rem+1vw)]">
    <section class="flex justify-between items-center pb-[calc(1rem+0.5vw)]">
        <h2 class="font-dfserif text-xl/xl">
            Social calendar
        </h2>
        <form id="search-form">
            <input type="text" id="search-input" placeholder="Search in calendar…" class="font-dfserif text-xl/xl text-df-grey bg-df-light-grey text-right">
        </form>
    </section>
    <div id="social-posts-container">
        <!-- Posts will be dynamically loaded here -->
    </div>
    <div id="load-more-container">
        <button class="font-dfserif text-xl/xl py-[calc(1rem+0.5vw)]" id="load-more" data-page="1" data-max="" data-query="">Show previous events ↓</button>
    </div>
</main>



<?php
// Include the footer
get_footer();
?>