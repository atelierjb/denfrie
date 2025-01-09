<?php

/**
 * Theme setup.
 */
function tailpress_setup() {

    add_theme_support( 'automatic-feed-links' );
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

    add_image_size('exhibition-small', 400, 0, false);
    add_image_size('exhibition-medium', 800, 0, false);
    add_image_size('exhibition-large', 1200, 0, false);
    add_image_size('exhibition-xlarge', 2000, 0, false);

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


function tailpress_custom_image_sizes( $sizes ) {
    return array_merge( $sizes, array(
        'exhibition-small' => __( 'Exhibition Small' ),
        'exhibition-medium' => __( 'Exhibition Medium' ),
        'exhibition-large' => __( 'Exhibition Large' ),
        'exhibition-xlarge' => __( 'Exhibition XLarge' ),
    ) );
}
add_filter( 'image_size_names_choose', 'tailpress_custom_image_sizes' );



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







/* -------------------------------------------------------------------------- */
/*                             // SOCIALS PAGE //                             */
/* -------------------------------------------------------------------------- */

function enqueue_custom_scripts() {
    $social_page_id = pll_get_post(5);
    if (is_page($social_page_id)) {
        wp_enqueue_script(
            'social-page-js',
            get_template_directory_uri() . '/js/social-page.js',
            array(),
            null,
            true
        );

        // Pass AJAX URL and translations to JavaScript
        wp_localize_script('social-page-js', 'socialPageData', [
            'ajax_url' => admin_url('admin-ajax.php'),
            'toggle_show_text' => pll__('Show previous events ↓', 'tailpress'), // Translation for "Show previous events"
            'toggle_hide_text' => pll__('Hide previous events ↑', 'tailpress'), // Translation for "Hide previous events"
        ]);
    }
}
add_action('wp_enqueue_scripts', 'enqueue_custom_scripts');


function fetch_social_events() {
    $offset = isset($_POST['offset']) ? intval($_POST['offset']) : 0;
    $posts_per_page = isset($_POST['posts_per_page']) ? intval($_POST['posts_per_page']) : 5;
    $search_query = isset($_POST['search_query']) ? sanitize_text_field($_POST['search_query']) : '';

    $args = [
        'post_type' => 'social',
        'posts_per_page' => $posts_per_page,
        'offset' => $offset,
        'meta_key' => 'social-date',
        'orderby' => 'meta_value',
        'order' => 'DESC', // Sort by the farthest future date
    ];

    // Add search query
    if (!empty($search_query)) {
        $args['s'] = $search_query;
    }

    $social_query = new WP_Query($args);

    // Get the total number of events matching the query
    $total_args = $args;
    unset($total_args['posts_per_page'], $total_args['offset']); // Remove pagination to count all matching posts
    $total_query = new WP_Query($total_args);
    $total_posts = $total_query->found_posts;

    $html = '';

    if ($social_query->have_posts()) :
        while ($social_query->have_posts()) : $social_query->the_post();
            ob_start(); // Start output buffering
            ?>
            <div class="collapse py-[calc(0.25rem+0.5vw)] sm:py-sp4 grid-cols-1">
                <input type="checkbox" class="min-h-0 p-0" />
                <div class="collapse-title p-0 min-h-0 grid sm:grid-cols-6 sm:gap-sp2 text-large/large">
                    <p class="font-superclarendon col-span-2 whitespace-nowrap pt-1 sm:pt-0 animateOnView">
                        <?php the_field('social-date'); ?> : <?php the_field('social-date-start'); ?> <?php the_field('social-date-end'); ?>
                    </p>
                    <p class="font-dfserif pb-sp1 sm:pb-0 col-span-4 sm:truncate animateOnView">
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
            <?php
            $html .= ob_get_clean(); // Append buffered content
        endwhile;
    endif;

    wp_send_json([
        'html' => $html,
        'total' => $total_posts,
    ]);
}
add_action('wp_ajax_fetch_social_events', 'fetch_social_events');
add_action('wp_ajax_nopriv_fetch_social_events', 'fetch_social_events');





/* -------------------------------------------------------------------------- */
/*                              Archive functions                             */
/* -------------------------------------------------------------------------- */


function enqueue_custom_exhibition_scripts() {
    $archive_page_id = pll_get_post(159); // Assuming 5 is the ID of your social page
    if (is_page($archive_page_id)) {
    wp_enqueue_script('exhibition-page-js', get_template_directory_uri() . '/js/exhibition-page.js', array(), null, true);
    }

    // Get the total number of posts for the 'exhibition' post type
    $args = [
        'post_type' => 'exhibition',
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
    $total_posts = $exhibition_query->found_posts;

    // Pass data to JavaScript
    wp_localize_script('exhibition-page-js', 'exhibition_ajax', [
        'ajaxurl' => admin_url('admin-ajax.php'),
        'posts_per_page' => 6, // Set the posts per page value
        'total_posts' => $total_posts // Pass total number of posts
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
                    <figure class="mx-sp5 sm:mx-0 sm:w-full mb-sp1 overflow-hidden aspect-video">
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
                    <div class="w-fit hover:text-df-red text-xl/xl">
                        <h3 class="font-dfserif line-clamp-2">
                            <a class="" href="<?php the_permalink(); ?>">
                                <?php the_title(); ?>
                            </a>
                        </h3>
                        <p class="font-superclarendon">
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
                    <figure class="mx-sp5 sm:mx-0 sm:w-full mb-sp1 overflow-hidden aspect-video">
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
                    <div class="w-fit hover:text-df-red text-xl/xl">
                        <h3 class="font-dfserif line-clamp-2">
                            <a class="" href="<?php the_permalink(); ?>">
                                <?php the_title(); ?>
                            </a>
                        </h3>
                        <p class="font-superclarendon">
                            <a href="<?php echo esc_url( get_permalink() ); ?>">
                                <?php echo esc_html( get_field('exhibition-start-date') ); ?> — <?php echo esc_html( get_field('exhibition-end-date') ); ?>
                            </a>
                        </p>
                    </div>
                </div>
        <?php endwhile;
    else :
        echo '<p class="font-superclarendon text-large/large mt-sp4">' . pll__('No exhibitions found.', 'tailpress') . '</p>';
    endif;

    wp_die();
}
add_action('wp_ajax_search_exhibitions', 'search_exhibitions');
add_action('wp_ajax_nopriv_search_exhibitions', 'search_exhibitions');




/* -------------------------------------------------------------------------- */
/*                             Polylang functions                             */
/* -------------------------------------------------------------------------- */

// translates info post for header content
function get_translated_info_post() {
    $args = array(
        'post_type' => 'info',
        'posts_per_page' => 1,
        'lang' => pll_current_language()
    );
    $info_posts = get_posts($args);
    return !empty($info_posts) ? $info_posts[0] : null;
}


// Custom function to get the translated post title based on the current language
function pll_get_post_title($id) {
    $translated_id = pll_get_post($id);
    return get_the_title($translated_id);
}


/* Add strings for translation in Polylang */

function my_theme_register_strings() {
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
    pll_register_string('less-events', 'Hide previous events ↑', 'tailpress');

    //visit page
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
    $columns['exhibition_dates'] = __('Exhibition Dates', 'tailpress');
    return $columns;
}
add_filter('manage_exhibition_posts_columns', 'my_exhibition_custom_columns');

// Add custom columns for the 'social' post type
function my_social_custom_columns($columns) {
    $columns['social_date'] = __('Social Date', 'tailpress');
    return $columns;
}
add_filter('manage_social_posts_columns', 'my_social_custom_columns');

// Populate custom columns for the 'exhibition' post type
function my_exhibition_custom_column_content($column, $post_id) {
    if ($column == 'exhibition_dates') {
        // Fetch raw start and end dates
        $start_date = get_field('exhibition-start-date', $post_id);
        $end_date = get_field('exhibition-end-date', $post_id);

        // Check if the dates exist and convert them to sortable format (d-m-Y)
        if ($start_date) {
            $formatted_start_date = DateTime::createFromFormat('d.m.y', $start_date)->format('d-m-Y');
        }

        if ($end_date) {
            $formatted_end_date = DateTime::createFromFormat('d.m.y', $end_date)->format('d-m-Y');
        }

        // Display combined start and end dates or a placeholder
        if ($formatted_start_date && $formatted_end_date) {
            echo $formatted_start_date . ' - ' . $formatted_end_date;
        } elseif ($formatted_start_date) {
            echo $formatted_start_date; // If only start date is present
        } else {
            echo __('No dates available', 'tailpress'); // Added text-domain here
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
    // Enqueue the modified ACF custom JavaScript
    wp_enqueue_script('acf-custom-js', get_template_directory_uri() . '/js/acf-custom.js', array('acf-input'), null, true);
}
add_action('acf/input/admin_enqueue_scripts', 'enqueue_acf_custom_js');

// Clean up any formatting when pasting into the editor
function custom_mce_paste_filter($init) {
    $init['paste_as_text'] = true; // Forces paste to plain text
    return $init;
}
add_filter('tiny_mce_before_init', 'custom_mce_paste_filter');




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
            // Parse the date string into a DateTime object
            $date = DateTime::createFromFormat('d.m.y', $social_date);
            
            if ($date) {
                // Danish month names
                $danish_months = [
                    'januar', 'februar', 'marts', 'april', 'maj', 'juni',
                    'juli', 'august', 'september', 'oktober', 'november', 'december'
                ];

                // English month names
                $english_months = [
                    'January', 'February', 'March', 'April', 'May', 'June',
                    'July', 'August', 'September', 'October', 'November', 'December'
                ];

                // Get month index (1-12)
                $month_index = (int)$date->format('n');

                // Format the date with both Danish and English month names
                $formatted_date = $date->format('d') . ' ' . 
                                  $danish_months[$month_index - 1] . ' ' . 
                                  $english_months[$month_index - 1] . ' ' . 
                                  $date->format('Y');
                
                // Combine the formatted date and time values
                $social_date_search = $formatted_date . ' ' . $social_date_start . ' ' . $social_date_end;
                
                // Update the 'social-date-search' field with the combined value
                update_field('social-date-search', $social_date_search, $post_id);
            }
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
            // Danish month names
            $danish_months = [
                'januar', 'februar', 'marts', 'april', 'maj', 'juni',
                'juli', 'august', 'september', 'oktober', 'november', 'december'
            ];

            // English month names
            $english_months = [
                'January', 'February', 'March', 'April', 'May', 'June',
                'July', 'August', 'September', 'October', 'November', 'December'
            ];

            // Function to format date with both Danish and English month names
            $format_date = function($date_string) use ($danish_months, $english_months) {
                $date = DateTime::createFromFormat('d.m.y', $date_string);
                if ($date) {
                    $month_index = (int)$date->format('n');
                    return $date->format('d') . ' ' . 
                           $danish_months[$month_index - 1] . ' ' . 
                           $english_months[$month_index - 1] . ' ' . 
                           $date->format('Y');
                }
                return $date_string; // Return original if parsing fails
            };

            // Format start and end dates
            $formatted_start_date = $format_date($exhibition_start_date);
            $formatted_end_date = $format_date($exhibition_end_date);
            
            // Combine the formatted dates
            $exhibition_date_search = $formatted_start_date . ' — ' . $formatted_end_date;

            // Update the 'exhibition-date-search' field with the combined value
            update_field('exhibition-date-search', $exhibition_date_search, $post_id);
        }
    }
}





/* -------------------------------------------------------------------------- */
/*                                  Swiper.js                                 */
/* -------------------------------------------------------------------------- */

function enqueue_swiper_assets() {
    // Only load Swiper assets on single posts/pages
    if (is_single() || is_singular('exhibition')) {
        // Swiper CSS
        wp_enqueue_style('swiper-css', get_template_directory_uri() . '/css/swiper-bundle.min.css', array(), null);
        
        // Swiper JS
        wp_enqueue_script('swiper-js', get_template_directory_uri() . '/js/swiper-bundle.min.js', array(), null, true);
    }
}
add_action('wp_enqueue_scripts', 'enqueue_swiper_assets');





/* -------------------------------------------------------------------------- */
/*                           GSAP and ScrollTrigger                           */
/* -------------------------------------------------------------------------- */

function enqueue_gsap_scripts() {
    // Enqueue GSAP core first
    wp_enqueue_script('gsap', get_template_directory_uri() . '/js/gsap.min.js', array(), null, false);
    
    // ScrollTrigger depends on GSAP
    wp_enqueue_script('scrolltrigger', get_template_directory_uri() . '/js/ScrollTrigger.min.js', array('gsap'), null, false);
    
    // Custom script depends on both
    wp_enqueue_script('custom-gsap', get_template_directory_uri() . '/js/custom-gsap.js', array('gsap', 'scrolltrigger'), null, true);
}
add_action('wp_enqueue_scripts', 'enqueue_gsap_scripts');




/* -------------------------------------------------------------------------- */
/*                             Newsletter function                            */
/* -------------------------------------------------------------------------- */

function enqueue_newsletter_script() {
    $newsletter_page_id = pll_get_post(4);
    if (is_page($newsletter_page_id) ) {
        wp_enqueue_script('newsletter-js', get_template_directory_uri() . '/js/newsletter.js', array(), null, true);
        wp_localize_script('newsletter-js', 'ajax_object', array(
            'ajax_url' => admin_url('admin-ajax.php')
        ));
    }
}
add_action('wp_enqueue_scripts', 'enqueue_newsletter_script');


add_action('wp_ajax_mailchimp_subscribe', 'mailchimp_subscribe');
add_action('wp_ajax_nopriv_mailchimp_subscribe', 'mailchimp_subscribe');

function mailchimp_subscribe() {
    // Check if email is set and not empty
    if ( !isset($_POST['email']) || empty($_POST['email']) ) {
        wp_send_json_error( array( 'message' => 'Email is required.' ) );
        wp_die();
    }

    // Sanitize input data
    $email   = sanitize_email( $_POST['email'] );
    $name    = sanitize_text_field( $_POST['name'] );
    $surname = sanitize_text_field( $_POST['surname'] );

    // Check if email is valid
    if ( !is_email( $email ) ) {
        wp_send_json_error( array( 'message' => 'Invalid email address.' ) );
        wp_die();
    }

    // Mailchimp API details
    $api_key = MAILCHIMP_API_KEY; // Replace with your API Key constant
    $list_id = '30cac02d72';      // Replace with actual Mailchimp List ID

    // Prepare the Mailchimp API endpoint and request data
    $url  = 'https://us5.api.mailchimp.com/3.0/lists/' . $list_id . '/members/';
    $body = json_encode( array(
        'email_address' => $email,
        'status'        => 'subscribed',
        'merge_fields'  => array(
            'FNAME' => $name,
            'LNAME' => $surname,
        ),
    ) );

    // Setup request headers using Bearer token (Mailchimp API Key)
    $headers = array(
        'Authorization' => 'Bearer ' . $api_key, // Use Bearer token instead of base64 encoded Basic Auth
        'Content-Type'  => 'application/json',
    );

    // Make the POST request using wp_safe_remote_post()
    $response = wp_safe_remote_post( $url, array(
        'body'    => $body,
        'headers' => $headers,
        'timeout' => 15, // optional: set a timeout limit
    ) );

    // Check for errors in the response
    if ( is_wp_error( $response ) ) {
        wp_send_json_error( array( 'message' => 'An error occurred: ' . $response->get_error_message() ) );
        wp_die();
    }

    $http_code      = wp_remote_retrieve_response_code( $response );
    $response_body  = wp_remote_retrieve_body( $response );
    $response_data  = json_decode( $response_body, true );

    if ( $http_code === 200 ) {
        wp_send_json_success( array( 'message' => pll__( 'Successfully subscribed!', 'tailpress' ) ) );
    } else {
        $error_message = isset( $response_data['detail'] ) ? $response_data['detail'] : pll__( 'An unknown error occurred.', 'tailpress' );
        wp_send_json_error( array( 'message' => $error_message ) );
    }

    wp_die();
}




/* -------------------------------------------------------------------------- */
/*                        removes block-editor function                       */
/* -------------------------------------------------------------------------- */

function remove_wp_block_library_css() {
    if ( ! is_admin() ) { // Ensures it's not removed from the backend
        wp_dequeue_style( 'wp-block-library' );  // Front-end styles for blocks
        wp_dequeue_style( 'wp-block-library-theme' ); // Front-end styles for block themes
        wp_dequeue_style( 'wc-block-style' ); // WooCommerce block styles (if WooCommerce is active)
    }
}
add_action( 'wp_enqueue_scripts', 'remove_wp_block_library_css' );


/**
 * Enable revisions for custom post types.
 */
function enable_revisions_for_cpt( $args, $post_type ) {
    // Specify the custom post types where you want to enable revisions.
    $supported_post_types = array( 'social', 'exhibition', 'team-member' );

    // Check if the post type is in the list of supported post types.
    if ( in_array( $post_type, $supported_post_types ) ) {
        // Add 'revisions' support if it's not already enabled.
        if ( ! in_array( 'revisions', $args['supports'] ) ) {
            $args['supports'][] = 'revisions';
        }
    }

    return $args;
}
add_filter( 'register_post_type_args', 'enable_revisions_for_cpt', 10, 2 );




/* -------------------------------------------------------------------------- */
/*                         WORDPRESS ADMIN ADJUSTMENTS                        */
/* -------------------------------------------------------------------------- */


function my_custom_tinymce_config($init) {
    if (!isset($init['extended_valid_elements'])) {
        $init['extended_valid_elements'] = '';
    }
    
    // Add p[class] and h4 to extended_valid_elements
    if (strlen($init['extended_valid_elements']) > 0) {
        $init['extended_valid_elements'] .= ',p[class],h4';
    } else {
        $init['extended_valid_elements'] = 'p[class],h4';
    }

    // Prevent TinyMCE from removing empty tags
    $init['verify_html'] = false;
    
    // Prevent automatic tag conversion
    $init['forced_root_block'] = false;
    
    // Keep HTML formatting when switching between visual/text editors
    $init['preserve_format'] = true;

    return $init;
}
add_filter('tiny_mce_before_init', 'my_custom_tinymce_config');

// Modify allowed HTML tags for wp_kses_post
function my_custom_kses_allowed_html($tags) {
    $tags['h4'] = array();
    return $tags;
}
add_filter('wp_kses_allowed_html', 'my_custom_kses_allowed_html', 10, 2);


// Modified function to preserve intentional empty paragraphs
function preserve_empty_p_tags($content) {
    // Only remove paragraphs that are truly empty (no spaces or &nbsp;)
    return preg_replace('/<p><\/p>/', '', $content);
}
add_filter('the_content', 'preserve_empty_p_tags');
add_filter('acf_the_content', 'preserve_empty_p_tags');



