<section class="w-full sm:w-[calc(90%+1vw)] pb-sp8">
    <div class="font-superclarendon text-regular/regular break-inside-avoid text-pretty">
        <?php 
        $short_text = get_field('exhibition-description-short');
        $long_text = get_field('exhibition-description-long');
        $exhibition_folder = get_field('exhibition-folder');  // Assuming these are the fields for the download links
        $exhibition_presskit = get_field('exhibition-presskit');
        ?>

        <div id="exhibition-text" class="wysiwyg-exhibition overflow-hidden transition-all duration-500 ease-in-out">
            <?php echo wp_kses_post($short_text); ?>
        </div>

        <p id="toggle-button" class="font-dfserif text-[calc(0.75rem+0.6vw)]/regular cursor-pointer ml-sp5 sm:ml-sp9 hover:text-df-red mt-4">
            <?php echo pll__('More', 'tailpress'); ?> ↓
        </p>
    </div>      
</section>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const toggleButton = document.getElementById('toggle-button');
    const exhibitionText = document.getElementById('exhibition-text');

    const shortText = `<?php echo wp_kses_post($short_text); ?>`;
    const longText = `<?php echo wp_kses_post($long_text); ?>` + `
        <div class="sm:hidden mt-4 text-medium/medium">
            <?php if (!empty($exhibition_folder)): ?>
                <a href="<?php echo esc_url($exhibition_folder); ?>" target="_blank" rel="noopener noreferrer" class="hover:text-df-red underline underline-offset-2">
                    <?php echo pll__('Exhibition folder', 'tailpress'); ?>
                </a>
            <?php endif; ?>
                <br>
            <?php if (!empty($exhibition_presskit)): ?>
                <a href="<?php echo esc_url($exhibition_presskit); ?>" target="_blank" rel="noopener noreferrer" class="hover:text-df-red underline underline-offset-2">
                    <?php echo pll__('Presskit', 'tailpress'); ?>
                </a>
            <?php endif; ?>
        </div>`;

    let isExpanded = false;

    toggleButton.addEventListener('click', function () {
        if (isExpanded) {
            // Start collapsing: measure the height of the current (long) content
            const expandedHeight = exhibitionText.scrollHeight;

            // Temporarily switch to short content to measure its height
            exhibitionText.innerHTML = shortText;
            const collapsedHeight = exhibitionText.scrollHeight;

            // Revert back to long content before starting the transition
            exhibitionText.innerHTML = longText;
            exhibitionText.style.height = `${expandedHeight}px`; // Set to the expanded height

            // Allow the browser to render the new height before transitioning
            setTimeout(() => {
                exhibitionText.style.transition = 'height 0.5s ease-in-out';
                exhibitionText.style.height = `${collapsedHeight}px`; // Transition to the collapsed height

                // After transition ends, switch to the short text and reset height
                setTimeout(() => {
                    exhibitionText.style.transition = 'none';
                    exhibitionText.innerHTML = shortText;
                    exhibitionText.style.height = 'auto'; // Reset to auto to avoid issues with dynamic content
                }, 500); // Match the duration of the transition
            }, 10);

            toggleButton.textContent = '<?php echo pll__('More', 'tailpress'); ?> ↓';
        } else {
            // Expand: transition to the long text height
            const collapsedHeight = exhibitionText.scrollHeight;

            exhibitionText.innerHTML = longText;
            const expandedHeight = exhibitionText.scrollHeight;

            exhibitionText.style.height = `${collapsedHeight}px`; // Set to the collapsed height first

            // Allow the browser to render the height before transitioning
            setTimeout(() => {
                exhibitionText.style.transition = 'height 0.5s ease-in-out';
                exhibitionText.style.height = `${expandedHeight}px`; // Transition to the expanded height

                setTimeout(() => {
                    exhibitionText.style.transition = 'none';
                    exhibitionText.style.height = 'auto'; // Reset to auto after expanding
                }, 500); // Match the duration of the transition
            }, 10);

            toggleButton.textContent = '<?php echo pll__('Less', 'tailpress'); ?> ↑';
        }

        isExpanded = !isExpanded;
    });
});
</script>
