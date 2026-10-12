<?php
if (!defined('ABSPATH')) exit;
function gim_env(){ return defined('GIM_ENVIRONMENT')?GIM_ENVIRONMENT:'development'; }
function gim_is_prod(){ return gim_env()==='production'; }
function gim_private_root(){
 $root=defined('GIM_PRIVATE_FILE_ROOT')?GIM_PRIVATE_FILE_ROOT:WP_CONTENT_DIR.'/gim-private';
 if(gim_is_prod()&&!defined('GIM_PRIVATE_FILE_ROOT')) wp_die('GOTITMATE production requires GIM_PRIVATE_FILE_ROOT.');
 if(!is_dir($root)) wp_mkdir_p($root);
 if(!file_exists($root.'/index.php')) @file_put_contents($root.'/index.php',"<?php http_response_code(404); exit;\n");
 if(!file_exists($root.'/.htaccess')) @file_put_contents($root.'/.htaccess',"Require all denied\nDeny from all\n");
 return $root;
}
function gim_secure_upload($field,$subdir,$allowed=['image/jpeg'=>'jpg','image/png'=>'png','image/webp'=>'webp','application/pdf'=>'pdf'],$max=10485760){
 if(empty($_FILES[$field]['tmp_name'])) return new WP_Error('missing_file','File required.');
 $f=$_FILES[$field]; if((int)$f['size']>$max)return new WP_Error('file_too_large','File too large.');
 $type=wp_check_filetype_and_ext($f['tmp_name'],$f['name']); $mime=$type['type']?:mime_content_type($f['tmp_name']);
 if(!isset($allowed[$mime]))return new WP_Error('file_type','File type not allowed.');
 $dir=trailingslashit(gim_private_root()).sanitize_file_name($subdir); if(!is_dir($dir))wp_mkdir_p($dir);
 $name=gim_uuid().'.'.$allowed[$mime]; $dest=$dir.'/'.$name;
 if(!move_uploaded_file($f['tmp_name'],$dest))return new WP_Error('upload_failed','Upload failed.');
 return ['path'=>$dest,'hash'=>hash_file('sha256',$dest),'mime'=>$mime,'name'=>$name];
}
add_action('send_headers',function(){ header('X-Content-Type-Options: nosniff'); header('X-Frame-Options: SAMEORIGIN'); header('Referrer-Policy: strict-origin-when-cross-origin'); header('Permissions-Policy: camera=(), microphone=(), geolocation=()'); if(gim_is_prod()&&is_ssl())header('Strict-Transport-Security: max-age=31536000; includeSubDomains'); });
function gim_rate_limit($bucket,$limit=10,$window=600){ $ip=$_SERVER['REMOTE_ADDR']??'unknown'; $key='gim_rl_'.md5($bucket.'|'.$ip); $x=get_transient($key); if(!$x)$x=['n'=>0]; $x['n']++; set_transient($key,$x,$window); return $x['n']<=$limit; }
