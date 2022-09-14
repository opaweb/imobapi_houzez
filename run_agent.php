<?php
define('WP_USE_THEMES', false);
(string)$caminho = dirname(__FILE__);
require_once( $caminho.'/../../../wp-blog-header.php' );

if($_REQUEST['post_id']){
    $postid = $_REQUEST['post_id'];
}else{
    $postid = null;
}
$post = get_post($postid);

if ( class_exists( 'EXMAGE_WP_IMAGE_LINKS' ) ) {      
   
    $image = get_post_meta($post->ID, '_agent_avatar', true);
    
    fifu_dev_set_image($post->ID, $image);

    
}
?>