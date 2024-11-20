document.addEventListener('DOMContentLoaded', function () {
    let showPast = false; // Tracks the current toggle state
    const toggleButton = document.getElementById('toggle-past-events');
    const searchInput = document.getElementById('social-search-input');
    const searchForm = document.getElementById('search-form');
    const socialContainer = document.getElementById('social-container');

    // Prevent form submission (disable "Enter" refresh)
    searchForm.addEventListener('submit', function (e) {
        e.preventDefault();
    });

    // Reapply accordion behavior with styling for open items
    function reapplyAccordionBehavior() {
        const collapseInputs = document.querySelectorAll('#social-container .collapse input[type="checkbox"]');

        collapseInputs.forEach(input => {
            input.addEventListener('change', function () {
                // Close all other accordions and reset their styling
                document.querySelectorAll('.collapse input[type="checkbox"]').forEach(checkbox => {
                    if (checkbox !== input) {
                        checkbox.checked = false;

                        // Remove styling from title <p> tags of closed accordions
                        checkbox.closest('.collapse').querySelectorAll('.collapse-title p').forEach(p => {
                            p.classList.remove('text-df-red', 'underline', 'underline-offset-2');
                        });
                    }
                });

                // Style the title <p> tags of the currently opened accordion
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

    // Fetch events
    function fetchEvents(fetchAll = false) {
        const data = new URLSearchParams();
        data.append('action', 'fetch_social_events');

        if (fetchAll) {
            data.append('show_past', 'both'); // Fetch both upcoming and past events during search
        } else {
            data.append('show_past', showPast ? '1' : '0'); // Respect the toggle state
        }

        data.append('search_query', searchInput.value.trim()); // Include search query

        fetch(socialPageData.ajax_url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: data,
        })
            .then((response) => response.text())
            .then((html) => {
                socialContainer.innerHTML = html;
                reapplyAccordionBehavior(); // Reapply accordion behavior for new content
            })
            .catch((error) => console.error('Error fetching events:', error));
    }

    // Toggle past events
    toggleButton.addEventListener('click', function () {
        if (searchInput.value.trim()) return; // Disable toggle while searching

        showPast = !showPast;
        toggleButton.textContent = showPast
            ? socialPageData.toggle_hide_text
            : socialPageData.toggle_show_text;
        fetchEvents();
    });

    // Search functionality
    searchInput.addEventListener('input', function () {
        const searchQuery = searchInput.value.trim();

        if (searchQuery) {
            fetchEvents(true);
        } else {
            fetchEvents();
        }
    });

    // Prevent "Enter" from refreshing the page
    searchInput.addEventListener('keydown', function (e) {
        if (e.key === 'Enter') {
            e.preventDefault();
        }
    });

    // Initialize accordion behavior
    reapplyAccordionBehavior();
});
