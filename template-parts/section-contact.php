<?php
// Arguments for WP_Query for non-service staff
$args_non_service = array(
    'post_type' => 'team-member', // Custom post type key
    'posts_per_page' => -1, // Get all posts
    'meta_key' => 'staff-order', // Custom field to sort by
    'orderby' => 'meta_value_num', // Order by custom field numeric value
    'order' => 'ASC', // Ascending order
    'meta_query' => array(
        array(
            'key' => 'service-staff-option',
            'value' => '0', // false
            'compare' => '=='
        )
    )
);

// Custom Query for non-service staff
$query_non_service = new WP_Query($args_non_service);

// Loop for non-service staff
if ($query_non_service->have_posts()) {
    while ($query_non_service->have_posts()) {
        $query_non_service->the_post();

        // Get ACF fields
        $staff_title = get_field('staff-title');
        $staff_mail = get_field('staff-mail');
        $staff_phone = get_field('staff-phone');

        // Display non-service staff
        ?>
        <div class="pb-[calc(0.5rem+0.75vw)] break-inside-avoid">
            <p class="underline"><?php echo esc_html($staff_title); ?></p>
            <p><?php the_title(); ?></p>
            <p class="hover:text-df-grey"><a href="mailto:<?php echo esc_attr($staff_mail); ?>"><?php echo esc_html($staff_mail); ?></a></p>
            <p class="hover:text-df-grey"><a href="tel:<?php echo esc_attr($staff_phone); ?>"><?php echo esc_html($staff_phone); ?></a></p>
        </div>
        <?php
    }
    wp_reset_postdata(); // Restore original Post Data
} else {
    ?>
    <p>No non-service staff members found.</p>
    <?php
}
?>

<?php
// Arguments for WP_Query for service staff
$args_service = array(
    'post_type' => 'team-member', // Custom post type key
    'posts_per_page' => -1, // Get all posts
    'order' => 'ASC', // Ascending order
    'meta_query' => array(
        array(
            'key' => 'service-staff-option',
            'value' => '1', // true
            'compare' => '=='
        )
    )
);

// Custom Query for service staff
$query_service = new WP_Query($args_service);

// Loop for service staff
if ($query_service->have_posts()) {
    ?>
    <div class="pb-[calc(0.5rem+0.75vw)]">
        <p class="underline">Service staff</p>
        <?php
        while ($query_service->have_posts()) {
            $query_service->the_post();
            ?>
            <p><?php the_title(); ?></p>
            <?php
        }
        ?>
    </div>
    <?php
    wp_reset_postdata(); // Restore original Post Data
} else {
    ?>
    <p>No service staff members found.</p>
    <?php
}
?>
