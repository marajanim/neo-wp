const galleryImage = (src, caption, width, height) => ({
  src,
  caption,
  alt: caption,
  width,
  height,
});

const coordinationImages = [
  galleryImage(window.neoAssetBase + "assets/gallery/team/cox-bazar-team.jpg", "Project coordination team gathering in Cox's Bazar", 1600, 1066),
  galleryImage(window.neoAssetBase + "assets/gallery/team/family-picnic.jpg", "Neo Associates family picnic", 1600, 1200),
  galleryImage(window.neoAssetBase + "assets/gallery/service/office-project-coordination.jpg", "Office and project coordination", 3648, 2736),
  galleryImage(window.neoAssetBase + "assets/gallery/team/project-support-activity.jpg", "Project coordination activity", 4000, 3000),
  galleryImage(window.neoAssetBase + "assets/gallery/team/service-engineering-field.jpg", "Project team moment", 4000, 3000),
  galleryImage(window.neoAssetBase + "assets/gallery/team/team-milestone-gathering.jpg", "Neo Associates team moment", 3984, 2656),
  galleryImage(window.neoAssetBase + "assets/gallery/team/engineering-work-moment.jpg", "Neo Associates work moment", 1280, 960),
];

const serviceImages = [
  galleryImage(window.neoAssetBase + "assets/gallery/team/service-engineering-field.jpg", "Service engineering team in the field", 4000, 3000),
  galleryImage(window.neoAssetBase + "assets/gallery/service/field-service-activity.jpg", "Neo Associates service activity", 4000, 3000),
  galleryImage(window.neoAssetBase + "assets/gallery/service/technical-service-support.jpg", "Technical service support", 4000, 3000),
  galleryImage(window.neoAssetBase + "assets/gallery/fat/fat-facility-visit.jpg", "Factory acceptance test visit", 828, 621),
  galleryImage(window.neoAssetBase + "assets/gallery/fat/fat-documentation-review.jpg", "FAT documentation and review", 2653, 1868),
  galleryImage(window.neoAssetBase + "assets/gallery/fat/fat-equipment-staging.jpg", "Factory acceptance test equipment area", 3048, 1584),
  galleryImage(window.neoAssetBase + "assets/gallery/fat/fat-technical-inspection.jpg", "FAT technical inspection", 828, 559),
  galleryImage(window.neoAssetBase + "assets/gallery/fat/fat-delegation-group.jpg", "Factory acceptance test group moment", 3244, 2057),
  galleryImage(window.neoAssetBase + "assets/gallery/team/engineering-work-moment.jpg", "Engineering work moment", 1280, 960),
];

const supportImages = [
  galleryImage(window.neoAssetBase + "assets/gallery/team/project-support-activity.jpg", "Neo Associates project support team", 4000, 3000),
  galleryImage(window.neoAssetBase + "assets/gallery/service/office-project-coordination.jpg", "Office and project coordination", 3648, 2736),
  galleryImage(window.neoAssetBase + "assets/gallery/fat/fat-documentation-review.jpg", "Project documentation and FAT review", 2653, 1868),
  galleryImage(window.neoAssetBase + "assets/gallery/fat/fat-equipment-staging.jpg", "Project equipment readiness review", 3048, 1584),
  galleryImage(window.neoAssetBase + "assets/gallery/fat/fat-technical-inspection.jpg", "Project technical inspection", 828, 559),
  galleryImage(window.neoAssetBase + "assets/gallery/fat/fat-delegation-group.jpg", "Project support group moment", 3244, 2057),
  galleryImage(window.neoAssetBase + "assets/gallery/service/field-service-activity.jpg", "On-site project support", 4000, 3000),
  galleryImage(window.neoAssetBase + "assets/gallery/service/technical-service-support.jpg", "Technical support activity", 4000, 3000),
  galleryImage(window.neoAssetBase + "assets/gallery/team/team-milestone-gathering.jpg", "Neo Associates project team moment", 3984, 2656),
];

