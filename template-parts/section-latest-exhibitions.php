<?php
// Get the current date
$current_date = date('Ymd'); // Format: YYYYMMDD

// Query arguments
$args = array(
    'post_type' => 'exhibition',
    'posts_per_page' => 5,
    'meta_query' => array(
        array(
            'key' => 'exhibition-end-date',
            'compare' => '<',
            'value' => $current_date,
            'type' => 'DATE'
        )
    ),
    'orderby' => 'meta_value',
    'order' => 'DESC',
    'meta_key' => 'exhibition-end-date',
);

// Custom query
$query = new WP_Query($args);

// Loop through the posts
if ($query->have_posts()) :
    while ($query->have_posts()) : $query->the_post();
        $exhibition_image_id = get_field('exhibition-image');
        $exhibition_start_date = get_field('exhibition-start-date');
        $exhibition_end_date = get_field('exhibition-end-date');
        $exhibition_description = get_field('exhibition-description-long');
        $post_url = get_permalink();
        ?>

        <section class="grid grid-cols-6 gap-sp2 mt-sp2 sm:mt-sp4">
            <div class="col-span-2">
                <p class="font-superclarendon mb-sp2 sm:mb-sp4 text-regular/regular sm:text-medium/medium">
                    <a href="<?php echo esc_url($post_url); ?>">
                        <?php echo esc_html($exhibition_start_date); ?> — <?php echo esc_html($exhibition_end_date); ?>
                    </a>
                </p>
                <figure class="w-full mb-sp2 sm:mb-sp8 overflow-hidden aspect-video animate-image">
                <a href="<?php echo esc_url($post_url); ?>">
                    <?php echo wp_get_attachment_image( $exhibition_image_id, 'full', false, array(
                        'alt' => get_the_title(),
                        'class' => 'w-full h-full transform transition-transform duration-500 hover:scale-105 object-cover',
                    )); ?>
                </a>
                </figure>
            </div>
            <div class="col-span-4 mb-sp6">
                <p class="font-superclarendon text-regular/regular sm:text-medium/medium mb-[calc(0.2rem+1vw)] sm:mb-sp4 truncate">
                    <a href="<?php echo esc_url($post_url); ?>" class="font-dfserif hover:text-df-red">
                        <?php the_title(); ?>
                    </a> 
                </p>
                <div class="wysiwyg-content font-superclarendon text-small/small sm:text-regular/regular text-pretty -mt-[0.5vw] line-clamp-5 sm:line-clamp-[7] md:line-clamp-[8] lg:line-clamp-[9] xl:line-clamp-[10] 2xl:line-clamp-[11]">
                    <?php echo wp_kses_post($exhibition_description); ?> 
                </div>
            </div>
        </section>
        <hr class="border-df-black">
        <?php
    endwhile;
    wp_reset_postdata();
else :
    echo '<p class="font-superclarendon text-xl/xl px-sp9">' . pll__('No archive found.', 'tailpress') . '</p>';

endif;
?>
