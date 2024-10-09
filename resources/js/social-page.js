document.addEventListener('DOMContentLoaded', function() {
    const loadMoreButton = document.getElementById('social-load-more');
    let page = 1;
    let loadedPosts = document.getElementById('social-container').children.length;
    const totalPosts = socialPageData.total_posts;

    // Function to reapply the accordion behavior
    function reapplyAccordionBehavior() {
        const collapseInputs = document.querySelectorAll('#social-container .collapse input[type="checkbox"]');

        collapseInputs.forEach(input => {
            input.addEventListener('change', function() {
                document.querySelectorAll('.collapse input[type="checkbox"]').forEach(checkbox => {
                    if (checkbox !== input) {
                        checkbox.checked = false;
                        // Remove classes from both <p> tags inside the title
                        checkbox.closest('.collapse').querySelectorAll('.collapse-title p').forEach(p => {
                            p.classList.remove('text-df-red', 'underline', 'underline-offset-2');
                        });
                    }
                });

                // Toggle the class on both <p> tags inside the currently selected item
                const titlePs = input.closest('.collapse').querySelectorAll('.collapse-title p');
                titlePs.forEach(p => {
                    if (input.checked) {
                        p.classList.add('text-df-red', 'underline', 'underline-offset-2');
                    } else {
                        p.classList.remove('text-df-red', 'underline', 'underline-offset-2');
                    }
                });
            });
        });
    }

    // Load more posts functionality
    if (loadMoreButton) {
        loadMoreButton.addEventListener('click', function(e) {
            e.preventDefault();
            page++;

            const data = new URLSearchParams();
            data.append('action', 'load_more_posts');
            data.append('page', page);

            fetch(socialPageData.ajax_url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: data
            })
            .then(response => response.text())
            .then(response => {
                if (response.trim() !== '') {
                    document.getElementById('social-container').insertAdjacentHTML('beforeend', response);
                    loadedPosts = document.getElementById('social-container').children.length;

                    if (loadedPosts >= totalPosts) {
                        loadMoreButton.style.display = 'none';
                    }

                    // Reapply the accordion behavior to new items
                    reapplyAccordionBehavior();
                } else {
                    loadMoreButton.style.display = 'none';
                }
            })
            .catch(error => console.error('Error:', error));
        });
    }

    // Reapply accordion behavior for initially loaded items
    reapplyAccordionBehavior();

    // Search functionality for the social page
    document.getElementById('social-search-input').addEventListener('keyup', function() {
        const searchQuery = this.value;

        const data = new URLSearchParams();
        data.append('action', 'filter_search');
        data.append('searchQuery', searchQuery);

        fetch(socialPageData.ajax_url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: data
        })
        .then(response => response.text())
        .then(response => {
            const socialContainer = document.getElementById('social-container');
            socialContainer.innerHTML = response;

            // Reapply the accordion behavior to new items
            reapplyAccordionBehavior();
        })
        .catch(error => console.error('Error:', error));
    });
});
