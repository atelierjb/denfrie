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


function enqueue_custom_scripts() {
    wp_enqueue_script('social-page-js', get_template_directory_uri() . '/js/social-page.js', ['jquery'], null, true);
    wp_localize_script('social-page-js', 'ajaxurl', admin_url('admin-ajax.php'));
}
add_action('wp_enqueue_scripts', 'enqueue_custom_scripts');


// Load more posts via AJAX
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
                <div class="collapse-title p-0 min-h-0 grid grid-cols-4 gap-sp9 text-medium/medium">
                    <p class="font-superclarendon col-span-1 whitespace-nowrap hover:text-df-grey"> 
                        <?php the_field('social-date'); ?> <?php the_field('social-date-start'); ?> <?php the_field('social-date-end'); ?>
                    </p>
                    <p class="font-dfserif leading-[calc(110%+0.2vw)] col-span-3 line-clamp-1 hover:text-df-grey">
                        <?php the_title(); ?>
                    </p>
                </div>
                <div class="collapse-content px-0 grid grid-cols-4 gap-sp9">
                    <figure class="w-full overflow-hidden aspect-video col-span-1 mt-sp4">
                        <img src="<?php the_field('social-image'); ?>" alt="<?php the_title(); ?>" class="w-full h-full transform transition-transform duration-500 hover:scale-105 object-cover">
                    </figure>
                    <div class="font-superclarendon mt-sp4 text-regular/regular col-span-3 indent-sp8">
                        <?php the_field('social-description'); ?>
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

// AJAX search function
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
                <div class="collapse-title p-0 min-h-0 grid grid-cols-4 gap-sp9 text-medium/medium">
                    <p class="font-superclarendon col-span-1 whitespace-nowrap hover:text-df-grey"> 
                        <?php the_field('social-date'); ?> <?php the_field('social-date-start'); ?> <?php the_field('social-date-end'); ?>
                    </p>
                    <p class="font-dfserif leading-[calc(110%+0.2vw)] col-span-3 line-clamp-1 hover:text-df-grey">
                        <?php the_title(); ?>
                    </p>
                </div>
                <div class="collapse-content px-0 grid grid-cols-4 gap-sp9">
                    <figure class="w-full overflow-hidden aspect-video col-span-1 mt-sp4">
                        <img src="<?php the_field('social-image'); ?>" alt="<?php the_title(); ?>" class="w-full h-full transform transition-transform duration-500 hover:scale-105 object-cover">
                    </figure>
                    <div class="font-superclarendon mt-sp4 text-regular/regular col-span-3 indent-sp8">
                        <?php the_field('social-description'); ?>
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


// Archive functions

function enqueue_custom_exhibition_scripts() {
    wp_enqueue_script('exhibition-page-js', get_template_directory_uri() . '/js/exhibition-page.js', ['jquery'], null, true);

    // Pass PHP data to the JavaScript file
    wp_localize_script('exhibition-page-js', 'exhibition_ajax', [
        'ajaxurl' => admin_url('admin-ajax.php'),
        'posts_per_page' => 6, // Set the posts per page value here
    ]);
}
add_action('wp_enqueue_scripts', 'enqueue_custom_exhibition_scripts');

// Load more exhibitions via AJAX
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
            <div class="mb-sp1">
                <figure class="mb-sp1 overflow-hidden aspect-video">
                    <a href="<?php the_permalink(); ?>">
                        <img src="<?php the_field('exhibition-image'); ?>" alt="<?php the_title(); ?>" class="w-full h-full transform transition-transform duration-500 hover:scale-105 object-cover">
                    </a>
                </figure>
                <h3 class="font-dfserif text-xl/xl">
                    <a class="hover:text-df-grey" href="<?php the_permalink(); ?>">
                        <?php the_title(); ?>
                    </a>
                </h3>
                <p class="font-superclarendon text-large/large line-clamp-1">
                    <a href="<?php the_permalink(); ?>">
                        <?php the_field('exhibition-artists'); ?>
                    </a>
                </p>
                <p class="font-superclarendon text-large/large">
                    <a href="<?php the_permalink(); ?>">
                        <?php the_field('exhibition-start-date'); ?> — <?php the_field('exhibition-end-date'); ?>
                    </a>
                </p>
            </div>
        <?php endwhile;
    endif;

    wp_die();
}
add_action('wp_ajax_load_more_exhibitions', 'load_more_exhibitions');
add_action('wp_ajax_nopriv_load_more_exhibitions', 'load_more_exhibitions');

// Search exhibitions via AJAX
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
            <div class="mb-sp1">
                <figure class="mb-sp1 overflow-hidden aspect-video">
                    <a href="<?php the_permalink(); ?>">
                        <img src="<?php the_field('exhibition-image'); ?>" alt="<?php the_title(); ?>" class="w-full h-full transform transition-transform duration-500 hover:scale-105 object-cover">
                    </a>
                </figure>
                <h3 class="font-dfserif text-xl/xl">
                    <a class="hover:text-df-grey" href="<?php the_permalink(); ?>">
                        <?php the_title(); ?>
                    </a>
                </h3>
                <p class="font-superclarendon text-large/large line-clamp-1">
                    <a href="<?php the_permalink(); ?>">
                        <?php the_field('exhibition-artists'); ?>
                    </a>
                </p>
                <p class="font-superclarendon text-large/large">
                    <a href="<?php the_permalink(); ?>">
                        <?php the_field('exhibition-start-date'); ?> — <?php the_field('exhibition-end-date'); ?>
                    </a>
                </p>
            </div>
        <?php endwhile;
    else :
        echo '<p class="font-superclarendon text-large/large mt-sp4">No results found.</p>';
    endif;

    wp_die();
}
add_action('wp_ajax_search_exhibitions', 'search_exhibitions');
add_action('wp_ajax_nopriv_search_exhibitions', 'search_exhibitions');


