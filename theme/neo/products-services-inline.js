
    // Interactive tab switcher logic
    document.addEventListener('DOMContentLoaded', () => {
      const tabTriggers = document.querySelectorAll('.tab-trigger');
      const tabPanels = document.querySelectorAll('.tab-panel');

      function switchTab(trigger) {
        const targetId = trigger.getAttribute('aria-controls');

        // Remove active state from all triggers
        tabTriggers.forEach(t => {
          t.classList.remove('active');
          t.setAttribute('aria-selected', 'false');
        });

        // Hide all panels
        tabPanels.forEach(p => p.classList.remove('active'));

        // Activate target trigger and panel
        trigger.classList.add('active');
        trigger.setAttribute('aria-selected', 'true');
        const targetPanel = document.getElementById(targetId);
        if (targetPanel) {
          targetPanel.classList.add('active');
        }
      }

      tabTriggers.forEach(trigger => {
        trigger.addEventListener('click', () => {
          switchTab(trigger);

          // Update URL hash without jumping
          const cleanId = trigger.getAttribute('aria-controls').replace('-panel', '');
          history.pushState(null, null, '#' + cleanId);
        });
      });

      // Initialize from URL hash (e.g. products-services.html#osd)
      function initFromHash() {
        const hash = window.location.hash;
        if (hash) {
          const panelId = hash.replace('#', '') + '-panel';
          const trigger = Array.from(tabTriggers).find(t => t.getAttribute('aria-controls') === panelId);
          if (trigger) {
            switchTab(trigger);

            // Scroll slightly to focus on tabs
            window.setTimeout(() => {
              const tabsContainer = document.querySelector('.tabs-container');
              if (tabsContainer) {
                tabsContainer.scrollIntoView({ behavior: 'smooth', block: 'start' });
              }
            }, 100);
          }
        }
      }

      initFromHash();

      // Listen to browser back/forward hash changes
      window.addEventListener('hashchange', initFromHash);
    });
  