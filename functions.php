<?php

/**
 * Theme setup.
 */
function tailpress_setup() {
	add_theme_support( 'title-tag' );

	register_nav_menus(
		array(
			'primary' => __( 'Primary Menu', 'tailpress' ),
		)
	);

	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		)
	);

    add_theme_support( 'custom-logo' );
	add_theme_support( 'post-thumbnails' );

	add_theme_support( 'align-wide' );
	add_theme_support( 'wp-block-styles' );

	add_theme_support( 'editor-styles' );
	add_editor_style( 'css/editor-style.css' );
}

add_action( 'after_setup_theme', 'tailpress_setup' );

/**
 * Enqueue theme assets.
 */
function tailpress_enqueue_scripts() {
	$theme = wp_get_theme();

	wp_enqueue_style( 'tailpress', tailpress_asset( 'css/app.css' ), array(), $theme->get( 'Version' ) );
	wp_enqueue_script( 'tailpress', tailpress_asset( 'js/app.js' ), array(), $theme->get( 'Version' ) );
}

add_action( 'wp_enqueue_scripts', 'tailpress_enqueue_scripts' );

/**
 * Get asset path.
 *
 * @param string  $path Path to asset.
 *
 * @return string
 */
function tailpress_asset( $path ) {
	if ( wp_get_environment_type() === 'production' ) {
		return get_stylesheet_directory_uri() . '/' . $path;
	}

	return add_query_arg( 'time', time(),  get_stylesheet_directory_uri() . '/' . $path );
}

/**
 * Adds option 'li_class' to 'wp_nav_menu'.
 *
 * @param string  $classes String of classes.
 * @param mixed   $item The current item.
 * @param WP_Term $args Holds the nav menu arguments.
 *
 * @return array
 */
function tailpress_nav_menu_add_li_class( $classes, $item, $args, $depth ) {
	if ( isset( $args->li_class ) ) {
		$classes[] = $args->li_class;
	}

	if ( isset( $args->{"li_class_$depth"} ) ) {
		$classes[] = $args->{"li_class_$depth"};
	}

	return $classes;
}

add_filter( 'nav_menu_css_class', 'tailpress_nav_menu_add_li_class', 10, 4 );

/**
 * Adds option 'submenu_class' to 'wp_nav_menu'.
 *
 * @param string  $classes String of classes.
 * @param mixed   $item The current item.
 * @param WP_Term $args Holds the nav menu arguments.
 *
 * @return array
 */
function tailpress_nav_menu_add_submenu_class( $classes, $args, $depth ) {
	if ( isset( $args->submenu_class ) ) {
		$classes[] = $args->submenu_class;
	}

	if ( isset( $args->{"submenu_class_$depth"} ) ) {
		$classes[] = $args->{"submenu_class_$depth"};
	}

	return $classes;
}

add_filter( 'nav_menu_submenu_css_class', 'tailpress_nav_menu_add_submenu_class', 10, 3 );




/* -------------------------------------------------------------------------- */
/*                                  Allow SVG                                 */
/* -------------------------------------------------------------------------- */


add_filter( 'wp_check_filetype_and_ext', function($data, $file, $filename, $mimes) {

	global $wp_version;
	if ( $wp_version !== '4.7.1' ) {
	   return $data;
	}
  
	$filetype = wp_check_filetype( $filename, $mimes );
  
	return [
		'ext'             => $filetype['ext'],
		'type'            => $filetype['type'],
		'proper_filename' => $data['proper_filename']
	];
  
  }, 10, 4 );
  
  function cc_mime_types( $mimes ){
	$mimes['svg'] = 'image/svg+xml';
	return $mimes;
  }
  add_filter( 'upload_mimes', 'cc_mime_types' );
  
  function fix_svg() {
	echo '<style type="text/css">
		  .attachment-266x266, .thumbnail img {
			   width: 100% !important;
			   height: auto !important;
		  }
		  </style>';
  }
  add_action( 'admin_head', 'fix_svg' );




/* -------------------------------------------------------------------------- */
/*                            Back to top function                            */
/* -------------------------------------------------------------------------- */


  function custom_back_to_top_script() {
    ?>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Select the existing back-to-top link by its ID
            var backToTopButton = document.getElementById('back-to-top');
            
            // Ensure the button exists
            if (backToTopButton) {
                // Scroll to the top when the button is clicked
                backToTopButton.addEventListener('click', function(event) {
                    event.preventDefault();
                    window.scrollTo({ top: 0, behavior: 'smooth' });
                });
            }
        });
    </script>
    <?php
}
add_action('wp_footer', 'custom_back_to_top_script');


