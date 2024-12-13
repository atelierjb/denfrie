<?php
/*
Template Name: Exhibitions
*/
get_header();
?>

<main class="mx-sp3 my-sp5" id="main-content">
    <article>
        <section class="w-full">
            <h2 class="font-dfserif text-large/large sm:text-xl/xl pb-sp5 sm:pb-sp7 animateOnView">
                <?php echo pll__('Current Exhibitions', 'tailpress'); ?>
            </h2>
            <?php get_template_part( 'template-parts/section-current-exhibitions' ); ?>
        </section>
        <section class="w-full pb-sp7 sm:pb-sp9">
            <h2 class="font-dfserif text-large/large sm:text-xl/xl pb-sp5 sm:pb-sp7 animateOnView">
                <?php echo pll__('Upcoming Exhibitions', 'tailpress'); ?>
            </h2>
            <?php get_template_part( 'template-parts/section-upcoming-exhibitions' ); ?>
        </section>
        <section class="w-full">
            <div class="flex justify-between">
                <h2 class="font-dfserif text-large/large sm:text-xl/xl pb-sp5 sm:pb-sp7 animateOnView">
                    <?php echo pll__('Latest Exhibitions', 'tailpress'); ?>
                </h2>
                <h2 class="font-dfserif text-large/large sm:text-xl/xl pb-sp7 text-df-grey animateOnView">
                    <a href="<?php echo get_permalink(pll_get_post(159)); ?>" class="hover:text-df-red">
                        <?php echo pll__('Go to archive', 'tailpress'); ?> →
                    </a>
                </h2>
            </div>
            <hr class="border-df-black animateOnView">
            <?php get_template_part( 'template-parts/section-latest-exhibitions' ); ?>
            <p class="font-dfserif text-large/large sm:text-xl/xl py-sp7 animateOnView">
                <a href="<?php echo get_permalink(pll_get_post(159)); ?>" class="hover:text-df-red">
                    <?php echo pll__('Show more archive', 'tailpress'); ?> →
                </a>
            </p>
        </section>
    </article>
</main>    



<?php
// Include the footer
get_footer();
?>