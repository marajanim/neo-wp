// Progressive enhancement: the poster remains visible without JavaScript,
// when autoplay is blocked, or when motion/data preferences disable video.
(() => {
  const reducedMotion = window.matchMedia("(prefers-reduced-motion: reduce)");
  const mobile = window.matchMedia("(max-width: 700px)");
  const connection = navigator.connection;

  document.querySelectorAll("[data-hero-video]").forEach((video) => {
    const section = video.closest("section");
    const toggle = section.querySelector(".hero-playback-toggle");
    let visible = !("IntersectionObserver" in window);
    let userPaused = false;
    let failed = false;
    let autoplayBlocked = false;

    video.muted = true;
    video.defaultMuted = true;

    const staticOnly = () => reducedMotion.matches || Boolean(connection?.saveData);

    function showPoster() {
      video.pause();
      if (video.hasAttribute("src")) {
        video.removeAttribute("src");
        video.load();
      }
    }

    function updatePlayback() {
      if (staticOnly() || failed || autoplayBlocked) {
        showPoster();
        return;
      }
      if (!visible || document.hidden || userPaused) {
        video.pause();
        return;
      }
      if (!video.hasAttribute("src")) {
        // Select once per load, so resizing does not download a second encode.
        video.src = mobile.matches ? video.dataset.mobileSrc : video.dataset.desktopSrc;
      }
      video.play()?.catch((error) => {
        // Scrolling away can abort a pending play; that is not a media failure.
        if (error.name === "NotAllowedError") {
          autoplayBlocked = true;
          showPoster();
        } else if (error.name === "NotSupportedError") {
          failed = true;
          showPoster();
        }
      });
    }

    video.addEventListener("error", () => {
      failed = true;
      showPoster();
    });
    document.addEventListener("visibilitychange", updatePlayback);
    window.addEventListener("pagehide", () => video.pause());
    window.addEventListener("pageshow", updatePlayback);
    reducedMotion.addEventListener("change", updatePlayback);
    connection?.addEventListener("change", updatePlayback);

    if (toggle) {
      toggle.addEventListener("click", () => {
        userPaused = !userPaused;
        autoplayBlocked = false;
        toggle.classList.toggle("is-paused", userPaused);
        toggle.setAttribute("aria-pressed", String(userPaused));
        const label = toggle.querySelector(".playback-text");
        if (label) label.textContent = userPaused
          ? "Sequence Paused • Click to Resume"
          : "Live Machine Sequence";
        updatePlayback();
      });
    }

    if ("IntersectionObserver" in window) {
      new IntersectionObserver(([entry]) => {
        visible = entry.isIntersecting;
        updatePlayback();
      }).observe(section);
    }
    updatePlayback();
  });
})();