function enqueue_custom_scripts() {
    wp_enqueue_script('social-page-js', get_template_directory_uri() . '/js/social-page.js', ['jquery'], null, true);
    wp_localize_script('social-page-js', 'ajaxurl', admin_url('admin-ajax.php'));
}
add_action('wp_enqueue_scripts', 'enqueue_custom_scripts');




/* -------------------------------------------------------------------------- */
/*                             // SOCIALS PAGE //                             */
/* -------------------------------------------------------------------------- */


/* ----------------------- Load more posts via AJAX ---------------------- */
function load_more_posts() {
    $paged = $_POST['page'];
    $posts_per_page = 8;

    $args = [
        'post_type' => 'social',
        'posts_per_page' => $posts_per_page,
        'paged' => $paged,
        'meta_key' => 'social-date',  // Update this to use hyphen
        'orderby' => 'meta_value',
        'order' => 'DESC',
    ];

    $social_query = new WP_Query($args);

    if ($social_query->have_posts()) :
        while ($social_query->have_posts()) : $social_query->the_post(); ?>
            <div class="collapse py-sp4 grid-cols-1">
                <input type="checkbox" class="min-h-0 p-0" />
                <div class="collapse-title p-0 min-h-0 grid sm:grid-cols-7 sm:gap-sp9 text-medium/medium">
                    <p class="font-superclarendon col-span-2 whitespace-nowrap pt-1 sm:pt-0"> 
                        <?php the_field('social-date'); ?> <?php the_field('social-date-start'); ?> <?php the_field('social-date-end'); ?>
                    </p> <br class="sm:hidden">
                    <p class="font-dfserif leading-[calc(110%+0.2vw)] pb-1 sm:pb-0 col-span-5 sm:truncate">
                        <?php the_title(); ?>
                    </p>
                </div>
                <div class="collapse-content px-0 grid sm:grid-cols-7 sm:gap-sp9">
                    <figure class="w-full overflow-hidden aspect-video col-span-7 sm:col-span-2 mt-sp4">
                        <?php 
                        $social_image_id = get_field('social-image'); 
                        if( $social_image_id ) : ?>
                            <?php echo wp_get_attachment_image( $social_image_id, 'full', false, array(
                                'alt'   => get_the_title(),
                                'class' => 'w-full h-full transform transition-transform duration-500 hover:scale-105 object-cover',
                            )); ?>
                        <?php endif; ?>
                    </figure>
                    <div class="wysiwyg-content font-superclarendon mt-sp4 text-regular/regular col-span-7 sm:col-span-5">
                        <?php echo wp_kses_post( get_field('social-description') ); ?>
                    </div>
                </div>
            </div>
            <hr class="border-df-black">
        <?php endwhile;
    endif;

    wp_die();
}
add_action('wp_ajax_load_more_posts', 'load_more_posts');
add_action('wp_ajax_nopriv_load_more_posts', 'load_more_posts');


/* ------------------------- AJAX search function ------------------------ */

