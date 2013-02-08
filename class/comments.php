<?php

/**
 * Description of comments
 *
 */
class comments {
	

	
	public function getList( $post_id ) {
		
		$out = '';
		
		$res = mysql_query(" SELECT * FROM `comments` WHERE `post`=$post_id ");
		if ( $res && mysql_num_rows($res) ) {
			
			while( $item = mysql_fetch_array($res)) {
				
				$template = file_get_contents("html/comment.html");
				
				foreach( $item as $k=>$v ) 
					$template = str_replace('{{'.$k.'}}', $v, $template);
				
				$out .= $template;
			}
		} else {
			$out = '<li class="comment">Комментарии отсутствуют</li>';
		}
		return "<ul class=\"comments-ul\">$out</ul>";
	}
	public function getForm( $post_id ) {
		
		$errors = $this->setComment();
		
		$template = file_get_contents("html/comment-form.html");
		
		$name = $_COOKIE['name'];
		
		$template = str_replace('{{name}}', $name, $template);
		$template = str_replace('{{post}}', $post_id, $template);
		
		if ( sizeof($errors) ) {
			
			$template = str_replace('{{errorName}}', $errors['{{errorName}}'], $template);
			$template = str_replace('{{errorContent}}', $errors['{{errorContent}}'], $template);
		} else {
			
			$template = str_replace('{{errorName}}', '', $template);
			$template = str_replace('{{errorContent}}', '', $template);
		}
		
		
		return $template;
	}
	public function setComment( ) {
		
		$errors = array();
		
		if ( isset($_POST['post']) ) {
		
			$post_id = $_POST['post'];
			$name = $_POST['name'];
			$content = $_POST['content'];
			
			$errors = array(
				'{{errorName}}' => '',
				'{{errorContent}}' => '',
			);
			$errorFlag = false;
			
			if ( $name == '' ) {
				$errors['{{errorName}}'] = 'Укажите имя';
			}
			
			if ( $content == '' ) {
				$errorFlag = true;
				$errors['{{errorContent}}'] = 'Напишите комментарий';
			}
			
			
			if ( $errorFlag ) {
				return $errors;
			} else {
				setcookie('name', $name);
				if ( !$this->saveComment($post_id, $name, $content) ) exit('Ошибка сохранения комментария!');
			}
		}
		return $errors;
	}
	public function saveComment( $post_id, $name, $content ) {
		
		$query = " INSERT INTO `comments` (`post`, `name`, `content`, `created`) VALUES ($post_id, '$name', '$content', NOW() ) ";
		
		if ( !mysql_query($query) ) return false;
		else return true;
	}
}

?>