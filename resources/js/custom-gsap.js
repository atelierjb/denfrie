/* -------------------------------------------------------------------------- */
/*                              LOADING SEQUENCE                              */
/* -------------------------------------------------------------------------- */

document.addEventListener('DOMContentLoaded', function() {
    // Check if the loading animation has already been shown this session
    if (sessionStorage.getItem('hasSeenAnimation') === 'true') {
        // Skip the animation if already seen this session
        document.querySelector("#loading-screen").style.display = 'none';
        gsap.set("#nav-container", { y: 0 });
        gsap.set("#main-content", { y: 0 });

        // Initialize ScrollTrigger after skipping animation
        initializeScrollTrigger();
        return;
    }

    // Set up the animation as before
    const tl = gsap.timeline();

    // Set initial positions
    gsap.set("#loading-image", { y: "100%", opacity: 0 });
    gsap.set("#nav-container", { y: "100%" });
    gsap.set("#main-content", { y: "100%" });

    // Image slides in from the bottom
    tl.to("#loading-image", { 
        y: 0, 
        opacity: 1, 
        duration: 0.5, 
        ease: "power4.out" 
    });

    // Pause for 1 second
    tl.to("#loading-image", { duration: 0.5 });

    // Loading screen slides up and out of view
    tl.to("#loading-screen", {
        y: "-100%", 
        duration: 1.5, 
        ease: "power4.inOut"
    });

    // Nav-container and main-content move up as a combined block
    tl.to("#nav-container", {
        y: 0, 
        duration: 1.5, 
        ease: "power4.inOut"
    }, "-=1.5")
    .to("#main-content", {
        y: 0,
        duration: 1.5, 
        ease: "power4.inOut",
        onComplete: function() {
            document.querySelector("#loading-screen").style.display = 'none';
            // Store a value in session storage to indicate the animation has been seen this session
            sessionStorage.setItem('hasSeenAnimation', 'true');

            // Short delay to ensure layout has settled
            setTimeout(() => {
                ScrollTrigger.refresh(); // Refresh ScrollTrigger to recalculate positions
                initializeScrollTrigger(); // Initialize ScrollTrigger after everything is in place
            }, 100); // 100ms delay to allow layout to settle
        }
    }, "-=1.5");
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
