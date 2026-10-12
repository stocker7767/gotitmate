<?php
if (!defined('ABSPATH')) exit;
define('GIM_VERSION', '1.0.0');
define('GIM_PATH', get_template_directory());
define('GIM_URL', get_template_directory_uri());
$modules = [
 'helpers','database','roles','security','audit','install','auth','service-catalogue','providers','vji','jobs','matching','estimates','payments','materials','additional-work','assurance','risk','outcomes','resolutions','notifications','rest-api','shortcodes'
];
foreach ($modules as $module) require_once GIM_PATH . '/inc/' . $module . '.php';
add_action('after_setup_theme', function(){ add_theme_support('title-tag'); add_theme_support('post-thumbnails'); });
add_action('wp_enqueue_scripts', function(){ wp_enqueue_style('gim-app', GIM_URL.'/assets/css/app.css', [], GIM_VERSION); wp_enqueue_script('gim-app', GIM_URL.'/assets/js/app.js', [], GIM_VERSION, true); wp_localize_script('gim-app','GIM',['rest'=>esc_url_raw(rest_url('gotitmate/v1/')),'nonce'=>wp_create_nonce('wp_rest')]); });
