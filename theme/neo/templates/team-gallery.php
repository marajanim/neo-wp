<?php defined('ABSPATH') || exit; ?>
<main id="top">
<section aria-labelledby="team-gallery-title" class="gallery-hero">
<?php neo_image('team_gallery_image_001', json_decode('{"sizes": "1600px", "data-team-gallery-hero": "", "fetchpriority": "high", "data-neo-image": "team_gallery_image_001"}', true)); ?>
<div class="gallery-hero-content">
<p class="eyebrow" data-neo-field="neo_team_gallery_008" data-team-gallery-eyebrow=""><?php neo_text('neo_team_gallery_008'); ?></p>
<h1 class="hero-title" id="team-gallery-title">
<span class="hero-title-line" data-neo-field="neo_team_gallery_009" data-team-gallery-title-primary=""><?php neo_text('neo_team_gallery_009'); ?></span>
<span class="hero-title-line">
<span class="hero-title-serif" data-neo-field="neo_team_gallery_010" data-team-gallery-title-serif=""><?php neo_text('neo_team_gallery_010'); ?></span>
<span data-neo-field="neo_team_gallery_011" data-team-gallery-title-end=""><?php neo_text('neo_team_gallery_011'); ?></span>
</span>
</h1>
<p data-neo-field="neo_team_gallery_012" data-team-gallery-description=""><?php neo_text('neo_team_gallery_012'); ?></p>
</div>
</section>
<section aria-label="Category gallery overview" class="gallery-intro-section">
<div>
<p class="eyebrow" data-neo-field="neo_team_gallery_013"><?php neo_text('neo_team_gallery_013'); ?></p>
<h2 data-neo-field="neo_team_gallery_014" data-team-gallery-intro=""><?php neo_text('neo_team_gallery_014'); ?></h2>
</div>
<div class="gallery-intro-copy">
<p><span data-team-gallery-count="">0</span> gallery images. Select any image for a larger view.</p>
<a class="text-link gallery-back-link no-word-reveal" data-neo-field="neo_team_gallery_015" href="<?php echo esc_url(neo_page_link('index.html#team')); ?>"><?php neo_text('neo_team_gallery_015'); ?></a>
</div>
</section>
<section aria-labelledby="team-gallery-wall-title" class="gallery-wall-section">
<div class="gallery-wall-heading">
<div>
<p class="eyebrow" data-neo-field="neo_team_gallery_016"><?php neo_text('neo_team_gallery_016'); ?></p>
<h2 data-neo-field="neo_team_gallery_017" data-team-gallery-wall-title="" id="team-gallery-wall-title"><?php neo_text('neo_team_gallery_017'); ?></h2>
</div>
</div>
<div class="gallery-grid" data-team-gallery-grid=""></div>
</section>
</main>