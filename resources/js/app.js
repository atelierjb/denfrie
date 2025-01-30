// motion one setup
import { animate, inView } from "@motionone/dom";

document.addEventListener('DOMContentLoaded', () => {
    /* -------------------------------------------------------------------------- */
    /*                              PREFETCH FUNCTION                             */
    /* -------------------------------------------------------------------------- */

    const prefetched = {}; // Store prefetched URLs to avoid multiple requests

    function prefetchPage(url) {
        if (url && !prefetched[url]) {
            prefetched[url] = true; // Mark this URL as prefetched
            fetch(url)
                .then(response => response.text())
                .then(html => {
                })
                .catch(err => console.error('Prefetch failed:', err));
        }
    }

    // Attach hover event to all links on the page
    document.querySelectorAll('a').forEach(link => {
        link.addEventListener('mouseenter', function() {
            const url = link.href;
            if (url && url.startsWith(window.location.origin)) {
                prefetchPage(url);
            }
        });
    });

    /* -------------------------------------------------------------------------- */
    /*                            NAVIGATION TOGGLE                               */
    /* -------------------------------------------------------------------------- */

    const menuIcon = document.querySelector('#menu-icon');
    const mainNavigation = document.querySelector('#primary-menu');
    let menuIsOpen = false;

    document.querySelector('#primary-menu-toggle')?.addEventListener('click', function (e) {
        e.preventDefault();

        menuIsOpen = !menuIsOpen;
        
        // Toggle menu icon
        menuIcon.setAttribute('name', menuIsOpen ? 'close-sharp' : 'menu-sharp');
        
        // Toggle menu class for animation
        mainNavigation.classList.toggle('menu-open');
    });

    /* -------------------------------------------------------------------------- */
    /*                            ANIMATION ON VIEW                               */
    /* -------------------------------------------------------------------------- */

    // Using InView to detect when the element is in the viewport
    inView('.animateOnView', ({ target }) => {
        animate(target, 
            { 
                opacity: [1], 
                transform: ['translateY(15px)', 'translateY(0)'] 
            }, 
            { 
                delay: 0.1, 
                duration: 0.8, 
                easing: [0.17, 0.55, 0.55, 1] 
            }
        );
    });
});

