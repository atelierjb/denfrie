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

// Define the number of posts per page
$posts_per_page = 8;

// Arguments for WP_Query
$args = [
    'post_type' => 'social',
    'posts_per_page' => $posts_per_page,
    'meta_key' => 'social-date',
    'orderby' => 'meta_value',
    'order' => 'DESC',
    'meta_query' => [
        [
            'key' => 'social-date',
            'compare' => 'EXISTS'
        ]
    ]
];

// Query for social posts
$social_query = new WP_Query($args);
$total_posts = $social_query->found_posts;
?>

<main id="primary" class="mx-sp3 my-sp5">
<div id="main-content">
    <section class="flex justify-between items-center pb-sp7">
        <h2 class="font-dfserif text-xl/xl">
            <?php echo pll__('Social calendar', 'tailpress'); ?>
        </h2>
        <form id="search-form">
            <input type="text" id="search-input" placeholder="<?php echo pll__('Search in calendar...', 'tailpress'); ?>" class="font-dfserif text-xl/xl text-df-grey bg-df-light-grey text-right focus:outline-none" autocomplete="off">
        </form>
    </section>
    <hr class="border-df-black">
    <div id="social-container">
    <?php if ($social_query->have_posts()) : ?>
        <?php while ($social_query->have_posts()) : $social_query->the_post(); ?>
            <div class="collapse py-sp4 grid-cols-1">
                <input type="checkbox" class="min-h-0 p-0" />
                <div class="collapse-title p-0 min-h-0 grid sm:grid-cols-4 sm:gap-sp9 text-medium/medium">
                    <p class="font-superclarendon col-span-1 whitespace-nowrap pt-1 sm:pt-0"> 
                        <?php the_field('social-date'); ?> <?php the_field('social-date-start'); ?> <?php the_field('social-date-end'); ?>
                    </p> <br class="sm:hidden">
                    <p class="font-dfserif leading-[calc(110%+0.2vw)] pb-1 sm:pb-0 col-span-3 line-clamp-1">
                        <?php the_title(); ?>
                    </p>
                </div>
                <div class="collapse-content px-0 grid sm:grid-cols-4 sm:gap-sp9">
                    <figure class="w-full overflow-hidden aspect-video col-span-4 sm:col-span-1 mt-sp4">
                        <?php 
                        $social_image_id = get_field('social-image'); 
                        if( $social_image_id ) : ?>
                            <?php echo wp_get_attachment_image( $social_image_id, 'full', false, array(
                                'alt'   => get_the_title(),
                                'class' => 'w-full h-full transform transition-transform duration-500 hover:scale-105 object-cover',
                            )); ?>
                        <?php endif; ?>
                    </figure>
                    <div class="font-superclarendon mt-sp4 text-regular/regular col-span-3 indent-sp8 text-pretty">
                        <?php the_field('social-description'); ?>
                    </div>
                </div>
            </div>
            <hr class="border-df-black">
        <?php endwhile; ?>
    <?php else : ?>
        <p class="font-superclarendon text-large/large">
            <?php echo pll__('No events found.', 'tailpress'); ?>
        </p>
    <?php endif; ?>
    <?php wp_reset_postdata(); ?>
</div>
<?php if ($total_posts > $posts_per_page) : ?>
    <div id="load-more-container">
        <button class="font-dfserif text-xl/xl py-sp7 hover:text-df-red" id="load-more"><?php echo pll__('Show previous events ↓', 'tailpress'); ?></button>
    </div>
<?php endif; ?>
</div>
</main>



<?php
// Include the footer
get_footer();
?>