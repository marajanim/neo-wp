<?php defined('ABSPATH') || exit; neo_set_owner(0); ?>
<footer aria-label="Site footer" class="site-footer" data-neo-owner="0">
<div class="footer-grid">
<div class="footer-company">
<a aria-label="Neo Associates home" class="footer-brand" href="<?php echo esc_url(neo_page_link('index.html#top')); ?>">
<?php neo_image('site_image_001', json_decode('{"data-neo-image": "site_image_001"}', true)); ?>
</a>
<p data-neo-field="site_neo_index_210"><?php neo_text('site_neo_index_210'); ?></p>
</div>
<div class="footer-column">
<h2 data-neo-field="site_neo_index_211"><?php neo_text('site_neo_index_211'); ?></h2>
<p>
<a data-neo-field="site_neo_index_212" href="mailto:office@neo-bd.com?subject=Pharmaceutical%20machinery%20project%20request"><?php neo_text('site_neo_index_212'); ?></a>
<a data-neo-field="site_neo_index_213" href="tel:+8801709661600"><?php neo_text('site_neo_index_213'); ?></a>
<span data-neo-field="site_neo_index_214"><?php neo_text('site_neo_index_214'); ?></span>
<span data-neo-field="site_neo_index_215"><?php neo_text('site_neo_index_215'); ?></span>
</p>
</div>
<div class="footer-column">
<h2 data-neo-field="site_neo_index_216"><?php neo_text('site_neo_index_216'); ?></h2>
<?php neo_menu('footer_pages', 'footer-list'); ?>
</div>
<div class="footer-column">
<h2 data-neo-field="site_neo_index_224"><?php neo_text('site_neo_index_224'); ?></h2>
<div aria-label="Social media" class="footer-social-links"><?php neo_menu('footer_social', 'neo-social-menu'); ?></div>
<?php neo_menu('footer_connect', 'footer-list'); ?>
</div>
</div>
<div class="footer-bottom">
<p data-neo-field="site_neo_index_225"><?php neo_text('site_neo_index_225'); ?></p>
</div>
</footer>
<?php wp_footer(); ?>
</body></html>
