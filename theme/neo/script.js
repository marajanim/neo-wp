const cursor = document.querySelector(".cursor");
const cursorRing = document.querySelector(".cursor-ring");
const cursorDot = document.querySelector(".cursor-dot");
const prefersReducedMotion = window.matchMedia("(prefers-reduced-motion: reduce)");

function splitHeroTitle() {
  const title = document.querySelector(".hero-sequence .hero-title");
  if (!title || title.classList.contains("is-split")) {
    return;
  }

  let index = 0;

  function splitNode(node) {
    if (node.nodeType === 3) {
      if (!node.textContent.trim()) {
        node.remove();
        return;
      }

      const fragment = document.createDocumentFragment();
      const compactText = node.textContent.replace(/\s+/g, " ");
      const hasLeadingSpace = /^\s/.test(compactText) && node.previousSibling;
      const hasTrailingSpace = /\s$/.test(compactText) && node.nextSibling;
      const normalizedText = `${hasLeadingSpace ? " " : ""}${compactText.trim()}${
        hasTrailingSpace ? " " : ""
      }`;
      const tokens = normalizedText.split(/(\s+)/);

      for (const token of tokens) {
        if (!token) {
          continue;
        }

        if (!token.trim()) {
          const space = document.createElement("span");
          space.className = "hero-word-space";
          space.setAttribute("aria-hidden", "true");
          fragment.appendChild(space);
          continue;
        }

        const word = document.createElement("span");
        word.className = "hero-word-part";

        for (const char of token) {
          const span = document.createElement("span");
          span.className = "hero-char";
          span.style.setProperty("--char-index", index);
          span.textContent = char;
          word.appendChild(span);
          index += 1;
        }

        fragment.appendChild(word);
      }

      node.replaceWith(fragment);
      return;
    }

    if (node.nodeType !== 1 || node.classList.contains("hero-title-media")) {
      return;
    }

    Array.from(node.childNodes).forEach(splitNode);
  }

  Array.from(title.childNodes).forEach(splitNode);
  title.classList.add("is-split");

  if (!prefersReducedMotion.matches) {
    window.requestAnimationFrame(() => {
      title.classList.add("is-animating");
      window.setTimeout(
        () => title.classList.remove("is-animating"),
        120 + index * 24 + 920,
      );
    });
  }
}

splitHeroTitle();

function initSectionReveals() {
  const revealItems = Array.from(
    document.querySelectorAll("main > section, .site-footer"),
  ).filter((item) => !item.classList.contains("hero-sequence"));

  if (!revealItems.length) {
    return;
  }

  function splitRevealText(element) {
    if (
      element.dataset.revealSplit === "true" ||
      element.classList.contains("no-word-reveal")
    ) {
      return;
    }

    let wordIndex = 0;

    function splitNode(node) {
      if (node.nodeType === 3) {
        if (!node.textContent.trim()) {
          return;
        }

        const fragment = document.createDocumentFragment();
        const tokens = node.textContent.split(/(\s+)/);

        for (const token of tokens) {
          if (!token) {
            continue;
          }

          if (!token.trim()) {
            fragment.appendChild(document.createTextNode(token));
            continue;
          }

          const span = document.createElement("span");
          span.className = "section-word";
          span.style.setProperty("--word-index", wordIndex);
          span.textContent = token;
          fragment.appendChild(span);
          wordIndex += 1;
        }

        node.replaceWith(fragment);
        return;
      }

      if (
        node.nodeType !== 1 ||
        node.classList.contains("section-word") ||
        ["IMG", "SVG", "CANVAS", "SCRIPT", "STYLE"].includes(node.tagName)
      ) {
        return;
      }

      Array.from(node.childNodes).forEach(splitNode);
    }

    Array.from(element.childNodes).forEach(splitNode);
    element.dataset.revealSplit = "true";
  }

  const textSelector = [
    ".eyebrow",
    "h1",
    "h2",
    "h3",
    "p:not(.no-word-reveal)",
    ".button",
    ".hero-button",
    ".text-link:not(.no-word-reveal)",
    ".cta-solutions-link",
    ".system-card",
    ".stats-grid > div > span",
    ".stats-grid strong",
    ".section-proof > span",
    ".solution-tags > span",
    ".partner-card > span",
    ".partner-card strong",
    ".category-stats-item strong",
    ".category-stats-item > span",
    ".sub-category-title > span",
    ".service-card-num",
    ".about-leader-grid > span",
    ".about-capability-list p",
    ".about-principles span",
    ".team-pill",
    ".team-card-copy h3",
    ".team-card-copy p",
    ".team-card-copy a",
    ".team-control",
    ".home-gallery-pill",
    ".home-gallery-filter",
    ".home-gallery-caption-text",
    ".home-gallery-link",
    ".gallery-filter",
    ".gallery-caption",
    ".footer-brand span",
    ".footer-company p",
    ".footer-column h2",
    ".footer-column p",
    ".footer-list a",
    ".footer-bottom p",
    ".footer-legal a",
  ].join(", ");

  const shouldSplitRevealText = !document.body.classList.contains("home-page");

  revealItems.forEach((item) => {
    item.classList.add("section-reveal");
    item.querySelectorAll("h1, h2").forEach((heading) => {
      heading.classList.add("section-display-heading");
    });
    if (shouldSplitRevealText) {
      item.querySelectorAll(textSelector).forEach(splitRevealText);
    }
  });

  const showItem = (item) => item.classList.add("is-visible");

  if (prefersReducedMotion.matches || !("IntersectionObserver" in window)) {
    revealItems.forEach(showItem);
    return;
  }

  const observer = new IntersectionObserver(
    (entries) => {
      entries.forEach((entry) => {
        if (!entry.isIntersecting) {
          return;
        }

        showItem(entry.target);
        observer.unobserve(entry.target);
      });
    },
    {
      rootMargin: "0px 0px -12% 0px",
      threshold: 0.01,
    },
  );

  revealItems.forEach((item) => observer.observe(item));
}

initSectionReveals();

