<?php
// Contact form: every submission is stored as a private "Contact submission" post first,
// then emailed. A failed send is retried hourly by WP-Cron, so nothing is lost if mail is down.
defined('ABSPATH') || exit;
const NEO_CONTACT_TO='office@neo-bd.com';
const NEO_CONTACT_FIELDS=['name'=>'Name','company'=>'Company','email'=>'Email','phone'=>'Phone','inquiry_type'=>'Inquiry type','message'=>'Message'];
const NEO_CONTACT_MAX_TRIES=24;

add_action('init',function() {
    register_post_type('neo_inquiry',['labels'=>['name'=>'Contact submissions','singular_name'=>'Contact submission','menu_name'=>'Contact submissions',
        'edit_item'=>'Contact submission','search_items'=>'Search submissions','not_found'=>'No submissions yet'],
        'public'=>false,'show_ui'=>true,'menu_icon'=>'dashicons-email-alt','menu_position'=>26,'supports'=>['title'],
        'capability_type'=>'post','capabilities'=>['create_posts'=>'do_not_allow'],'map_meta_cap'=>true]);
});

function neo_contact_redirect($status) {
    $back=wp_get_referer()?:home_url('/contact/');
    wp_safe_redirect(add_query_arg('contact',$status,remove_query_arg('contact',$back)).'#contact-form-title'); exit;
}

function neo_contact_handle() {
    // Honeypot plus a minimum fill time: bots fill the hidden field or post instantly.
    if (!empty($_POST['website']) || (time()-(int)($_POST['neo_ts']??0))<3) neo_contact_redirect('sent');
    $data=[];
    foreach (NEO_CONTACT_FIELDS as $key=>$label) {
        $value=wp_unslash($_POST[$key]??'');
        $data[$key]=$key==='message'?sanitize_textarea_field($value):sanitize_text_field($value);
    }
    $data['email']=sanitize_email($data['email']);
    if (!$data['name'] || !is_email($data['email']) || !$data['inquiry_type'] || !$data['message']) neo_contact_redirect('invalid');
    $id=wp_insert_post(['post_type'=>'neo_inquiry','post_status'=>'private','post_title'=>$data['name'].' – '.$data['inquiry_type'],'post_content'=>$data['message']],true);
    if (is_wp_error($id)) neo_contact_redirect('error');
    foreach ($data as $key=>$value) update_post_meta($id,'_neo_'.$key,$value);
    update_post_meta($id,'_neo_ip',sanitize_text_field($_SERVER['REMOTE_ADDR']??''));
    update_post_meta($id,'_neo_page',esc_url_raw(wp_get_referer()?:''));
    neo_contact_send($id);
    neo_contact_redirect('sent');
}
add_action('admin_post_nopriv_neo_contact','neo_contact_handle');
add_action('admin_post_neo_contact','neo_contact_handle');

function neo_contact_send($id) {
    $field=fn($key)=>(string)get_post_meta($id,'_neo_'.$key,true);
    $lines=[];
    foreach (NEO_CONTACT_FIELDS as $key=>$label) if ($key!=='message') $lines[]=$label.': '.($field($key)?:'-');
    $body="New contact form submission from ".home_url('/')."\n\n".implode("\n",$lines)."\n\nMessage:\n".$field('message')
        ."\n\nSubmitted: ".get_the_date('Y-m-d H:i',$id).' ('.wp_timezone_string().")\nView in admin: ".admin_url('post.php?post='.$id.'&action=edit');
    $headers=['Reply-To: '.str_replace(["\r","\n",'<','>'],'',$field('name')).' <'.$field('email').'>'];
    $subject='Website inquiry: '.$field('inquiry_type').' – '.$field('name').($field('company')?' ('.$field('company').')':'');
    $sent=wp_mail(NEO_CONTACT_TO,$subject,$body,$headers);
    update_post_meta($id,'_neo_mail_tries',(int)get_post_meta($id,'_neo_mail_tries',true)+1);
    update_post_meta($id,'_neo_mail_status',$sent?'sent':'failed');
    if ($sent) update_post_meta($id,'_neo_mail_sent_at',current_time('mysql'));
    return $sent;
}

// Envelope sender = From address so SPF aligns with neo-bd.com (the domain's DMARC policy is p=reject).
add_filter('wp_mail_from',fn()=>'wordpress@neo-bd.com');
add_filter('wp_mail_from_name',fn()=>'Neo Associates Website');
add_action('phpmailer_init',function($mailer) { $mailer->Sender=$mailer->From; });
add_action('wp_mail_failed',function($error) {
    $data=$error->get_error_data();
    error_log('neo contact mail failed: '.$error->get_error_message().' to '.implode(',',(array)($data['to']??[])));
});

// Retry failed sends hourly.
add_action('neo_contact_retry',function() {
    foreach (get_posts(['post_type'=>'neo_inquiry','post_status'=>'any','numberposts'=>20,'fields'=>'ids',
        'meta_query'=>[['key'=>'_neo_mail_status','value'=>'failed'],['key'=>'_neo_mail_tries','value'=>NEO_CONTACT_MAX_TRIES,'compare'=>'<','type'=>'NUMERIC']]]) as $id) neo_contact_send($id);
});
add_action('init',function() { if (!wp_next_scheduled('neo_contact_retry')) wp_schedule_event(time()+300,'hourly','neo_contact_retry'); });

// Admin list + detail view.
add_filter('manage_neo_inquiry_posts_columns',fn()=>['cb'=>'<input type="checkbox">','title'=>'Submission','neo_email'=>'Email','neo_phone'=>'Phone','neo_mail'=>'Email to office','date'=>'Received']);
add_action('manage_neo_inquiry_posts_custom_column',function($column,$id) {
    if ($column==='neo_email') echo esc_html(get_post_meta($id,'_neo_email',true));
    if ($column==='neo_phone') echo esc_html(get_post_meta($id,'_neo_phone',true));
    if ($column==='neo_mail') {
        $status=get_post_meta($id,'_neo_mail_status',true);
        echo $status==='sent'?'<span style="color:#1a7f37">Sent</span>':'<span style="color:#b32d2e">Not sent yet</span> (tries: '.(int)get_post_meta($id,'_neo_mail_tries',true).')';
    }
},10,2);
add_action('add_meta_boxes_neo_inquiry',function() {
    remove_meta_box('submitdiv','neo_inquiry','side');
    add_meta_box('neo_inquiry_details','Details',function($post) {
        echo '<table class="form-table">';
        foreach (NEO_CONTACT_FIELDS+['page'=>'Sent from page','ip'=>'IP address','mail_status'=>'Email to office','mail_sent_at'=>'Emailed at'] as $key=>$label) {
            $value=$key==='message'?$post->post_content:get_post_meta($post->ID,'_neo_'.$key,true);
            echo '<tr><th>'.esc_html($label).'</th><td>'.nl2br(esc_html((string)$value)).'</td></tr>';
        }
        echo '</table>';
    },'neo_inquiry','normal','high');
});
add_filter('post_row_actions',function($actions,$post) { if ($post->post_type==='neo_inquiry') unset($actions['inline hide-if-no-js']); return $actions; },10,2);
