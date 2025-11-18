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

        // Scrolling down - hide header
        if (currentScrollY > lastScrollY) {
            header.classList.add('header-hidden');
        }
        // Scrolling up - show header
        else if (currentScrollY < lastScrollY) {
            header.classList.remove('header-hidden');
        }

        lastScrollY = currentScrollY;
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
