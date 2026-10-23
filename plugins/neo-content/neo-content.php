<?php
/**
 * Plugin Name: Neo Content
 * Description: Free structured content, migration and shared editing services for Neo.
 * Version: 0.1.0
 * Requires PHP: 8.1
 */
defined('ABSPATH') || exit;

function neo_schema() {
    static $schema;
    if (!$schema) $schema = json_decode(file_get_contents(__DIR__ . '/data/import.json'), true);
    return $schema;
}
function neo_field_definition($owner, $key) {
    if (!$owner) $fields = neo_schema()['site'];
    elseif (in_array(get_post_type($owner), ['neo_product', 'neo_service'], true)) {
        $fields = [['key'=>'catalog_image', 'type'=>'image'], ['key'=>'catalog_order','type'=>'number']];
    } else $fields = neo_schema()['pages'][get_post_meta($owner, '_neo_source', true)]['fields'] ?? [];
    foreach ($fields as $field) if ($field['key'] === $key) return $field;
    return null;
}
function neo_content_value($owner, $key) {
    if (!$owner && $key==='site_image_001' && get_theme_mod('custom_logo')) return get_theme_mod('custom_logo');
    return $owner ? get_post_meta($owner, $key, true) : (get_option('neo_site_values', [])[$key] ?? '');
}
function neo_content_revision($owner, $key) {
    return hash('sha256', wp_json_encode(neo_content_value($owner, $key)));
}
function neo_can_edit($owner) {
    return $owner ? current_user_can('edit_post', $owner) : current_user_can('manage_options');
}
function neo_validate_value($definition, $value) {
    if (in_array($definition['type'], ['image','file'], true)) {
        $id = absint($value);
        if (!$id && ($value === '' || $value === 0 || $value === '0')) return 0;
        if (!$id || get_post_type($id) !== 'attachment') return new WP_Error('media', 'Select an existing media attachment.');
        $mime = get_post_mime_type($id);
        if ($definition['type'] === 'image' && !str_starts_with($mime, 'image/')) return new WP_Error('media', 'Select an image.');
        if ($definition['type'] === 'file' && $mime !== 'video/mp4') return new WP_Error('media', 'Select an MP4 video.');
        return $id;
    }
    if (!is_scalar($value) || mb_strlen((string)$value) > 20000) return new WP_Error('value', 'Text is too long or invalid.');
    if ($definition['type'] === 'number') return max(0, intval($value));
    return sanitize_textarea_field((string)$value);
}
function neo_store_value($owner, $key, $value) {
    $definition = neo_field_definition($owner, $key);
    if (!$definition) return new WP_Error('field', 'Unknown field.');
    $value = neo_validate_value($definition, $value);
    if (is_wp_error($value)) return $value;
    $history = $owner ? get_post_meta($owner, '_neo_history', true) : get_option('neo_site_history', []);
    $history = is_array($history) ? $history : [];
    $history[] = ['key'=>$key,'value'=>neo_content_value($owner,$key),'time'=>time(),'user'=>get_current_user_id()];
    $history = array_slice($history, -40);
    if ($owner) {
        update_post_meta($owner, '_neo_history', $history);
        if (function_exists('update_field')) update_field('field_neo_' . $key, $value, $owner);
        else update_post_meta($owner, $key, $value);
        clean_post_cache($owner);
    } else {
        $values = get_option('neo_site_values', []);
        $values[$key] = $value;
        update_option('neo_site_history', $history, false);
        update_option('neo_site_values', $values, false);
        if ($key==='site_image_001') set_theme_mod('custom_logo',$value);
    }
    do_action('neo_content_saved', $owner, $key);
    return $value;
}
add_action('init', function() {
    foreach (['neo_product'=>'Products', 'neo_service'=>'Services'] as $type=>$label) {
        register_post_type($type, ['labels'=>['name'=>$label,'singular_name'=>rtrim($label,'s')], 'public'=>false,
            'show_ui'=>true,'show_in_rest'=>true,'menu_icon'=>'dashicons-products',
            'supports'=>['title','revisions','page-attributes','custom-fields']]);
    }
    register_taxonomy('neo_catalog_group', ['neo_product','neo_service'], ['label'=>'Catalog groups', 'show_ui'=>true,'show_in_rest'=>true,'public'=>false]);
});
add_action('acf/init', function() {
    foreach (neo_schema()['pages'] as $source=>$page) {
        $page_id = get_option('neo_page_ids', [])[$source] ?? 0;
        if (!$page_id) continue;
        $fields = [];
        $last_group = null;
        foreach ($page['fields'] as $definition) {
            if ($definition['group'] !== $last_group) {
                $last_group = $definition['group'];
                $fields[] = ['key'=>'field_tab_'.md5($source.$last_group.count($fields)), 'label'=>ucwords(str_replace(['-','_'],' ',$last_group)), 'type'=>'tab', 'placement'=>'left'];
            }
            $field = ['key'=>'field_neo_'.$definition['key'],'name'=>$definition['key'],'label'=>$definition['label'],
                'type'=>$definition['type'],'instructions'=>'Used in: '.$definition['group']];
            if (in_array($definition['type'], ['image','file'],true)) {
                $field['return_format']='id'; $field['preview_size']='medium';
                $field['mime_types']=$definition['type']==='image'?'jpg,jpeg,png,webp,gif':'mp4';
            } else { $field['rows']=2; $field['new_lines']=''; }
            $fields[] = $field;
        }
        acf_add_local_field_group(['key'=>'group_neo_'.$source,'title'=>'Neo Page Content','fields'=>$fields,
            'location'=>[[['param'=>'page','operator'=>'==','value'=>(string)$page_id]]]]);
    }
    acf_add_local_field_group(['key'=>'group_neo_catalog','title'=>'Catalog details','fields'=>[
        ['key'=>'field_neo_catalog_image','name'=>'catalog_image','label'=>'Image','type'=>'image','return_format'=>'id'],
        ['key'=>'field_neo_catalog_order','name'=>'catalog_order','label'=>'Display order','type'=>'number','min'=>0],
    ],'location'=>[[['param'=>'post_type','operator'=>'==','value'=>'neo_product']],[['param'=>'post_type','operator'=>'==','value'=>'neo_service']]]]);
});
add_filter('acf/validate_value',function($valid,$value,$field,$input) {
    if ($valid !== true || !str_starts_with($field['key']??'','field_neo_')) return $valid;
    $result=neo_validate_value(['type'=>$field['type']],$value);
    return is_wp_error($result)?$result->get_error_message():$valid;
},10,4);
add_filter('acf/update_value',function($value,$post_id,$field) {
    if (!str_starts_with($field['key']??'','field_neo_')) return $value;
    $result=neo_validate_value(['type'=>$field['type']],$value);
    if (is_wp_error($result)) return get_post_meta((int)$post_id,$field['name'],true);
    return $result;
},10,3);
add_action('admin_notices', function() {
    if (!function_exists('acf_add_local_field_group') && current_user_can('activate_plugins')) {
        echo '<div class="notice notice-warning"><p>Neo: activate ACF Free to edit page and catalog fields. Saved public content remains available.</p></div>';
    }
});
add_action('admin_menu', function() {
    add_menu_page('Neo Site Settings','Neo Settings','manage_options','neo-settings','neo_settings_screen','dashicons-admin-generic',30);
});
add_action('admin_enqueue_scripts', function($hook) {
    if ($hook !== 'toplevel_page_neo-settings') return;
    wp_enqueue_media();
    wp_enqueue_script('neo-settings', plugins_url('settings.js',__FILE__), ['jquery'], '0.1.0', true);
});
function neo_settings_screen() {
    if (!current_user_can('manage_options')) return;
    if (isset($_POST['neo_save'])) {
        check_admin_referer('neo_settings');
        foreach (neo_schema()['site'] as $field) {
            if (isset($_POST['values'][$field['key']])) {
                $result = neo_store_value(0, $field['key'], wp_unslash($_POST['values'][$field['key']]));
                if (is_wp_error($result)) echo '<div class="notice notice-error"><p>'.esc_html($field['label'].': '.$result->get_error_message()).'</p></div>';
            }
        }
        echo '<div class="notice notice-success"><p>Site settings saved.</p></div>';
    }
    echo '<div class="wrap"><h1>Neo shared site content</h1><p>These values are shared by every page. Navigation is managed under Appearance → Menus.</p><form method="post">';
    wp_nonce_field('neo_settings');
    echo '<table class="form-table">';
    foreach (neo_schema()['site'] as $field) {
        $value = neo_content_value(0, $field['key']);
        echo '<tr><th><label for="'.esc_attr($field['key']).'">'.esc_html($field['label']).'</label></th><td>';
        if (in_array($field['type'],['image','file'],true)) {
            echo '<input id="'.esc_attr($field['key']).'" name="values['.esc_attr($field['key']).']" type="hidden" value="'.esc_attr($value).'">';
            echo '<div class="neo-preview">'.($value ? wp_get_attachment_image($value,'thumbnail') : '').'</div><button type="button" class="button neo-pick" data-target="'.esc_attr($field['key']).'">Choose image</button> <button type="button" class="button neo-remove" data-target="'.esc_attr($field['key']).'">Remove</button>';
        } else echo '<textarea class="large-text" rows="2" id="'.esc_attr($field['key']).'" name="values['.esc_attr($field['key']).']">'.esc_textarea($value).'</textarea>';
        echo '</td></tr>';
    }
    echo '</table>'; submit_button('Save shared content','primary','neo_save'); echo '</form></div>';
}

