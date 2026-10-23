<?php defined('ABSPATH') || exit; ?>
<main id="top">

<section aria-labelledby="gallery-hero-title" class="gallery-hero">
<div aria-hidden="true" class="gallery-hero-bg">
<?php neo_image('gallery_image_001', json_decode('{"sizes": "100vw", "fetchpriority": "high", "data-neo-image": "gallery_image_001"}', true)); ?>
<div class="gallery-hero-vignette"></div>
<div class="gallery-hero-spotlight"></div>
</div>
<div class="gallery-hero-content">
<div class="gallery-hero-badge">
<span aria-hidden="true" class="gallery-hero-badge-dot"></span>
<span class="gallery-hero-badge-text" data-neo-field="neo_gallery_008"><?php neo_text('neo_gallery_008'); ?></span>
<span aria-hidden="true" class="gallery-hero-badge-sep">•</span>
<span class="gallery-hero-badge-year" data-neo-field="neo_gallery_009"><?php neo_text('neo_gallery_009'); ?></span>
</div>
<h1 class="gallery-hero-title no-word-reveal" id="gallery-hero-title">
<span class="gallery-hero-title-line" data-neo-field="neo_gallery_010"><?php neo_text('neo_gallery_010'); ?></span>
<span class="gallery-hero-title-line gallery-hero-title-accent" data-neo-field="neo_gallery_011"><?php neo_text('neo_gallery_011'); ?></span>
</h1>
<p class="gallery-hero-copy" data-neo-field="neo_gallery_012"><?php neo_text('neo_gallery_012'); ?></p>
<div class="gallery-hero-actions">
<a class="hero-button hero-button-primary no-word-reveal" href="#gallery-wall">
<span data-neo-field="neo_gallery_013"><?php neo_text('neo_gallery_013'); ?></span>
<span aria-hidden="true" class="hero-btn-arrow">↓</span>
</a>
<div aria-label="Archive telemetry" class="gallery-hero-stats">
<div class="gallery-hero-stat">
<strong data-neo-field="neo_gallery_014"><?php neo_text('neo_gallery_014'); ?></strong>
<span data-neo-field="neo_gallery_015"><?php neo_text('neo_gallery_015'); ?></span>
</div>
<span aria-hidden="true" class="gallery-stat-sep">/</span>
<div class="gallery-hero-stat">
<strong data-neo-field="neo_gallery_016"><?php neo_text('neo_gallery_016'); ?></strong>
<span data-neo-field="neo_gallery_017"><?php neo_text('neo_gallery_017'); ?></span>
</div>
<span aria-hidden="true" class="gallery-stat-sep">/</span>
<div class="gallery-hero-stat">
<strong data-neo-field="neo_gallery_018"><?php neo_text('neo_gallery_018'); ?></strong>
<span data-neo-field="neo_gallery_019"><?php neo_text('neo_gallery_019'); ?></span>
</div>
</div>
</div>
</div>
</section>

<section aria-label="Gallery overview" class="gallery-intro-section">
<div class="gallery-intro-header">
<div class="gallery-pill-tag">
<span aria-hidden="true" class="gallery-pill-dot"></span>
<span data-neo-field="neo_gallery_020"><?php neo_text('neo_gallery_020'); ?></span>
</div>
<h2 data-neo-field="neo_gallery_021"><?php neo_text('neo_gallery_021'); ?></h2>
</div>
<div class="gallery-intro-copy">
<p data-neo-field="neo_gallery_022"><?php neo_text('neo_gallery_022'); ?></p>
<div aria-label="Archive categories" class="gallery-quick-tags">
<span data-neo-field="neo_gallery_023"><?php neo_text('neo_gallery_023'); ?></span>
<span data-neo-field="neo_gallery_024"><?php neo_text('neo_gallery_024'); ?></span>
<span data-neo-field="neo_gallery_025"><?php neo_text('neo_gallery_025'); ?></span>
<span data-neo-field="neo_gallery_026"><?php neo_text('neo_gallery_026'); ?></span>
<span data-neo-field="neo_gallery_027"><?php neo_text('neo_gallery_027'); ?></span>
</div>
</div>
</section>

