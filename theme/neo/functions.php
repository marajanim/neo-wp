<?php
defined('ABSPATH') || exit;
function neo_set_owner($owner) { $GLOBALS['neo_owner']=(int)$owner; }
function neo_owner() { return $GLOBALS['neo_owner']??get_queried_object_id(); }
function neo_value($key) {
    if (function_exists('neo_content_value')) return neo_content_value(neo_owner(),$key);
    return neo_owner()?get_post_meta(neo_owner(),$key,true):(get_option('neo_site_values',[])[$key]??'');
}
function neo_text($key) { echo nl2br(esc_html((string)neo_value($key)),false); }
function neo_counter($key,$suffix=false) {
    preg_match('/^(\d+)(.*)$/',(string)neo_value($key),$match);
    return $suffix?($match[2]??''):($match[1]??0);
}
function neo_media_url($key) { return wp_get_attachment_url(absint(neo_value($key)))?:''; }
function neo_image($key,$attributes=[]) {
    $id=absint(neo_value($key));
    if (!$id) return;
    $attributes['data-neo-owner']=neo_owner();
    echo wp_get_attachment_image($id,'full',false,$attributes);
}
function neo_asset($path) { return get_theme_file_uri('/'.ltrim($path,'/')); }
function neo_page_link($path) {
    if (str_starts_with($path,'#')) return $path;
    preg_match('/^([a-z0-9-]+)\.html(.*)$/',$path,$parts);
    if (!$parts) return $path;
    $ids=get_option('neo_page_ids',[]);
    return (isset($ids[$parts[1]])?get_permalink($ids[$parts[1]]):home_url('/')).($parts[2]??'');
}
function neo_menu($location,$class) {
    $args=['theme_location'=>$location,'container'=>false,'fallback_cb'=>false,'menu_class'=>$class,'depth'=>3];
    if (in_array($location,['primary','header_cta','footer_social'],true)) $args+=['items_wrap'=>'%3$s','walker'=>new Neo_Primary_Walker()];
    wp_nav_menu($args);
}
class Neo_Primary_Walker extends Walker_Nav_Menu {
    public function start_lvl(&$output,$depth=0,$args=null) { $output.='<div class="nav-dropdown-menu">'; }
    public function end_lvl(&$output,$depth=0,$args=null) { $output.='</div>'; }
    public function start_el(&$output,$item,$depth=0,$args=null,$id=0) {
        $parent=in_array('menu-item-has-children',$item->classes,true);
        if ($parent) $output.='<div class="nav-dropdown">';
        $classes=[];
        if ($item->current) $classes[]='active-page';
        if ($args->theme_location==='header_cta') $classes[]='nav-cta';
        $label=esc_html($item->title);
        if ($args->theme_location==='footer_social') {
            $icons=[
                'facebook'=>'M13.6 21v-8h2.7l.4-3.1h-3.1v-2c0-.9.3-1.5 1.6-1.5h1.7V3.6c-.8-.1-1.7-.2-2.5-.2-2.5 0-4.2 1.5-4.2 4.3v2.2H7.4V13h2.8v8h3.4Z',
                'linkedin'=>'M6.4 8.1H3.2V21h3.2V8.1ZM4.8 3A1.9 1.9 0 1 0 4.8 6.8 1.9 1.9 0 0 0 4.8 3ZM21 13.6c0-3.9-2.1-5.7-4.9-5.7-2.3 0-3.3 1.2-3.8 2.1V8.1H9.1V21h3.2v-6.4c0-1.7.3-3.4 2.5-3.4 2.2 0 2.2 2 2.2 3.5V21h3.2l.8-7.4Z',
            ];
            foreach ($icons as $host=>$path) if (str_contains(wp_parse_url($item->url,PHP_URL_HOST)??'', $host.'.com')) $label='<svg viewBox="0 0 24 24" aria-hidden="true"><path d="'.esc_attr($path).'"/></svg>';
        }
        $output.='<a href="'.esc_url($item->url).'" class="'.esc_attr(implode(' ',$classes)).'" aria-label="'.esc_attr($item->title).'"'.($item->current?' aria-current="page"':'').($item->target?' target="'.esc_attr($item->target).'"':'').($item->xfn?' rel="'.esc_attr($item->xfn).'"':'').'>'.$label.'</a>';
        if ($parent) $output.='<button type="button" class="nav-dropdown-toggle" aria-expanded="false" aria-label="'.esc_attr(sprintf(__('Toggle submenu for %s','neo'),$item->title)).'">⌄</button>';
    }
    public function end_el(&$output,$item,$depth=0,$args=null) { if (in_array('menu-item-has-children',$item->classes,true)) $output.='</div>'; }
}
function neo_catalog_rows($group,$type) {
    $posts=get_posts(['post_type'=>$type,'numberposts'=>-1,'meta_key'=>'catalog_order','orderby'=>['meta_value_num'=>'ASC','ID'=>'ASC'],
        'tax_query'=>[['taxonomy'=>'neo_catalog_group','field'=>'slug','terms'=>$group]]]);
    foreach ($posts as $post) {
        echo '<tr><td class="spec-highlight service-name-with-image">';
        echo wp_get_attachment_image((int)get_post_meta($post->ID,'catalog_image',true),'full',false,['loading'=>'lazy','sizes'=>'(max-width: 700px) 100vw, 50vw']);
        echo '<span>'.esc_html($post->post_title).'</span></td></tr>';
    }
}
add_action('after_setup_theme',function() {
    add_theme_support('title-tag'); add_theme_support('post-thumbnails'); add_theme_support('custom-logo');
    add_theme_support('html5',['search-form','gallery','caption','style','script']);
    register_nav_menus(['primary'=>'Primary navigation','header_cta'=>'Header contact button','footer_pages'=>'Footer pages','footer_social'=>'Footer social links','footer_connect'=>'Footer connect links']);
    add_image_size('neo-small',640,0,false); add_image_size('neo-medium',1280,0,false);
});
add_filter('use_block_editor_for_post',function($enabled,$post) { return get_post_meta($post->ID,'_neo_source',true)?false:$enabled; },10,2);
add_action('wp_enqueue_scripts',function() {
    $source=get_post_meta(get_queried_object_id(),'_neo_source',true);
    wp_enqueue_style('neo-fonts','https://fonts.googleapis.com/css2?family=Anton&family=Anton+SC&family=Space+Grotesk:wght@300..700&display=swap',[],null);
    wp_enqueue_style('neo-layout',neo_asset('styles.css'),[],filemtime(get_theme_file_path('styles.css')));
    wp_enqueue_style('neo-wordpress',neo_asset('wordpress.css'),['neo-layout'],filemtime(get_theme_file_path('wordpress.css')));
    if ($source==='team-gallery') wp_enqueue_script('neo-team-gallery',neo_asset('team-gallery.js'),['neo-responsive-images'],filemtime(get_theme_file_path('team-gallery.js')),['in_footer'=>true,'strategy'=>'defer']);
    foreach (['responsive-images','hero-video','script'] as $script) {
        $dependencies=$script==='script' && $source==='team-gallery'?['neo-team-gallery']:[];
        wp_enqueue_script('neo-'.$script,neo_asset($script.'.js'),$dependencies,filemtime(get_theme_file_path($script.'.js')),['in_footer'=>true,'strategy'=>'defer']);
    }
    if (is_file(get_theme_file_path($source.'-inline.js'))) wp_enqueue_script('neo-page',neo_asset($source.'-inline.js'),['neo-script'],filemtime(get_theme_file_path($source.'-inline.js')),['in_footer'=>true,'strategy'=>'defer']);
    wp_add_inline_script('neo-responsive-images','window.neoAssetBase='.wp_json_encode(trailingslashit(get_theme_file_uri())).';','before');
    wp_enqueue_script('neo-wp-interactions',neo_asset('wordpress.js'),['neo-script'],filemtime(get_theme_file_path('wordpress.js')),['in_footer'=>true,'strategy'=>'defer']);
});
add_filter('body_class',function($classes) {
    $source=get_post_meta(get_queried_object_id(),'_neo_source',true);
    $schema=function_exists('neo_schema')?neo_schema():[];
    foreach (explode(' ',$schema['pages'][$source]['body_class']??'') as $class) if ($class) $classes[]=$class;
    return $classes;
});
add_filter('nav_menu_link_attributes',function($attributes,$item,$args) {
    if (!empty($item->current)) $attributes['class']=trim(($attributes['class']??'').' active-page');
    if ($args->theme_location==='header_cta') $attributes['class']='nav-cta';
    return $attributes;
},10,3);
add_action('wp_head',function() {
    $source=get_post_meta(get_queried_object_id(),'_neo_source',true);
    $schema=function_exists('neo_schema')?neo_schema():[];
    if (!empty($schema['pages'][$source]['description'])) echo '<meta name="description" content="'.esc_attr($schema['pages'][$source]['description']).'">';
},1);
