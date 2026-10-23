<?php defined('ABSPATH') || exit; ?>
<main id="top">
<section aria-labelledby="training-gallery-title" class="gallery-hero">
<?php neo_image('training_gallery_image_001', json_decode('{"sizes": "100vw", "fetchpriority": "high", "data-neo-image": "training_gallery_image_001"}', true)); ?>
<div class="gallery-hero-content">
<p class="eyebrow" data-neo-field="neo_training_gallery_008"><?php neo_text('neo_training_gallery_008'); ?></p>
<h1 class="hero-title" id="training-gallery-title">
<span class="hero-title-line" data-neo-field="neo_training_gallery_009"><?php neo_text('neo_training_gallery_009'); ?></span>
<span class="hero-title-line"><span class="hero-title-serif" data-neo-field="neo_training_gallery_010"><?php neo_text('neo_training_gallery_010'); ?></span> <span data-neo-field="neo_training_gallery_011"><?php neo_text('neo_training_gallery_011'); ?></span></span>
</h1>
<p data-neo-field="neo_training_gallery_012"><?php neo_text('neo_training_gallery_012'); ?></p>
</div>
</section>
<section aria-label="Training gallery overview" class="gallery-intro-section">
<div>
<p class="eyebrow" data-neo-field="neo_training_gallery_013"><?php neo_text('neo_training_gallery_013'); ?></p>
<h2 data-neo-field="neo_training_gallery_014"><?php neo_text('neo_training_gallery_014'); ?></h2>
</div>
<div class="gallery-intro-copy">
<p data-neo-field="neo_training_gallery_015"><?php neo_text('neo_training_gallery_015'); ?></p>
<a class="text-link" data-neo-field="neo_training_gallery_016" href="<?php echo esc_url(neo_page_link('index.html#team')); ?>"><?php neo_text('neo_training_gallery_016'); ?></a>
</div>
</section>
<section aria-labelledby="training-wall-title" class="gallery-wall-section">
<div class="gallery-wall-heading">
<div>
<p class="eyebrow" data-neo-field="neo_training_gallery_017"><?php neo_text('neo_training_gallery_017'); ?></p>
<h2 data-neo-field="neo_training_gallery_018" id="training-wall-title"><?php neo_text('neo_training_gallery_018'); ?></h2>
</div>
<div aria-label="Filter training gallery" class="gallery-filters">
<button aria-pressed="true" class="gallery-filter active" data-filter="all" data-neo-field="neo_training_gallery_019" type="button"><?php neo_text('neo_training_gallery_019'); ?></button>
<button aria-pressed="false" class="gallery-filter" data-filter="training" data-neo-field="neo_training_gallery_020" type="button"><?php neo_text('neo_training_gallery_020'); ?></button>
<button aria-pressed="false" class="gallery-filter" data-filter="seminars" data-neo-field="neo_training_gallery_021" type="button"><?php neo_text('neo_training_gallery_021'); ?></button>
<button aria-pressed="false" class="gallery-filter" data-filter="fat" data-neo-field="neo_training_gallery_022" type="button"><?php neo_text('neo_training_gallery_022'); ?></button>
</div>
</div>
<div class="gallery-grid">
<figure class="gallery-item gallery-item-feature" data-category="training">
<button data-gallery-caption="Training and technical discussion" data-gallery-image="<?php echo esc_url(neo_asset('assets/gallery/service/technical-training-discussion.jpg')); ?>" type="button">
<?php neo_image('training_gallery_image_002', json_decode('{"sizes": "(max-width: 700px) 100vw, 50vw", "loading": "lazy", "data-neo-image": "training_gallery_image_002"}', true)); ?>
<span class="gallery-caption" data-neo-field="neo_training_gallery_023"><?php neo_text('neo_training_gallery_023'); ?></span>
</button>
</figure>
<figure class="gallery-item" data-category="training">
<button data-gallery-caption="Technical training certificate moment" data-gallery-image="<?php echo esc_url(neo_asset('assets/gallery/team/technical-certification-portrait.jpg')); ?>" type="button">
<?php neo_image('training_gallery_image_003', json_decode('{"sizes": "(max-width: 700px) 100vw, 50vw", "loading": "lazy", "data-neo-image": "training_gallery_image_003"}', true)); ?>
<span class="gallery-caption" data-neo-field="neo_training_gallery_024"><?php neo_text('neo_training_gallery_024'); ?></span>
</button>
</figure>
<figure class="gallery-item" data-category="seminars">
<button data-gallery-caption="Technical seminar with pharmaceutical industry attendees" data-gallery-image="<?php echo esc_url(neo_asset('assets/gallery/seminars/technical-seminar-attendees.jpg')); ?>" type="button">
<?php neo_image('training_gallery_image_004', json_decode('{"sizes": "(max-width: 700px) 100vw, 50vw", "loading": "lazy", "data-neo-image": "training_gallery_image_004"}', true)); ?>
<span class="gallery-caption" data-neo-field="neo_training_gallery_025"><?php neo_text('neo_training_gallery_025'); ?></span>
</button>
</figure>
<figure class="gallery-item" data-category="seminars">
<button data-gallery-caption="Marchesini seminar with Neo Associates and industry partners" data-gallery-image="<?php echo esc_url(neo_asset('assets/gallery/seminars/marchesini-seminar.jpg')); ?>" type="button">
<?php neo_image('training_gallery_image_005', json_decode('{"sizes": "(max-width: 700px) 100vw, 50vw", "loading": "lazy", "data-neo-image": "training_gallery_image_005"}', true)); ?>
<span class="gallery-caption" data-neo-field="neo_training_gallery_026"><?php neo_text('neo_training_gallery_026'); ?></span>
</button>
</figure>
<figure class="gallery-item" data-category="seminars">
<button data-gallery-caption="Tofflon seminar with pharmaceutical industry guests" data-gallery-image="<?php echo esc_url(neo_asset('assets/gallery/seminars/tofflon-seminar.jpg')); ?>" type="button">
<?php neo_image('training_gallery_image_006', json_decode('{"sizes": "(max-width: 700px) 100vw, 50vw", "loading": "lazy", "data-neo-image": "training_gallery_image_006"}', true)); ?>
<span class="gallery-caption" data-neo-field="neo_training_gallery_027"><?php neo_text('neo_training_gallery_027'); ?></span>
</button>
</figure>
<figure class="gallery-item" data-category="seminars">
<button data-gallery-caption="Tofflon technical seminar and partner session" data-gallery-image="<?php echo esc_url(neo_asset('assets/gallery/seminars/tofflon-seminar-session.jpg')); ?>" type="button">
<?php neo_image('training_gallery_image_007', json_decode('{"sizes": "(max-width: 700px) 100vw, 50vw", "loading": "lazy", "data-neo-image": "training_gallery_image_007"}', true)); ?>
<span class="gallery-caption" data-neo-field="neo_training_gallery_028"><?php neo_text('neo_training_gallery_028'); ?></span>
</button>
</figure>
<figure class="gallery-item" data-category="seminars">
<button data-gallery-caption="DR seminar for pharmaceutical professionals" data-gallery-image="<?php echo esc_url(neo_asset('assets/gallery/seminars/dr-pharmaceutical-seminar.jpg')); ?>" type="button">
<?php neo_image('training_gallery_image_008', json_decode('{"sizes": "(max-width: 700px) 100vw, 50vw", "loading": "lazy", "data-neo-image": "training_gallery_image_008"}', true)); ?>
<span class="gallery-caption" data-neo-field="neo_training_gallery_029"><?php neo_text('neo_training_gallery_029'); ?></span>
</button>
</figure>
<figure class="gallery-item" data-category="seminars">
<button data-gallery-caption="Tofflon seminar hosted with industry guests" data-gallery-image="<?php echo esc_url(neo_asset('assets/gallery/seminars/tofflon-industry-seminar.jpg')); ?>" type="button">
<?php neo_image('training_gallery_image_009', json_decode('{"sizes": "(max-width: 700px) 100vw, 50vw", "loading": "lazy", "data-neo-image": "training_gallery_image_009"}', true)); ?>
<span class="gallery-caption" data-neo-field="neo_training_gallery_030"><?php neo_text('neo_training_gallery_030'); ?></span>
</button>
</figure>
<figure class="gallery-item" data-category="fat">
<button data-gallery-caption="Factory acceptance test visit" data-gallery-image="<?php echo esc_url(neo_asset('assets/gallery/fat/fat-facility-visit.jpg')); ?>" type="button">
<?php neo_image('training_gallery_image_010', json_decode('{"sizes": "(max-width: 700px) 100vw, 50vw", "loading": "lazy", "data-neo-image": "training_gallery_image_010"}', true)); ?>
<span class="gallery-caption" data-neo-field="neo_training_gallery_031"><?php neo_text('neo_training_gallery_031'); ?></span>
</button>
</figure>
<figure class="gallery-item" data-category="fat">
<button data-gallery-caption="FAT documentation and review" data-gallery-image="<?php echo esc_url(neo_asset('assets/gallery/fat/fat-documentation-review.jpg')); ?>" type="button">
<?php neo_image('training_gallery_image_011', json_decode('{"sizes": "(max-width: 700px) 100vw, 50vw", "loading": "lazy", "data-neo-image": "training_gallery_image_011"}', true)); ?>
<span class="gallery-caption" data-neo-field="neo_training_gallery_032"><?php neo_text('neo_training_gallery_032'); ?></span>
</button>
</figure>
<figure class="gallery-item" data-category="fat">
<button data-gallery-caption="Factory acceptance test equipment area" data-gallery-image="<?php echo esc_url(neo_asset('assets/gallery/fat/fat-equipment-staging.jpg')); ?>" type="button">
<?php neo_image('training_gallery_image_012', json_decode('{"sizes": "(max-width: 700px) 100vw, 50vw", "loading": "lazy", "data-neo-image": "training_gallery_image_012"}', true)); ?>
<span class="gallery-caption" data-neo-field="neo_training_gallery_033"><?php neo_text('neo_training_gallery_033'); ?></span>
</button>
</figure>
<figure class="gallery-item" data-category="fat">
<button data-gallery-caption="FAT technical inspection" data-gallery-image="<?php echo esc_url(neo_asset('assets/gallery/fat/fat-technical-inspection.jpg')); ?>" type="button">
<?php neo_image('training_gallery_image_013', json_decode('{"sizes": "(max-width: 700px) 100vw, 50vw", "loading": "lazy", "data-neo-image": "training_gallery_image_013"}', true)); ?>
<span class="gallery-caption" data-neo-field="neo_training_gallery_034"><?php neo_text('neo_training_gallery_034'); ?></span>
</button>
</figure>
<figure class="gallery-item" data-category="fat">
<button data-gallery-caption="Factory acceptance test group moment" data-gallery-image="<?php echo esc_url(neo_asset('assets/gallery/fat/fat-delegation-group.jpg')); ?>" type="button">
<?php neo_image('training_gallery_image_014', json_decode('{"sizes": "(max-width: 700px) 100vw, 50vw", "loading": "lazy", "data-neo-image": "training_gallery_image_014"}', true)); ?>
<span class="gallery-caption" data-neo-field="neo_training_gallery_035"><?php neo_text('neo_training_gallery_035'); ?></span>
</button>
</figure>
</div>
</section>
</main>