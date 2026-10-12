<?php
if (!defined('ABSPATH')) exit;
function gim_audit($event,$entity_type=null,$entity_ref=null,$data=[]){ global $wpdb; $u=wp_get_current_user(); $ip=$_SERVER['REMOTE_ADDR']??''; $wpdb->insert(gim_table('audit'),['actor_user_id'=>get_current_user_id()?:null,'actor_role'=>gim_current_role(),'event_type'=>$event,'entity_type'=>$entity_type,'entity_ref'=>$entity_ref,'data_json'=>gim_json($data),'ip_hash'=>$ip?hash_hmac('sha256',$ip,wp_salt('auth')):null,'created_at'=>gim_now()]); }