function initTeamCarousel() {
  const section = document.querySelector(".team-section");
  if (!section) {
    return;
  }

  const carousel = section.querySelector(".team-carousel");
  const cards = Array.from(section.querySelectorAll("[data-team-card]"));
  const controls = Array.from(section.querySelectorAll("[data-team-direction]"));
  const currentLabel = section.querySelector("[data-team-current]");
  // Always clear every position, including positions unused by a four-card loop.
  const slotClasses = [
    "team-card-slot-far-left",
    "team-card-slot-left",
    "team-card-slot-center",
    "team-card-slot-right",
    "team-card-slot-far-right",
  ];
  const rotationSlots = cards.length === 4 ? slotClasses.slice(0, 4) : slotClasses;
  let slots = cards.length === 4
    ? [
        "team-card-slot-left",
        "team-card-slot-center",
        "team-card-slot-right",
        "team-card-slot-far-left",
      ]
    : [
        "team-card-slot-left",
        "team-card-slot-center",
        "team-card-slot-right",
        "team-card-slot-far-right",
        "team-card-slot-far-left",
      ];
  let dragStartX = null;
  let dragStartY = null;
  let dragPointerId = null;

  section.classList.add("team-motion");

  function animateActiveCard(card) {
    card.classList.remove("team-card-active");
    window.requestAnimationFrame(() => {
      card.classList.add("team-card-active");
      window.setTimeout(() => card.classList.remove("team-card-active"), 900);
    });
  }

  function applySlots(animate = false) {
    let activeCard = null;
    let activeIndex = 0;

    cards.forEach((card, index) => {
      card.classList.remove(...slotClasses, "team-card-active");
      card.classList.add(slots[index]);
      card.style.setProperty("--team-card-rx", "0deg");
      card.style.setProperty("--team-card-ry", "0deg");
      const isActive = slots[index] === "team-card-slot-center";
      card.setAttribute("aria-hidden", String(!isActive));
      card.querySelectorAll("a, button").forEach((interactive) => {
        interactive.tabIndex = isActive ? 0 : -1;
      });

      if (slots[index] === "team-card-slot-center") {
        activeCard = card;
        activeIndex = index;
      }
    });

    if (currentLabel) {
      currentLabel.textContent = String(activeIndex + 1).padStart(2, "0");
    }
    section.style.setProperty("--team-progress", (activeIndex + 1) / cards.length);

    if (animate && activeCard && !prefersReducedMotion.matches) {
      animateActiveCard(activeCard);
    }
  }

  function shiftSlots(direction) {
    slots = slots.map((slot) => {
      const currentIndex = rotationSlots.indexOf(slot);
      return direction > 0
        ? rotationSlots[(currentIndex - 1 + rotationSlots.length) % rotationSlots.length]
        : rotationSlots[(currentIndex + 1) % rotationSlots.length];
    });
  }

  function renderCards(direction) {
    shiftSlots(direction);
    applySlots(true);
  }

  applySlots();

  controls.forEach((control) => {
    control.addEventListener("click", () => {
      renderCards(Number(control.dataset.teamDirection || 1));
    });
  });

  if (!carousel) {
    return;
  }

  carousel.tabIndex = 0;
  carousel.setAttribute("aria-label", "Team groups carousel. Use arrow keys or drag to explore.");

  carousel.querySelectorAll("img").forEach((image) => {
    image.draggable = false;
  });

  carousel.addEventListener("keydown", (event) => {
    if (event.key === "ArrowLeft" || event.key === "ArrowRight") {
      event.preventDefault();
      renderCards(event.key === "ArrowRight" ? 1 : -1);
    }
  });

  carousel.addEventListener("pointerdown", (event) => {
    if (!event.isPrimary || event.button !== 0 || event.target.closest("a, button")) {
      return;
    }

    dragStartX = event.clientX;
    dragStartY = event.clientY;
    dragPointerId = event.pointerId;
    carousel.classList.add("is-dragging");
    carousel.setPointerCapture?.(event.pointerId);
  });

  function finishDrag(event, cancelled = false) {
    if (dragStartX === null || event.pointerId !== dragPointerId) {
      return;
    }

    const distance = event.clientX - dragStartX;
    const verticalDistance = event.clientY - dragStartY;
    dragStartX = null;
    dragStartY = null;
    dragPointerId = null;
    carousel.classList.remove("is-dragging");

    if (carousel.hasPointerCapture?.(event.pointerId)) {
      carousel.releasePointerCapture(event.pointerId);
    }

    if (!cancelled && Math.abs(distance) > 46 && Math.abs(distance) > Math.abs(verticalDistance)) {
      renderCards(distance < 0 ? 1 : -1);
    }
  }

  carousel.addEventListener("pointerup", finishDrag);
  carousel.addEventListener("pointercancel", (event) => finishDrag(event, true));
  carousel.addEventListener("lostpointercapture", (event) => finishDrag(event, true));

  const supportsDepth =
    window.matchMedia("(hover: hover) and (pointer: fine)").matches &&
    !prefersReducedMotion.matches;

  if (!supportsDepth) {
    return;
  }

  carousel.addEventListener("pointermove", (event) => {
    const activeCard = event.target.closest(".team-card-slot-center");
    if (!activeCard || dragStartX !== null) {
      return;
    }

    const bounds = activeCard.getBoundingClientRect();
    const x = (event.clientX - bounds.left) / bounds.width - 0.5;
    const y = (event.clientY - bounds.top) / bounds.height - 0.5;
    activeCard.style.setProperty("--team-card-rx", `${-y * 4}deg`);
    activeCard.style.setProperty("--team-card-ry", `${x * 5}deg`);
  });

  carousel.addEventListener("pointerout", (event) => {
    const activeCard = event.target.closest(".team-card-slot-center");
    if (!activeCard || activeCard.contains(event.relatedTarget)) {
      return;
    }

    activeCard.style.setProperty("--team-card-rx", "0deg");
    activeCard.style.setProperty("--team-card-ry", "0deg");
  });
}

initTeamCarousel();

function initServicesExperience() {
  const section = document.querySelector(".services-experience");
  if (!section) {
    return;
  }

  section.classList.add("services-motion");

  const supportsImageMotion =
    window.matchMedia("(hover: hover) and (pointer: fine)").matches &&
    !prefersReducedMotion.matches;

  if (!supportsImageMotion) {
    return;
  }

  section.querySelectorAll(".home-service-card").forEach((card) => {
    card.addEventListener("pointermove", (event) => {
      const bounds = card.getBoundingClientRect();
      const x = (event.clientX - bounds.left) / bounds.width - 0.5;
      const y = (event.clientY - bounds.top) / bounds.height - 0.5;
      card.style.setProperty("--service-image-x", `${-x * 7}px`);
      card.style.setProperty("--service-image-y", `${-y * 7}px`);
    });

    card.addEventListener("pointerleave", () => {
      card.style.setProperty("--service-image-x", "0px");
      card.style.setProperty("--service-image-y", "0px");
    });
  });
}

initServicesExperience();

