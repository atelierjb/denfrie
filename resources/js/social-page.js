document.addEventListener('DOMContentLoaded', function () {
    let offset = 0; // Tracks the current offset for loaded events
    const postsPerPage = 5; // Number of events per load
    const toggleButton = document.getElementById('toggle-past-events');
    const searchInput = document.getElementById('social-search-input');
    const searchForm = document.getElementById('search-form');
    const socialContainer = document.getElementById('social-container');
    let totalEvents = 0; // Tracks the total number of events

    // Prevent form submission
    searchForm.addEventListener('submit', function (e) {
        e.preventDefault();
    });

    // Fetch events
    function fetchEvents(isSearch = false, resetOffset = false) {
        if (resetOffset) {
            offset = 0;
            totalEvents = 0; // Reset the total events count when refreshing
        }

        const data = new URLSearchParams();
        data.append('action', 'fetch_social_events');
        data.append('offset', offset);
        data.append('posts_per_page', postsPerPage);
        data.append('search_query', searchInput.value.trim());

        fetch(socialPageData.ajax_url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: data,
        })
            .then((response) => response.json()) // Expect JSON response
            .then((result) => {
                const { html, total } = result;

                if (resetOffset) {
                    socialContainer.innerHTML = html; // Replace content for new searches
                } else {
                    socialContainer.insertAdjacentHTML('beforeend', html); // Append new events
                }

                // Update offset and total events
                offset += postsPerPage;
                totalEvents = total;

                // Check if all events are loaded
                if (offset >= totalEvents) {
                    toggleButton.style.display = 'none'; // Hide button if no more events
                } else {
                    toggleButton.style.display = 'block'; // Ensure button is visible if more events are available
                }

                reapplyAccordionBehavior(); // Reapply accordion behavior
            })
            .catch((error) => console.error('Error fetching events:', error));
    }

    // Initialize accordion behavior
    function reapplyAccordionBehavior() {
        const collapseInputs = document.querySelectorAll('#social-container .collapse input[type="checkbox"]');

        collapseInputs.forEach(input => {
            input.addEventListener('change', function () {
                // Close all other accordions
                document.querySelectorAll('.collapse input[type="checkbox"]').forEach(checkbox => {
                    if (checkbox !== input) checkbox.checked = false;
                });
            });
        });
    }

    // Toggle load more events
    toggleButton.addEventListener('click', function () {
        if (searchInput.value.trim() || offset >= totalEvents) return; // Disable toggle if searching or all events loaded
        fetchEvents();
    });

    // Search functionality
    searchInput.addEventListener('input', function () {
        fetchEvents(true, true);
    });

    // Initial fetch
    fetchEvents();
});