const exhibitionImages = [
  galleryImage(window.neoAssetBase + "assets/gallery/exhibitions/ape-2025-team-booth.jpg", "APE 2025 exhibition team photo", 5760, 3840),
  galleryImage(window.neoAssetBase + "assets/gallery/exhibitions/ape-2023-exhibition.jpg", "APE 2023 exhibition", 2976, 1984),
  galleryImage(window.neoAssetBase + "assets/gallery/exhibitions/ape-2022-exhibition.jpg", "APE 2022 exhibition", 4032, 3024),
  galleryImage(window.neoAssetBase + "assets/gallery/exhibitions/ape-2022-partner-display.jpg", "APE 2022 partner activity", 5184, 3456),
  galleryImage(window.neoAssetBase + "assets/gallery/exhibitions/ape-2020-exhibition.jpg", "APE 2020 exhibition", 6000, 4000),
  galleryImage(window.neoAssetBase + "assets/gallery/exhibitions/ape-2020-booth-floor.jpg", "APE 2020 exhibition floor", 6000, 4000),
  galleryImage(window.neoAssetBase + "assets/gallery/exhibitions/ape-2019-partner-display.jpg", "APE 2019 partner display", 5184, 3456),
  galleryImage(window.neoAssetBase + "assets/gallery/exhibitions/ape-2019-booth-activity.jpg", "APE 2019 booth activity", 5184, 3456),
  galleryImage(window.neoAssetBase + "assets/gallery/exhibitions/ape-2019-exhibition-team.jpg", "APE 2019 exhibition team", 6000, 4000),
  galleryImage(window.neoAssetBase + "assets/gallery/exhibitions/ape-2019-delegation-moment.jpg", "APE 2019 exhibition moment", 4487, 3456),
  galleryImage(window.neoAssetBase + "assets/gallery/exhibitions/ape-2018-exhibition.jpg", "APE 2018 exhibition", 5184, 3456),
  galleryImage(window.neoAssetBase + "assets/gallery/exhibitions/ape-2018-booth-moment.jpg", "APE 2018 booth moment", 3984, 2656),
  galleryImage(window.neoAssetBase + "assets/gallery/exhibitions/ape-2018-exhibition-floor.jpg", "APE 2018 exhibition floor", 3984, 2656),
  galleryImage(window.neoAssetBase + "assets/gallery/exhibitions/ape-2018-visitor-discussion.jpg", "APE 2018 visitor discussion", 3984, 2656),
  galleryImage(window.neoAssetBase + "assets/gallery/exhibitions/ape-2018-industry-networking.jpg", "APE 2018 industry networking", 3984, 2656),
  galleryImage(window.neoAssetBase + "assets/gallery/exhibitions/ape-2017-portrait-moment.jpg", "APE 2017 portrait moment", 1536, 2048),
  galleryImage(window.neoAssetBase + "assets/gallery/exhibitions/ape-2017-exhibition-activity.jpg", "APE 2017 exhibition activity", 2048, 1536),
  galleryImage(window.neoAssetBase + "assets/gallery/exhibitions/ape-2017-partner-delegation.jpg", "APE 2017 partner photo", 2048, 1536),
  galleryImage(window.neoAssetBase + "assets/gallery/exhibitions/ape-2016-portrait-moment.jpg", "APE 2016 exhibition portrait", 720, 960),
  galleryImage(window.neoAssetBase + "assets/gallery/exhibitions/ape-2016-exhibition-team.jpg", "APE 2016 exhibition team", 960, 720),
  galleryImage(window.neoAssetBase + "assets/gallery/exhibitions/international-exhibition-delegation.jpg", "International exhibition visit", 1024, 768),
  galleryImage(window.neoAssetBase + "assets/gallery/exhibitions/industry-exhibition-2019.jpg", "Industry exhibition in 2019", 3084, 1980),
];

