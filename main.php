

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>РГР 1 пункт</title>
</head>
<body>
			<?php

				$mysqli_user = "root";
				$mysqli_password = "";
				$conn = mysqli_connect("127.0.0.1", $mysqli_user, $mysqli_password);
				if(!$conn) 
					die("Нет соединения с MySQL");

				$resultSelectDB = mysqli_select_db($conn,"rgr");

				if(!$resultSelectDB)
					die("<p>Не удалось выбрать базу данных</p>" . mysqli_error($conn));

				
				$queryDropTable = "DROP TABLE IF EXISTS T1";

				$resultDropTable = mysqli_query($conn, $queryDropTable);
			
				if(!$resultDropTable)
					die("<p>Нельзя уничтожить таблицу T1</p>" . mysqli_error($conn));
			
				$queryCreateTable = "CREATE TABLE T1 (id INT NOT NULL AUTO_INCREMENT, PRIMARY KEY(id), name VARCHAR(50), type VARCHAR(50), company VARCHAR(50))";
			
				$resultCreateTable = mysqli_query($conn, $queryCreateTable);

				$sql = "
        		INSERT INTO T1(name, type, company) VALUES 
            	('Access', 'Реляц', 'Microsoft'),
            	('FoxPro', 'Реляц', 'Microsoft'),
            	('Oracle7', 'Реляц', 'Oracle'),
            	('Orion3', 'ОО', 'Orion'),
            	('Orion 4', 'ОО', 'Orion'),
            	('Delphi', 'ОО', 'Microsoft'),
            	('Essbase1', 'Многом', 'Arbor'),
            	('Essbase2', 'Многом', 'Arbor'),
            	('Orion5', 'Многом', 'Orion'),
            	('Oracle8', 'Многом', 'Oracle')
        		";

				mysqli_query($conn, $sql);

				if (isset($_POST['id']) && isset($_POST['field_name'])) {
					$id = $_POST['id'];
					$field_name = $_POST['field_name'];

					if (!isset($_POST['field_value'])  || empty($_POST['field_value'])) {
						$field_value = "NULL";
					}else{
						$field_value = "'" . $_POST['field_value'] . "'";
					}

					$queryUpdate = "UPDATE T1 SET $field_name=$field_value WHERE id = $id";

					$resultUpdate = mysqli_query($conn, $queryUpdate);

					if(!$resultUpdate)
						die("<p>Не удалось изменить запись в таблице T1</p>" . mysqli_error($conn));
					print "<p>Успешно изменено</p>";
					print "<p><a href=\"main.php\">Вывести все записи таблицы</a></p>";
				}else if (!isset($_POST['id'])) {
					
					$script = $_SERVER['PHP_SELF'];
					print "<form action=\"$script\" method=\"POST\">
								<table cellpadding=0 border=1>
									<tr>
										<td>Название</td>
										<td>Тип</td>
										<td>Фирма</td>
									</tr>";

					$querySelect = "SELECT id, name, type, company FROM `T1`";
					
					$resultSelect = mysqli_query($conn, $querySelect);

					if(!$resultSelect)
						die("<p>Не удалось выбрать записи из таблицы T1</p>" . mysqli_error($conn));


					foreach ($resultSelect as $row) {
						print "<tr>";
						print "<td>" . $row['name'] . "</td>";
						print "<td>" . $row['type'] . "</td>";
						print "<td>" . $row['company'] . "</td>";
						//print "<td><input type=\"radio\" name=\"id\" value=\"" . $row['id'] . "\"></td>";
						print "</tr>";
					}


					//print "	</table>
							//<p><button type=\"submit\">Выбрать</button></p>
							//</form>";
					print "</table>
					</form>";

							$script = $_SERVER['PHP_SELF'];
								print "<form action=\"$script\" method=\"POST\">
									<p>TASK 1</p>
									<table cellpadding=0 border=1>
										<tr>
											<td>Название</td>
											<td>Тип</td>
											<td>Фирма</td>
										</tr>";


							$querySelect1 = "SELECT name, type, company FROM T1 WHERE name IN ('Access', 'FoxPro', 'Orion3');";
					
							$resultSelect1 = mysqli_query($conn, $querySelect1);
		
							foreach ($resultSelect1 as $row) {
								print "<tr>";
								print "<td>" . $row['name'] . "</td>";
								print "<td>" . $row['type'] . "</td>";
								print "<td>" . $row['company'] . "</td>";
								print "</tr>";
							}

							print "</table></form>";

							
							$script = $_SERVER['PHP_SELF'];
								print "<form action=\"$script\" method=\"POST\">
									<p>TASK 2</p>
									<table cellpadding=0 border=1>
										<tr>
											<td>Тип</td>
										</tr>";


							$querySelect2 = "SELECT type, COUNT(type) FROM T1 WHERE company NOT IN ('Microsoft', 'Oracle') GROUP BY type;";
					
							$resultSelect2 = mysqli_query($conn, $querySelect2);
		
							foreach ($resultSelect2 as $row) {
								print "<tr>";
								print "<td>" . $row['type'] . "</td>";
								print "<td>" . $row['COUNT(type)'] . "</td>";
								print "</tr>";
							}

							print "</table></form>";


							$script = $_SERVER['PHP_SELF'];
								print "<form action=\"$script\" method=\"POST\">
									<p>TASK 3</p>
									<table cellpadding=0 border=1>
										<tr>
											<td>Фирма</td>
										</tr>";


							$querySelect3 = "SELECT company FROM T1 WHERE type IN (SELECT type FROM T1 WHERE type LIKE '%Р%');";
					
							$resultSelect3 = mysqli_query($conn, $querySelect3);
		
							foreach ($resultSelect3 as $row) {
								print "<tr>";
								print "<td>" . $row['company'] . "</td>";
								print "</tr>";
							}

							print "</table></form>";


							

				}else if (isset($_POST['id'])) {
					$id = $_POST['id'];
				

					$querySelect = "SELECT id, name, type, company FROM `T1` WHERE id = $id";

					$resultSelect = mysqli_query($conn, $querySelect);

					if(!$resultSelect)
						die("<p>Не удалось выбрать запись из таблицы T1</p>" . mysqli_error($conn));
					
					$row = mysqli_fetch_row($resultSelect);
					$script = $_SERVER['PHP_SELF'];

					print "<form action=\"$script\" method=\"POST\">";
					print "<p><select name=\"field_name\">
						    <option value=\"name\" selected>$row[1]</option>
						    <option value=\"type\">$row[2]</option>
						    <option value=\"company\">$row[3]</option>
						   </select>
						   <input type=\"text\" name=\"field_value\"></p>";
					print "<input type=\"hidden\" name=\"id\" value=\"$id\">";
					print "<button type=\"submit\">Заменить</button>";
					print "</form>";
				}
			?>

</body>
</html>