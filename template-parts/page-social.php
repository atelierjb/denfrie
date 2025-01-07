<?php
/*
Template Name: Social
*/
get_header();
?>

<main class="mx-sp3 my-sp5" id="main-content">
    <article>
        <section class="flex justify-between items-center pb-sp5 sm:pb-sp7">
            <h1 class="font-dfserif text-xl/xl animateOnView">
                <?php echo pll__('Social calendar', 'tailpress'); ?>
            </h1>
            <form id="search-form" class="animateOnView">
                <input type="text" id="social-search-input" placeholder="<?php echo pll__('Search in calendar...', 'tailpress'); ?>" class="font-dfserif text-xl/xl text-df-grey bg-df-light-grey text-right focus:outline-none" autocomplete="off">
            </form>
        </section>
        <hr class="border-df-black animateOnView">
        <div id="social-container">
            
        </div>
        <div id="social-toggle-container" class="mt-sp5">
            <button id="toggle-past-events" class="font-dfserif text-xl/xl py-sp7 hover:text-df-red animateOnView">
                <?php echo pll__('Show previous events ↓', 'tailpress'); ?>
            </button>
        </div>
    </article>
</main>

<?php get_footer(); ?>
