document.querySelectorAll('.neo-primary-menu .menu-item-has-children').forEach(item => {
  const button = document.createElement('button');
  button.type = 'button'; button.className = 'neo-submenu-toggle'; button.textContent = '⌄';
  button.setAttribute('aria-label', 'Toggle submenu'); button.setAttribute('aria-expanded', 'false');
  item.querySelector('a').after(button);
  button.addEventListener('click', () => button.setAttribute('aria-expanded', String(item.classList.toggle('neo-submenu-open'))));
});
document.addEventListener('keydown', event => {
  if (event.key !== 'Escape') return;
  document.querySelectorAll('.neo-submenu-open').forEach(item => { item.classList.remove('neo-submenu-open'); item.querySelector('button').setAttribute('aria-expanded','false'); });
});

// WordPress fixes its toolbar on desktop but scrolls it away on narrow screens.
// Use its visible height so the floating header never slides underneath it.
(() => {
  const toolbar = document.getElementById('wpadminbar');
  if (!toolbar || !document.body.classList.contains('admin-bar')) return;
  let frame = 0;
  function updateToolbarOffset() {
    frame = 0;
    const rect = toolbar.getBoundingClientRect();
    const visibleHeight = Math.max(0, Math.min(rect.bottom, innerHeight) - Math.max(0, rect.top));
    document.body.style.setProperty('--neo-admin-bar-offset', `${visibleHeight}px`);
  }
  function scheduleUpdate() {
    if (!frame) frame = requestAnimationFrame(updateToolbarOffset);
  }
  window.addEventListener('scroll', scheduleUpdate, { passive: true });
  window.addEventListener('resize', scheduleUpdate, { passive: true });
  if ('ResizeObserver' in window) new ResizeObserver(scheduleUpdate).observe(toolbar);
  updateToolbarOffset();
})();