function neo_import_media($relative, $root, $alt='') {
    static $cache=[];
    if (isset($cache[$relative])) return $cache[$relative];
    $existing=get_posts(['post_type'=>'attachment','post_status'=>'inherit','meta_key'=>'_neo_import_path','meta_value'=>$relative,'fields'=>'ids','numberposts'=>1]);
    if ($existing) return $cache[$relative]=(int)$existing[0];
    $source=realpath($root.'/'.$relative);
    $root_path=realpath($root);
    if (!$source || !str_starts_with(str_replace('\\','/',$source), str_replace('\\','/',$root_path).'/')) throw new RuntimeException('Invalid media source: '.$relative);
    $upload=wp_upload_dir(); $target=$upload['basedir'].'/neo-import/'.$relative;
    wp_mkdir_p(dirname($target));
    if (!copy($source,$target)) throw new RuntimeException('Could not copy '.$relative);
    $mime=wp_check_filetype($target)['type'];
    $id=wp_insert_attachment(['post_mime_type'=>$mime,'post_title'=>sanitize_text_field(pathinfo($relative,PATHINFO_FILENAME)),'post_status'=>'inherit'],$target,0,true);
    if (is_wp_error($id)) throw new RuntimeException($id->get_error_message());
    require_once ABSPATH.'wp-admin/includes/image.php';
    if (str_starts_with($mime,'image/')) wp_update_attachment_metadata($id,wp_generate_attachment_metadata($id,$target));
    update_post_meta($id,'_wp_attachment_image_alt',sanitize_text_field($alt));
    update_post_meta($id,'_neo_import_path',$relative);
    return $cache[$relative]=$id;
}
if (defined('WP_CLI') && WP_CLI) {
    WP_CLI::add_command('neo import', function($args,$assoc) {
        $root=$assoc['asset-root']??'';
        if (!$root || !is_dir($root.'/assets')) WP_CLI::error('Supply --asset-root with the static project folder.');
        $ids=get_option('neo_page_ids',[]);
        foreach (neo_schema()['pages'] as $source=>$page) {
            if (empty($ids[$source]) || !get_post($ids[$source])) {
                $ids[$source]=wp_insert_post(['post_type'=>'page','post_title'=>$page['title'],'post_name'=>$source==='index'?'home':$source,'post_status'=>'publish']);
                update_post_meta($ids[$source],'_neo_source',$source);
            }
        }
        update_option('neo_page_ids',$ids,false);
        foreach (neo_schema()['pages'] as $source=>$page) {
            $id=$ids[$source];
            foreach ($page['fields'] as $field) {
                if (metadata_exists('post',$id,$field['key'])) continue;
                $value=in_array($field['type'],['image','file'],true)?neo_import_media($field['value'],$root,$field['alt']??''):$field['value'];
                // Field definitions become active on the next request after creating pages.
                update_post_meta($id,$field['key'],$value);
                update_post_meta($id,'_'.$field['key'],'field_neo_'.$field['key']);
            }
            WP_CLI::log('Imported '.$page['title']);
        }
        $values=get_option('neo_site_values',[]);
        foreach (neo_schema()['site'] as $field) if (!array_key_exists($field['key'],$values)) {
            $values[$field['key']]=in_array($field['type'],['image','file'],true)?neo_import_media($field['value'],$root,$field['alt']??''):$field['value'];
        }
        update_option('neo_site_values',$values,false);
        if (!get_theme_mod('custom_logo') && !empty($values['site_image_001'])) set_theme_mod('custom_logo',$values['site_image_001']);
        foreach (neo_schema()['catalog'] as $record) {
            if (get_posts(['post_type'=>$record['type'],'meta_key'=>'_neo_import_key','meta_value'=>$record['key'],'fields'=>'ids','numberposts'=>1,'post_status'=>'any'])) continue;
            $id=wp_insert_post(['post_type'=>$record['type'],'post_title'=>$record['title'],'post_status'=>'publish','menu_order'=>$record['order']]);
            update_post_meta($id,'_neo_import_key',$record['key']);
            $term=term_exists($record['group'],'neo_catalog_group');
            if (!$term) $term=wp_insert_term($record['group_label'],'neo_catalog_group',['slug'=>$record['group']]);
            wp_set_object_terms($id,[(int)$term['term_id']],'neo_catalog_group');
            foreach (['catalog_image'=>neo_import_media($record['image'],$root,$record['alt']),'catalog_order'=>$record['order']] as $key=>$value) {
                update_post_meta($id,$key,$value); update_post_meta($id,'_'.$key,'field_neo_'.$key);
            }
        }
        update_option('show_on_front','page'); update_option('page_on_front',$ids['index']);
        update_option('blogname','Neo Associates Ltd.'); update_option('blogdescription','Pharmaceutical Machinery & Engineering Solutions');
        update_option('permalink_structure','/%postname%/'); flush_rewrite_rules();
        neo_seed_menus($ids);
        WP_CLI::success('Neo pages, fields, catalog and menus imported. Existing saved values were preserved.');
    });
}
function neo_seed_menus($ids) {
    $locations=get_theme_mod('nav_menu_locations',[]);
    $sets=[
        'primary'=>[['Home','index'],['About','about'],['Products & Services','products-services'],['Associates','associates'],['Team','team-organogram'],['Gallery','gallery']],
        'header_cta'=>[['Contact','contact']],
        'footer_pages'=>[['Home','index'],['About','about'],['Team','team-organogram'],['Products','products-services'],['Services','products-services','#services'],['Gallery','gallery'],['Contact','contact']],
        'footer_connect'=>[['Associates','associates'],['Gallery','gallery'],['Email','mailto:office@neo-bd.com']],
        'footer_social'=>[['Facebook','https://www.facebook.com/neoassociatesbd'],['LinkedIn','https://www.linkedin.com/company/neobd']],
    ];
    foreach ($sets as $location=>$items) {
        if (!empty($locations[$location])) continue;
        $name='Neo '.ucwords(str_replace('_',' ',$location));
        $menu=wp_get_nav_menu_object($name); $menu_id=$menu?$menu->term_id:wp_create_nav_menu($name);
        if (!wp_get_nav_menu_items($menu_id)) foreach ($items as $item) {
            $data=['menu-item-title'=>$item[0],'menu-item-status'=>'publish'];
            if (isset($ids[$item[1]]) && empty($item[2])) $data+=['menu-item-type'=>'post_type','menu-item-object'=>'page','menu-item-object-id'=>$ids[$item[1]]];
            else $data+=['menu-item-type'=>'custom','menu-item-url'=>isset($ids[$item[1]])?get_permalink($ids[$item[1]]).($item[2]??''):$item[1]];
            wp_update_nav_menu_item($menu_id,0,$data);
        }
        $locations[$location]=$menu_id;
    }
    set_theme_mod('nav_menu_locations',$locations);
}
