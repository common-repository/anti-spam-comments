<?php
/*
Plugin Name: Anti Spam Comments
Plugin URI: http://samrat131.wordpress.com/
Description: Usign this plugins, blog admin/site owner can stop, user to submit a web address on the very first comments on any post, and send those comments to spam folder.
Version: 1.0
Author: samrat131
Author URI: http://samrat131.wordpress.com/
License: GPL2
*/
function filter_handler( $data )
{
	global $wpdb;
	$sql = "SELECT * FROM $wpdb->comments WHERE comment_author_email = '$data[comment_author_email]' AND comment_author = '$data[comment_author]' AND comment_approved = 1";
	$comment_list = $wpdb->get_results($sql, ARRAY_A);
 
	if ($data['comment_author_url'] != '' and empty($comment_list) ){
		$data['comment_approved'] = 'spam';
		$data['comment_content'] = $data['comment_content'].'.';
		wp_insert_comment($data);
		wp_die( __('<strong>Sorry</strong>, You Are Not Permitted To Submit A Website Address In Blog Comments On Your Very First Comment In This Blog. Click Your Back Button, Delete The Website In The Website Field And Submit Your Comment For Approval.') );
	}
	else{
		return $data; 
	}	
}
add_filter( 'preprocess_comment' , 'filter_handler');
?>