/* -------------------------------------------------------------------------- */
/*                              LOADING SEQUENCE                              */
/* -------------------------------------------------------------------------- */

document.addEventListener('DOMContentLoaded', function() {
    const isMobile = window.innerWidth <= 768;

    // Check if animation has been seen this session
    if (sessionStorage.getItem('hasSeenAnimation') === 'true') {
        document.querySelector("#loading-screen").style.display = 'none';
        gsap.set("#nav-container", { y: 0 });
        gsap.set("#main-content", { y: 0 });
        return;
    }

    const tl = gsap.timeline();

    // Set initial positions with different starting points for mobile/desktop
    gsap.set("#nav-container", { y: "100%" });
    gsap.set("#main-content", { y: "100%" });
    gsap.set("#loading-image", { 
        y: isMobile ? "10%" : "100%",
        opacity: 0 
    });

    // Animation sequence
    tl.to("#loading-image", { 
        y: 0, 
        opacity: 1, 
        duration: isMobile ? 0.3 : 0.5, 
        ease: "power4.out" 
    });

    // Shorter pause for mobile
    tl.to("#loading-image", { duration: isMobile ? 0.15 : 0.25 });

    // Rest of the animation
    tl.to("#loading-screen", {
        y: "-100%", 
        duration: isMobile ? 1 : 1.5, 
        ease: "power4.inOut"
    });

    // Nav-container and main-content move up
    tl.to("#nav-container", {
        y: 0, 
        duration: isMobile ? 1 : 1.5, 
        ease: "power4.inOut"
    }, "-=1")
    .to("#main-content", {
        y: 0,
        duration: isMobile ? 1 : 1.5, 
        ease: "power4.inOut",
        onComplete: function() {
            // ... rest of the onComplete function ...
        }
    }, "-=1");
});


/* -------------------------------------------------------------------------- */
/*                              PREFETCH FUNCTION                             */
/* -------------------------------------------------------------------------- */

document.addEventListener('DOMContentLoaded', function() {
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

    const prefetched = {}; // Store prefetched URLs to avoid multiple requests

    // Attach hover event to all links on the page
    document.querySelectorAll('a').forEach(link => {
        link.addEventListener('mouseenter', function() {
            const url = link.href;
            if (url && url.startsWith(window.location.origin)) {
                prefetchPage(url);
            }
        });
    });
});


/* -------------------------------------------------------------------------- */
/*                            // Navigation toggle                            */
/* -------------------------------------------------------------------------- */

document.addEventListener('DOMContentLoaded', function () {
    let menuIcon = document.querySelector('#menu-icon');
    let mainNavigation = document.querySelector('#primary-menu');
    let menuIsOpen = false;

    document.querySelector('#primary-menu-toggle').addEventListener('click', function (e) {
        e.preventDefault();

        if (menuIsOpen) {
            // Close menu
            menuIcon.setAttribute('name', 'menu-sharp');
            gsap.to(mainNavigation, { duration: 0.5, x: '100%', ease: 'power3.inOut' });
        } else {
            // Open menu
            menuIcon.setAttribute('name', 'close-sharp');
            gsap.to(mainNavigation, { duration: 0.75, x: '0%', ease: 'power3.inOut' });
        }

        menuIsOpen = !menuIsOpen; // Toggle the menu state
    });
});
