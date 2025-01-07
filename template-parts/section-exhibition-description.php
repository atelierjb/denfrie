<section class="w-full sm:w-[calc(90%+1vw)] mb-sp8">
    <div class="font-superclarendon break-inside-avoid">
        <?php 
        $short_text = get_field('exhibition-description-short');
        $long_text = get_field('exhibition-description-long');
        $exhibition_folder = get_field('exhibition-folder');  // Assuming these are the fields for the download links
        $exhibition_presskit = get_field('exhibition-presskit');
        ?>

        <div id="exhibition-text" class="wysiwyg-content overflow-hidden animateOnView">
            <?php 
            $allowed_html = array(
                'p' => array(
                    'class' => array(),
                    'style' => array()
                ),
                'h4' => array(),
                // other allowed tags...
            );

            echo wp_kses($short_text, $allowed_html);
            ?>
        </div>

        <?php if (!empty($long_text)): ?>
            <p id="toggle-button" class="font-dfserif text-medium/medium sm:text-base/regular cursor-pointer hover:text-df-red mt-sp1 animateOnView">
                <?php echo pll__('More', 'tailpress'); ?> ↓
            </p>
        <?php endif; ?>
    </div>      
</section>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const toggleButton = document.getElementById('toggle-button');
    const exhibitionText = document.getElementById('exhibition-text');

    const shortText = `<?php echo wp_kses_post($short_text); ?>`;
    const longText = `<?php echo wp_kses_post($long_text); ?>` + `
        
            <?php if (!empty($exhibition_folder) || !empty($exhibition_presskit)): ?>
               <div class="flex flex-col my-sp4 break-inside-avoid-column"> 
                <?php if (!empty($exhibition_folder)): ?>
                    <a href="<?php echo esc_url($exhibition_folder); ?>" target="_blank" rel="noopener noreferrer" class="hover:text-df-red underline underline-offset-2 text-medium/medium sm:text-regular/regular">
                        <?php echo pll__('Exhibition folder', 'tailpress'); ?>
                    </a>
                <?php endif; ?>
                <?php if (!empty($exhibition_presskit)): ?>
                    <a href="<?php echo esc_url($exhibition_presskit); ?>" target="_blank" rel="noopener noreferrer" class="hover:text-df-red underline underline-offset-2 text-medium/medium sm:text-regular/regular">
                        <?php echo pll__('Presskit', 'tailpress'); ?>
                    </a>
                <?php endif; ?>
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