function initHomeGallery() {
  const section = document.querySelector(".home-gallery-section");
  if (!section) {
    return;
  }

  const filters = Array.from(section.querySelectorAll(".home-gallery-filter"));
  const images = Array.from(section.querySelectorAll("[data-home-gallery-slot]"));
  const captions = Array.from(section.querySelectorAll("[data-home-gallery-caption]"));

  const sets = {
    all: [
      {
        src: window.neoAssetBase + "assets/gallery/seminars/technical-seminar-attendees.jpg",
        alt: "Technical seminar with pharmaceutical industry attendees",
        caption: "Technical seminar",
        width: 5395,
        height: 3597,
      },
      {
        src: window.neoAssetBase + "assets/gallery/exhibitions/ape-2025-team-booth.jpg",
        alt: "APE 2025 exhibition team photo",
        caption: "APE 2025",
        width: 5760,
        height: 3840,
      },
      {
        src: window.neoAssetBase + "assets/gallery/seminars/tofflon-industry-seminar.jpg",
        alt: "Tofflon seminar hosted with industry guests",
        caption: "Tofflon seminar",
        width: 5472,
        height: 3648,
      },
      {
        src: window.neoAssetBase + "assets/gallery/fat/fat-equipment-staging.jpg",
        alt: "Factory acceptance test equipment area",
        caption: "FAT equipment",
        width: 3048,
        height: 1584,
      },
      {
        src: window.neoAssetBase + "assets/gallery/service/field-service-activity.jpg",
      alt: "Neo Associates service activity",
      caption: "Service",
        width: 4000,
        height: 3000,
      },
    ],
    exhibitions: [
      {
        src: window.neoAssetBase + "assets/gallery/exhibitions/ape-2025-team-booth.jpg",
        alt: "APE 2025 exhibition team photo",
        caption: "APE 2025",
        width: 5760,
        height: 3840,
      },
      {
        src: window.neoAssetBase + "assets/gallery/exhibitions/ape-2023-exhibition.jpg",
        alt: "APE 2023 exhibition",
        caption: "APE 2023",
        width: 2976,
        height: 1984,
      },
      {
        src: window.neoAssetBase + "assets/gallery/exhibitions/ape-2022-exhibition.jpg",
        alt: "APE 2022 exhibition",
        caption: "APE 2022",
        width: 4032,
        height: 3024,
      },
      {
        src: window.neoAssetBase + "assets/gallery/exhibitions/ape-2020-exhibition.jpg",
        alt: "APE 2020 exhibition",
        caption: "APE 2020",
        width: 6000,
        height: 4000,
      },
      {
        src: window.neoAssetBase + "assets/gallery/exhibitions/ape-2019-exhibition-team.jpg",
        alt: "APE 2019 exhibition team",
        caption: "APE 2019",
        width: 6000,
        height: 4000,
      },
    ],
    seminars: [
      {
        src: window.neoAssetBase + "assets/gallery/seminars/technical-seminar-attendees.jpg",
        alt: "Technical seminar with pharmaceutical industry attendees",
        caption: "Technical seminar",
        width: 5395,
        height: 3597,
      },
      {
        src: window.neoAssetBase + "assets/gallery/seminars/marchesini-seminar.jpg",
        alt: "Marchesini seminar with Neo Associates and industry partners",
        caption: "Marchesini seminar",
        width: 1600,
        height: 1015,
      },
      {
        src: window.neoAssetBase + "assets/gallery/seminars/dr-pharmaceutical-seminar.jpg",
        alt: "DR seminar for pharmaceutical professionals",
        caption: "DR seminar",
        width: 5320,
        height: 3560,
      },
      {
        src: window.neoAssetBase + "assets/gallery/seminars/tofflon-industry-seminar.jpg",
        alt: "Tofflon seminar hosted with industry guests",
        caption: "Tofflon seminar",
        width: 5472,
        height: 3648,
      },
      {
        src: window.neoAssetBase + "assets/gallery/team/technical-event-audience.jpg",
        alt: "Audience at a technical event",
        caption: "Technical event",
        width: 5472,
        height: 3648,
      },
    ],
    fat: [
      {
        src: window.neoAssetBase + "assets/gallery/fat/fat-equipment-staging.jpg",
        alt: "Factory acceptance test equipment area",
        caption: "FAT equipment",
        width: 3048,
        height: 1584,
      },
      {
        src: window.neoAssetBase + "assets/gallery/fat/fat-delegation-group.jpg",
        alt: "Factory acceptance test group moment",
        caption: "FAT group",
        width: 3244,
        height: 2057,
      },
      {
        src: window.neoAssetBase + "assets/gallery/fat/fat-documentation-review.jpg",
        alt: "FAT documentation and review",
        caption: "FAT review",
        width: 2653,
        height: 1868,
      },
      {
        src: window.neoAssetBase + "assets/gallery/fat/fat-technical-inspection.jpg",
        alt: "FAT technical inspection",
        caption: "FAT inspection",
        width: 828,
        height: 559,
      },
      {
        src: window.neoAssetBase + "assets/gallery/fat/fat-facility-visit.jpg",
        alt: "Factory acceptance test visit",
        caption: "FAT visit",
        width: 828,
        height: 621,
      },
    ],
    service: [
      {
        src: window.neoAssetBase + "assets/gallery/service/field-service-activity.jpg",
      alt: "Neo Associates service activity",
      caption: "Service",
        width: 4000,
        height: 3000,
      },
      {
        src: window.neoAssetBase + "assets/gallery/service/technical-service-support.jpg",
        alt: "Technical service support",
        caption: "Service support",
        width: 4000,
        height: 3000,
      },
      {
        src: window.neoAssetBase + "assets/gallery/service/technical-training-discussion.jpg",
        alt: "Training and technical discussion",
        caption: "Training",
        width: 3461,
        height: 2596,
      },
      {
        src: window.neoAssetBase + "assets/gallery/service/office-project-coordination.jpg",
        alt: "Office and project coordination",
        caption: "Office coordination",
        width: 3648,
        height: 2736,
      },
      {
        src: window.neoAssetBase + "assets/gallery/team/service-engineering-field.jpg",
        alt: "Project team moment in 2023",
        caption: "Project team",
        width: 4000,
        height: 3000,
      },
    ],
  };

  function showSet(key) {
    const activeSet = sets[key] || sets.all;
    section.classList.add("is-switching");
    images.forEach((image, index) => {
      const item = activeSet[index];
      if (!item) {
        return;
      }

      image.style.opacity = "0";
      window.setTimeout(() => {
        setResponsivePhoto(image, item.src);
        image.alt = item.alt;
        image.width = item.width;
        image.height = item.height;
        if (captions[index]) {
          captions[index].textContent = item.caption;
        }
        image.style.opacity = "1";
        const tile = image.closest(".home-gallery-tile");
        tile?.classList.add("is-refreshed");
        window.setTimeout(() => tile?.classList.remove("is-refreshed"), 520);
      }, 90 + index * 45);
    });
    window.setTimeout(() => section.classList.remove("is-switching"), 520);
  }

  filters.forEach((filter) => {
    filter.addEventListener("click", () => {
      const key = filter.dataset.homeFilter;
      filters.forEach((item) => {
        const isActive = item === filter;
        item.classList.toggle("active", isActive);
        item.setAttribute("aria-pressed", String(isActive));
      });
      showSet(key);
    });
  });

  const tiles = Array.from(section.querySelectorAll(".home-gallery-tile"));
  tiles.forEach((tile, index) => {
    tile.style.setProperty("--gallery-delay", `${index * 70}ms`);
    tile.addEventListener("pointermove", (event) => {
      if (window.matchMedia("(prefers-reduced-motion: reduce)").matches) return;
      const rect = tile.getBoundingClientRect();
      const x = ((event.clientX - rect.left) / rect.width - 0.5) * 10;
      const y = ((event.clientY - rect.top) / rect.height - 0.5) * 10;
      tile.style.setProperty("--gallery-x", `${x}px`);
      tile.style.setProperty("--gallery-y", `${y}px`);
    });
    tile.addEventListener("pointerleave", () => {
      tile.style.setProperty("--gallery-x", "0px");
      tile.style.setProperty("--gallery-y", "0px");
    });
  });
}

initHomeGallery();

function initGalleryPage() {
  const galleryItems = Array.from(document.querySelectorAll(".gallery-item"));
  const filters = Array.from(document.querySelectorAll(".gallery-filter"));
  const lightbox = document.querySelector(".gallery-lightbox");

  if (!galleryItems.length || !lightbox) {
    return;
  }

  const previewButtons = galleryItems
    .map((item) => item.querySelector("[data-gallery-image]"))
    .filter(Boolean);
  const lightboxImage = lightbox.querySelector(".gallery-lightbox-panel img");
  const lightboxCaption = lightbox.querySelector(".gallery-lightbox-panel figcaption");
  const closeButtons = lightbox.querySelectorAll(
    ".gallery-lightbox-close, .gallery-lightbox-backdrop",
  );
  const prevButton = lightbox.querySelector(".gallery-lightbox-prev");
  const nextButton = lightbox.querySelector(".gallery-lightbox-next");
  let activeButton = null;
  let activeIndex = 0;

  function visibleButtons() {
    return previewButtons.filter((button) => !button.closest(".gallery-item").hidden);
  }

  function openPreview(button) {
    const buttons = visibleButtons();
    activeIndex = Math.max(buttons.indexOf(button), 0);
    activeButton = button;
    lightboxImage.src = button.dataset.galleryImage;
    lightboxImage.alt = button.querySelector("img")?.alt || "";
    lightboxCaption.textContent = button.dataset.galleryCaption || "";
    lightbox.setAttribute("aria-hidden", "false");
    document.body.classList.add("gallery-lightbox-open");
  }

  function closePreview() {
    lightbox.setAttribute("aria-hidden", "true");
    document.body.classList.remove("gallery-lightbox-open");
    lightboxImage.removeAttribute("src");
    if (activeButton) {
      activeButton.focus();
    }
  }

  function showRelativeImage(direction) {
    const buttons = visibleButtons();
    if (!buttons.length) {
      return;
    }

    activeIndex = (activeIndex + direction + buttons.length) % buttons.length;
    openPreview(buttons[activeIndex]);
  }

  const statusIndicator = document.getElementById("gallery-active-status");

  function updateStatusCount(category, label) {
    if (!statusIndicator) return;
    const count = galleryItems.filter(
      (item) => category === "all" || item.dataset.category === category,
    ).length;
    if (category === "all") {
      statusIndicator.textContent = `Showing all ${count} moments`;
    } else {
      statusIndicator.textContent = `Showing ${count} ${label} moments`;
    }
  }

  function applyFilter(targetFilter) {
    const category = targetFilter.dataset.filter;
    const label = targetFilter.querySelector("span")?.textContent?.trim() || category;
    filters.forEach((item) => {
      const isActive = item === targetFilter;
      item.classList.toggle("active", isActive);
      item.setAttribute("aria-pressed", String(isActive));
    });
    galleryItems.forEach((item) => {
      item.hidden = category !== "all" && item.dataset.category !== category;
    });
    updateStatusCount(category, label);
  }

  filters.forEach((filter) => {
    filter.addEventListener("click", () => applyFilter(filter));
  });

  // URL query parameter support (e.g. ?category=seminars or ?filter=fat)
  const urlParams = new URLSearchParams(window.location.search);
  const initialCategory = urlParams.get("category") || urlParams.get("filter");
  if (initialCategory) {
    const matchingFilter = filters.find((f) => f.dataset.filter === initialCategory.toLowerCase());
    if (matchingFilter) {
      applyFilter(matchingFilter);
    }
  }

  previewButtons.forEach((button) => {
    button.addEventListener("click", () => openPreview(button));
  });

  closeButtons.forEach((button) => button.addEventListener("click", closePreview));
  prevButton?.addEventListener("click", () => showRelativeImage(-1));
  nextButton?.addEventListener("click", () => showRelativeImage(1));

  document.addEventListener("keydown", (event) => {
    if (lightbox.getAttribute("aria-hidden") === "true") {
      return;
    }

    if (event.key === "Escape") {
      closePreview();
    } else if (event.key === "ArrowLeft") {
      showRelativeImage(-1);
    } else if (event.key === "ArrowRight") {
      showRelativeImage(1);
    }
  });
}

