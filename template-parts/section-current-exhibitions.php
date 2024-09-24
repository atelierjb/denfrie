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
        <section class="pb-sp10">
            <figure class="mx-sp5 sm:mx-sp9 mb-sp1 overflow-hidden aspect-video animate-image">
                <a href="<?php echo esc_url($post_url); ?>">
                    <?php echo wp_get_attachment_image( $exhibition_image_id, 'full', false, array(
                        'alt' => get_the_title(),
                        'class' => 'w-full h-full transform transition-transform duration-500 hover:scale-105 object-cover',
                    )); ?>
                </a>
            </figure>
            <div class="w-fit hover:text-df-red">
                <h3 class="font-dfserif text-xxl/xxl">
                <a  class="" href="<?php echo esc_url($post_url); ?>">
                        <?php the_title(); ?>
                </a>
                </h3>
                <p class="-ml-[1px] sm:-ml-[3px] font-superclarendon text-xxl/xxl mt-0 sm:-mt-2">
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
