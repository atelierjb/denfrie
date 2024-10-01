jQuery(document).ready(function($) {
    let loadMoreButton = $('#archive-load-more');
    let page = 1;
    let loadedPosts = $('#exhibitions-list').children().length; // Initial count of loaded posts
    const totalPosts = exhibition_ajax.total_posts; // Total number of posts passed from PHP

    // Load more posts functionality for the archive page
    if (loadMoreButton.length) {
        loadMoreButton.click(function(e) {
            e.preventDefault();
            page++;
            let data = {
                'action': 'load_more_exhibitions',
                'page': page
            };

            $.post(exhibition_ajax.ajaxurl, data, function(response) {
                if (response.trim() !== '') {
                    $('#exhibitions-list').append(response);
                    // Update the count of loaded posts
                    loadedPosts = $('#exhibitions-list').children().length;

                    // Hide the button if all posts are loaded
                    if (loadedPosts >= totalPosts) {
                        loadMoreButton.hide();
                    }
                } else {
                    // No more posts to load; hide the button
                    loadMoreButton.hide();
                }
            });
        });
    }

    // Search functionality for the archive page
    $('#archive-search-input').on('keyup', function() {
        let searchQuery = $(this).val();
        $.ajax({
            type: 'POST',
            url: exhibition_ajax.ajaxurl,
            data: {
                action: 'search_exhibitions',
                searchQuery: searchQuery
            },
            success: function(response) {
                $('#exhibitions-list').html(response);
                // Hide the load more button if fewer posts are returned
                if (response.trim().length === 0 || $('#exhibitions-list').children().length < exhibition_ajax.posts_per_page) {
                    loadMoreButton.hide();
                } else {
                    loadMoreButton.show();
                }
            }
        });
    });
});