initGalleryPage();

function initIntroExperience() {
  const section = document.querySelector(".intro-experience");
  if (!section) {
    return;
  }

  section.classList.add("intro-motion");

  const counters = Array.from(section.querySelectorAll("[data-count]"));
  let countersStarted = false;

  function animateCounters() {
    if (countersStarted) {
      return;
    }

    countersStarted = true;

    if (prefersReducedMotion.matches) {
      counters.forEach((counter) => {
        counter.textContent = `${counter.dataset.count || 0}${counter.dataset.suffix || ""}`;
      });
      return;
    }

    counters.forEach((counter) => {
      const target = Number(counter.dataset.count || 0);
      const suffix = counter.dataset.suffix || "";
      const duration = 1400;
      const start = performance.now();

      function update(now) {
        const progress = Math.min((now - start) / duration, 1);
        const eased = 1 - Math.pow(1 - progress, 3);
        counter.textContent = `${Math.round(target * eased)}${suffix}`;

        if (progress < 1) {
          window.requestAnimationFrame(update);
        }
      }

      window.requestAnimationFrame(update);
    });
  }

  if (prefersReducedMotion.matches || !("IntersectionObserver" in window)) {
    animateCounters();
  } else {
    counters.forEach((counter) => {
      counter.textContent = `0${counter.dataset.suffix || ""}`;
    });

    const counterObserver = new IntersectionObserver(
      (entries) => {
        if (entries.some((entry) => entry.isIntersecting)) {
          animateCounters();
          counterObserver.disconnect();
        }
      },
      { threshold: 0.24 },
    );
    counterObserver.observe(section);
  }

  const figure = section.querySelector("[data-intro-tilt]");
  const supportsTilt =
    figure &&
    window.matchMedia("(hover: hover) and (pointer: fine)").matches &&
    !prefersReducedMotion.matches;

  if (!supportsTilt) {
    return;
  }

  figure.addEventListener("pointermove", (event) => {
    const bounds = figure.getBoundingClientRect();
    const x = (event.clientX - bounds.left) / bounds.width - 0.5;
    const y = (event.clientY - bounds.top) / bounds.height - 0.5;
    figure.style.setProperty("--tilt-x", `${-y * 4.5}deg`);
    figure.style.setProperty("--tilt-y", `${x * 5.5}deg`);
    figure.style.setProperty("--image-x", `${-x * 8}px`);
    figure.style.setProperty("--image-y", `${-y * 8}px`);
  });

  figure.addEventListener("pointerleave", () => {
    figure.style.setProperty("--tilt-x", "0deg");
    figure.style.setProperty("--tilt-y", "0deg");
    figure.style.setProperty("--image-x", "0px");
    figure.style.setProperty("--image-y", "0px");
  });
}

initIntroExperience();

function initCursor() {
  const supportsCursor =
    cursor &&
    cursorRing &&
    cursorDot &&
    window.matchMedia("(hover: hover) and (pointer: fine)").matches &&
    !prefersReducedMotion.matches;

  if (!supportsCursor) {
    return;
  }

  const syringeFixedRotation = 1.2;
  const syringeStart = { x: 7.5, y: 78 };
  const interactiveSelector = "a, button, .button, .text-link, [role='button']";

  document.body.classList.add("cursor-ready", "cursor-hidden");

  function setCursorCoordinates(x, y) {
    cursorRing.style.transform = `translate3d(${x}px, ${y}px, 0) rotate(${syringeFixedRotation}rad) translate(-${syringeStart.x}%, -${syringeStart.y}%)`;
    cursorDot.style.transform = `translate3d(${x}px, ${y}px, 0) translate(-50%, -50%)`;
  }

  window.addEventListener(
    "pointermove",
    (event) => {
      setCursorCoordinates(event.clientX, event.clientY);
      document.body.classList.remove("cursor-hidden");
    },
    { passive: true },
  );

  document.addEventListener("pointerover", (event) => {
    if (event.target.closest(interactiveSelector)) {
      document.body.classList.add("cursor-hover");
    }
  });

  document.addEventListener("pointerout", (event) => {
    if (event.target.closest(interactiveSelector)) {
      document.body.classList.remove("cursor-hover");
    }
  });

  document.addEventListener("pointerdown", () => {
    document.body.classList.add("cursor-pressed");
  });

  document.addEventListener("pointerup", () => {
    document.body.classList.remove("cursor-pressed");
  });

  document.addEventListener("mouseleave", () => {
    document.body.classList.add("cursor-hidden");
  });

  document.addEventListener("mouseenter", () => {
    document.body.classList.remove("cursor-hidden");
  });
}

function initNavDropdowns() {
  const dropdowns = document.querySelectorAll(".nav-dropdown");

  if (!dropdowns.length) {
    return;
  }

  function closeDropdown(dropdown) {
    dropdown.classList.remove("is-open");
    dropdown.querySelector(".nav-dropdown-toggle")?.setAttribute("aria-expanded", "false");
  }

  function closeAll(exceptDropdown = null) {
    dropdowns.forEach((dropdown) => {
      if (dropdown !== exceptDropdown) {
        closeDropdown(dropdown);
      }
    });
  }

  dropdowns.forEach((dropdown) => {
    const toggle = dropdown.querySelector(".nav-dropdown-toggle");

    if (!toggle) {
      return;
    }

    toggle.addEventListener("click", (event) => {
      event.preventDefault();
      const willOpen = !dropdown.classList.contains("is-open");
      closeAll(dropdown);
      dropdown.classList.toggle("is-open", willOpen);
      toggle.setAttribute("aria-expanded", String(willOpen));
    });
  });

  document.addEventListener("click", (event) => {
    if (!event.target.closest(".nav-dropdown")) {
      closeAll();
    }
  });

  document.addEventListener("keydown", (event) => {
    if (event.key === "Escape") {
      closeAll();
    }
  });
}

