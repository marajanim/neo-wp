<?php
defined('ABSPATH') || exit;
get_header();
$source=get_post_meta(get_queried_object_id(),'_neo_source',true);
if (in_array($source,['index','about','products-services','associates','team-organogram','gallery','team-gallery','training-gallery','contact'],true)) {
    get_template_part('templates/'.$source);
} else {
    echo '<main id="top" class="neo-default-page">';
    if (have_posts()) while(have_posts()) { the_post(); the_title('<h1>','</h1>'); the_content(); }
    else { echo '<h1>'.esc_html__('Page not found','neo').'</h1>'; }
    echo '</main>';
}
get_footer();
