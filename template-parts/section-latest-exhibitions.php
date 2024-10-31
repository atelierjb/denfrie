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

        <section class="grid grid-cols-6 gap-x-sp2 mt-sp2 sm:mt-sp4">
            <div class="col-span-6 block sm:hidden">
                <p class="font-superclarendon text-large/large mb-sp2 sm:mb-sp4 truncate">
                    <a href="<?php echo esc_url($post_url); ?>" class="font-dfserif hover:text-df-red">
                        <?php the_title(); ?>
                    </a> 
                </p>
            </div>
            <div class="col-span-2">
                <p class="hidden sm:block font-superclarendon mb-sp4 text-large/large">
                    <a href="<?php echo esc_url($post_url); ?>" class="hover:text-df-red">
                        <?php echo esc_html($exhibition_start_date); ?> — <?php echo esc_html($exhibition_end_date); ?>
                    </a>
                </p>
                <figure class="w-full mb-sp2 sm:mb-sp8 overflow-hidden aspect-video animate-image">
                <a href="<?php echo esc_url($post_url); ?>" aria-label="Go to exhibition">
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
            </div>
            <div class="col-span-4 mb-sp6">
                <p class="hidden sm:block font-superclarendon text-large/large mb-sp4 truncate">
                    <a href="<?php echo esc_url($post_url); ?>" class="font-dfserif hover:text-df-red">
                        <?php the_title(); ?>
                    </a> 
                </p>
                <div class="wysiwyg-content font-superclarendon text-small/small sm:text-regular/regular text-pretty -mt-[0.5vw] line-clamp-4 sm:line-clamp-[7] md:line-clamp-[8] lg:line-clamp-[9] xl:line-clamp-[10] 2xl:line-clamp-[11]">
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