function initMobileNavigation() {
  const header = document.querySelector(".site-header");
  const toggle = header?.querySelector(".nav-menu-toggle");
  const menu = header?.querySelector(".nav-links");

  if (!header || !toggle || !menu) {
    return;
  }

  function setMenu(open) {
    header.classList.toggle("is-menu-open", open);
    document.documentElement.classList.toggle("nav-menu-lock", open);
    toggle.setAttribute("aria-expanded", String(open));
    toggle.setAttribute("aria-label", open ? "Close navigation menu" : "Open navigation menu");
  }

  toggle.addEventListener("click", () => {
    setMenu(!header.classList.contains("is-menu-open"));
  });

  menu.addEventListener("click", (event) => {
    if (event.target.closest("a")) {
      setMenu(false);
    }
  });

  document.addEventListener("click", (event) => {
    if (!header.contains(event.target)) {
      setMenu(false);
    }
  });

  document.addEventListener("keydown", (event) => {
    if (event.key === "Escape" && header.classList.contains("is-menu-open")) {
      setMenu(false);
      toggle.focus();
    }
  });

  const desktopQuery = window.matchMedia("(min-width: 981px)");
  desktopQuery.addEventListener?.("change", (event) => {
    if (event.matches) {
      setMenu(false);
    }
  });
}


function initAwwwardsNavigation() {
  const header = document.querySelector(".site-header");
  const menu = header?.querySelector(".nav-links");

  if (!header || !menu) {
    return;
  }

  const contactCta = header.querySelector(".nav-cta");
  if (contactCta && !menu.querySelector(".nav-mobile-contact")) {
    const mobileContact = document.createElement("a");
    mobileContact.className = "nav-mobile-contact";
    mobileContact.href = contactCta.href;
    mobileContact.textContent = contactCta.textContent.trim();
    if (contactCta.classList.contains("active-page")) {
      mobileContact.classList.add("active-page");
    }
    menu.append(mobileContact);
  }

  const links = Array.from(menu.querySelectorAll(":scope > a"));
  const activeLink = links.find(
    (link) => link.classList.contains("active-page") && !link.classList.contains("nav-mobile-contact")
  );
  const indicator = document.createElement("span");
  const scrim = document.createElement("span");
  let scrollFrame = 0;

  indicator.className = "nav-active-indicator";
  indicator.setAttribute("aria-hidden", "true");
  menu.prepend(indicator);

  scrim.className = "nav-scrim";
  scrim.setAttribute("aria-hidden", "true");
  header.insertAdjacentElement("afterend", scrim);

  links.forEach((link, index) => {
    link.dataset.navIndex = String(index + 1).padStart(2, "0");
  });

  function positionIndicator(link = activeLink) {
    if (!link || window.matchMedia("(max-width: 980px)").matches) {
      indicator.style.opacity = "0";
      return;
    }

    indicator.style.setProperty("--indicator-x", `${link.offsetLeft}px`);
    indicator.style.setProperty("--indicator-width", `${link.offsetWidth}px`);
    indicator.style.opacity = "1";
  }

  links.forEach((link) => {
    link.addEventListener("pointerenter", () => positionIndicator(link));
    link.addEventListener("focus", () => positionIndicator(link));
  });

  menu.addEventListener("pointerleave", () => positionIndicator());
  menu.addEventListener("focusout", (event) => {
    if (!menu.contains(event.relatedTarget)) {
      positionIndicator();
    }
  });

  function updateScrollState() {
    scrollFrame = 0;
    const scrollable = Math.max(document.documentElement.scrollHeight - window.innerHeight, 1);
    const progress = Math.min(Math.max(window.scrollY / scrollable, 0), 1);
    header.style.setProperty("--nav-progress", `${progress * 100}%`);
    header.classList.toggle("is-scrolled", window.scrollY > 24);
  }

  window.addEventListener(
    "scroll",
    () => {
      if (!scrollFrame) {
        scrollFrame = window.requestAnimationFrame(updateScrollState);
      }
    },
    { passive: true }
  );

  window.addEventListener("resize", () => positionIndicator(), { passive: true });
  scrim.addEventListener("click", () => header.querySelector(".nav-menu-toggle")?.click());

  if ("ResizeObserver" in window) {
    const navResizeObserver = new ResizeObserver(() => positionIndicator());
    navResizeObserver.observe(menu);
  }

  header.classList.add("nav-enhanced");
  window.requestAnimationFrame(() => {
    header.classList.add("nav-ready");
    positionIndicator();
    updateScrollState();
  });
}


function initEditorialFooter() {
  const footer = document.querySelector(".site-footer");
  const footerGrid = footer?.querySelector(".footer-grid");
  const footerBottom = footer?.querySelector(".footer-bottom");

  if (!footer || !footerGrid || !footerBottom || footer.classList.contains("footer-experience")) {
    return;
  }

  footer.classList.add("footer-experience");


  footer.querySelectorAll(".footer-column").forEach((column, index) => {
    column.dataset.footerIndex = String(index + 1).padStart(2, "0");
  });

  const status = document.createElement("div");
  status.className = "footer-status no-word-reveal";
  status.innerHTML = "<span aria-hidden=\"true\"></span><strong>Dhaka, Bangladesh</strong>";
  footer.querySelector(".footer-company")?.append(status);

  const backToTop = document.createElement("a");
  backToTop.className = "footer-return no-word-reveal";
  backToTop.href = "#top";
  backToTop.setAttribute("aria-label", "Back to the top of the page");
  backToTop.innerHTML = "<span>Back to top</span><span class=\"footer-return-icon\" aria-hidden=\"true\">\u2191</span>";
  footer.insertBefore(backToTop, footerBottom);

  if (window.matchMedia("(hover: hover) and (pointer: fine)").matches && !prefersReducedMotion.matches) {
    footer.addEventListener(
      "pointermove",
      (event) => {
        const rect = footer.getBoundingClientRect();
        footer.style.setProperty("--footer-x", event.clientX - rect.left + "px");
        footer.style.setProperty("--footer-y", event.clientY - rect.top + "px");
      },
      { passive: true }
    );
  }
}


function initProductsEditorial() {
  const section = document.querySelector(".products-content-section");
  if (!section) {
    return;
  }

  const panels = Array.from(section.querySelectorAll(".tab-panel"));
  const triggers = Array.from(section.querySelectorAll(".tab-trigger"));
  let sectionVisible = false;

  section.classList.add("products-editorial");

  panels.forEach((panel, panelIndex) => {
    panel.dataset.productIndex = String(panelIndex + 1).padStart(2, "0");

    panel.querySelectorAll(".specs-table").forEach((table) => {
      const labels = Array.from(
        table.querySelectorAll("thead th"),
        (heading) => heading.textContent.trim()
      );

      table.querySelectorAll("tbody tr").forEach((row, rowIndex) => {
        row.style.setProperty("--product-row-index", rowIndex);
        row.querySelectorAll("td").forEach((cell, cellIndex) => {
          cell.dataset.specLabel = labels[cellIndex] || "Specification";
        });
      });
    });

    panel.querySelectorAll(".sub-category-block").forEach((block, index) => {
      block.style.setProperty("--product-block-index", index);
    });

    panel.querySelectorAll(".service-flow-card").forEach((card, index) => {
      card.style.setProperty("--service-flow-index", index);
    });
  });

  function revealActivePanel() {
    if (!sectionVisible) {
      return;
    }

    panels.forEach((panel) => panel.classList.remove("is-product-revealed"));
    const activePanel = panels.find((panel) => panel.classList.contains("active"));

    if (activePanel) {
      window.requestAnimationFrame(() => {
        window.requestAnimationFrame(() => activePanel.classList.add("is-product-revealed"));
      });
    }
  }

  triggers.forEach((trigger, index) => {
    trigger.addEventListener("click", () => window.requestAnimationFrame(revealActivePanel));
    trigger.addEventListener("keydown", (event) => {
      if (!["ArrowLeft", "ArrowRight", "Home", "End"].includes(event.key)) {
        return;
      }

      event.preventDefault();
      let nextIndex = index;
      if (event.key === "ArrowLeft") nextIndex = (index - 1 + triggers.length) % triggers.length;
      if (event.key === "ArrowRight") nextIndex = (index + 1) % triggers.length;
      if (event.key === "Home") nextIndex = 0;
      if (event.key === "End") nextIndex = triggers.length - 1;
      triggers[nextIndex].focus();
      triggers[nextIndex].click();
    });
  });

  window.addEventListener("hashchange", () => window.requestAnimationFrame(revealActivePanel));

  if (prefersReducedMotion.matches || !("IntersectionObserver" in window)) {
    sectionVisible = true;
    section.classList.add("is-products-visible");
    panels.forEach((panel) => panel.classList.add("is-product-revealed"));
    return;
  }

  const observer = new IntersectionObserver(
    (entries) => {
      if (entries.some((entry) => entry.isIntersecting)) {
        sectionVisible = true;
        section.classList.add("is-products-visible");
        revealActivePanel();
        observer.disconnect();
      }
    },
    { threshold: 0.05, rootMargin: "0px 0px -8% 0px" }
  );
  observer.observe(section);
}

