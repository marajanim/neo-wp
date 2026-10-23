<?php defined('ABSPATH') || exit; neo_set_owner(get_queried_object_id()); ?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head><meta charset="<?php bloginfo('charset'); ?>"><meta name="viewport" content="width=device-width, initial-scale=1"><?php wp_head(); ?></head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<div class="cursor" aria-hidden="true"><span class="cursor-ring"></span><span class="cursor-dot"></span></div>
<header class="site-header" aria-label="<?php esc_attr_e('Primary navigation','neo'); ?>">
  <a class="brand" href="<?php echo esc_url(home_url('/')); ?>" aria-label="<?php echo esc_attr(get_bloginfo('name')); ?>">
    <?php $logo=get_theme_mod('custom_logo'); if ($logo) echo wp_get_attachment_image($logo,'full',false,['alt'=>get_bloginfo('name'),'data-neo-image'=>'site_image_001','data-neo-owner'=>'0']); ?>
  </a>
  <nav class="nav-links" id="primary-menu" aria-label="<?php esc_attr_e('Site sections','neo'); ?>"><?php neo_menu('primary','neo-primary-menu'); ?></nav>
  <?php neo_menu('header_cta','neo-header-cta'); ?>
  <button class="nav-menu-toggle" type="button" aria-expanded="false" aria-controls="primary-menu" aria-label="<?php esc_attr_e('Open navigation menu','neo'); ?>"><span></span><span></span><span></span></button>
</header>
