<?php

/**
 * Description of page
 *
 */
class page {
	
	public $post_id = 0;


	public function __construct() {
		
		$this->post_id = $_GET['q'];
		
	}
	
	public function getPage() {
		
		$header = file_get_contents('html/header.html');
		
		$res = mysql_query( " SELECT * FROM `posts` WHERE `id` = {$this->post_id} " );
		if ( !($res && mysql_num_rows($res)) ) {
			$this->post_id=1;$res = mysql_query( " SELECT * FROM `posts` WHERE `id` = 1 " );
		}
		
		$content = file_get_contents('html/content.html');
		$item = mysql_fetch_assoc($res);
		
		$header = str_replace('{{menu}}', $this->getMenu(), $header);
		
		$content = str_replace('{{header}}', $item['header'], $content);
		$content = str_replace('{{content}}', $item['content'], $content);
		$content = str_replace('{{created}}', $item['created'], $content);		
		
		$footer = file_get_contents('html/footer.html');
		
		return $header . $content . $footer;
	}
	private function getMenu(){
		
		$out = '';
		
		$res = mysql_query( " SELECT * FROM `posts` " );
		while( $item = mysql_fetch_array($res) ) {
			$selected = false;
			if ( $item['id'] == $this->post_id ) $selected = true;
			
			$out .= '<li ' . ($selected? 'class="selected"':'') . '><a href="?q='.$item['id'].'">'.$item['name'].'</a></li>';
		}
		return '<ul class="menu">'.$out.'</ul>';
	}
	
}

?>