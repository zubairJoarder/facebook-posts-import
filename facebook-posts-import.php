<?php
/**
 * Plugin Name: Facebook Posts Import
 * Plugin URI: 
 * Description: This plugin imports facebook posts.
 * Version: 1.0.0
 * Author: Zubair Joarder
 * Author URI: 
 * License: GPL2
 */
 
include "config.php";
 

function post_facebook_post() {
	$wordpressPoster = new WordpressPoster();
	$wordpressPoster->importFacebookPost();
}
add_action('wp_login', 'post_facebook_post');