function filter_search() {
    $search_query = sanitize_text_field($_POST['searchQuery']);
    $posts_per_page = 8;

    $args = [
        'post_type' => 'social',
        'posts_per_page' => $posts_per_page,
        's' => $search_query,  // Main search parameter
        'meta_key' => 'social-date',  // The custom field to order by
        'orderby' => 'meta_value',
        'order' => 'DESC',  // Descending order 
    ];

    $social_query = new WP_Query($args);

    if ($social_query->have_posts()) :
        while ($social_query->have_posts()) : $social_query->the_post(); ?>
            <div class="collapse py-sp4 grid-cols-1">
                <input type="checkbox" class="min-h-0 p-0" />
                <div class="collapse-title p-0 min-h-0 grid sm:grid-cols-7 sm:gap-sp9 text-medium/medium">
                    <p class="font-superclarendon col-span-2 whitespace-nowrap pt-1 sm:pt-0"> 
                        <?php the_field('social-date'); ?> <?php the_field('social-date-start'); ?> <?php the_field('social-date-end'); ?>
                    </p> <br class="sm:hidden">
                    <p class="font-dfserif leading-[calc(110%+0.2vw)] pb-1 sm:pb-0 col-span-5 sm:truncate">
                        <?php the_title(); ?>
                    </p>
                </div>
                <div class="collapse-content px-0 grid sm:grid-cols-7 sm:gap-sp9">
                    <figure class="w-full overflow-hidden aspect-video col-span-7 sm:col-span-2 mt-sp4">
                        <?php 
                        $social_image_id = get_field('social-image'); 
                        if( $social_image_id ) : ?>
                            <?php echo wp_get_attachment_image( $social_image_id, 'full', false, array(
                                'alt'   => get_the_title(),
                                'class' => 'w-full h-full transform transition-transform duration-500 hover:scale-105 object-cover',
                            )); ?>
                        <?php endif; ?>
                    </figure>
                    <div class="wysiwyg-content font-superclarendon mt-sp4 text-regular/regular col-span-7 sm:col-span-5">
                        <?php echo wp_kses_post( get_field('social-description') ); ?>
                    </div>
                </div>
            </div>
            <hr class="border-df-black">
        <?php endwhile;
    else :
        echo '<p class="font-superclarendon text-large/large mt-sp4">No results found.</p>';
    endif;

    wp_die();
}

add_action('wp_ajax_filter_search', 'filter_search');
add_action('wp_ajax_nopriv_filter_search', 'filter_search');




/* -------------------------------------------------------------------------- */
/*                              Archive functions                             */
/* -------------------------------------------------------------------------- */


function enqueue_custom_exhibition_scripts() {
    wp_enqueue_script('exhibition-page-js', get_template_directory_uri() . '/js/exhibition-page.js', ['jquery'], null, true);

    // Pass PHP data to the JavaScript file
    wp_localize_script('exhibition-page-js', 'exhibition_ajax', [
        'ajaxurl' => admin_url('admin-ajax.php'),
        'posts_per_page' => 6, // Set the posts per page value here
    ]);
}
add_action('wp_enqueue_scripts', 'enqueue_custom_exhibition_scripts');


/* -------------------- Load more exhibitions via AJAX ------------------- */

function load_more_exhibitions() {
    $paged = $_POST['page'];
    $posts_per_page = 6;

    $args = [
        'post_type' => 'exhibition',
        'posts_per_page' => $posts_per_page,
        'paged' => $paged,
        'meta_key' => 'exhibition-end-date',
        'orderby' => 'meta_value',
        'order' => 'DESC',
        'meta_query' => [
            [
                'key' => 'exhibition-end-date',
                'compare' => '<=',
                'value' => date('Ymd'),
                'type' => 'DATE'
            ]
        ]
    ];

    $exhibition_query = new WP_Query($args);

    if ($exhibition_query->have_posts()) :
        while ($exhibition_query->have_posts()) : $exhibition_query->the_post(); ?>
            <div class="">
                    <figure class="mb-sp1 overflow-hidden aspect-video">
                        <a href="<?php the_permalink(); ?>">
                            <?php
                            $exhibition_image_id = get_field('exhibition-image');
                            if ( $exhibition_image_id ) {
                                echo wp_get_attachment_image( $exhibition_image_id, 'full', false, array(
                                    'alt'   => get_the_title(),
                                    'class' => 'w-full h-full transform transition-transform duration-500 hover:scale-105 object-cover',
                                ));
                            }
                            ?>
                        </a>
                    </figure>
                    <div class="w-fit hover:text-df-red">
                        <h3 class="font-dfserif text-xxl/xxl line-clamp-2">
                            <a class="" href="<?php the_permalink(); ?>">
                                <?php the_title(); ?>
                            </a>
                        </h3>
                        <p class="font-superclarendon text-xxl/xxl">
                            <a href="<?php echo esc_url( get_permalink() ); ?>">
                                <?php echo esc_html( get_field('exhibition-start-date') ); ?> — <?php echo esc_html( get_field('exhibition-end-date') ); ?>
                            </a>
                        </p>
                    </div>
            </div>
        <?php endwhile;
    endif;

    wp_die();
}
add_action('wp_ajax_load_more_exhibitions', 'load_more_exhibitions');
add_action('wp_ajax_nopriv_load_more_exhibitions', 'load_more_exhibitions');


/* ----------------------- Search exhibitions via AJAX ---------------------- */

