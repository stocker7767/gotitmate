<?php
if (!defined('ABSPATH')) exit;
function gim_table($name){ global $wpdb; return $wpdb->prefix.'gim_'.$name; }
function gim_now(){ return current_time('mysql', true); }
function gim_uuid(){ return wp_generate_uuid4(); }
function gim_money($pence){ return '£'.number_format(((int)$pence)/100,2); }
function gim_json($v){ return wp_json_encode($v, JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE); }
function gim_decode($v,$default=[]){ $d=json_decode((string)$v,true); return is_array($d)?$d:$default; }
function gim_page_url($slug,$args=[]){ $p=get_page_by_path($slug); $url=$p?get_permalink($p):home_url('/'.$slug.'/'); return $args?add_query_arg($args,$url):$url; }
function gim_current_role(){ if(!is_user_logged_in())return 'guest'; $u=wp_get_current_user(); if(in_array('gim_admin',$u->roles,true)||current_user_can('manage_options'))return 'admin'; if(in_array('gim_provider',$u->roles,true))return 'provider'; if(in_array('gim_customer',$u->roles,true))return 'customer'; return 'user'; }
function gim_dashboard_url(){ $r=gim_current_role(); return gim_page_url($r==='admin'?'gim-admin-dashboard':($r==='provider'?'gim-provider-dashboard':'gim-customer-dashboard')); }
function gim_require_role($role){ if(!is_user_logged_in()){ auth_redirect(); exit; } if($role==='admin' && !(current_user_can('gim_admin_access')||current_user_can('manage_options')))wp_die('Not authorised.',403); if($role==='provider'&&!current_user_can('gim_provider_access'))wp_die('Not authorised.',403); if($role==='customer'&&!current_user_can('gim_customer_access'))wp_die('Not authorised.',403); }
function gim_post_text($key,$default=''){ return isset($_POST[$key])?sanitize_text_field(wp_unslash($_POST[$key])):$default; }
function gim_post_int($key,$default=0){ return isset($_POST[$key])?(int)$_POST[$key]:$default; }
function gim_ref($prefix='GM'){ return $prefix.'-'.strtoupper(substr(str_replace('-','',gim_uuid()),0,10)); }
function gim_job_by_ref($ref){ global $wpdb; return $wpdb->get_row($wpdb->prepare('SELECT * FROM '.gim_table('jobs').' WHERE reference=%s',$ref)); }
function gim_provider_profile($user_id){ global $wpdb; return $wpdb->get_row($wpdb->prepare('SELECT * FROM '.gim_table('providers').' WHERE user_id=%d',$user_id)); }
function gim_redirect_notice($url,$msg,$type='ok'){ wp_safe_redirect(add_query_arg(['gim_notice'=>$msg,'gim_notice_type'=>$type],$url)); exit; }
function gim_render_notice(){ if(empty($_GET['gim_notice']))return; $type=($_GET['gim_notice_type']??'ok')==='error'?'gim-error':''; echo '<div class="gim-alert '.esc_attr($type).'">'.esc_html(wp_unslash($_GET['gim_notice'])).'</div>'; }
