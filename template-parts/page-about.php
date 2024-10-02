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
<main data-barba="container" data-barba-namespace="about" class="mx-sp3 my-sp5" id="main-content">
    <article class="columns-1 sm:columns-2 gap-sp1 pr-sp2">
            <section class="w-full pb-sp8">
                <h2 class="font-dfserif text-large/large sm:text-xl/xl pb-sp1">
                    <?php echo pll__('Contact', 'tailpress'); ?>
                </h2>
                <div class="columns-2 font-superclarendon text-regular/regular">
                    <?php get_template_part( 'template-parts/section-contact' ); ?>
                </div>
            </section>
            <section class="w-full sm:w-[calc(90%+1vw)] pb-sp8">
                <h2 class="font-dfserif text-large/large sm:text-xl/xl pb-sp1">
                    <?php echo esc_html( get_field('about-title-about') ); ?>
                </h2>
                <div class="wysiwyg-content font-superclarendon text-regular/regular text-pretty">
                    <?php the_field('about-text-about'); ?>
                </div>
            </section>
            <section class="w-full sm:w-[calc(90%+1vw)] pb-sp8">
                <h2 class="font-dfserif text-large/large sm:text-xl/xl pb-sp1">
                    <?php echo esc_html( get_field('about-title-oslo') ); ?>
                </h2>
                <div class="wysiwyg-content font-superclarendon text-regular/regular text-pretty">
                    <?php the_field('about-text-oslo'); ?>
                </div>
            </section>
            <figure class="w-full px-sp5 sm:px-sp8 sm:w-[calc(90%+1vw)] hidden sm:block break-after-avoid sm:break-after-column pb-sp8">
                <?php 
                $about_image_1_id = get_field('about-image-1'); 
                if( $about_image_1_id ) : ?>
                    <?php echo wp_get_attachment_image( $about_image_1_id, 'full', false, array(
                        'class' => 'w-full h-auto',
                    )); ?>
                <?php endif; ?>
            </figure>
            <figure class="w-full px-sp5 sm:px-sp8 sm:w-[calc(90%+1vw)] hidden sm:block pb-sp8">
                <?php 
                    $about_image_2_id = get_field('about-image-2'); 
                    if( $about_image_2_id ) : ?>
                        <?php echo wp_get_attachment_image( $about_image_2_id, 'full', false, array(
                        'class' => 'w-full h-auto',
                    )); ?>
                <?php endif; ?>
            </figure>
            <section class="w-full sm:w-[calc(90%+1vw)] pb-sp8">
                <h2 class="font-dfserif text-large/large sm:text-xl/xl pb-sp1">
                    <?php echo esc_html( get_field('about-title-history') ); ?>
                </h2>
                <div class="wysiwyg-content font-superclarendon text-regular/regular text-pretty">
                    <?php the_field('about-text-history'); ?>
                </div>
            </section>
            <section class="w-full sm:w-[calc(90%+1vw)] pb-sp8">
                <h2 class="font-dfserif text-large/large sm:text-xl/xl pb-sp1">
                    <?php echo esc_html( get_field('about-title-toaster') ); ?>
                </h2>
                <div class="wysiwyg-content font-superclarendon text-regular/regular text-pretty">
                    <?php the_field('about-text-toaster'); ?>
                </div>
            </section>
            <figure class="w-full px-sp5 sm:px-sp8 sm:hidden pb-sp8">
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