function search_exhibitions() {
    $search_query = sanitize_text_field($_POST['searchQuery']);
    $posts_per_page = 6;

    $args = [
        'post_type' => 'exhibition',
        'posts_per_page' => $posts_per_page,
        's' => $search_query,
        'meta_key' => 'exhibition-end-date',
        'orderby' => 'meta_value',
        'order' => 'DESC',
        'meta_query' => [
            [
                'key' => 'exhibition-end-date',
                'compare' => '<=',
                'value' => date('Ymd'),
                'type' => 'DATE'
            ]
        ]
    ];

    $exhibition_query = new WP_Query($args);

    if ($exhibition_query->have_posts()) :
        while ($exhibition_query->have_posts()) : $exhibition_query->the_post(); ?>
            <div class="">
                    <figure class="mb-sp1 overflow-hidden aspect-video">
                        <a href="<?php the_permalink(); ?>">
                            <?php
                            $exhibition_image_id = get_field('exhibition-image');
                            if ( $exhibition_image_id ) {
                                echo wp_get_attachment_image( $exhibition_image_id, 'full', false, array(
                                    'alt'   => get_the_title(),
                                    'class' => 'w-full h-full transform transition-transform duration-500 hover:scale-105 object-cover',
                                ));
                            }
                            ?>
                        </a>
                    </figure>
                    <div class="w-fit hover:text-df-red">
                        <h3 class="font-dfserif text-xxl/xxl line-clamp-2">
                            <a class="" href="<?php the_permalink(); ?>">
                                <?php the_title(); ?>
                            </a>
                        </h3>
                        <p class="font-superclarendon text-xxl/xxl">
                            <a href="<?php echo esc_url( get_permalink() ); ?>">
                                <?php echo esc_html( get_field('exhibition-start-date') ); ?> — <?php echo esc_html( get_field('exhibition-end-date') ); ?>
                            </a>
                        </p>
                    </div>
            </div>
        <?php endwhile;
    else :
        echo '<p class="font-superclarendon text-large/large mt-sp4">No results found.</p>';
    endif;

    wp_die();
}
add_action('wp_ajax_search_exhibitions', 'search_exhibitions');
add_action('wp_ajax_nopriv_search_exhibitions', 'search_exhibitions');




/* -------------------------------------------------------------------------- */
/*                             Polylang functions                             */
/* -------------------------------------------------------------------------- */


// Custom function to get the translated post title based on the current language
function pll_get_post_title($id) {
    $translated_id = pll_get_post($id);
    return get_the_title($translated_id);
}


/* Add strings for translation in Polylang */

