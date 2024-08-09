jQuery(document).ready(function($) {
    let loadMoreButton = $('#load-more');
    let page = 1;

    // Load more posts functionality
    loadMoreButton.click(function(e) {
        e.preventDefault();
        page++;
        let data = {
            'action': 'load_more_exhibitions',
            'page': page
        };

        $.post(exhibition_ajax.ajaxurl, data, function(response) {
            if (response) {
                $('#exhibitions-list').append(response);
                // Hide the button if there are no more posts
                if (response.trim().length === 0) {
                    loadMoreButton.hide();
                }
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
            url: exhibition_ajax.ajaxurl,
            data: {
                action: 'search_exhibitions',
                searchQuery: searchQuery
            },
            success: function(response) {
                $('#exhibitions-list').html(response);
                // Check if the number of returned posts is less than the posts_per_page
                if (response.trim().length === 0 || $('#exhibitions-list').children().length < exhibition_ajax.posts_per_page) {
                    loadMoreButton.hide();
                } else {
                    loadMoreButton.show();
                }
            }
        });
    });
});
