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

<main data-barba="wrapper" class="mx-sp3 my-sp5" id="main-content">
    <article data-barba="container">
        <section class="flex justify-between items-center pb-sp5 sm:pb-sp7">
            <h2 class="font-dfserif text-xl/xl animateOnView">
                <?php echo pll__('Archive', 'tailpress'); ?>
            </h2>
            <form id="search-form" class="animateOnView">
                <input type="text" id="archive-search-input" placeholder="<?php echo pll__('Search in archive...', 'tailpress'); ?>" class="font-dfserif text-xl/xl text-df-grey bg-df-light-grey text-right focus:outline-none" autocomplete="off">
            </form>
        </section>

        <section id="exhibitions-list" class="grid grid-cols-1 sm:grid-cols-2 gap-x-sp2 gap-y-sp7 sm:gap-y-sp9">
            <?php if ($exhibition_query->have_posts()) : ?>
                <?php while ($exhibition_query->have_posts()) : $exhibition_query->the_post(); ?>
                    <div class="">
                        <figure class="mx-sp5 sm:mx-0 sm:w-full mb-sp1 overflow-hidden aspect-video animateOnView">
                            <a href="<?php the_permalink(); ?>" aria-label="Go to exhibition">
                                <?php 
                                $image_id = get_field('exhibition-image');
                                if ($image_id) {
                                    $image_data = wp_get_attachment_image_src($image_id, 'exhibition-medium');
                                    $image_alt = get_post_meta($image_id, '_wp_attachment_image_alt', true);
                                    
                                    $srcset = wp_get_attachment_image_srcset($image_id, 'exhibition-medium');
                                    $sizes = '(max-width: 400px) 400px, (max-width: 800px) 800px, (max-width: 1200px) 1200px, 2000px';

                                    echo '<img src="' . esc_url($image_data[0]) . '" 
                                            srcset="' . esc_attr($srcset) . '" 
                                            sizes="' . esc_attr($sizes) . '" 
                                            alt="' . esc_attr($image_alt) . '" 
                                            class="w-full h-full transform transition-transform duration-500 hover:scale-105 object-cover"
                                            loading="lazy">';
                                }
                                ?>
                            </a>
                        </figure>
                        <div class="w-fit hover:text-df-red text-xl/xl">
                            <h3 class="font-dfserif line-clamp-2 animateOnView">
                                <a class="" href="<?php the_permalink(); ?>">
                                    <?php the_title(); ?>
                                </a>
                            </h3>
                            <p class="font-superclarendon animateOnView">
                                <a href="<?php echo esc_url( get_permalink() ); ?>">
                                    <?php echo esc_html( get_field('exhibition-start-date') ); ?> — <?php echo esc_html( get_field('exhibition-end-date') ); ?>
                                </a>
                            </p>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else : ?>
                <p class="font-superclarendon text-large/large">
                    <?php echo pll__('No exhibitions found.', 'tailpress'); ?>
                </p>
            <?php endif; ?>
            <?php wp_reset_postdata(); ?>
        </section>

        <?php if ($total_posts > $posts_per_page) : ?>
            <div id="archive-load-more-container">
                <button class="font-dfserif text-xl/xl py-sp9 hover:text-df-red animateOnView" id="archive-load-more">
                    <?php echo pll__('Show more archive', 'tailpress'); ?> ↓
                </button>
            </div>
        <?php endif; ?>
    </article>
</main>

<?php
// Include the footer
get_footer();
?>