function my_theme_register_strings() {
    // header
    pll_register_string('exhibitions', 'Exhibitions', 'tailpress');
    pll_register_string('social', 'Social', 'tailpress');
    pll_register_string('about', 'About', 'tailpress');
    pll_register_string('visit', 'Visit', 'tailpress');
    pll_register_string('address', 'Oslo plads 1, 2100, Kbh Ø, DK', 'tailpress');
    pll_register_string('mon', 'Mon : Closed', 'tailpress');
    pll_register_string('tue-sun', 'Tues-Sun : 12 — 18', 'tailpress');
    pll_register_string('thur', '(Thurs : 12 — 21)', 'tailpress');

    // footer
    pll_register_string('newsletter', 'Newsletter', 'tailpress');
    pll_register_string('annualpass', 'Annual pass', 'tailpress');

    // exhibitions page
    pll_register_string('current-exhibitions', 'Current Exhibitions', 'tailpress');
    pll_register_string('no-current-exhibitions', 'No current exhibitions found.', 'tailpress');
    pll_register_string('upcoming-exhibitions', 'Upcoming Exhibitions', 'tailpress');
    pll_register_string('no-upcoming-exhibitions', 'No upcoming exhibitions found.', 'tailpress');
    pll_register_string('latest-exhibitions', 'Latest Exhibitions', 'tailpress');
    pll_register_string('no-latest-exhibitions', 'No archive found.', 'tailpress');
    pll_register_string('go-to-archive', 'Go to archive', 'tailpress');
    pll_register_string('go-to-archive', 'Show more archive', 'tailpress');

    //archive page
    pll_register_string('archive', 'Archive', 'tailpress');
    pll_register_string('no-exhibitions-found', 'No exhibitions found.', 'tailpress');
    pll_register_string('search-archive', 'Search in archive...', 'tailpress');

    //social page
    pll_register_string('social-calendar', 'Social calendar', 'tailpress');
    pll_register_string('no-events-found', 'No events found.', 'tailpress');
    pll_register_string('search-archive', 'Search in calendar...', 'tailpress');
    pll_register_string('more-events', 'Show previous events ↓', 'tailpress');

    //about page
    pll_register_string('contact', 'Contact', 'tailpress');

    //visit page
    pll_register_string('price-adults', '+16 years', 'tailpress');
    pll_register_string('price-seniors', 'Seniors', 'tailpress');
    pll_register_string('price-students', 'Students', 'tailpress');
    pll_register_string('price-kids', '0—15 years', 'tailpress');
    pll_register_string('price-annualpass', 'w. Annual pass', 'tailpress');
    pll_register_string('newsletter-name', 'Name', 'tailpress');
    pll_register_string('newsletter-surname', 'Surname', 'tailpress');
    pll_register_string('newsletter-signup', 'Sign up', 'tailpress');
    pll_register_string('newsletter-success', 'Successfully subscribed!', 'tailpress');
    pll_register_string('newsletter-error', 'An unknown error occurred.', 'tailpress');

    //exhibition sub page
    pll_register_string('exhibition-folder', 'Exhibition folder', 'tailpress');
    pll_register_string('exhibition-presskit', 'Presskit', 'tailpress');
    pll_register_string('exhibition-more', 'More', 'tailpress');
    pll_register_string('exhibition-less', 'Less', 'tailpress');
    pll_register_string('exhibition-artists', 'Participating artists', 'tailpress');
    pll_register_string('exhibition-description', 'Description', 'tailpress');
    pll_register_string('exhibition-additional', 'Additional content', 'tailpress');
    pll_register_string('exhibition-support', 'The exhibition is generously supported by', 'tailpress');

    //contact section
    pll_register_string('contact-servicestaff', 'Service staff', 'tailpress');
    pll_register_string('contact-nostaff', 'No staff members found.', 'tailpress');
    pll_register_string('contact-noservicestaff', 'No service staff members found.', 'tailpress');
}
add_action('init', 'my_theme_register_strings');




/* -------------------------------------------------------------------------- */
/*                         WORDPRESS ADMIN ADJUSTMENTS                        */
/* -------------------------------------------------------------------------- */


function my_custom_admin_bar() {
    global $wp_admin_bar;
    
    // Remove the "Updates" icon
    $wp_admin_bar->remove_node('updates');
    
    // Remove the "Comments" icon
    $wp_admin_bar->remove_node('comments');
    
    // Remove the "New" content menu
    $wp_admin_bar->remove_node('new-content');
    
    // Remove the "View Site" link
    $wp_admin_bar->remove_node('view-site');
    
    // You can remove other items by specifying their IDs
}
add_action('wp_before_admin_bar_render', 'my_custom_admin_bar');



/* ---------- Fetching ACF fields to custom post type overviews ---------- */

// Add custom columns for the 'exhibition' post type
function my_exhibition_custom_columns($columns) {
    $columns['exhibition_dates'] = __('Exhibition Dates');
    return $columns;
}
add_filter('manage_exhibition_posts_columns', 'my_exhibition_custom_columns');

// Add custom columns for the 'social' post type
function my_social_custom_columns($columns) {
    $columns['social_date'] = __('Social Date');
    return $columns;
}
add_filter('manage_social_posts_columns', 'my_social_custom_columns');

// Add custom columns for the 'team-member' post type
function my_team_member_custom_columns($columns) {
    $columns['service_staff_option'] = __('Service Staff Option');
    return $columns;
}
add_filter('manage_team-member_posts_columns', 'my_team_member_custom_columns');

// Populate custom columns for the 'exhibition' post type
function my_exhibition_custom_column_content($column, $post_id) {
    if ($column == 'exhibition_dates') {
        // Fetch raw start and end dates
        $start_date = get_field('exhibition-start-date', $post_id);
        $end_date = get_field('exhibition-end-date', $post_id);

        // Check if the dates exist and convert them to sortable format (d-m-Y)
        if ($start_date) {
            $formatted_start_date = DateTime::createFromFormat('d.m.', $start_date)->format('d-m-Y');
        }

        if ($end_date) {
            $formatted_end_date = DateTime::createFromFormat('d.m. Y', $end_date)->format('d-m-Y');
        }

        // Display combined start and end dates or a placeholder
        if ($formatted_start_date && $formatted_end_date) {
            echo $formatted_start_date . ' - ' . $formatted_end_date;
        } elseif ($formatted_start_date) {
            echo $formatted_start_date; // If only start date is present
        } else {
            echo __('No dates available');
        }
    }
}
add_action('manage_exhibition_posts_custom_column', 'my_exhibition_custom_column_content', 10, 2);


