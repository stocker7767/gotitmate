<?php
if (!defined('ABSPATH')) exit;
function gim_notify_user($user_id,$subject,$message){ $u=get_userdata($user_id); return $u?wp_mail($u->user_email,$subject,$message):false; }
