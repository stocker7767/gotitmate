<?php
if (!defined('ABSPATH')) exit;
add_action('rest_api_init',function(){
 register_rest_route('gotitmate/v1','/stripe/webhook',['methods'=>'POST','permission_callback'=>'__return_true','callback'=>function(WP_REST_Request $req){ $payload=$req->get_body(); $sig=$req->get_header('stripe-signature'); if(!gim_verify_stripe_signature($payload,$sig))return new WP_REST_Response(['ok'=>false],400); $e=json_decode($payload,true); if(($e['type']??'')==='account.updated'){ gim_reconcile_stripe_account($e['data']['object']??[]); } elseif(($e['type']??'')==='checkout.session.completed'){ $obj=$e['data']['object']??[]; $ref=$obj['client_reference_id']??''; $pi=$obj['payment_intent']??''; if($ref&&$pi)gim_capture_payment_from_stripe($ref,$pi); } return ['ok'=>true]; }]);
 register_rest_route('gotitmate/v1','/health',['methods'=>'GET','permission_callback'=>'__return_true','callback'=>fn()=>['ok'=>true,'version'=>GIM_VERSION,'env'=>gim_env()]]);
});
