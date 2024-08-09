jQuery(document).ready(function($) {
    // Accordion collapse functionality
    $('#social-container').on('change', '.collapse input[type="checkbox"]', function() {
        // Close all other accordions
        $('.collapse input[type="checkbox"]').not(this).prop('checked', false);

        // Reset styles for all
        $('.collapse-title p').removeClass('text-df-red underline');

        // Apply styles to the current expanded accordion
        if ($(this).is(':checked')) {
            $(this).closest('.collapse').find('.collapse-title p').addClass('text-df-red underline');
        }
    });

    // Load more posts functionality
    let loadMoreButton = $('#load-more');
    let page = 1;

    loadMoreButton.click(function(e) {
        e.preventDefault();
        page++;
        let data = {
            'action': 'load_more_posts',
            'page': page
        };

        $.post(ajaxurl, data, function(response) {
            if (response) {
                $('#load-more-container').before(response);
                // Reapply the accordion behavior to new items
                $('#social-container .collapse input[type="checkbox"]').change(function() {
                    $('.collapse input[type="checkbox"]').not(this).prop('checked', false);
                    $('.collapse-title p').removeClass('text-df-red underline');
                    if ($(this).is(':checked')) {
                        $(this).closest('.collapse').find('.collapse-title p').addClass('text-df-red underline');
                    }
                });
            } else {
                loadMoreButton.hide();
            }
        });
    });

    // Search functionality
    $('#search-input').on('keyup', function() {
        let searchQuery = $(this).val();
        $.ajax({
            type: 'POST',
            url: ajaxurl,
            data: {
                action: 'filter_search',
                searchQuery: searchQuery
            },
            success: function(response) {
                $('#social-container').html(response);
                // Reapply the accordion behavior to new items
                $('#social-container .collapse input[type="checkbox"]').change(function() {
                    $('.collapse input[type="checkbox"]').not(this).prop('checked', false);
                    $('.collapse-title p').removeClass('text-df-red underline');
                    if ($(this).is(':checked')) {
                        $(this).closest('.collapse').find('.collapse-title p').addClass('text-df-red underline');
                    }
                });
            }
        });
    });
});
