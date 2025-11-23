/**
 * Header scroll behavior
 * - Shows header when scrolling up
 * - Hides header when scrolling down
 */
document.addEventListener('DOMContentLoaded', function() {
    const header = document.querySelector('header');
    if (!header) return;

    let lastScrollY = window.scrollY;
    let ticking = false;

    // Add padding to body to account for fixed header
    function updateBodyPadding() {
        const headerHeight = header.offsetHeight;
        document.body.style.paddingTop = headerHeight + 'px';
    }

    // Update padding on load and resize
    updateBodyPadding();
    window.addEventListener('resize', updateBodyPadding);

    function handleScroll() {
        const currentScrollY = window.scrollY;

        // Don't hide header when at top of page
        if (currentScrollY <= 0) {
            header.classList.remove('header-hidden');
            lastScrollY = currentScrollY;
            return;
        }

        const scrollDiff = currentScrollY - lastScrollY;

        // Scrolling down - hide header (5px以上)
        if (scrollDiff > 5) {
            header.classList.add('header-hidden');
            lastScrollY = currentScrollY;
        }
        // Scrolling up - show header (5px以上)
        else if (scrollDiff < -5) {
            header.classList.remove('header-hidden');
            lastScrollY = currentScrollY;
        }
    }

    window.addEventListener('scroll', function() {
        if (!ticking) {
            window.requestAnimationFrame(function() {
                handleScroll();
                ticking = false;
            });
            ticking = true;
        }
    }, { passive: true });
});
