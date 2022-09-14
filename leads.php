<?php
define('WP_USE_THEMES', false);
(string)$caminho = dirname(__FILE__);
require_once( $caminho.'/../../../wp-blog-header.php' );

$remote_url = 'https://app.imobapi.com.br/api/lead';
$api_token = get_option('imobapi_key');
if($_REQUEST['property_contract'] == 'Venda'){
    $contract = 1;
}
elseif($_REQUEST['property_contract'] == 'Locação'){
    $contract = 2;
}
elseif($_REQUEST['property_contract'] == 'Temporada'){
    $contract = 3;
}
else {
    $contract = null;
}
$body = array(
    'full_name' => $_REQUEST['full_name'],
    'email' => $_REQUEST['email'],
    'phone' => $_REQUEST['phone'],
    'message' => $_REQUEST['message'],
    'tags' => $_REQUEST['tags'],
    'source' => $_REQUEST['source'],
    'subject' => $_REQUEST['subject'],
    'property_code' => $_REQUEST['property_code'],
    'property_contract' => $contract,
);
$args = array(
    'headers'     => array(
        'Authorization' => 'Bearer ' . $api_token,
    ),
    'body' => $body,
); 
$imobapi = wp_remote_post( $remote_url, $args );

var_dump($imobapi);


?>