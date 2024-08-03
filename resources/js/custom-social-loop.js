jQuery(document).ready(function($) {
    var searchTimer;
    var $container = $('#social-posts-container');
    var $loadMoreBtn = $('#load-more');
    var currentPage = 1;
    var maxPages = 1;

    function fetchPosts(page, search = '') {
        $.ajax({
            url: ajax_object.ajax_url,
            type: 'POST',
            data: {
                action: 'fetch_social_posts',
                page: page,
                search: search
            },
            success: function(response) {
                renderPosts(response, page === 1);
                maxPages = response.max_pages;
                $loadMoreBtn.data('max', maxPages);
                $loadMoreBtn.toggle(currentPage < maxPages);
            }
        });
    }

    function renderPosts(posts, replace = false) {
        var html = '';
        $.each(posts, function(index, post) {
            if (typeof post === 'object') {
                html += `
                    <div class="collapse py-[calc(0.5rem+0.5vw)] grid-cols-1">
                        <input type="checkbox" class="min-h-0 p-0" />
                        <div class="collapse-title p-0 min-h-0 grid grid-cols-4 gap-[calc(2rem+2vw)] text-medium/medium">
                            <p class="font-superclarendon col-span-1 whitespace-nowrap">
                                ${post.date} ${post.date_start} ${post.date_end}
                            </p>
                            <p class="font-dfserif leading-[calc(110%+0.2vw)] col-span-3 line-clamp-1">
                                ${post.title}
                            </p>
                        </div>
                        <div class="collapse-content px-0 grid grid-cols-4 gap-[calc(2rem+2vw)]">
                            <figure class="w-full overflow-hidden aspect-video col-span-1 mt-[calc(0.5rem+0.5vw)]">
                                <img src="${post.image}" alt="${post.title}" class="w-full h-full transform transition-transform duration-500 hover:scale-110 object-cover">
                            </figure>
                            <div class="font-superclarendon mt-[calc(0.5rem+0.5vw)] text-regular/regular col-span-3 indent-[calc(1rem+1vw)]">
                                ${post.description}
                            </div>
                        </div>
                    </div>
                    <hr class="border-df-black">
                `;
            }
        });

        if (replace) {
            $container.html(html);
        } else {
            $container.append(html);
        }
    }

    $('#search-input').on('input', function() {
        clearTimeout(searchTimer);
        var searchQuery = $(this).val();
        $loadMoreBtn.data('query', searchQuery);

        searchTimer = setTimeout(function() {
            currentPage = 1;
            fetchPosts(currentPage, searchQuery);
        }, 300);
    });

    $loadMoreBtn.on('click', function() {
        currentPage++;
        var searchQuery = $('#search-input').val();
        fetchPosts(currentPage, searchQuery);
    });

    // Initial load
    fetchPosts(currentPage);
});