// Populate custom columns for the 'social' post type
function my_social_custom_column_content($column, $post_id) {
    if ($column == 'social_date') {
        echo get_field('social-date', $post_id);
    }
}
add_action('manage_social_posts_custom_column', 'my_social_custom_column_content', 10, 2);

// Populate custom columns for the 'team-member' post type
function my_team_member_custom_column_content($column, $post_id) {
    if ($column == 'service_staff_option') {
        $value = get_field('service-staff-option', $post_id);
        echo $value ? __('Yes') : __('No');
    }
}
add_action('manage_team-member_posts_custom_column', 'my_team_member_custom_column_content', 10, 2);

// Make 'exhibition' columns sortable
function my_exhibition_sortable_columns($columns) {
    $columns['exhibition_dates'] = 'exhibition_dates';
    return $columns;
}
add_filter('manage_edit-exhibition_sortable_columns', 'my_exhibition_sortable_columns');

// Make 'social' columns sortable
function my_social_sortable_columns($columns) {
    $columns['social_date'] = 'social_date';
    return $columns;
}
add_filter('manage_edit-social_sortable_columns', 'my_social_sortable_columns');

// Make 'team-member' columns sortable
function my_team_member_sortable_columns($columns) {
    $columns['service_staff_option'] = 'service_staff_option';
    return $columns;
}
add_filter('manage_edit-team-member_sortable_columns', 'my_team_member_sortable_columns');

// Sorting logic for custom columns
function my_custom_orderby($query) {
    if (!is_admin() || !$query->is_main_query()) {
        return;
    }

    $orderby = $query->get('orderby');

    // Sorting by exhibition start date
    if ($orderby == 'exhibition_dates') {
        $query->set('meta_key', 'exhibition-start-date'); // Sort by the start date field
        $query->set('orderby', 'meta_value'); // Sort as text (or 'meta_value_num' if necessary)
    }

    // Sorting by social date
    if ($orderby == 'social_date') {
        $query->set('meta_key', 'social-date');
        $query->set('orderby', 'meta_value_num');
    }

    // Sorting by service staff option
    if ($orderby == 'service_staff_option') {
        $query->set('meta_key', 'service-staff-option');
        $query->set('orderby', 'meta_value_num');
    }
}
add_action('pre_get_posts', 'my_custom_orderby');




/* -----------------------  edits to WYSIWYG editor ----------------------- */

function enqueue_acf_custom_js() {
    wp_enqueue_script('acf-custom-js', get_template_directory_uri() . '/js/acf-custom.js', array('acf-input'), null, true);
}
add_action('acf/input/admin_enqueue_scripts', 'enqueue_acf_custom_js');



/* -------------------- Automatic date fields for search -------------------- */

// Hook into ACF's save_post action for custom post type 'social'
add_action('acf/save_post', 'update_social_date_search_field', 20);

function update_social_date_search_field($post_id) {

    // Check if we're saving a post of the custom post type 'social'
    if (get_post_type($post_id) == 'social') {
        
        // Get the values of the date and time picker fields
        $social_date = get_field('social-date', $post_id);
        $social_date_start = get_field('social-date-start', $post_id);
        $social_date_end = get_field('social-date-end', $post_id);

        // Ensure all fields have values before proceeding
        if ($social_date && $social_date_start && $social_date_end) {
            
            // Combine the date and time values in the format you want
            $social_date_search = $social_date . ' ' . $social_date_start . ' ' . $social_date_end;
            
            // Update the 'social-date-search' field with the combined value
            update_field('social-date-search', $social_date_search, $post_id);
        }
    }
}

// Hook into ACF's save_post action for custom post type 'exhibition'
add_action('acf/save_post', 'update_exhibition_date_search_field', 20);

