<?php
if (!defined('ABSPATH')) exit;
function gim_services(){ return [
 'plumbing'=>['name'=>'Plumbing','assessment'=>'conditional'],
 'electrician'=>['name'=>'Electrician','assessment'=>'conditional'],
 'car-mobile-service'=>['name'=>'Car Mobile Service','assessment'=>'conditional'],
 'carpenter'=>['name'=>'Carpenter','assessment'=>'conditional'],
 'beautician'=>['name'=>'Beautician','assessment'=>'conditional']
 ]; }
function gim_seed_services(){ if(!get_option('gim_service_catalogue'))update_option('gim_service_catalogue',gim_services()); }
function gim_service($slug){ $s=get_option('gim_service_catalogue',gim_services()); return $s[$slug]??null; }
