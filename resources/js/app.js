// motion one setup
import { animate, inView } from "@motionone/dom";

// Using InView to detect when the element is in the viewport
document.addEventListener('DOMContentLoaded', () => {
    inView('.animateOnView', ({ target }) => {
        animate(target, { opacity: [1], transform: ['translateY(15px)', 'translateY(0)'] }, { delay: 0.1, duration: 0.8, easing: [0.17, 0.55, 0.55, 1] });
    });
});