function update_exhibition_date_search_field($post_id) {

    // Check if we're saving a post of the custom post type 'exhibition'
    if (get_post_type($post_id) == 'exhibition') {
        
        // Get the values of the date picker fields
        $exhibition_start_date = get_field('exhibition-start-date', $post_id);
        $exhibition_end_date = get_field('exhibition-end-date', $post_id);

        // Ensure both fields have values before proceeding
        if ($exhibition_start_date && $exhibition_end_date) {
            
            // Combine the dates in the format you want
            $exhibition_date_search = $exhibition_start_date . ' — ' . $exhibition_end_date;

            // Update the 'exhibition-date-search' field with the combined value
            update_field('exhibition-date-search', $exhibition_date_search, $post_id);
        }
    }
}


/* -------------------------------------------------------------------------- */
/*                                  Swiper.js                                 */
/* -------------------------------------------------------------------------- */


function enqueue_swiper_assets() {
    // Swiper CSS
    wp_enqueue_style( 'swiper-css', 'https://unpkg.com/swiper/swiper-bundle.min.css', array(), null );
    
    // Swiper JS
    wp_enqueue_script( 'swiper-js', 'https://unpkg.com/swiper/swiper-bundle.min.js', array(), null, true );
}
add_action( 'wp_enqueue_scripts', 'enqueue_swiper_assets' );




/* -------------------------------------------------------------------------- */
/*                           GSAP and ScrollTrigger                           */
/* -------------------------------------------------------------------------- */

function enqueue_gsap_scripts() {
    // Enqueue GSAP and ScrollTrigger
    wp_enqueue_script('gsap', 'https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js', array(), null, true);
    wp_enqueue_script('scrolltrigger', 'https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/ScrollTrigger.min.js', array('gsap'), null, true);

    // Enqueue the custom script, making sure it depends on GSAP and ScrollTrigger only
    wp_enqueue_script('custom-gsap', get_template_directory_uri() . '/js/custom-gsap.js', array('gsap', 'scrolltrigger'), null, true);
}
add_action('wp_enqueue_scripts', 'enqueue_gsap_scripts');




/* -------------------------------------------------------------------------- */
/*                             Newsletter function                            */
/* -------------------------------------------------------------------------- */


// Newsletter sign-up function for Mailchimp

function enqueue_newsletter_script() {
    wp_enqueue_script('newsletter-js', get_template_directory_uri() . '/js/newsletter.js', array('jquery'), null, true);

    // Pass admin-ajax.php URL to the JavaScript file
    wp_localize_script('newsletter-js', 'ajax_object', array(
        'ajax_url' => admin_url('admin-ajax.php')
    ));
}
add_action('wp_enqueue_scripts', 'enqueue_newsletter_script');


add_action('wp_ajax_mailchimp_subscribe', 'mailchimp_subscribe');
add_action('wp_ajax_nopriv_mailchimp_subscribe', 'mailchimp_subscribe');

function mailchimp_subscribe() {
    if ( !isset($_POST['email']) || empty($_POST['email']) ) {
        wp_send_json_error(['message' => 'Email is required.']);
        exit;
    }

    // Retrieve and sanitize inputs
    $email = sanitize_email($_POST['email']);
    $name = sanitize_text_field($_POST['name']);
    $surname = sanitize_text_field($_POST['surname']);
    $api_key = MAILCHIMP_API_KEY;
    $list_id = '30cac02d72'; // Replace with actual Mailchimp List ID

    // Mailchimp API endpoint and data
    $url = 'https://us5.api.mailchimp.com/3.0/lists/' . $list_id . '/members/';
    $data = [
        'email_address' => $email,
        'status' => 'subscribed',
        'merge_fields' => [
            'FNAME' => $name,
            'LNAME' => $surname
        ]
    ];

    // Initialize cURL
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_USERPWD, 'user:' . $api_key);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);

    // Execute request and capture response
    $response = curl_exec($ch);
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    // Parse the response and handle it
    $response_data = json_decode($response, true);

    if ($http_code === 200) {
        wp_send_json_success(['message' => pll__('Successfully subscribed!', 'tailpress')]);
    } else {
        // Check for a more detailed error from the Mailchimp API response
        $error_message = isset($response_data['detail']) ? $response_data['detail'] : pll__('An unknown error occurred.', 'tailpress');
        wp_send_json_error(['message' => $error_message]);
    }

    exit;
}