function initAchievementSection() {
  const section = document.querySelector(".achievement-section");
  if (!section) {
    return;
  }

  const cards = section.querySelectorAll(".achievement-card");
  const counters = section.querySelectorAll(".achievement-num");
  let hasAnimatedCounters = false;

  // 1. Intersection Observer for Scroll Entrance & Stagger Reveal
  const observer = new IntersectionObserver(
    (entries, obs) => {
      entries.forEach((entry) => {
        if (entry.isIntersecting) {
          section.classList.add("is-visible");
          if (!hasAnimatedCounters) {
            hasAnimatedCounters = true;
            animateCounters();
          }
          obs.unobserve(section);
        }
      });
    },
    { threshold: 0.16, rootMargin: "0px 0px -40px 0px" }
  );
  observer.observe(section);

  // 2. Kinetic Smooth Counter Animation
  function animateCounters() {
    if (prefersReducedMotion.matches) {
      counters.forEach((el) => {
        el.textContent = el.dataset.count || "0";
      });
      return;
    }

    counters.forEach((counter, idx) => {
      const target = parseInt(counter.dataset.count, 10) || 0;
      const duration = 1500;
      const startDelay = idx * 60;
      let startTime = null;

      function updateCounter(currentTime) {
        if (!startTime) {
          startTime = currentTime;
        }
        const elapsed = currentTime - startTime - startDelay;

        if (elapsed < 0) {
          window.requestAnimationFrame(updateCounter);
          return;
        }

        const progress = Math.min(Math.max(elapsed / duration, 0), 1);
        // High-end smooth easeOutExpo curve
        const ease = progress === 1 ? 1 : 1 - Math.pow(2, -10 * progress);
        const currentVal = Math.round(ease * target);

        counter.textContent = currentVal;

        if (progress < 1) {
          window.requestAnimationFrame(updateCounter);
        } else {
          counter.textContent = target;
        }
      }

      window.requestAnimationFrame(updateCounter);
    });
  }

  // 3. Interactive Mouse Spotlight & 3D Tilt Physics
  const canHover =
    !document.body.classList.contains("home-page") &&
    window.matchMedia("(hover: hover) and (pointer: fine)").matches;
  if (canHover && !prefersReducedMotion.matches) {
    cards.forEach((card) => {
      let bounds = null;

      function handlePointerMove(e) {
        if (!bounds) {
          bounds = card.getBoundingClientRect();
        }
        const x = e.clientX - bounds.left;
        const y = e.clientY - bounds.top;

        card.style.setProperty("--mouse-x", `${x}px`);
        card.style.setProperty("--mouse-y", `${y}px`);

        // Subtle 3D tilt calculation (-4 to 4 degrees)
        const normX = (x / bounds.width - 0.5) * 2;
        const normY = (y / bounds.height - 0.5) * 2;
        const tiltX = -normY * 4.5;
        const tiltY = normX * 4.5;

        card.style.transform = `perspective(800px) rotateX(${tiltX.toFixed(2)}deg) rotateY(${tiltY.toFixed(2)}deg) translateY(-6px)`;
      }

      function handlePointerLeave() {
        bounds = null;
        card.style.transform = "";
        card.style.removeProperty("--mouse-x");
        card.style.removeProperty("--mouse-y");
      }

      card.addEventListener(
        "pointerenter",
        () => {
          bounds = card.getBoundingClientRect();
        },
        { passive: true }
      );

      card.addEventListener("pointermove", handlePointerMove, { passive: true });
      card.addEventListener("pointerleave", handlePointerLeave, { passive: true });
    });
  }
}

function initAssociateSection() {
  const section = document.querySelector(".associate-marquee-section");
  if (!section) {
    return;
  }

  // 1. Scroll-triggered entrance
  const observer = new IntersectionObserver(
    (entries, obs) => {
      entries.forEach((entry) => {
        if (entry.isIntersecting) {
          section.classList.add("is-visible");
          obs.unobserve(section);
        }
      });
    },
    { threshold: 0.12, rootMargin: "0px 0px -30px 0px" }
  );
  observer.observe(section);

  // 2. Interactive Spotlight on Hover for Associate Cards
  const canHover = window.matchMedia("(hover: hover) and (pointer: fine)").matches;
  if (canHover && !prefersReducedMotion.matches) {
    const cards = section.querySelectorAll(".associate-card");
    cards.forEach((card) => {
      let bounds = null;

      card.addEventListener(
        "pointerenter",
        () => {
          bounds = card.getBoundingClientRect();
        },
        { passive: true }
      );

      card.addEventListener(
        "pointermove",
        (e) => {
          if (!bounds) {
            bounds = card.getBoundingClientRect();
          }
          const x = e.clientX - bounds.left;
          const y = e.clientY - bounds.top;
          card.style.setProperty("--mouse-x", `${x}px`);
          card.style.setProperty("--mouse-y", `${y}px`);
        },
        { passive: true }
      );

      card.addEventListener(
        "pointerleave",
        () => {
          bounds = null;
          card.style.removeProperty("--mouse-x");
          card.style.removeProperty("--mouse-y");
        },
        { passive: true }
      );
    });
  }
}

function initHeroExperience() {
  const heroSection = document.querySelector(".hero-sequence");
  if (!heroSection) {
    return;
  }

  // 1. Dynamic Interactive Spotlight & Subtle 3D Parallax Tracking
  const canHover =
    !document.body.classList.contains("home-page") &&
    window.matchMedia("(hover: hover) and (pointer: fine)").matches;
  const floatLeft = heroSection.querySelector(".hero-float-left");
  const floatRight = heroSection.querySelector(".hero-float-right");
  const capsuleToken = heroSection.querySelector(".hero-title-media");

  if (canHover && !prefersReducedMotion.matches) {
    heroSection.addEventListener(
      "pointermove",
      (e) => {
        const rect = heroSection.getBoundingClientRect();
        const x = ((e.clientX - rect.left) / rect.width) * 100;
        const y = ((e.clientY - rect.top) / rect.height) * 100;

        heroSection.style.setProperty("--hero-spot-x", `${x.toFixed(1)}%`);
        heroSection.style.setProperty("--hero-spot-y", `${y.toFixed(1)}%`);

        const normX = ((e.clientX - rect.left) / rect.width - 0.5) * 2;
        const normY = ((e.clientY - rect.top) / rect.height - 0.5) * 2;

        if (floatLeft) {
          floatLeft.style.transform = `translate3d(${(-normX * 14).toFixed(1)}px, ${(-normY * 12).toFixed(1)}px, 0)`;
        }
        if (floatRight) {
          floatRight.style.transform = `translate3d(${(normX * 16).toFixed(1)}px, ${(normY * 14).toFixed(1)}px, 0)`;
        }
        if (capsuleToken) {
          capsuleToken.style.transform = `translateY(0.04em) translate3d(${(normX * 8).toFixed(1)}px, ${(normY * 6).toFixed(1)}px, 0) rotate(${(normX * 5).toFixed(1)}deg)`;
        }
      },
      { passive: true }
    );

    heroSection.addEventListener(
      "pointerleave",
      () => {
        heroSection.style.removeProperty("--hero-spot-x");
        heroSection.style.removeProperty("--hero-spot-y");
        if (floatLeft) floatLeft.style.transform = "";
        if (floatRight) floatRight.style.transform = "";
        if (capsuleToken) capsuleToken.style.transform = "";
      },
      { passive: true }
    );
  }


}


