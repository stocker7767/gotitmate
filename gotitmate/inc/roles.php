<?php
if (!defined('ABSPATH')) exit;
function gim_install_roles(){
 add_role('gim_customer','GOTITMATE Customer',['read'=>true,'gim_customer_access'=>true]);
 add_role('gim_provider','GOTITMATE Provider',['read'=>true,'upload_files'=>true,'gim_provider_access'=>true]);
 add_role('gim_admin','GOTITMATE Admin',['read'=>true,'gim_admin_access'=>true,'gim_manage_providers'=>true,'gim_manage_disputes'=>true,'gim_manage_payments'=>true]);
 if($a=get_role('administrator'))foreach(['gim_admin_access','gim_manage_providers','gim_manage_disputes','gim_manage_payments'] as $c)$a->add_cap($c);
}
