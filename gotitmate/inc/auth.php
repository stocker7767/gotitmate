<?php
if (!defined('ABSPATH')) exit;
function gim_register_customer($email,$password,$name=''){
 if(!is_email($email)||strlen($password)<10)return new WP_Error('invalid','Use a valid email and a password of at least 10 characters.');
 if(email_exists($email))return new WP_Error('generic','Unable to create account with those details.');
 $id=wp_create_user($email,$password,$email); if(is_wp_error($id))return new WP_Error('generic','Unable to create account with those details.');
 $u=new WP_User($id); $u->set_role('gim_customer'); if($name)wp_update_user(['ID'=>$id,'display_name'=>$name]);
 update_user_meta($id,'gim_email_verified',0); gim_send_email_otp($id,'verify'); gim_audit('auth.customer_registered','user',(string)$id); return $id;
}
function gim_send_email_otp($user_id,$purpose='login'){
 if(!gim_rate_limit('otp_'.$user_id,8,3600))return new WP_Error('rate_limit','Too many OTP requests.');
 $code=(string)random_int(100000,999999); $digest=hash_hmac('sha256',$purpose.'|'.$code,wp_salt('auth'));
 set_transient('gim_otp_'.$purpose.'_'.$user_id,['digest'=>$digest,'tries'=>0],10*MINUTE_IN_SECONDS);
 $u=get_userdata($user_id); if($u)wp_mail($u->user_email,'Your GOTITMATE verification code','Your code is '.$code.'. It expires in 10 minutes.'); return true;
}
function gim_verify_email_otp($user_id,$purpose,$code){ $key='gim_otp_'.$purpose.'_'.$user_id; $d=get_transient($key); if(!$d)return false; $d['tries']=($d['tries']??0)+1; if($d['tries']>6){delete_transient($key);return false;} set_transient($key,$d,10*MINUTE_IN_SECONDS); $ok=hash_equals($d['digest'],hash_hmac('sha256',$purpose.'|'.$code,wp_salt('auth'))); if($ok){delete_transient($key); if($purpose==='verify')update_user_meta($user_id,'gim_email_verified',1);} return $ok; }
add_filter('wp_authenticate_user',function($user,$password){ if(is_wp_error($user))return $user; if(in_array('gim_customer',$user->roles,true)&&!get_user_meta($user->ID,'gim_email_verified',true))return new WP_Error('gim_email_unverified','Please verify your GOTITMATE email before logging in.'); return $user; },20,2);
