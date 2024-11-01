<?php
// Get the current date
$current_date = date('Ymd'); // Format: YYYYMMDD

// Query arguments
$args = array(
    'post_type' => 'exhibition',
    'posts_per_page' => -1,
    'meta_query' => array(
        array(
            'key' => 'exhibition-start-date',
            'compare' => '<=',
            'value' => $current_date,
            'type' => 'DATE'
        ),
        array(
            'key' => 'exhibition-end-date',
            'compare' => '>=',
            'value' => $current_date,
            'type' => 'DATE'
        )
    )
);

// Custom query
$query = new WP_Query($args);

// Loop through the posts
if ($query->have_posts()) :
    while ($query->have_posts()) : $query->the_post();
        $exhibition_image_id = get_field('exhibition-image');
        $exhibition_start_date = get_field('exhibition-start-date');
        $exhibition_end_date = get_field('exhibition-end-date');
        $post_url = get_permalink();
        ?>
        <section class="pb-sp8 sm:pb-sp10">
            <figure class="mx-sp5 sm:mx-sp9 mb-sp1 overflow-hidden aspect-video animateOnView">
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
            <div class="w-fit hover:text-df-red text-xxl/xxl sm:text-xxxl/xxl">
                <h3 class="font-dfserif animateOnView">
                    <a  class="" href="<?php echo esc_url($post_url); ?>">
                        <?php the_title(); ?>
                    </a>
                </h3>
                <p class="ml-[1px] sm:-ml-[2px] font-superclarendon animateOnView">
                    <a href="<?php echo esc_url($post_url); ?>">
                        <?php echo esc_html($exhibition_start_date); ?> — <?php echo esc_html($exhibition_end_date); ?>
                    </a>
                </p>
            </div>
        </section>
        <?php
    endwhile;
    wp_reset_postdata();
else :
    echo '<p class="font-superclarendon text-xl/xl px-sp9">' . pll__('No current exhibitions found.', 'tailpress') . '</p>';
endif;
?>
