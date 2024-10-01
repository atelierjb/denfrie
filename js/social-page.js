jQuery(document).ready(function($) {
    let loadMoreButton = $('#social-load-more'); // Use the updated unique ID
    let page = 1;
    let loadedPosts = $('#social-container').children().length; // Initial count of loaded posts
    const totalPosts = socialPageData.total_posts; // Total number of posts passed from PHP

    // Load more posts functionality for the social page
    if (loadMoreButton.length) {
        loadMoreButton.click(function(e) {
            e.preventDefault();
            page++;
            let data = {
                'action': 'load_more_posts',
                'page': page
            };

            $.post(socialPageData.ajax_url, data, function(response) {
                if (response.trim() !== '') {
                    $('#social-container').append(response);

                    // Update the count of loaded posts
                    loadedPosts = $('#social-container').children().length;

                    // Hide the button if all posts are loaded
                    if (loadedPosts >= totalPosts) {
                        loadMoreButton.hide();
                    }

                    // Reapply the accordion behavior to new items
                    $('#social-container .collapse input[type="checkbox"]').change(function() {
                        $('.collapse input[type="checkbox"]').not(this).prop('checked', false);
                        $('.collapse-title p').removeClass('text-df-red underline underline-offset-2');
                        if ($(this).is(':checked')) {
                            $(this).closest('.collapse').find('.collapse-title p').addClass('text-df-red underline underline-offset-2');
                        }
                    });
                } else {
                    // No more posts to load; hide the button
                    loadMoreButton.hide();
                }
            });
        });
    }

    // Search functionality for the social page
    $('#social-search-input').on('keyup', function() {
        let searchQuery = $(this).val();
        $.ajax({
            type: 'POST',
            url: socialPageData.ajax_url, // Use socialPageData.ajax_url here
            data: {
                action: 'filter_search',
                searchQuery: searchQuery
            },
            success: function(response) {
                $('#social-container').html(response);
                // Reapply the accordion behavior to new items
                $('#social-container .collapse input[type="checkbox"]').change(function() {
                    $('.collapse input[type="checkbox"]').not(this).prop('checked', false);
                    $('.collapse-title p').removeClass('text-df-red underline underline-offset-2');
                    if ($(this).is(':checked')) {
                        $(this).closest('.collapse').find('.collapse-title p').addClass('text-df-red underline underline-offset-2');
                    }
                });
            }
        });
    });
});
