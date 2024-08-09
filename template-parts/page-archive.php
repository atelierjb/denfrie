<?php
/*
Template Name: Archive
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

// Define the number of posts per page
$posts_per_page = 6;

// Arguments for WP_Query
$args = [
    'post_type' => 'exhibition',
    'posts_per_page' => $posts_per_page,
    'meta_key' => 'exhibition-end-date',
    'orderby' => 'meta_value',
    'order' => 'DESC',
    'meta_query' => [
        [
            'key' => 'exhibition-end-date',
            'compare' => '<=',
            'value' => date('Ymd'), // Ensuring we only get exhibitions that have ended
            'type' => 'DATE'
        ]
    ]
];

// Query for exhibitions
$exhibition_query = new WP_Query($args);
$total_posts = $exhibition_query->found_posts;
?>

<main class="mx-sp3 my-sp5">
   <section class="flex justify-between items-center pb-sp7">
        <h2 class="font-dfserif text-xl/xl">
            Archive
        </h2>
        <form id="search-form">
            <input type="text" id="search-input" placeholder="Search in archive..." class="font-dfserif text-xl/xl text-df-grey bg-df-light-grey text-right focus:outline-none" autocomplete="off">
        </form>
    </section>

    <section id="exhibitions-list" class="grid grid-cols-1 sm:grid-cols-2 gap-sp1 pb-sp8">
        <?php if ($exhibition_query->have_posts()) : ?>
            <?php while ($exhibition_query->have_posts()) : $exhibition_query->the_post(); ?>
                <div class="mb-sp1">
                    <figure class="mb-sp1 overflow-hidden aspect-video">
                        <a href="<?php the_permalink(); ?>">
                            <img src="<?php the_field('exhibition-image'); ?>" alt="<?php the_title(); ?>" class="w-full h-full transform transition-transform duration-500 hover:scale-105 object-cover">
                        </a>
                    </figure>
                    <h3 class="font-dfserif text-xl/xl">
                        <a class="hover:text-df-grey" href="<?php the_permalink(); ?>">
                            <?php the_title(); ?>
                        </a>
                    </h3>
                    <p class="font-superclarendon text-large/large line-clamp-1">
                        <a href="<?php the_permalink(); ?>">
                            <?php the_field('exhibition-artists'); ?>
                        </a>
                    </p>
                    <p class="font-superclarendon text-large/large">
                        <a href="<?php the_permalink(); ?>">
                            <?php the_field('exhibition-start-date'); ?> — <?php the_field('exhibition-end-date'); ?>
                        </a>
                    </p>
                </div>
            <?php endwhile; ?>
        <?php else : ?>
            <p>No exhibitions found.</p>
        <?php endif; ?>
        <?php wp_reset_postdata(); ?>
    </section>

    <?php if ($total_posts > $posts_per_page) : ?>
        <div id="load-more-container">
            <button class="font-dfserif text-xl/xl py-sp7" id="load-more">Show more archive ↓</button>
        </div>
    <?php endif; ?>
</main>

<?php
// Include the footer
get_footer();
?>


