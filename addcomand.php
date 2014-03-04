		<?php
		$link = mysql_connect('localhost', 'root', 'Drakowa')
		    or die('Не удалось соединиться: ' . mysql_error());
		echo 'Соединение успешно установлено';
		mysql_select_db('command') or die('Не удалось выбрать базу данных/n');

		// Выполняем SQL-запрос
		$cmd = $_POST['cmd'];
		$source = 1;//$_POST['source'];
		$dest = 2;//$_POST['dest'];


		$query = 'SELECT * FROM commands';
		$query = "INSERT INTO commands (cmd, source, dest) VALUES ('".$cmd."', '".$source."', '".$dest."')";
		$result = mysql_query($query) or die('Запрос не удался: ' . mysql_error());

		// Освобождаем память от результата
		mysql_free_result($result);

		// Закрываем соединение
		mysql_close($link);
		?>