<section aria-labelledby="gallery-wall-title" class="gallery-wall-section" id="gallery-wall">
<div class="gallery-wall-heading">
<div class="gallery-wall-heading-main">
<div class="gallery-pill-tag">
<span aria-hidden="true" class="gallery-pill-dot"></span>
<span data-neo-field="neo_gallery_028"><?php neo_text('neo_gallery_028'); ?></span>
</div>
<h2 data-neo-field="neo_gallery_029" id="gallery-wall-title"><?php neo_text('neo_gallery_029'); ?></h2>
<p class="gallery-wall-subtitle" data-neo-field="neo_gallery_030"><?php neo_text('neo_gallery_030'); ?></p>
</div>
<div class="gallery-filter-wrap">
<div aria-label="Filter gallery images" class="gallery-filter-list" role="tablist">
<button aria-pressed="true" class="gallery-filter active" data-filter="all" type="button">
<span data-neo-field="neo_gallery_031"><?php neo_text('neo_gallery_031'); ?></span>
<span class="gallery-filter-count" data-neo-field="neo_gallery_032"><?php neo_text('neo_gallery_032'); ?></span>
</button>
<button aria-pressed="false" class="gallery-filter" data-filter="exhibitions" type="button">
<span data-neo-field="neo_gallery_033"><?php neo_text('neo_gallery_033'); ?></span>
<span class="gallery-filter-count" data-neo-field="neo_gallery_034"><?php neo_text('neo_gallery_034'); ?></span>
</button>
<button aria-pressed="false" class="gallery-filter" data-filter="seminars" type="button">
<span data-neo-field="neo_gallery_035"><?php neo_text('neo_gallery_035'); ?></span>
<span class="gallery-filter-count" data-neo-field="neo_gallery_036"><?php neo_text('neo_gallery_036'); ?></span>
</button>
<button aria-pressed="false" class="gallery-filter" data-filter="fat" type="button">
<span data-neo-field="neo_gallery_037"><?php neo_text('neo_gallery_037'); ?></span>
<span class="gallery-filter-count" data-neo-field="neo_gallery_038"><?php neo_text('neo_gallery_038'); ?></span>
</button>
<button aria-pressed="false" class="gallery-filter" data-filter="service" type="button">
<span data-neo-field="neo_gallery_039"><?php neo_text('neo_gallery_039'); ?></span>
<span class="gallery-filter-count" data-neo-field="neo_gallery_040"><?php neo_text('neo_gallery_040'); ?></span>
</button>
<button aria-pressed="false" class="gallery-filter" data-filter="team" type="button">
<span data-neo-field="neo_gallery_041"><?php neo_text('neo_gallery_041'); ?></span>
<span class="gallery-filter-count" data-neo-field="neo_gallery_042"><?php neo_text('neo_gallery_042'); ?></span>
</button>
</div>
<div aria-live="polite" class="gallery-live-indicator">
<span aria-hidden="true" class="gallery-live-dot"></span>
<span data-neo-field="neo_gallery_043" id="gallery-active-status"><?php neo_text('neo_gallery_043'); ?></span>
</div>
</div>
</div>
<div class="gallery-grid">
<figure class="gallery-item gallery-item-feature" data-category="seminars">
<button data-gallery-caption="Technical seminar with pharmaceutical industry attendees" data-gallery-image="<?php echo esc_url(neo_asset('assets/gallery/seminars/technical-seminar-attendees.jpg')); ?>" type="button">
<?php neo_image('gallery_image_002', json_decode('{"sizes": "(max-width: 700px) 100vw, 50vw", "loading": "lazy", "data-neo-image": "gallery_image_002"}', true)); ?>
<span class="gallery-caption" data-neo-field="neo_gallery_044"><?php neo_text('neo_gallery_044'); ?></span>
</button>
</figure>
<figure class="gallery-item" data-category="seminars">
<button data-gallery-caption="Marchesini seminar with Neo Associates and industry partners" data-gallery-image="<?php echo esc_url(neo_asset('assets/gallery/seminars/marchesini-seminar.jpg')); ?>" type="button">
<?php neo_image('gallery_image_003', json_decode('{"sizes": "(max-width: 700px) 100vw, 50vw", "loading": "lazy", "data-neo-image": "gallery_image_003"}', true)); ?>
<span class="gallery-caption" data-neo-field="neo_gallery_045"><?php neo_text('neo_gallery_045'); ?></span>
</button>
</figure>
<figure class="gallery-item" data-category="seminars">
<button data-gallery-caption="DR seminar for pharmaceutical professionals" data-gallery-image="<?php echo esc_url(neo_asset('assets/gallery/seminars/dr-pharmaceutical-seminar.jpg')); ?>" type="button">
<?php neo_image('gallery_image_004', json_decode('{"sizes": "(max-width: 700px) 100vw, 50vw", "loading": "lazy", "data-neo-image": "gallery_image_004"}', true)); ?>
<span class="gallery-caption" data-neo-field="neo_gallery_046"><?php neo_text('neo_gallery_046'); ?></span>
</button>
</figure>
<figure class="gallery-item" data-category="seminars">
<button data-gallery-caption="Tofflon seminar hosted with industry guests" data-gallery-image="<?php echo esc_url(neo_asset('assets/gallery/seminars/tofflon-industry-seminar.jpg')); ?>" type="button">
<?php neo_image('gallery_image_005', json_decode('{"sizes": "(max-width: 700px) 100vw, 50vw", "loading": "lazy", "data-neo-image": "gallery_image_005"}', true)); ?>
<span class="gallery-caption" data-neo-field="neo_gallery_047"><?php neo_text('neo_gallery_047'); ?></span>
</button>
</figure>
<figure class="gallery-item" data-category="exhibitions">
<button data-gallery-caption="APE 2025 exhibition team photo" data-gallery-image="<?php echo esc_url(neo_asset('assets/gallery/exhibitions/ape-2025-team-booth.jpg')); ?>" type="button">
<?php neo_image('gallery_image_006', json_decode('{"sizes": "(max-width: 700px) 100vw, 50vw", "loading": "lazy", "data-neo-image": "gallery_image_006"}', true)); ?>
<span class="gallery-caption" data-neo-field="neo_gallery_048"><?php neo_text('neo_gallery_048'); ?></span>
</button>
</figure>
<figure class="gallery-item" data-category="seminars">
<button data-gallery-caption="Tofflon seminar with pharmaceutical industry guests" data-gallery-image="<?php echo esc_url(neo_asset('assets/gallery/seminars/tofflon-seminar.jpg')); ?>" type="button">
<?php neo_image('gallery_image_007', json_decode('{"sizes": "(max-width: 700px) 100vw, 50vw", "loading": "lazy", "data-neo-image": "gallery_image_007"}', true)); ?>
<span class="gallery-caption" data-neo-field="neo_gallery_049"><?php neo_text('neo_gallery_049'); ?></span>
</button>
</figure>
<figure class="gallery-item" data-category="seminars">
<button data-gallery-caption="Tofflon technical seminar and partner session" data-gallery-image="<?php echo esc_url(neo_asset('assets/gallery/seminars/tofflon-seminar-session.jpg')); ?>" type="button">
<?php neo_image('gallery_image_008', json_decode('{"sizes": "(max-width: 700px) 100vw, 50vw", "loading": "lazy", "data-neo-image": "gallery_image_008"}', true)); ?>
<span class="gallery-caption" data-neo-field="neo_gallery_050"><?php neo_text('neo_gallery_050'); ?></span>
</button>
</figure>
<figure class="gallery-item" data-category="exhibitions">
<button data-gallery-caption="APE 2023 exhibition" data-gallery-image="<?php echo esc_url(neo_asset('assets/gallery/exhibitions/ape-2023-exhibition.jpg')); ?>" type="button">
<?php neo_image('gallery_image_009', json_decode('{"sizes": "(max-width: 700px) 100vw, 50vw", "loading": "lazy", "data-neo-image": "gallery_image_009"}', true)); ?>
<span class="gallery-caption" data-neo-field="neo_gallery_051"><?php neo_text('neo_gallery_051'); ?></span>
</button>
</figure>
<figure class="gallery-item" data-category="exhibitions">
<button data-gallery-caption="APE 2022 exhibition" data-gallery-image="<?php echo esc_url(neo_asset('assets/gallery/exhibitions/ape-2022-exhibition.jpg')); ?>" type="button">
<?php neo_image('gallery_image_010', json_decode('{"sizes": "(max-width: 700px) 100vw, 50vw", "loading": "lazy", "data-neo-image": "gallery_image_010"}', true)); ?>
<span class="gallery-caption" data-neo-field="neo_gallery_052"><?php neo_text('neo_gallery_052'); ?></span>
</button>
</figure>
<figure class="gallery-item" data-category="exhibitions">
<button data-gallery-caption="APE 2022 partner activity" data-gallery-image="<?php echo esc_url(neo_asset('assets/gallery/exhibitions/ape-2022-partner-display.jpg')); ?>" type="button">
<?php neo_image('gallery_image_011', json_decode('{"sizes": "(max-width: 700px) 100vw, 50vw", "loading": "lazy", "data-neo-image": "gallery_image_011"}', true)); ?>
<span class="gallery-caption" data-neo-field="neo_gallery_053"><?php neo_text('neo_gallery_053'); ?></span>
</button>
</figure>
<figure class="gallery-item" data-category="exhibitions">
<button data-gallery-caption="APE 2020 exhibition" data-gallery-image="<?php echo esc_url(neo_asset('assets/gallery/exhibitions/ape-2020-exhibition.jpg')); ?>" type="button">
<?php neo_image('gallery_image_012', json_decode('{"sizes": "(max-width: 700px) 100vw, 50vw", "loading": "lazy", "data-neo-image": "gallery_image_012"}', true)); ?>
<span class="gallery-caption" data-neo-field="neo_gallery_054"><?php neo_text('neo_gallery_054'); ?></span>
</button>
</figure>
<figure class="gallery-item" data-category="exhibitions">
<button data-gallery-caption="APE 2020 exhibition floor" data-gallery-image="<?php echo esc_url(neo_asset('assets/gallery/exhibitions/ape-2020-booth-floor.jpg')); ?>" type="button">
<?php neo_image('gallery_image_013', json_decode('{"sizes": "(max-width: 700px) 100vw, 50vw", "loading": "lazy", "data-neo-image": "gallery_image_013"}', true)); ?>
<span class="gallery-caption" data-neo-field="neo_gallery_055"><?php neo_text('neo_gallery_055'); ?></span>
</button>
</figure>
<figure class="gallery-item" data-category="exhibitions">
<button data-gallery-caption="APE 2019 partner display" data-gallery-image="<?php echo esc_url(neo_asset('assets/gallery/exhibitions/ape-2019-partner-display.jpg')); ?>" type="button">
<?php neo_image('gallery_image_014', json_decode('{"sizes": "(max-width: 700px) 100vw, 50vw", "loading": "lazy", "data-neo-image": "gallery_image_014"}', true)); ?>
<span class="gallery-caption" data-neo-field="neo_gallery_056"><?php neo_text('neo_gallery_056'); ?></span>
</button>
</figure>
<figure class="gallery-item" data-category="exhibitions">
<button data-gallery-caption="APE 2019 booth activity" data-gallery-image="<?php echo esc_url(neo_asset('assets/gallery/exhibitions/ape-2019-booth-activity.jpg')); ?>" type="button">
<?php neo_image('gallery_image_015', json_decode('{"sizes": "(max-width: 700px) 100vw, 50vw", "loading": "lazy", "data-neo-image": "gallery_image_015"}', true)); ?>
<span class="gallery-caption" data-neo-field="neo_gallery_057"><?php neo_text('neo_gallery_057'); ?></span>
</button>
</figure>
<figure class="gallery-item" data-category="exhibitions">
<button data-gallery-caption="APE 2019 exhibition team" data-gallery-image="<?php echo esc_url(neo_asset('assets/gallery/exhibitions/ape-2019-exhibition-team.jpg')); ?>" type="button">
<?php neo_image('gallery_image_016', json_decode('{"sizes": "(max-width: 700px) 100vw, 50vw", "loading": "lazy", "data-neo-image": "gallery_image_016"}', true)); ?>
<span class="gallery-caption" data-neo-field="neo_gallery_058"><?php neo_text('neo_gallery_058'); ?></span>
</button>
</figure>
<figure class="gallery-item" data-category="exhibitions">
<button data-gallery-caption="APE 2019 exhibition moment" data-gallery-image="<?php echo esc_url(neo_asset('assets/gallery/exhibitions/ape-2019-delegation-moment.jpg')); ?>" type="button">
<?php neo_image('gallery_image_017', json_decode('{"sizes": "(max-width: 700px) 100vw, 50vw", "loading": "lazy", "data-neo-image": "gallery_image_017"}', true)); ?>
<span class="gallery-caption" data-neo-field="neo_gallery_059"><?php neo_text('neo_gallery_059'); ?></span>
</button>
</figure>
<figure class="gallery-item" data-category="exhibitions">
<button data-gallery-caption="APE 2018 exhibition" data-gallery-image="<?php echo esc_url(neo_asset('assets/gallery/exhibitions/ape-2018-exhibition.jpg')); ?>" type="button">
<?php neo_image('gallery_image_018', json_decode('{"sizes": "(max-width: 700px) 100vw, 50vw", "loading": "lazy", "data-neo-image": "gallery_image_018"}', true)); ?>
<span class="gallery-caption" data-neo-field="neo_gallery_060"><?php neo_text('neo_gallery_060'); ?></span>
</button>
</figure>
<figure class="gallery-item" data-category="exhibitions">
<button data-gallery-caption="APE 2018 booth moment" data-gallery-image="<?php echo esc_url(neo_asset('assets/gallery/exhibitions/ape-2018-booth-moment.jpg')); ?>" type="button">
<?php neo_image('gallery_image_019', json_decode('{"sizes": "(max-width: 700px) 100vw, 50vw", "loading": "lazy", "data-neo-image": "gallery_image_019"}', true)); ?>
<span class="gallery-caption" data-neo-field="neo_gallery_061"><?php neo_text('neo_gallery_061'); ?></span>
</button>
</figure>
<figure class="gallery-item" data-category="exhibitions">
<button data-gallery-caption="APE 2018 exhibition floor" data-gallery-image="<?php echo esc_url(neo_asset('assets/gallery/exhibitions/ape-2018-exhibition-floor.jpg')); ?>" type="button">
<?php neo_image('gallery_image_020', json_decode('{"sizes": "(max-width: 700px) 100vw, 50vw", "loading": "lazy", "data-neo-image": "gallery_image_020"}', true)); ?>
<span class="gallery-caption" data-neo-field="neo_gallery_062"><?php neo_text('neo_gallery_062'); ?></span>
</button>
</figure>
<figure class="gallery-item" data-category="exhibitions">
<button data-gallery-caption="APE 2018 visitor discussion" data-gallery-image="<?php echo esc_url(neo_asset('assets/gallery/exhibitions/ape-2018-visitor-discussion.jpg')); ?>" type="button">
<?php neo_image('gallery_image_021', json_decode('{"sizes": "(max-width: 700px) 100vw, 50vw", "loading": "lazy", "data-neo-image": "gallery_image_021"}', true)); ?>
<span class="gallery-caption" data-neo-field="neo_gallery_063"><?php neo_text('neo_gallery_063'); ?></span>
</button>
</figure>
<figure class="gallery-item" data-category="exhibitions">
<button data-gallery-caption="APE 2018 industry networking" data-gallery-image="<?php echo esc_url(neo_asset('assets/gallery/exhibitions/ape-2018-industry-networking.jpg')); ?>" type="button">
<?php neo_image('gallery_image_022', json_decode('{"sizes": "(max-width: 700px) 100vw, 50vw", "loading": "lazy", "data-neo-image": "gallery_image_022"}', true)); ?>
<span class="gallery-caption" data-neo-field="neo_gallery_064"><?php neo_text('neo_gallery_064'); ?></span>
</button>
</figure>
<figure class="gallery-item" data-category="exhibitions">
<button data-gallery-caption="APE 2017 portrait moment" data-gallery-image="<?php echo esc_url(neo_asset('assets/gallery/exhibitions/ape-2017-portrait-moment.jpg')); ?>" type="button">
<?php neo_image('gallery_image_023', json_decode('{"sizes": "(max-width: 700px) 100vw, 50vw", "loading": "lazy", "data-neo-image": "gallery_image_023"}', true)); ?>
<span class="gallery-caption" data-neo-field="neo_gallery_065"><?php neo_text('neo_gallery_065'); ?></span>
</button>
</figure>
<figure class="gallery-item" data-category="exhibitions">
<button data-gallery-caption="APE 2017 exhibition activity" data-gallery-image="<?php echo esc_url(neo_asset('assets/gallery/exhibitions/ape-2017-exhibition-activity.jpg')); ?>" type="button">
<?php neo_image('gallery_image_024', json_decode('{"sizes": "(max-width: 700px) 100vw, 50vw", "loading": "lazy", "data-neo-image": "gallery_image_024"}', true)); ?>
<span class="gallery-caption" data-neo-field="neo_gallery_066"><?php neo_text('neo_gallery_066'); ?></span>
</button>
</figure>
<figure class="gallery-item" data-category="exhibitions">
<button data-gallery-caption="APE 2017 partner photo" data-gallery-image="<?php echo esc_url(neo_asset('assets/gallery/exhibitions/ape-2017-partner-delegation.jpg')); ?>" type="button">
<?php neo_image('gallery_image_025', json_decode('{"sizes": "(max-width: 700px) 100vw, 50vw", "loading": "lazy", "data-neo-image": "gallery_image_025"}', true)); ?>
<span class="gallery-caption" data-neo-field="neo_gallery_067"><?php neo_text('neo_gallery_067'); ?></span>
</button>
</figure>
<figure class="gallery-item" data-category="exhibitions">
<button data-gallery-caption="APE 2016 exhibition portrait" data-gallery-image="<?php echo esc_url(neo_asset('assets/gallery/exhibitions/ape-2016-portrait-moment.jpg')); ?>" type="button">
<?php neo_image('gallery_image_026', json_decode('{"sizes": "(max-width: 700px) 100vw, 50vw", "loading": "lazy", "data-neo-image": "gallery_image_026"}', true)); ?>
<span class="gallery-caption" data-neo-field="neo_gallery_068"><?php neo_text('neo_gallery_068'); ?></span>
</button>
</figure>
<figure class="gallery-item" data-category="exhibitions">
<button data-gallery-caption="APE 2016 exhibition team" data-gallery-image="<?php echo esc_url(neo_asset('assets/gallery/exhibitions/ape-2016-exhibition-team.jpg')); ?>" type="button">
<?php neo_image('gallery_image_027', json_decode('{"sizes": "(max-width: 700px) 100vw, 50vw", "loading": "lazy", "data-neo-image": "gallery_image_027"}', true)); ?>
<span class="gallery-caption" data-neo-field="neo_gallery_069"><?php neo_text('neo_gallery_069'); ?></span>
</button>
</figure>
<figure class="gallery-item" data-category="exhibitions">
<button data-gallery-caption="International exhibition visit" data-gallery-image="<?php echo esc_url(neo_asset('assets/gallery/exhibitions/international-exhibition-delegation.jpg')); ?>" type="button">
<?php neo_image('gallery_image_028', json_decode('{"sizes": "(max-width: 700px) 100vw, 50vw", "loading": "lazy", "data-neo-image": "gallery_image_028"}', true)); ?>
<span class="gallery-caption" data-neo-field="neo_gallery_070"><?php neo_text('neo_gallery_070'); ?></span>
</button>
</figure>
<figure class="gallery-item" data-category="exhibitions">
<button data-gallery-caption="Industry exhibition in 2019" data-gallery-image="<?php echo esc_url(neo_asset('assets/gallery/exhibitions/industry-exhibition-2019.jpg')); ?>" type="button">
<?php neo_image('gallery_image_029', json_decode('{"sizes": "(max-width: 700px) 100vw, 50vw", "loading": "lazy", "data-neo-image": "gallery_image_029"}', true)); ?>
<span class="gallery-caption" data-neo-field="neo_gallery_071"><?php neo_text('neo_gallery_071'); ?></span>
</button>
</figure>
<figure class="gallery-item" data-category="fat">
<button data-gallery-caption="Factory acceptance test visit" data-gallery-image="<?php echo esc_url(neo_asset('assets/gallery/fat/fat-facility-visit.jpg')); ?>" type="button">
<?php neo_image('gallery_image_030', json_decode('{"sizes": "(max-width: 700px) 100vw, 50vw", "loading": "lazy", "data-neo-image": "gallery_image_030"}', true)); ?>
<span class="gallery-caption" data-neo-field="neo_gallery_072"><?php neo_text('neo_gallery_072'); ?></span>
</button>
</figure>
<figure class="gallery-item" data-category="fat">
<button data-gallery-caption="FAT documentation and review" data-gallery-image="<?php echo esc_url(neo_asset('assets/gallery/fat/fat-documentation-review.jpg')); ?>" type="button">
<?php neo_image('gallery_image_031', json_decode('{"sizes": "(max-width: 700px) 100vw, 50vw", "loading": "lazy", "data-neo-image": "gallery_image_031"}', true)); ?>
<span class="gallery-caption" data-neo-field="neo_gallery_073"><?php neo_text('neo_gallery_073'); ?></span>
</button>
</figure>
<figure class="gallery-item" data-category="fat">
<button data-gallery-caption="Factory acceptance test equipment area" data-gallery-image="<?php echo esc_url(neo_asset('assets/gallery/fat/fat-equipment-staging.jpg')); ?>" type="button">
<?php neo_image('gallery_image_032', json_decode('{"sizes": "(max-width: 700px) 100vw, 50vw", "loading": "lazy", "data-neo-image": "gallery_image_032"}', true)); ?>
<span class="gallery-caption" data-neo-field="neo_gallery_074"><?php neo_text('neo_gallery_074'); ?></span>
</button>
</figure>
<figure class="gallery-item" data-category="fat">
<button data-gallery-caption="FAT technical inspection" data-gallery-image="<?php echo esc_url(neo_asset('assets/gallery/fat/fat-technical-inspection.jpg')); ?>" type="button">
<?php neo_image('gallery_image_033', json_decode('{"sizes": "(max-width: 700px) 100vw, 50vw", "loading": "lazy", "data-neo-image": "gallery_image_033"}', true)); ?>
<span class="gallery-caption" data-neo-field="neo_gallery_075"><?php neo_text('neo_gallery_075'); ?></span>
</button>
</figure>
<figure class="gallery-item" data-category="fat">
<button data-gallery-caption="Factory acceptance test group moment" data-gallery-image="<?php echo esc_url(neo_asset('assets/gallery/fat/fat-delegation-group.jpg')); ?>" type="button">
<?php neo_image('gallery_image_034', json_decode('{"sizes": "(max-width: 700px) 100vw, 50vw", "loading": "lazy", "data-neo-image": "gallery_image_034"}', true)); ?>
<span class="gallery-caption" data-neo-field="neo_gallery_076"><?php neo_text('neo_gallery_076'); ?></span>
</button>
</figure>
<figure class="gallery-item" data-category="service">
<button data-gallery-caption="Neo Associates service activity" data-gallery-image="<?php echo esc_url(neo_asset('assets/gallery/service/field-service-activity.jpg')); ?>" type="button">
<?php neo_image('gallery_image_035', json_decode('{"sizes": "(max-width: 700px) 100vw, 50vw", "loading": "lazy", "data-neo-image": "gallery_image_035"}', true)); ?>
<span class="gallery-caption" data-neo-field="neo_gallery_077"><?php neo_text('neo_gallery_077'); ?></span>
</button>
</figure>
<figure class="gallery-item" data-category="service">
<button data-gallery-caption="Technical service support" data-gallery-image="<?php echo esc_url(neo_asset('assets/gallery/service/technical-service-support.jpg')); ?>" type="button">
<?php neo_image('gallery_image_036', json_decode('{"sizes": "(max-width: 700px) 100vw, 50vw", "loading": "lazy", "data-neo-image": "gallery_image_036"}', true)); ?>
<span class="gallery-caption" data-neo-field="neo_gallery_078"><?php neo_text('neo_gallery_078'); ?></span>
</button>
</figure>
<figure class="gallery-item" data-category="service">
<button data-gallery-caption="Training and technical discussion" data-gallery-image="<?php echo esc_url(neo_asset('assets/gallery/service/technical-training-discussion.jpg')); ?>" type="button">
<?php neo_image('gallery_image_037', json_decode('{"sizes": "(max-width: 700px) 100vw, 50vw", "loading": "lazy", "data-neo-image": "gallery_image_037"}', true)); ?>
<span class="gallery-caption" data-neo-field="neo_gallery_079"><?php neo_text('neo_gallery_079'); ?></span>
</button>
</figure>
<figure class="gallery-item" data-category="service">
<button data-gallery-caption="Office and project coordination" data-gallery-image="<?php echo esc_url(neo_asset('assets/gallery/service/office-project-coordination.jpg')); ?>" type="button">
<?php neo_image('gallery_image_038', json_decode('{"sizes": "(max-width: 700px) 100vw, 50vw", "loading": "lazy", "data-neo-image": "gallery_image_038"}', true)); ?>
<span class="gallery-caption" data-neo-field="neo_gallery_080"><?php neo_text('neo_gallery_080'); ?></span>
</button>
</figure>
<figure class="gallery-item" data-category="team">
<button data-gallery-caption="Neo Associates family day 2018" data-gallery-image="<?php echo esc_url(neo_asset('assets/gallery/team/annual-family-day-2018.jpg')); ?>" type="button">
<?php neo_image('gallery_image_039', json_decode('{"sizes": "(max-width: 700px) 100vw, 50vw", "loading": "lazy", "data-neo-image": "gallery_image_039"}', true)); ?>
<span class="gallery-caption" data-neo-field="neo_gallery_081"><?php neo_text('neo_gallery_081'); ?></span>
</button>
</figure>
<figure class="gallery-item" data-category="team">
<button data-gallery-caption="Neo Associates team portrait" data-gallery-image="<?php echo esc_url(neo_asset('assets/gallery/team/technical-certification-portrait.jpg')); ?>" type="button">
<?php neo_image('gallery_image_040', json_decode('{"sizes": "(max-width: 700px) 100vw, 50vw", "loading": "lazy", "data-neo-image": "gallery_image_040"}', true)); ?>
<span class="gallery-caption" data-neo-field="neo_gallery_082"><?php neo_text('neo_gallery_082'); ?></span>
</button>
</figure>
<figure class="gallery-item" data-category="team">
<button data-gallery-caption="Neo Associates family picnic" data-gallery-image="<?php echo esc_url(neo_asset('assets/gallery/team/family-picnic.jpg')); ?>" type="button">
<?php neo_image('gallery_image_041', json_decode('{"sizes": "(max-width: 700px) 100vw, 50vw", "loading": "lazy", "data-neo-image": "gallery_image_041"}', true)); ?>
<span class="gallery-caption" data-neo-field="neo_gallery_083"><?php neo_text('neo_gallery_083'); ?></span>
</button>
</figure>
<figure class="gallery-item" data-category="team">
<button data-gallery-caption="Neo Associates team gathering in Cox's Bazar" data-gallery-image="<?php echo esc_url(neo_asset('assets/gallery/team/cox-bazar-team.jpg')); ?>" type="button">
<?php neo_image('gallery_image_042', json_decode('{"sizes": "(max-width: 700px) 100vw, 50vw", "loading": "lazy", "data-neo-image": "gallery_image_042"}', true)); ?>
<span class="gallery-caption" data-neo-field="neo_gallery_084"><?php neo_text('neo_gallery_084'); ?></span>
</button>
</figure>
<figure class="gallery-item" data-category="team">
<button data-gallery-caption="Team activity in 2023" data-gallery-image="<?php echo esc_url(neo_asset('assets/gallery/team/project-support-activity.jpg')); ?>" type="button">
<?php neo_image('gallery_image_043', json_decode('{"sizes": "(max-width: 700px) 100vw, 50vw", "loading": "lazy", "data-neo-image": "gallery_image_043"}', true)); ?>
<span class="gallery-caption" data-neo-field="neo_gallery_085"><?php neo_text('neo_gallery_085'); ?></span>
</button>
</figure>
<figure class="gallery-item" data-category="team">
<button data-gallery-caption="Project team moment in 2023" data-gallery-image="<?php echo esc_url(neo_asset('assets/gallery/team/service-engineering-field.jpg')); ?>" type="button">
<?php neo_image('gallery_image_044', json_decode('{"sizes": "(max-width: 700px) 100vw, 50vw", "loading": "lazy", "data-neo-image": "gallery_image_044"}', true)); ?>
<span class="gallery-caption" data-neo-field="neo_gallery_086"><?php neo_text('neo_gallery_086'); ?></span>
</button>
</figure>
<figure class="gallery-item" data-category="team">
<button data-gallery-caption="Neo Associates team moment" data-gallery-image="<?php echo esc_url(neo_asset('assets/gallery/team/team-milestone-gathering.jpg')); ?>" type="button">
<?php neo_image('gallery_image_045', json_decode('{"sizes": "(max-width: 700px) 100vw, 50vw", "loading": "lazy", "data-neo-image": "gallery_image_045"}', true)); ?>
<span class="gallery-caption" data-neo-field="neo_gallery_087"><?php neo_text('neo_gallery_087'); ?></span>
</button>
</figure>
<figure class="gallery-item" data-category="team">
<button data-gallery-caption="Neo Associates work moment" data-gallery-image="<?php echo esc_url(neo_asset('assets/gallery/team/engineering-work-moment.jpg')); ?>" type="button">
<?php neo_image('gallery_image_046', json_decode('{"sizes": "(max-width: 700px) 100vw, 50vw", "loading": "lazy", "data-neo-image": "gallery_image_046"}', true)); ?>
<span class="gallery-caption" data-neo-field="neo_gallery_088"><?php neo_text('neo_gallery_088'); ?></span>
</button>
</figure>
<figure class="gallery-item" data-category="team">
<button data-gallery-caption="Industry gathering" data-gallery-image="<?php echo esc_url(neo_asset('assets/gallery/team/industry-delegation-gathering.jpg')); ?>" type="button">
<?php neo_image('gallery_image_047', json_decode('{"sizes": "(max-width: 700px) 100vw, 50vw", "loading": "lazy", "data-neo-image": "gallery_image_047"}', true)); ?>
<span class="gallery-caption" data-neo-field="neo_gallery_089"><?php neo_text('neo_gallery_089'); ?></span>
</button>
</figure>
<figure class="gallery-item" data-category="team">
<button data-gallery-caption="Team and seminar activity" data-gallery-image="<?php echo esc_url(neo_asset('assets/gallery/team/seminar-activity-session.jpg')); ?>" type="button">
<?php neo_image('gallery_image_048', json_decode('{"sizes": "(max-width: 700px) 100vw, 50vw", "loading": "lazy", "data-neo-image": "gallery_image_048"}', true)); ?>
<span class="gallery-caption" data-neo-field="neo_gallery_090"><?php neo_text('neo_gallery_090'); ?></span>
</button>
</figure>
<figure class="gallery-item" data-category="team">
<button data-gallery-caption="Team seminar moment" data-gallery-image="<?php echo esc_url(neo_asset('assets/gallery/team/seminar-interaction-moment.jpg')); ?>" type="button">
<?php neo_image('gallery_image_049', json_decode('{"sizes": "(max-width: 700px) 100vw, 50vw", "loading": "lazy", "data-neo-image": "gallery_image_049"}', true)); ?>
<span class="gallery-caption" data-neo-field="neo_gallery_091"><?php neo_text('neo_gallery_091'); ?></span>
</button>
</figure>
<figure class="gallery-item" data-category="team">
<button data-gallery-caption="Audience at a technical event" data-gallery-image="<?php echo esc_url(neo_asset('assets/gallery/team/technical-event-audience.jpg')); ?>" type="button">
<?php neo_image('gallery_image_050', json_decode('{"sizes": "(max-width: 700px) 100vw, 50vw", "loading": "lazy", "data-neo-image": "gallery_image_050"}', true)); ?>
<span class="gallery-caption" data-neo-field="neo_gallery_092"><?php neo_text('neo_gallery_092'); ?></span>
</button>
</figure>
<figure class="gallery-item" data-category="team">
<button data-gallery-caption="Industry guests during a session" data-gallery-image="<?php echo esc_url(neo_asset('assets/gallery/team/industry-guests-session.jpg')); ?>" type="button">
<?php neo_image('gallery_image_051', json_decode('{"sizes": "(max-width: 700px) 100vw, 50vw", "loading": "lazy", "data-neo-image": "gallery_image_051"}', true)); ?>
<span class="gallery-caption" data-neo-field="neo_gallery_093"><?php neo_text('neo_gallery_093'); ?></span>
</button>
</figure>
</div>
</section>
</main>