<?php
/*
Template Name: About
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
<main data-barba="wrapper" class="mx-sp3 my-sp5" id="main-content">
    <article data-barba="container" class="columns-1 sm:columns-2 gap-sp1 pr-sp2">
            <section class="w-full pb-sp8">
                <h2 class="font-dfserif text-xl/xl pb-sp1 animateOnView">
                    <?php echo esc_html( get_field('about-title-contact') ); ?>
                </h2>
                <div class="columns-2 font-superclarendon text-base/regular sm:text-regular/regular w-full sm:w-[calc(90%+1vw)]">
                    <?php get_template_part( 'template-parts/section-contact' ); ?>
                </div>
            </section>

            <?php if( have_rows('about-left') ): ?>
                <?php while( have_rows('about-left') ): the_row(); ?>
                    <?php if( get_row_layout() == 'textsection' ): ?>
                        <section class="w-full sm:w-[calc(90%+1vw)] pb-sp8">
                            <h2 class="font-dfserif text-xl/xl pb-sp1 animateOnView">
                                <?php echo esc_html( get_sub_field('title') ); ?>
                            </h2>
                            <div class="wysiwyg-content font-superclarendon text-base/regular sm:text-regular/regular text-pretty animateOnView">
                                <?php echo wp_kses_post( get_sub_field('text') ); ?>
                            </div>
                        </section>
                    <?php endif; ?>
                <?php endwhile; ?>
            <?php endif; ?>

            <figure class="w-full px-sp5 sm:px-sp8 sm:w-[calc(90%+1vw)] hidden sm:block break-after-avoid sm:break-after-column pb-sp8 animateOnView">
                <?php 
                $about_image_1_id = get_field('about-image-1'); 
                if( $about_image_1_id ) : ?>
                    <?php echo wp_get_attachment_image( $about_image_1_id, 'full', false, array(
                        'class' => 'w-full h-auto',
                    )); ?>
                <?php endif; ?>
            </figure>
            <figure class="w-full px-sp5 sm:px-sp8 sm:w-[calc(90%+1vw)] hidden sm:block pb-sp8 animateOnView">
                <?php 
                    $about_image_2_id = get_field('about-image-2'); 
                    if( $about_image_2_id ) : ?>
                        <?php echo wp_get_attachment_image( $about_image_2_id, 'full', false, array(
                        'class' => 'w-full h-auto',
                    )); ?>
                <?php endif; ?>
            </figure>
            <?php if( have_rows('about-right') ): ?>
                <?php while( have_rows('about-right') ): the_row(); ?>
                    <?php if( get_row_layout() == 'textsection' ): ?>
                        <section class="w-full sm:w-[calc(90%+1vw)] pb-sp8">
                            <h2 class="font-dfserif text-xl/xl pb-sp1 animateOnView">
                                <?php echo esc_html( get_sub_field('title') ); ?>
                            </h2>
                            <div class="wysiwyg-content font-superclarendon text-base/regular sm:text-regular/regular text-pretty animateOnView">
                                <?php echo wp_kses_post( get_sub_field('text') ); ?>
                            </div>
                        </section>
                    <?php endif; ?>
                <?php endwhile; ?>
            <?php endif; ?>
            <figure class="w-full px-sp5 sm:hidden pb-sp8 animateOnView">
                <?php 
                    $about_image_1_id = get_field('about-image-1'); 
                    if( $about_image_1_id ) : ?>
                        <?php echo wp_get_attachment_image( $about_image_1_id, 'full', false, array(
                        'class' => 'w-full h-auto',
                    )); ?>
                <?php endif; ?>
            </figure>
    </article>
</main>



<?php
// Include the footer
get_footer();
?>