const teamGalleries = {
  "project-coordination": {
    name: "Project Coordination",
    eyebrow: "Project coordination",
    titlePrimary: "Planning in practice.",
    titleSerif: "People",
    titleEnd: "behind every project.",
    description: "Sales planning, customer follow-up, documentation, and the team moments that keep projects moving.",
    intro: "Coordination from first discussion to delivery.",
    hero: coordinationImages[0],
    images: coordinationImages,
  },
  "service-engineering": {
    name: "Service Engineering",
    eyebrow: "Service engineering",
    titlePrimary: "Engineering in action.",
    titleSerif: "Support",
    titleEnd: "in the field.",
    description: "Installation, commissioning, inspection, maintenance, and hands-on technical support across project sites.",
    intro: "Technical readiness where it matters.",
    hero: serviceImages[0],
    images: serviceImages,
  },
  "exhibition-team": {
    name: "Exhibition Team",
    eyebrow: "Exhibition team",
    titlePrimary: "Industry presence.",
    titleSerif: "Partners",
    titleEnd: "in conversation.",
    description: "Neo Associates at APE and industry exhibitions, connecting customers with global pharmaceutical technologies.",
    intro: "A complete archive of exhibition activity.",
    hero: exhibitionImages[0],
    images: exhibitionImages,
  },
  "project-support": {
    name: "Project Support",
    eyebrow: "Project support",
    titlePrimary: "Projects in motion.",
    titleSerif: "Readiness",
    titleEnd: "at every stage.",
    description: "Documentation, factory reviews, technical coordination, and on-site activity supporting dependable execution.",
    intro: "Support across review, readiness, and execution.",
    hero: supportImages[0],
    images: supportImages,
  },
};

function initTeamGalleryDetail() {
  const requestedCategory = new URLSearchParams(window.location.search).get("category");
  const category = Object.prototype.hasOwnProperty.call(teamGalleries, requestedCategory)
    ? requestedCategory
    : "project-coordination";
  const gallery = teamGalleries[category];
  const heroImage = document.querySelector("[data-team-gallery-hero]");
  const grid = document.querySelector("[data-team-gallery-grid]");

  document.title = gallery.name + " Gallery | Neo Associates Ltd.";
  document.querySelector("[data-team-gallery-eyebrow]").textContent = gallery.eyebrow;
  document.querySelector("[data-team-gallery-title-primary]").textContent = gallery.titlePrimary;
  document.querySelector("[data-team-gallery-title-serif]").textContent = gallery.titleSerif;
  document.querySelector("[data-team-gallery-title-end]").textContent = gallery.titleEnd;
  document.querySelector("[data-team-gallery-description]").textContent = gallery.description;
  document.querySelector("[data-team-gallery-intro]").textContent = gallery.intro;
  document.querySelector("[data-team-gallery-wall-title]").textContent = gallery.name + " gallery";
  document.querySelector("[data-team-gallery-count]").textContent = String(gallery.images.length);

  document.querySelectorAll("[data-neo-variants]").forEach((element) => {
    const edits = JSON.parse(element.dataset.neoVariants);
    if (Object.prototype.hasOwnProperty.call(edits, category)) element.textContent = edits[category];
  });

  setResponsivePhoto(heroImage, gallery.hero.src, `${gallery.hero.width}px`);
  heroImage.alt = gallery.hero.alt;
  heroImage.width = gallery.hero.width;
  heroImage.height = gallery.hero.height;

  gallery.images.forEach((item, index) => {
    const figure = document.createElement("figure");
    figure.className = index === 0 ? "gallery-item gallery-item-feature" : "gallery-item";
    figure.dataset.category = category;

    const button = document.createElement("button");
    button.type = "button";
    button.dataset.galleryImage = item.src;
    button.dataset.galleryCaption = item.caption;

    const image = document.createElement("img");
    image.loading = "lazy";
    setResponsivePhoto(image, item.src);
    image.alt = item.alt;
    image.width = item.width;
    image.height = item.height;

    const caption = document.createElement("span");
    caption.className = "gallery-caption";
    caption.textContent = item.caption;

    button.append(image, caption);
    figure.append(button);
    grid.append(figure);
  });
}

initTeamGalleryDetail();
