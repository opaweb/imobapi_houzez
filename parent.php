<?php

 //$setParentState = Http::get($this->client->wordpress_url.'/wp-content/plugins/imobapi_houzez/parent.php', ['type' => 'parent_state', 'parent_term' => $propertyState, 'child_slug' => $state_slug]);

define('WP_USE_THEMES', false);
(string)$caminho = dirname(__FILE__);
require_once( $caminho.'/../../../wp-blog-header.php' );

if($_REQUEST['current_term']){
    $current_term = $_REQUEST['current_term'];
}else{
    $current_term = null;
}

if($_REQUEST['current_id']){
    $current_id = $_REQUEST['current_id'];
}else{
    $current_id= null;
}

if($_REQUEST['parent_term']){
    $parent_term = $_REQUEST['parent_term'];
}else{
    $parent_term= null;
}

if($_REQUEST['parent_slug']){
    $parent_slug = $_REQUEST['parent_slug'];
}else{
    $parent_slug = null;
}

$value = array($parent_term => $parent_slug);

$set_option = add_option('_houzez_'.$current_term.'_'.$current_id, $value);
var_dump($set_option);
?>