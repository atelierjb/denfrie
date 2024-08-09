<?php
/*
Template Name: Archive
*/
?>

<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package denfrie
 */

get_header();
?>
<main class="mx-sp3 my-sp5">
    <?php
    // Get the current date
    $current_date = date('Ymd'); // Format: YYYYMMDD

    // Pagination setup
    $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

    // Query arguments
    $args = array(
        'post_type' => 'exhibition',
        'posts_per_page' => 6,
        'paged' => $paged,
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
    ?>
        
    <section class="flex justify-between items-center pb-sp7">
        <h2 class="font-dfserif text-xl/xl">
            Archive
        </h2>
        <form id="search-form">
            <input type="text" id="search-input" placeholder="Search in archive..." class="font-dfserif text-xl/xl text-df-grey bg-df-light-grey text-right">
        </form>
    </section>

    <section id="exhibitions-list" class="grid grid-cols-1 sm:grid-cols-2 gap-sp1 pb-sp8">
        <?php if ($query->have_posts()) : ?>
            <?php while ($query->have_posts()) : $query->the_post(); ?>
                <?php
                $exhibition_image = get_field('exhibition-image');
                $exhibition_artists = get_field('exhibition-artists');
                $exhibition_start_date = get_field('exhibition-start-date');
                $exhibition_end_date = get_field('exhibition-end-date');
                $post_url = get_permalink();
                ?>
                <div class="mb-sp1">
                    <figure class="mb-sp1 overflow-hidden aspect-video">
                        <a href="<?php echo esc_url($post_url); ?>">
                            <img src="<?php echo esc_url($exhibition_image); ?>" alt="<?php the_title(); ?>" class="w-full h-full transform transition-transform duration-500 hover:scale-105 object-cover">
                        </a>
                    </figure>
                    <h3 class="font-dfserif text-xl/xl">
                        <a class="hover:text-df-grey" href="<?php echo esc_url($post_url); ?>">
                            <?php the_title(); ?>
                        </a>
                    </h3>
                    <p class="font-superclarendon text-large/large line-clamp-1">
                    <a href="<?php echo esc_url($post_url); ?>">
                        <?php echo esc_html($exhibition_artists); ?>
                    </a>
                    </p>
                    <p class="font-superclarendon text-large/large">
                    <a href="<?php echo esc_url($post_url); ?>">
                        <?php echo esc_html($exhibition_start_date); ?> — <?php echo esc_html($exhibition_end_date); ?>
                    </a>
                    </p>
                </div>
            <?php endwhile; ?>
            <?php wp_reset_postdata(); ?>
        <?php else : ?>
            <p class="font-superclarendon text-large/large">No past exhibitions found.</p>
        <?php endif; ?>
    </section>

    <?php if ($query->max_num_pages > 1) : ?>
        <div id="load-more-container">
            <button class="font-dfserif text-xl/xl py-sp7" id="load-more" data-page="1" data-max="<?php echo $query->max_num_pages; ?>" data-query="">Show more archive ↓</button>
        </div>
    <?php endif; ?>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script type="text/javascript">
jQuery(document).ready(function($){
    $(document).on('click', '#load-more', function(){
        var button = $(this),
            page = button.data('page') + 1,
            max = button.data('max'),
            searchQuery = button.data('query') || '';

        console.log('Load More Clicked - Page:', page, 'Query:', searchQuery);

        $.ajax({
            url : '<?php echo site_url() ?>/wp-admin/admin-ajax.php',
            type : 'post',
            data : {
                action : 'load_more_exhibitions',
                page : page,
                current_date : '<?php echo date("Ymd"); ?>',
                query : searchQuery // Pass search query if exists
            },
            success : function(response){
                console.log('Load More Success:', response);
                $('#load-more-container').remove();
                $('#exhibitions-list').append(response);
                button.data('page', page);
                if(page >= max) button.hide();
            },
            error: function(xhr, status, error) {
                console.log('Load More Error:', xhr.responseText, status, error);
            }
        });
    });

    $('#search-input').on('keyup', function(){
        var searchQuery = $(this).val();

        console.log('Search Input - Query:', searchQuery);

        $.ajax({
            url : '<?php echo site_url() ?>/wp-admin/admin-ajax.php',
            type : 'post',
            data : {
                action : 'search_exhibitions',
                query : searchQuery,
                page : 1 // Ensure the page resets to 1
            },
            success : function(response){
                console.log('Search Success:', response);
                $('#exhibitions-list').html(response); // Replace content in #exhibitions-list

                // Show or hide the "Load More" button
                if ($('#load-more-container').length) {
                    $('#load-more-container').remove();
                }
                if (response.includes('id="load-more-container"')) {
                    $('#exhibitions-list').after(response);
                }
            },
            error: function(xhr, status, error) {
                console.log('Search Error:', xhr.responseText, status, error);
            }
        });
    });
});
</script>



</main>

<?php
// Include the footer
get_footer();
?>


