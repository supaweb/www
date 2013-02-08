<?php

	
	define( 'DB_HOST', 'localhost' );
	define( 'DB_USER', 'root' );
	define( 'DB_PASSWORD', '123123' );
	define( 'DB_NAME', 'test_job' );

			// подключаемся MySQL-серверу
	$link = mysql_connect( DB_HOST, DB_USER, DB_PASSWORD);

		// соединяемся с бд
	mysql_select_db( DB_NAME );

?>