function initAboutEditorial() {
  const hero = document.querySelector(".about-hero");
  if (!hero) {
    return;
  }

  document.body.classList.add("about-editorial-page");

  const stages = Array.from(
    document.querySelectorAll(
      ".about-hero, .about-story-section, .about-purpose-intro, .about-leader-section, .key-customers-section, .about-partner-section",
    ),
  );

  const revealSelectors = [
    ".about-hero-content > *",
    ".about-story-section > div",
    ".about-story-copy > p",
    ".about-purpose-intro > *",
    ".about-leader-copy > *",
    ".about-leader-grid > span",
    ".key-customers-heading > *",
    ".key-customer-logo",
    ".about-partner-section > div:first-child > *",
    ".about-principles > article",
  ].join(", ");

  stages.forEach((stage) => {
    stage.classList.add("about-stage");
    const elements = Array.from(stage.querySelectorAll(revealSelectors));

    elements.forEach((element, index) => {
      element.classList.add("about-element-reveal");
      element.style.setProperty("--about-delay", `${Math.min(index * 70, 420)}ms`);
    });
  });

  const revealStage = (stage) => stage.classList.add("is-about-visible");

  if (prefersReducedMotion.matches || !("IntersectionObserver" in window)) {
    stages.forEach(revealStage);
    return;
  }

  const observer = new IntersectionObserver(
    (entries) => {
      entries.forEach((entry) => {
        if (!entry.isIntersecting) {
          return;
        }

        revealStage(entry.target);
        observer.unobserve(entry.target);
      });
    },
    { rootMargin: "0px 0px -10% 0px", threshold: 0.08 },
  );

  stages.forEach((stage) => observer.observe(stage));

  if (window.matchMedia("(hover: hover) and (pointer: fine)").matches) {
    const image = hero.querySelector(":scope > img");
    hero.addEventListener(
      "pointermove",
      (event) => {
        if (!image) {
          return;
        }

        const bounds = hero.getBoundingClientRect();
        const x = (event.clientX - bounds.left) / bounds.width - 0.5;
        const y = (event.clientY - bounds.top) / bounds.height - 0.5;
        image.style.transform = `scale(1.055) translate3d(${(x * -12).toFixed(1)}px, ${(y * -10).toFixed(1)}px, 0)`;
      },
      { passive: true },
    );
    hero.addEventListener("pointerleave", () => {
      if (image) {
        image.style.transform = "";
      }
    });
  }
}
function initAwwwardsPurposeCards() {
  const grid = document.querySelector("#purpose-interactive-grid");
  if (!grid) {
    return;
  }

  const cards = Array.from(grid.querySelectorAll(".about-purpose-section"));
  if (!cards.length) {
    return;
  }

  // 1. Entrance Scroll Reveal
  const revealCards = () => {
    cards.forEach((card) => card.classList.add("is-purpose-inview"));
  };

  if (prefersReducedMotion.matches || !("IntersectionObserver" in window)) {
    revealCards();
  } else {
    const observer = new IntersectionObserver(
      (entries) => {
        entries.forEach((entry) => {
          if (entry.isIntersecting) {
            entry.target.classList.add("is-purpose-inview");
            observer.unobserve(entry.target);
          }
        });
      },
      { rootMargin: "0px 0px -12% 0px", threshold: 0.12 },
    );
    cards.forEach((card) => observer.observe(card));
  }

  // 2. Interactive 3D Physics & Spotlight Tracking
  const canHover = window.matchMedia("(hover: hover) and (pointer: fine)").matches;
  if (!canHover || prefersReducedMotion.matches) {
    return;
  }

  cards.forEach((card) => {
    const watermark = card.querySelector(".purpose-watermark");
    const icon = card.querySelector(".about-purpose-icon");
    let isHovered = false;
    let rafId = 0;
    let targetX = 0;
    let targetY = 0;
    let currentX = 0;
    let currentY = 0;

    const updatePhysics = () => {
      if (!isHovered) {
        return;
      }
      // Smooth interpolation (lerp)
      currentX += (targetX - currentX) * 0.14;
      currentY += (targetY - currentY) * 0.14;

      const tiltX = (currentY * -12).toFixed(2);
      const tiltY = (currentX * 14).toFixed(2);

      card.style.transform = `perspective(1200px) rotateX(${tiltX}deg) rotateY(${tiltY}deg) translateY(-8px) scale(1.012)`;

      if (watermark) {
        watermark.style.transform = `translate3d(${(currentX * -26).toFixed(1)}px, ${(currentY * -20).toFixed(1)}px, -15px)`;
      }

      if (icon) {
        icon.style.transform = `translate3d(${(currentX * 18).toFixed(1)}px, ${(currentY * 16).toFixed(1)}px, 32px) scale(1.08) rotate(${(currentX * 10).toFixed(1)}deg)`;
      }

      rafId = window.requestAnimationFrame(updatePhysics);
    };

    card.addEventListener("pointerenter", () => {
      isHovered = true;
      card.style.transition = "transform 0.15s ease-out, box-shadow 0.4s ease";
      rafId = window.requestAnimationFrame(updatePhysics);
    }, { passive: true });

    card.addEventListener("pointermove", (event) => {
      const rect = card.getBoundingClientRect();
      const normX = (event.clientX - rect.left) / rect.width - 0.5;
      const normY = (event.clientY - rect.top) / rect.height - 0.5;

      targetX = normX;
      targetY = normY;

      // Update specular spotlight position CSS vars
      const pctX = ((normX + 0.5) * 100).toFixed(1);
      const pctY = ((normY + 0.5) * 100).toFixed(1);
      card.style.setProperty("--mouse-x", `${pctX}%`);
      card.style.setProperty("--mouse-y", `${pctY}%`);
    }, { passive: true });

    card.addEventListener("pointerleave", () => {
      isHovered = false;
      window.cancelAnimationFrame(rafId);
      targetX = 0;
      targetY = 0;
      currentX = 0;
      currentY = 0;

      card.style.transition = "transform 0.65s cubic-bezier(0.16, 1, 0.3, 1), box-shadow 0.65s cubic-bezier(0.16, 1, 0.3, 1)";
      card.style.transform = "perspective(1200px) rotateX(0deg) rotateY(0deg) translateY(0) scale(1)";

      if (watermark) {
        watermark.style.transform = "translateZ(-15px)";
      }
      if (icon) {
        icon.style.transform = "";
      }
    }, { passive: true });
  });
}
function initAwwwardsStoryCards() {
  const section = document.querySelector("#story-interactive-section");
  if (!section) {
    return;
  }

  const cards = Array.from(section.querySelectorAll(".story-card"));
  const nodes = Array.from(section.querySelectorAll(".story-rail-node"));
  const laser = section.querySelector("#story-rail-laser");

  // 1. Scroll Reveal
  if (prefersReducedMotion.matches || !("IntersectionObserver" in window)) {
    section.classList.add("is-story-inview");
  } else {
    const observer = new IntersectionObserver(
      (entries) => {
        entries.forEach((entry) => {
          if (entry.isIntersecting) {
            section.classList.add("is-story-inview");
            observer.unobserve(entry.target);
          }
        });
      },
      { rootMargin: "0px 0px -10% 0px", threshold: 0.1 },
    );
    observer.observe(section);
  }

  // 2. Active State & Laser Rail Synchronization
  const setActiveIndex = (index) => {
    cards.forEach((card, i) => {
      const isActive = i === index;
      card.classList.toggle("is-active", isActive);
    });

    nodes.forEach((node, i) => {
      const isActive = i === index;
      node.classList.toggle("is-active", isActive);
      node.setAttribute("aria-selected", isActive ? "true" : "false");
    });

    if (laser) {
      // Base track connects center of Node 01 (16.666%) to center of Node 03 (83.333%)
      const progressWidths = ["0%", "33.333%", "66.666%"];
      laser.style.left = "16.666%";
      laser.style.width = progressWidths[index] || "0%";
    }
  };

  nodes.forEach((node, index) => {
    node.addEventListener("click", () => setActiveIndex(index));
    node.addEventListener("mouseenter", () => setActiveIndex(index));
  });

  cards.forEach((card, index) => {
    card.addEventListener("mouseenter", () => setActiveIndex(index));
    card.addEventListener("focus", () => setActiveIndex(index));
  });

  // 3. 3D Tilt Physics & Mouse Spotlight
  const canHover = window.matchMedia("(hover: hover) and (pointer: fine)").matches;
  if (!canHover || prefersReducedMotion.matches) {
    return;
  }

  cards.forEach((card) => {
    const watermark = card.querySelector(".story-watermark");
    const icon = card.querySelector(".story-card-icon");
    let isHovered = false;
    let rafId = 0;
    let targetX = 0;
    let targetY = 0;
    let currentX = 0;
    let currentY = 0;

    const updatePhysics = () => {
      if (!isHovered) {
        return;
      }
      currentX += (targetX - currentX) * 0.14;
      currentY += (targetY - currentY) * 0.14;

      const tiltX = (currentY * -10).toFixed(2);
      const tiltY = (currentX * 12).toFixed(2);

      card.style.transform = `perspective(1200px) rotateX(${tiltX}deg) rotateY(${tiltY}deg) translateY(-6px) scale(1.014)`;

      if (watermark) {
        watermark.style.transform = `translate3d(${(currentX * -20).toFixed(1)}px, ${(currentY * -16).toFixed(1)}px, -10px)`;
      }

      if (icon) {
        icon.style.transform = `translate3d(${(currentX * 14).toFixed(1)}px, ${(currentY * 12).toFixed(1)}px, 26px) scale(1.1) rotate(${(currentX * 8).toFixed(1)}deg)`;
      }

      rafId = window.requestAnimationFrame(updatePhysics);
    };

    card.addEventListener("pointerenter", () => {
      isHovered = true;
      card.style.transition = "transform 0.15s ease-out, box-shadow 0.4s ease";
      rafId = window.requestAnimationFrame(updatePhysics);
    }, { passive: true });

    card.addEventListener("pointermove", (event) => {
      const rect = card.getBoundingClientRect();
      const normX = (event.clientX - rect.left) / rect.width - 0.5;
      const normY = (event.clientY - rect.top) / rect.height - 0.5;

      targetX = normX;
      targetY = normY;

      const pctX = ((normX + 0.5) * 100).toFixed(1);
      const pctY = ((normY + 0.5) * 100).toFixed(1);
      card.style.setProperty("--mouse-x", `${pctX}%`);
      card.style.setProperty("--mouse-y", `${pctY}%`);
    }, { passive: true });

    card.addEventListener("pointerleave", () => {
      isHovered = false;
      window.cancelAnimationFrame(rafId);
      targetX = 0;
      targetY = 0;
      currentX = 0;
      currentY = 0;

      card.style.transition = "transform 0.65s cubic-bezier(0.16, 1, 0.3, 1), box-shadow 0.65s cubic-bezier(0.16, 1, 0.3, 1)";
      card.style.transform = "perspective(1200px) rotateX(0deg) rotateY(0deg) translateY(0) scale(1)";

      if (watermark) {
        watermark.style.transform = "translateZ(-10px)";
      }
      if (icon) {
        icon.style.transform = "";
      }
    }, { passive: true });
  });
}

