/**
 * Related Apps Swipe Scroll Functionality
 */
document.addEventListener('DOMContentLoaded', function() {
  const relateAppContainer = document.querySelector('.relate_app');

  if (!relateAppContainer) {
    return;
  }

  let isDown = false;
  let startX;
  let scrollLeft;

  // Mouse down / Touch start
  relateAppContainer.addEventListener('mousedown', handleStart);
  relateAppContainer.addEventListener('touchstart', handleStart, { passive: true });

  // Mouse move / Touch move
  relateAppContainer.addEventListener('mousemove', handleMove);
  relateAppContainer.addEventListener('touchmove', handleMove, { passive: false });

  // Mouse up / Touch end
  relateAppContainer.addEventListener('mouseup', handleEnd);
  relateAppContainer.addEventListener('mouseleave', handleEnd);
  relateAppContainer.addEventListener('touchend', handleEnd);

  function handleStart(e) {
    isDown = true;
    relateAppContainer.style.cursor = 'grabbing';

    const pageX = e.type.includes('mouse') ? e.pageX : e.touches[0].pageX;
    startX = pageX - relateAppContainer.offsetLeft;
    scrollLeft = relateAppContainer.scrollLeft;
  }

  function handleMove(e) {
    if (!isDown) return;

    // Prevent default scroll behavior for touch
    if (e.type === 'touchmove') {
      e.preventDefault();
    }

    const pageX = e.type.includes('mouse') ? e.pageX : e.touches[0].pageX;
    const x = pageX - relateAppContainer.offsetLeft;
    const walk = (x - startX) * 2; // Scroll speed adjustment (2x)
    relateAppContainer.scrollLeft = scrollLeft - walk;
  }

  function handleEnd() {
    isDown = false;
    relateAppContainer.style.cursor = 'grab';
  }

  // Initial cursor setting
  relateAppContainer.style.cursor = 'grab';
});
