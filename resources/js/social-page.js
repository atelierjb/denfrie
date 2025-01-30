document.addEventListener('DOMContentLoaded', function () {
    let offset = 0; // Tracks the current offset for loaded events
    const postsPerPage = 5; // Number of events per load (only used for past events)
    const toggleButton = document.getElementById('toggle-past-events');
    const searchInput = document.getElementById('social-search-input');
    const searchForm = document.getElementById('search-form');
    const socialContainer = document.getElementById('social-container');
    let totalEvents = 0; // Tracks the total number of events
    let loadingPastEvents = false; // Track whether we're loading past events
    
    // State management
    let savedState = {
        offset: 0,
        loadingPastEvents: false,
        totalEvents: 0,
        html: '',
        isSearching: false
    };

    // Prevent form submission and Enter key
    searchForm.addEventListener('submit', function (e) {
        e.preventDefault();
    });

    searchInput.addEventListener('keydown', function(e) {
        if (e.key === 'Enter') {
            e.preventDefault();
        }
    });

    // Save current state before searching
    function saveCurrentState() {
        savedState = {
            offset: offset,
            loadingPastEvents: loadingPastEvents,
            totalEvents: totalEvents,
            html: socialContainer.innerHTML,
            isSearching: true
        };
    }

    // Restore previous state
    function restoreState() {
        if (savedState.isSearching) {
            offset = savedState.offset;
            loadingPastEvents = savedState.loadingPastEvents;
            totalEvents = savedState.totalEvents;
            socialContainer.innerHTML = savedState.html;
            
            // Restore toggle button state
            if (loadingPastEvents) {
                if (offset >= totalEvents) {
                    toggleButton.style.display = 'none';
                } else {
                    toggleButton.style.display = 'block';
                    toggleButton.textContent = socialPageData.toggle_show_text;
                }
            } else {
                toggleButton.style.display = 'block';
                toggleButton.textContent = socialPageData.toggle_show_text;
            }
            
            savedState.isSearching = false;
        }
    }

    // Fetch events
    function fetchEvents(isSearch = false, resetOffset = false) {
        // Save state when starting a new search
        if (isSearch && resetOffset && !savedState.isSearching) {
            saveCurrentState();
        }

        if (resetOffset) {
            offset = 0;
            totalEvents = 0; // Reset the total events count when refreshing
            if (isSearch) {
                // Don't reset loadingPastEvents during search
                savedState.isSearching = true;
            } else {
                loadingPastEvents = false; // Only reset for non-search resets
            }
        }

        const data = new URLSearchParams();
        data.append('action', 'fetch_social_events');
        data.append('offset', offset);
        data.append('posts_per_page', postsPerPage);
        data.append('search_query', searchInput.value.trim());
        data.append('load_past_events', loadingPastEvents ? '1' : '0');

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

                // If search is cleared, restore previous state
                if (isSearch && searchInput.value.trim() === '') {
                    restoreState();
                    return;
                }

                if (resetOffset) {
                    socialContainer.innerHTML = html; // Replace content for new searches
                } else {
                    if (loadingPastEvents && offset === 0) {
                        // Add section title for previous events
                        socialContainer.insertAdjacentHTML('beforeend', `
                            <h2 class="font-dfserif text-xl/xl pt-sp7 pb-sp5 sm:pb-sp7 mt-sp5 animateOnView">
                                ${socialPageData.previous_events_text}
                            </h2>
                            <hr class="border-df-black animateOnView">
                        `);
                    }
                    socialContainer.insertAdjacentHTML('beforeend', html);
                }

                // Update offset and total events
                offset += postsPerPage;
                totalEvents = total;

                // Handle toggle button visibility
                if (isSearch) {
                    // Hide toggle button during search
                    toggleButton.style.display = 'none';
                } else {
                    // Show toggle button for future events (to load past events)
                    // or if there are more past events to load
                    if (!loadingPastEvents) {
                        toggleButton.style.display = 'block';
                        toggleButton.textContent = socialPageData.toggle_initial_text;
                    } else {
                        // For past events, hide button if all loaded
                        if (offset >= totalEvents) {
                            toggleButton.style.display = 'none';
                        } else {
                            toggleButton.style.display = 'block';
                            toggleButton.textContent = socialPageData.toggle_more_text;
                        }
                    }
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
        if (searchInput.value.trim()) return; // Disable toggle if searching
        if (!loadingPastEvents) {
            // First click on toggle - switch to past events
            loadingPastEvents = true;
            offset = 0;
        }
        fetchEvents();
    });

    // Search functionality with debounce
    let searchTimeout;
    searchInput.addEventListener('input', function () {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(() => {
            fetchEvents(true, true);
        }, 300); // Wait 300ms after user stops typing
    });

    // Initial fetch
    fetchEvents();
});
