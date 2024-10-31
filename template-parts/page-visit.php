<?php
/*
Template Name: Visit
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
        <!-- /* -------------------------------- left side ------------------------------- */ -->
            <?php if( have_rows('visit-left') ): ?>
                <?php while( have_rows('visit-left') ): the_row(); ?>
                
                    <?php if( get_row_layout() == 'textsection' ): ?>
                        <section class="w-full sm:w-[calc(90%+1vw)] pb-sp8">
                            <h2 class="font-dfserif text-xl/xl pb-sp1">
                                <?php echo esc_html( get_sub_field('title') ); ?>
                            </h2>
                            <div class="wysiwyg-content">
                                <?php echo wp_kses_post( get_sub_field('text') ); ?>
                            </div>
                        </section>
                    
                    <?php elseif( get_row_layout() == 'pricelist' ): ?>
                        <section class="w-full sm:w-[calc(90%+1vw)] pb-sp8">
                            <h2 class="font-dfserif text-xl/xl pb-sp1">
                                <?php echo esc_html( get_sub_field('title') ); ?>
                            </h2>
                            
                            <?php if( have_rows('pricing') ): ?>
                                <div class="font-superclarendon text-base/regular sm:text-regular/regular">
                                    <?php while( have_rows('pricing') ): the_row(); ?>
                                        <div class="columns-2 pb-sp1">
                                            <p><?php echo pll__( get_sub_field('category'), 'tailpress' ); ?></p>
                                            <p><?php echo esc_html( get_sub_field('price') ); ?></p>
                                        </div>
                                    <?php endwhile; ?>
                                </div>
                            <?php endif; ?>
                        </section>
                    
                    <?php endif; ?>

                <?php endwhile; ?>
            <?php endif; ?>


            <!-- /* -------------------------------- right side ------------------------------- */ -->
            <section class="w-full sm:w-[calc(90%+1vw)] pb-sp8 sm:break-before-column" id="newsletter">
                <h2 class="font-dfserif text-xl/xl pb-sp1">
                    <?php echo esc_html( get_field('visit-title-newsletter') ); ?>
                </h2>
                <div class="wysiwyg-content pb-sp2">
                    <?php the_field('visit-text-newsletter'); ?>
                </div>
                <form id="mailchimp-signup-form" method="post" class="flex flex-col gap-sp1">
                    <input type="email" name="email" id="email" placeholder="Email" class="input input-bordered rounded-none w-full h-auto p-sp2 border-df-grey" required />
                    <input type="text" name="name" id="name" placeholder="<?php echo pll__('Name', 'tailpress'); ?>" class="input input-bordered rounded-none w-full h-auto p-sp2 border-df-grey" required />
                    <input type="text" name="surname" id="surname" placeholder="<?php echo pll__('Surname', 'tailpress'); ?>" class="input input-bordered rounded-none w-full h-auto p-sp2 border-df-grey" />
                    <button type="submit" class="font-dfserif text-large/large w-fit mt-sp1 hover:text-df-red"><?php echo pll__('Sign up', 'tailpress'); ?> →</button>
                    <p id="response-message" class="font-superclarendon text-regular/regular mt-sp1"></p>
                </form>
            </section>
            <?php if( have_rows('visit-right') ): ?>
                <?php while( have_rows('visit-right') ): the_row(); ?>
                    <?php if( get_row_layout() == 'textsection' ): ?>
                        <section class="w-full sm:w-[calc(90%+1vw)] pb-sp8">
                            <h2 class="font-dfserif text-xl/xl pb-sp1">
                                <?php echo esc_html( get_sub_field('title') ); ?>
                            </h2>
                            <div class="wysiwyg-content font-superclarendon text-base/regular sm:text-regular/regular">
                                <?php echo wp_kses_post( get_sub_field('text') ); ?>
                            </div>
                        </section>
                    <?php endif; ?>
                <?php endwhile; ?>
            <?php endif; ?>
    </article>
</main>
<!-- <script>
    document.addEventListener("DOMContentLoaded", function() {
    // Select all WYSIWYG content sections
    const contentSections = document.querySelectorAll('.wysiwyg-content');

    contentSections.forEach(section => {
        // Find and remove empty <p> tags
        section.querySelectorAll("p").forEach(p => {
            if (p.innerHTML.trim() === "" || p.innerHTML === "&nbsp;") {
                p.remove(); // Remove the empty <p> tags from the DOM
            }
        });
        
        // Then apply the no-indent class only to the first valid paragraph
        let paragraphs = section.querySelectorAll("p:not(:empty)");

        if (paragraphs.length) {
            paragraphs[0].classList.add("no-indent");
        }
    });
});
</script> -->

<?php
// Include the footer
get_footer();
?>