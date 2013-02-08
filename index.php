<?php

/*
 * Индекс
 */

error_reporting(0);

	require "config.php";

	require "class/page.php";
	require "class/comments.php";

	
	$page = new page();
	$comments = new comments();
	
	
	
	
	$html = $page->getPage();
	
	$html = str_replace(
					'{{comments}}', 
					$comments->getList( $page->post_id ) . $comments->getForm( $page->post_id ), 
					$html
				);
	
	echo $html;
?>