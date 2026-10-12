<?php
if (!defined('ABSPATH')) exit;
function gim_install_pages(){ $pages=[
 'gim-login'=>'Login / Register','gim-customer-dashboard'=>'Customer Dashboard','gim-provider-dashboard'=>'Provider Dashboard','gim-admin-dashboard'=>'Admin Dashboard','gim-book-service'=>'Book Service','gim-provider-directory'=>'Find a Provider','gim-provider-apply'=>'Become a Provider','gim-job'=>'Job Details','gim-payment-return'=>'Payment Return','gim-disputes'=>'Cancellation & Disputes'
 ]; foreach($pages as $slug=>$title){ if(!get_page_by_path($slug)){ wp_insert_post(['post_title'=>$title,'post_name'=>$slug,'post_status'=>'publish','post_type'=>'page','post_content'=>'[gim_app page="'.$slug.'"]']); } }
}
function gim_install(){ gim_install_roles(); gim_install_tables(); gim_install_pages(); gim_seed_services(); gim_private_root(); }
add_action('after_switch_theme','gim_install');
add_action('init',function(){ if(get_option('gim_schema_version')!==GIM_VERSION)gim_install(); });
