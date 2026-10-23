<?php
/**
 * Plugin Name: Neo Pencil
 * Description: Optional authenticated inline text and media editing for Neo Content.
 * Version: 0.1.1
 * Requires PHP: 8.1
 */
defined('ABSPATH') || exit;
function neo_pencil_available() {
    return is_singular() && function_exists('neo_field_definition') && current_user_can('edit_post',get_queried_object_id());
}
function neo_pencil_edit_url() {
    $args=['neo-pencil'=>'1'];
    if (isset($_GET['category']) && is_string($_GET['category'])) $args['category']=sanitize_key(wp_unslash($_GET['category']));
    return add_query_arg($args,get_permalink(get_queried_object_id()));
}
add_action('admin_bar_menu',function($bar) {
    if (is_admin() || !neo_pencil_available()) return;
    $bar->add_node(['id'=>'neo-pencil','title'=>'✎ Pencil','href'=>neo_pencil_edit_url()]);
},100);
add_action('template_redirect',function() {
    if (!empty($_GET['neo-pencil']) && is_singular() && !is_user_logged_in()) {
        wp_safe_redirect(wp_login_url(neo_pencil_edit_url()));
        exit;
    }
    if (neo_pencil_available()) {
        if (!defined('DONOTCACHEPAGE')) define('DONOTCACHEPAGE',true);
        nocache_headers();
    }
});
add_filter('body_class',function($classes) {
    if (neo_pencil_available()) {
        $classes[]='neo-editor-available';
        if (!empty($_GET['neo-pencil'])) $classes[]='neo-pencil-active';
    }
    return $classes;
});
add_action('wp_footer',function() {
    if (!neo_pencil_available() || !empty($_GET['neo-pencil'])) return;
    echo '<a class="neo-pencil-launcher" href="'.esc_url(neo_pencil_edit_url()).'"><span aria-hidden="true">✎</span> Edit with Pencil</a>';
});
add_action('wp_enqueue_scripts',function() {
    $id=get_queried_object_id();
    if (!neo_pencil_available()) return;
    wp_enqueue_style('neo-pencil-controls',plugins_url('controls.css',__FILE__),[],filemtime(__DIR__.'/controls.css'));
    if (empty($_GET['neo-pencil'])) return;
    wp_enqueue_media();
    wp_enqueue_script('neo-pencil',plugins_url('pencil.js',__FILE__),['media-views'],filemtime(__DIR__.'/pencil.js'),true);
    wp_add_inline_script('neo-pencil','window.neoPencil='.wp_json_encode(['owner'=>$id,'endpoint'=>rest_url('neo-pencil/v1/field'),'nonce'=>wp_create_nonce('wp_rest')]).';','before');
});
add_action('rest_api_init',function() {
    $permission=function($request) {
        if (!function_exists('neo_can_edit')) return new WP_Error('dependency','Neo Content is inactive.',['status'=>503]);
        return neo_can_edit(absint($request->get_param('owner')));
    };
    register_rest_route('neo-pencil/v1','/field',[
        ['methods'=>'GET','callback'=>'neo_pencil_read','permission_callback'=>$permission],
        ['methods'=>'POST','callback'=>'neo_pencil_save','permission_callback'=>$permission],
    ]);
});
function neo_pencil_data($owner,$key,$definition) {
    $value=neo_content_value($owner,$key);
    $data=['value'=>$value,'revision'=>neo_content_revision($owner,$key),'type'=>$definition['type'],'label'=>$definition['label']??$key];
    if (in_array($definition['type'],['image','file'],true)) {
        $data['url']=wp_get_attachment_url((int)$value)?:'';
        $data['srcset']=wp_get_attachment_image_srcset((int)$value,'full')?:'';
        $data['alt']=get_post_meta((int)$value,'_wp_attachment_image_alt',true);
    }
    return new WP_REST_Response($data,200,['Cache-Control'=>'no-store, private']);
}
function neo_pencil_read($request) {
    $owner=absint($request['owner']); $key=sanitize_key($request['key']);
    $definition=neo_field_definition($owner,$key);
    if (!$definition) return new WP_Error('field','Unknown field.',['status'=>404]);
    return neo_pencil_data($owner,$key,$definition);
}
function neo_pencil_save($request) {
    $owner=absint($request['owner']); $key=sanitize_key($request['key']);
    $definition=neo_field_definition($owner,$key);
    if (!$definition) return new WP_Error('field','Unknown field.',['status'=>404]);
    if (!hash_equals(neo_content_revision($owner,$key),(string)$request['revision'])) return new WP_Error('conflict','This field changed. Reopen it before saving; your draft has been kept.',['status'=>409]);
    $result=neo_store_value($owner,$key,$request['value']);
    if (is_wp_error($result)) return new WP_Error('value',$result->get_error_message(),['status'=>400]);
    return neo_pencil_data($owner,$key,$definition);
}