function initAwwwardsTeamPage() {
  const teamPage = document.querySelector("body.team-editorial-page");
  if (!teamPage) {
    return;
  }

  // 1. Department Quick-Nav & ScrollSpy
  const navBtns = Array.from(teamPage.querySelectorAll(".team-nav-btn"));
  const sections = Array.from(teamPage.querySelectorAll(".team-section-container"));

  navBtns.forEach((btn) => {
    btn.addEventListener("click", (e) => {
      const targetId = btn.getAttribute("href");
      if (targetId && targetId.startsWith("#")) {
        const targetEl = document.querySelector(targetId);
        if (targetEl) {
          e.preventDefault();
          const targetY = targetEl.getBoundingClientRect().top + window.scrollY - 90;
          window.scrollTo({ top: targetY, behavior: "smooth" });
          navBtns.forEach((b) => b.classList.remove("is-active"));
          btn.classList.add("is-active");
        }
      }
    });
  });

  if ("IntersectionObserver" in window && sections.length > 0) {
    const sectionObserver = new IntersectionObserver(
      (entries) => {
        entries.forEach((entry) => {
          if (entry.isIntersecting) {
            const id = entry.target.id;
            navBtns.forEach((btn) => {
              const href = btn.getAttribute("href");
              btn.classList.toggle("is-active", href === `#${id}`);
            });
          }
        });
      },
      { rootMargin: "-20% 0px -60% 0px", threshold: 0 }
    );
    sections.forEach((sec) => sectionObserver.observe(sec));
  }

  // 2. 3D Tilt Physics & Specular Lighting
  const tiltCards = Array.from(teamPage.querySelectorAll("[data-tilt-card]"));

  tiltCards.forEach((card) => {
    let rafId = null;
    let targetX = 0;
    let targetY = 0;
    let currentX = 0;
    let currentY = 0;

    const updateTilt = () => {
      currentX += (targetX - currentX) * 0.12;
      currentY += (targetY - currentY) * 0.12;

      card.style.transform = `perspective(1200px) rotateX(${currentX.toFixed(2)}deg) rotateY(${currentY.toFixed(2)}deg) translateY(-4px)`;

      if (Math.abs(targetX - currentX) > 0.02 || Math.abs(targetY - currentY) > 0.02) {
        rafId = requestAnimationFrame(updateTilt);
      } else {
        rafId = null;
      }
    };

    card.addEventListener("mousemove", (e) => {
      const rect = card.getBoundingClientRect();
      const x = e.clientX - rect.left;
      const y = e.clientY - rect.top;

      card.style.setProperty("--mouse-x", `${x}px`);
      card.style.setProperty("--mouse-y", `${y}px`);

      if (prefersReducedMotion.matches) return;

      const normalizedX = (x / rect.width) * 2 - 1;
      const normalizedY = (y / rect.height) * 2 - 1;

      targetX = -normalizedY * 7;
      targetY = normalizedX * 7;

      card.style.transition = "none";
      if (!rafId) {
        rafId = requestAnimationFrame(updateTilt);
      }
    }, { passive: true });

    card.addEventListener("mouseleave", () => {
      if (rafId) {
        cancelAnimationFrame(rafId);
        rafId = null;
      }
      targetX = 0;
      targetY = 0;
      currentX = 0;
      currentY = 0;

      card.style.transition = "transform 0.55s cubic-bezier(0.16, 1, 0.3, 1), box-shadow 0.55s ease, border-color 0.4s ease";
      card.style.transform = "perspective(1200px) rotateX(0deg) rotateY(0deg) translateY(0)";
    }, { passive: true });
  });
}

initMobileNavigation();
initAwwwardsNavigation();
initEditorialFooter();
initProductsEditorial();
initAboutEditorial();
initAwwwardsStoryCards();
initAwwwardsPurposeCards();
initAwwwardsTeamPage();
initNavDropdowns();
initCursor();
initHeroExperience();
initAchievementSection();
initAssociateSection();
