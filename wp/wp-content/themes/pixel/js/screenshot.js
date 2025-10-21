/**
 * App Screenshots Swipe Scroll Functionality
 */
document.addEventListener('DOMContentLoaded', function() {
  const screenshotsContainer = document.querySelector('.app-screenshots');

  if (!screenshotsContainer) {
    return;
  }

  let isDown = false;
  let startX;
  let scrollLeft;

  // Mouse down / Touch start
  screenshotsContainer.addEventListener('mousedown', handleStart);
  screenshotsContainer.addEventListener('touchstart', handleStart, { passive: true });

  // Mouse move / Touch move
  screenshotsContainer.addEventListener('mousemove', handleMove);
  screenshotsContainer.addEventListener('touchmove', handleMove, { passive: false });

  // Mouse up / Touch end
  screenshotsContainer.addEventListener('mouseup', handleEnd);
  screenshotsContainer.addEventListener('mouseleave', handleEnd);
  screenshotsContainer.addEventListener('touchend', handleEnd);

  function handleStart(e) {
    isDown = true;
    screenshotsContainer.style.cursor = 'grabbing';

    const pageX = e.type.includes('mouse') ? e.pageX : e.touches[0].pageX;
    startX = pageX - screenshotsContainer.offsetLeft;
    scrollLeft = screenshotsContainer.scrollLeft;
  }

  function handleMove(e) {
    if (!isDown) return;

    // Prevent default scroll behavior for touch
    if (e.type === 'touchmove') {
      e.preventDefault();
    }

    const pageX = e.type.includes('mouse') ? e.pageX : e.touches[0].pageX;
    const x = pageX - screenshotsContainer.offsetLeft;
    const walk = (x - startX) * 2; // Scroll speed adjustment (2x)
    screenshotsContainer.scrollLeft = scrollLeft - walk;
  }

  function handleEnd() {
    isDown = false;
    screenshotsContainer.style.cursor = 'grab';
  }

  // Initial cursor setting
  screenshotsContainer.style.cursor = 'grab';
});
