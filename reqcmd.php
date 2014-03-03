<?php
		$link = mysql_connect('localhost', 'root', 'Drakowa');
		    //or die('Не удалось соединиться: ' . mysql_error());
		//echo 'Соединение успешно установлено';
		mysql_select_db('command');// or die('Не удалось выбрать базу данных/n');

		// Выполняем SQL-запрос
		$dest = 2;//$_POST['dest'];


		$query = "SELECT cmd FROM commands WHERE isSucess=0 AND dest = '".$dest."';";
		$result = mysql_query($query);// or die('Запрос не удался: ' . mysql_error());
		$query = "UPDATE commands SET isSucess = 1 WHERE isSucess=0 AND dest = '".$dest."';";
		mysql_query($query);
		
		while ($line = mysql_fetch_array($result, MYSQL_ASSOC)) {
			//$entry['cmd'] = $line[0];
		    foreach ($line as $col_value) {
		    	$entry[$line.key($col_value)] = $col_value;
		    }
		    $cmds[] = $line;
		}

		echo json_encode($cmds);
		//var_dump($cmds);

		// Освобождаем память от результата
		mysql_free_result($result);

		// Закрываем соединение
		mysql_close($link);
		?>