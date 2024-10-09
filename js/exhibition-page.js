document.addEventListener('DOMContentLoaded', () => {
    const loadMoreButton = document.getElementById('archive-load-more');
    let page = 1;
    let loadedPosts = document.getElementById('exhibitions-list').children.length;
    const totalPosts = exhibition_ajax.total_posts;

    // Load more posts functionality
    if (loadMoreButton) {
        loadMoreButton.addEventListener('click', (e) => {
            e.preventDefault();
            page++;

            const data = new URLSearchParams();
            data.append('action', 'load_more_exhibitions');
            data.append('page', page);

            fetch(exhibition_ajax.ajaxurl, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: data
            })
            .then(response => response.text())
            .then(response => {
                if (response.trim() !== '') {
                    document.getElementById('exhibitions-list').insertAdjacentHTML('beforeend', response);
                    loadedPosts = document.getElementById('exhibitions-list').children.length;

                    if (loadedPosts >= totalPosts) {
                        loadMoreButton.style.display = 'none';
                    }
                } else {
                    loadMoreButton.style.display = 'none';
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
        });
    }
});


document.getElementById('archive-search-input').addEventListener('keyup', () => {
    const searchQuery = document.getElementById('archive-search-input').value;

    const data = new URLSearchParams();
    data.append('action', 'search_exhibitions');
    data.append('searchQuery', searchQuery);

    fetch(exhibition_ajax.ajaxurl, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: data
    })
    .then(response => response.text())
    .then(response => {
        const exhibitionsList = document.getElementById('exhibitions-list');
        exhibitionsList.innerHTML = response;
        
        const loadMoreButton = document.getElementById('archive-load-more');
        if (response.trim().length === 0 || exhibitionsList.children.length < exhibition_ajax.posts_per_page) {
            loadMoreButton.style.display = 'none';
        } else {
            loadMoreButton.style.display = 'block';
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });
});
