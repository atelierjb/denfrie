/* -------------------------------------------------------------------------- */
/*                              LOADING SEQUENCE                              */
/* -------------------------------------------------------------------------- */

document.addEventListener('DOMContentLoaded', function() {
    const isMobile = window.innerWidth <= 768;
    const loadingScreen = document.querySelector("#loading-screen");
    const loadingImage = document.querySelector("#loading-image");
    const mainContent = document.querySelector("#main-content");
    const navContainer = document.querySelector("#nav-container");

    // Debug logs
    console.log('Loading screen:', loadingScreen);
    console.log('Loading image:', loadingImage);
    console.log('Main content:', mainContent);
    console.log('Nav container:', navContainer);

    // Error handling if elements don't exist
    if (!loadingScreen || !loadingImage || !mainContent || !navContainer) {
        console.warn('Required elements not found');
        return;
    }

    // Check if this is a fresh page load or internal navigation
    if (performance.navigation.type === 1 || !document.referrer.includes(window.location.hostname)) {
        // Set initial positions
        gsap.set(navContainer, { y: "100%" });
        gsap.set(mainContent, { y: "100%" });
        gsap.set(loadingImage, { 
            y: isMobile ? "10%" : "100%",
            opacity: 0 
        });

        // Force image reload to trigger onload
        const imageSrc = loadingImage.src;
        loadingImage.src = '';
        requestAnimationFrame(() => {
            loadingImage.src = imageSrc;
        });

        loadingImage.onload = function() {
            console.log('Image loaded, starting animation');
            const tl = gsap.timeline();

            tl.to(loadingImage, { 
                y: 0, 
                opacity: 1, 
                duration: isMobile ? 0.3 : 0.5, 
                ease: "power4.out" 
            })
            .to(loadingScreen, {
                y: "-100%", 
                duration: isMobile ? 1 : 0.8, 
                ease: "power4.inOut"
            })
            .to([navContainer, mainContent], {
                y: 0, 
                duration: isMobile ? 0.75 : 1.5, 
                ease: "power3.inOut",
                onComplete: function() {
                    loadingScreen.style.display = 'none';
                    ScrollTrigger.refresh();
                }
            }, "-=1");
        };
    } else {
        // Hide loading screen immediately for internal navigation
        loadingScreen.style.display = 'none';
        gsap.set(navContainer, { y: 0 });
        gsap.set(mainContent, { y: 0 });
    }
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
