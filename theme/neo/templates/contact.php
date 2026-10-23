<?php defined('ABSPATH') || exit; ?>
<main class="contact-page" id="top">
<section aria-labelledby="contact-title" class="contact-hero">
<div class="contact-hero-layout">
<div class="contact-hero-copy">
<p class="eyebrow" data-neo-field="neo_contact_008"><?php neo_text('neo_contact_008'); ?></p>
<h1 data-neo-field="neo_contact_009" id="contact-title"><?php neo_text('neo_contact_009'); ?></h1>
<p data-neo-field="neo_contact_010"><?php neo_text('neo_contact_010'); ?></p>
</div>
<div aria-label="Quick contact options" class="contact-quick-grid">
<a class="contact-quick-card contact-quick-card-primary" href="mailto:office@neo-bd.com?subject=Pharmaceutical%20machinery%20project%20request">
<span data-neo-field="neo_contact_011"><?php neo_text('neo_contact_011'); ?></span>
<strong data-neo-field="neo_contact_012"><?php neo_text('neo_contact_012'); ?></strong>
<small data-neo-field="neo_contact_013"><?php neo_text('neo_contact_013'); ?></small>
</a>
<a class="contact-quick-card" href="<?php echo esc_url(neo_page_link('products-services.html')); ?>">
<span data-neo-field="neo_contact_014"><?php neo_text('neo_contact_014'); ?></span>
<strong data-neo-field="neo_contact_015"><?php neo_text('neo_contact_015'); ?></strong>
<small data-neo-field="neo_contact_016"><?php neo_text('neo_contact_016'); ?></small>
</a>
<a class="contact-quick-card" href="<?php echo esc_url(neo_page_link('associates.html')); ?>">
<span data-neo-field="neo_contact_017"><?php neo_text('neo_contact_017'); ?></span>
<strong data-neo-field="neo_contact_018"><?php neo_text('neo_contact_018'); ?></strong>
<small data-neo-field="neo_contact_019"><?php neo_text('neo_contact_019'); ?></small>
</a>
</div>
</div>
</section>
<section aria-labelledby="contact-form-title" class="contact-main-section">
<div class="contact-form-panel">
<p class="eyebrow" data-neo-field="neo_contact_020"><?php neo_text('neo_contact_020'); ?></p>
<h2 data-neo-field="neo_contact_021" id="contact-form-title"><?php neo_text('neo_contact_021'); ?></h2>
<p data-neo-field="neo_contact_022"><?php neo_text('neo_contact_022'); ?></p>
<?php $neo_contact_status=sanitize_key($_GET['contact']??''); if ($neo_contact_status) : ?>
<p class="contact-form-notice contact-form-notice-<?php echo esc_attr($neo_contact_status); ?>" role="status"><?php echo esc_html(['sent'=>'Thank you — your message has been received. Our team will get back to you shortly.','invalid'=>'Please fill in your name, a valid email, the topic and your message, then send again.'][$neo_contact_status]??'Sorry, something went wrong. Please try again or email office@neo-bd.com directly.'); ?></p>
<?php endif; ?>
<form action="<?php echo esc_url(admin_url('admin-post.php')); ?>" class="contact-form" method="post">
<input name="action" type="hidden" value="neo_contact"/>
<input name="neo_ts" type="hidden" value="<?php echo time(); ?>"/>
<div aria-hidden="true" style="position:absolute;left:-9999px;width:1px;height:1px;overflow:hidden"><label>Website <input autocomplete="off" name="website" tabindex="-1" type="text"/></label></div>
<div class="contact-form-grid">
<label class="contact-field">
<span data-neo-field="neo_contact_023"><?php neo_text('neo_contact_023'); ?></span>
<input autocomplete="name" maxlength="200" name="name" required="" type="text"/>
</label>
<label class="contact-field">
<span data-neo-field="neo_contact_024"><?php neo_text('neo_contact_024'); ?></span>
<input autocomplete="organization" maxlength="200" name="company" type="text"/>
</label>
<label class="contact-field">
<span data-neo-field="neo_contact_025"><?php neo_text('neo_contact_025'); ?></span>
<input autocomplete="email" maxlength="200" name="email" required="" type="email"/>
</label>
<label class="contact-field">
<span data-neo-field="neo_contact_026"><?php neo_text('neo_contact_026'); ?></span>
<input autocomplete="tel" maxlength="50" name="phone" type="tel"/>
</label>
</div>
<label class="contact-field">
<span data-neo-field="neo_contact_027"><?php neo_text('neo_contact_027'); ?></span>
<select name="inquiry_type" required="">
<option value="">Select a topic</option>
<option>New project inquiry</option>
<option>Technical service support</option>
<option>Principal or associate coordination</option>
<option>Product and machinery information</option>
</select>
</label>
<label class="contact-field">
<span data-neo-field="neo_contact_028"><?php neo_text('neo_contact_028'); ?></span>
<textarea maxlength="5000" name="message" placeholder="Tell us about the process, product line, machine, timeline, or support you need." required="" rows="7"></textarea>
</label>
<div class="contact-form-actions">
<button class="contact-submit" data-neo-field="neo_contact_029" type="submit"><?php neo_text('neo_contact_029'); ?></button>
<span data-neo-field="neo_contact_030"><?php neo_text('neo_contact_030'); ?></span>
</div>
</form>
</div>
<aside aria-label="Contact support information" class="contact-info-stack">
<article class="contact-info-card contact-info-card-highlight">
<span data-neo-field="neo_contact_031"><?php neo_text('neo_contact_031'); ?></span>
<h2 data-neo-field="neo_contact_032"><?php neo_text('neo_contact_032'); ?></h2>
<p data-neo-field="neo_contact_033"><?php neo_text('neo_contact_033'); ?></p>
<a data-neo-field="neo_contact_034" href="mailto:office@neo-bd.com?subject=Pharmaceutical%20machinery%20project%20request"><?php neo_text('neo_contact_034'); ?></a>
</article>
<article class="contact-info-card">
<span data-neo-field="neo_contact_035"><?php neo_text('neo_contact_035'); ?></span>
<h2 data-neo-field="neo_contact_036"><?php neo_text('neo_contact_036'); ?></h2>
<ul>
<li data-neo-field="neo_contact_037"><?php neo_text('neo_contact_037'); ?></li>
<li data-neo-field="neo_contact_038"><?php neo_text('neo_contact_038'); ?></li>
<li data-neo-field="neo_contact_039"><?php neo_text('neo_contact_039'); ?></li>
<li data-neo-field="neo_contact_040"><?php neo_text('neo_contact_040'); ?></li>
</ul>
</article>
<article class="contact-info-card">
<span data-neo-field="neo_contact_041"><?php neo_text('neo_contact_041'); ?></span>
<h2 data-neo-field="neo_contact_042"><?php neo_text('neo_contact_042'); ?></h2>
<p data-neo-field="neo_contact_043"><?php neo_text('neo_contact_043'); ?></p>
</article>
</aside>
</section>
<section aria-labelledby="contact-band-title" class="contact-band">
<div>
<p class="eyebrow" data-neo-field="neo_contact_044"><?php neo_text('neo_contact_044'); ?></p>
<h2 data-neo-field="neo_contact_045" id="contact-band-title"><?php neo_text('neo_contact_045'); ?></h2>
</div>
<a data-neo-field="neo_contact_046" href="mailto:office@neo-bd.com?subject=Pharmaceutical%20machinery%20project%20request"><?php neo_text('neo_contact_046'); ?></a>
</section>
</main>