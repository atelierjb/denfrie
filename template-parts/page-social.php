<?php
/*
Template Name: Social
*/
get_header();

$posts_per_page = 8;

// Default query: Show only upcoming events
$args = [
    'post_type' => 'social',
    'posts_per_page' => $posts_per_page,
    'meta_key' => 'social-date',
    'orderby' => 'meta_value',
    'order' => 'ASC', // Sort by earliest upcoming events first
    'meta_query' => [
        [
            'key' => 'social-date',
            'value' => date('Y-m-d'), // Compare against today's date
            'compare' => '>=', // Only include future dates
            'type' => 'DATE',
        ],
    ],
];


$social_query = new WP_Query($args);
?>

<main data-barba="wrapper" class="mx-sp3 my-sp5" id="main-content">
    <article data-barba="container">
        <section class="flex justify-between items-center pb-sp5 sm:pb-sp7">
            <h2 class="font-dfserif text-xl/xl animateOnView">
                <?php echo pll__('Social calendar', 'tailpress'); ?>
            </h2>
            <form id="search-form" class="animateOnView">
                <input type="text" id="social-search-input" placeholder="<?php echo pll__('Search in calendar...', 'tailpress'); ?>" class="font-dfserif text-xl/xl text-df-grey bg-df-light-grey text-right focus:outline-none" autocomplete="off">
            </form>
        </section>
        <hr class="border-df-black animateOnView">
        <div id="social-container">
            <?php if ($social_query->have_posts()) : ?>
                <?php while ($social_query->have_posts()) : $social_query->the_post(); ?>
                    <div class="collapse py-[calc(0.25rem+0.5vw)] sm:py-sp4 grid-cols-1">
                        <input type="checkbox" class="min-h-0 p-0" />
                        <div class="collapse-title p-0 min-h-0 grid sm:grid-cols-6 sm:gap-sp2 text-large/large">
                            <p class="font-superclarendon col-span-2 whitespace-nowrap pt-1 sm:pt-0 animateOnView"> 
                                <?php the_field('social-date'); ?> : <?php the_field('social-date-start'); ?> <?php the_field('social-date-end'); ?>
                            </p> <br class="sm:hidden">
                            <p class="font-dfserif leading-[calc(110%+0.2vw)] pb-sp1 sm:pb-0 col-span-4 sm:truncate animateOnView">
                                <?php the_title(); ?>
                            </p>
                        </div>
                        <div class="collapse-content px-0 grid sm:grid-cols-6 sm:gap-sp2">
                            <figure class="w-full overflow-hidden aspect-video col-span-6 sm:col-span-2 mt-sp2 sm:mt-sp4">
                                <?php 
                                $social_image_id = get_field('social-image'); 
                                if ($social_image_id) :
                                    echo wp_get_attachment_image($social_image_id, 'full', false, [
                                        'alt'   => get_the_title(),
                                        'class' => 'w-full h-full transform transition-transform duration-500 hover:scale-105 object-cover',
                                    ]);
                                endif;
                                ?>
                            </figure>
                            <div class="wysiwyg-content font-superclarendon mt-sp4 text-base/regular sm:text-regular/regular col-span-6 sm:col-span-4">
                                <?php echo wp_kses_post(get_field('social-description')); ?>
                            </div>
                        </div>
                    </div>
                    <hr class="border-df-black animateOnView">
                <?php endwhile; ?>
            <?php else : ?>
                <p class="font-superclarendon text-large/large">
                    <?php echo pll__('No events found.', 'tailpress'); ?>
                </p>
            <?php endif; ?>
        </div>
        <div id="social-toggle-container" class="mt-sp5">
            <button id="toggle-past-events" class="font-dfserif text-xl/xl py-sp7 hover:text-df-red animateOnView">
                <?php echo pll__('Show previous events ↓', 'tailpress'); ?>
            </button>
        </div>
    </article>
</main>

<?php get_footer(); ?>
