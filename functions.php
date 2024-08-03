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


// Allow SVG
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


  // Back to top function
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


// Enqueue necessary scripts
function enqueue_custom_scripts() {
    wp_enqueue_script('jquery');
    wp_enqueue_script('custom-social-loop', get_template_directory_uri() . '/js/custom-social-loop.js', array('jquery'), '1.0', true);
    wp_localize_script('custom-social-loop', 'ajax_object', array('ajax_url' => admin_url('admin-ajax.php')));
}
add_action('wp_enqueue_scripts', 'enqueue_custom_scripts');

// AJAX handler for fetching posts
function fetch_social_posts() {
    $paged = $_POST['page'] ? intval($_POST['page']) : 1;
    $search = sanitize_text_field($_POST['search']);

    $args = array(
        'post_type' => 'social',
        'posts_per_page' => 10,
        'paged' => $paged,
        'orderby' => 'date',
        'order' => 'DESC'
    );

    if (!empty($search)) {
        $args['meta_query'] = array(
            'relation' => 'OR',
            array(
                'key' => 'social-description',
                'value' => $search,
                'compare' => 'LIKE'
            )
        );
        $args['s'] = $search; // This will search in post title and content
    }

    $query = new WP_Query($args);
    $response = array();

    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            $response[] = array(
                'title' => get_the_title(),
                'date' => get_field('social-date'),
                'date_start' => get_field('social-date-start'),
                'date_end' => get_field('social-date-end'),
                'description' => get_field('social-description'),
                'image' => get_field('social-image')
            );
        }
    }

    wp_reset_postdata();

    $response['max_pages'] = $query->max_num_pages;
    wp_send_json($response);
}
add_action('wp_ajax_fetch_social_posts', 'fetch_social_posts');
add_action('wp_ajax_nopriv_fetch_social_posts', 'fetch_social_posts');

// Function to output the social calendar loop
function social_calendar_loop() {
    ?>
    <main id="primary" class="mx-[calc(0.25rem+2vw)] my-[calc(0.5rem+1vw)]">
        <section class="flex justify-between items-center pb-[calc(1rem+0.5vw)]">
            <h2 class="font-dfserif text-xl/xl">Social calendar</h2>
            <form id="search-form">
                <input type="text" id="search-input" placeholder="Search in calendar…" class="font-dfserif text-xl/xl text-df-grey bg-df-light-grey text-right">
            </form>
        </section>
        <div id="social-posts-container"></div>
        <div id="load-more-container">
            <button class="font-dfserif text-xl/xl py-[calc(1rem+0.5vw)]" id="load-more" data-page="1" data-max="" data-query="">Show previous events ↓</button>
        </div>
    </main>
    <?php
}






