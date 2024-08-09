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
        $exhibition_image = get_field('exhibition-image');
        $exhibition_artists = get_field('exhibition-artists');
        $exhibition_start_date = get_field('exhibition-start-date');
        $exhibition_end_date = get_field('exhibition-end-date');
        $post_url = get_permalink();
        ?>

        <section class="grid grid-cols-2 sm:grid-cols-6 gap-sp2 mt-sp4">
            <div class="col-span-2">
                <p class="font-superclarendon mb-sp4 text-medium/medium">
                <a href="<?php echo esc_url($post_url); ?>">
                    <?php echo esc_html($exhibition_start_date); ?> — <?php echo esc_html($exhibition_end_date); ?>
                    </a>
                </p>
                <figure class="w-full mb-sp4 sm:mb-sp8 overflow-hidden aspect-video">
                <a href="<?php echo esc_url($post_url); ?>">
                    <img src="<?php echo esc_url($exhibition_image); ?>" alt="<?php the_title(); ?>" class="w-full h-full transform transition-transform duration-500 hover:scale-105 object-cover"></a>
                </figure>
            </div>
            <div class="col-span-4">
                <p class="font-superclarendon text-medium/medium mb-sp8">
                    <a href="<?php echo esc_url($post_url); ?>" class="font-dfserif hover:text-df-grey">
                        <?php the_title(); ?>:
                    </a> 
                    <a href="<?php echo esc_url($post_url); ?>">
                        <?php echo esc_html($exhibition_artists); ?>
                    </a>
                </p>
            </div>
        </section>
        <hr class="border-df-black">
        <?php
    endwhile;
    wp_reset_postdata();
else :
    echo '<p class="font-superclarendon text-xl/xl px-sp9">No upcoming exhibitions found.</p>';
endif;
?>
