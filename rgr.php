<html>
<head>
    <title>
        Расчетно-графическое задание
    </title>
    <?php
        $HOST = "localhost";  
        $USER = "root";
        $PASS = "";
        $DB   = "rgr";
    
        $conn = mysqli_connect($HOST, $USER, $PASS);
        
        if(!$conn) 
            die("<p>Нет соединения с MySQL</p>");

        //     if(!mysqli_query($conn, "DROP DATABASE IF EXISTS $DB"))
        //     die("<p>Не удалось удалить базу данных $DB</p>" . mysqli_error($conn));
    
        // if(!mysqli_query($conn, "CREATE DATABASE $DB"))
        //     die("<p>Не удалось создать базу данных $DB</p>" . mysqli_error($conn));

    
        if(!mysqli_select_db($conn, "$DB"))
            die("<p>Не удалось выбрать базу данных</p>" . mysqli_error($conn));
        
        $TABLE  = "T3";
    
        if(!mysqli_query($conn, "DROP TABLE IF EXISTS $TABLE"))
            die("<p>Не удалось удалить таблицу $TABLE</p>" . mysqli_error($conn));
        
        $sql = "CREATE TABLE $TABLE(
            n INT AUTO_INCREMENT NOT NULL,
            Lname VARCHAR(20) NOT NULL,
            Ltype VARCHAR(20) NOT NULL,
            company VARCHAR(20) NOT NULL,
            PRIMARY KEY(n)
        );";
        
        if(!mysqli_query($conn, $sql))
            die("<p>Не удалось создать таблицу $TABLE</p>" . mysqli_error($conn));

        $sql = "
        INSERT INTO $TABLE(Lname, Ltype, company) VALUES 
            ('Pascal', 'Процед', 'Borland'),
            ('C', 'Процед', 'Borland'),
            ('Java', 'Процед', 'Java inc'),
            ('C++', 'Объект', 'Java inc'),
            ('Visual C', 'Объект', 'Microsoft'),
            ('Visual Basic', 'Объект', 'Microsoft'),
            ('Delphi', 'Объект', 'Borland'),
            ('Lisp', 'Сценарн', 'IBM'),
            ('Prolog', 'Сценарн', 'IBM'),
            ('XML', 'Сценарн', 'Borland')
        ";

        if(!mysqli_query($conn, $sql))
            die("<p>Не удалось заполнить таблицу $TABLE</p>" . mysqli_error($conn));

	?>
</head>
<body>

<form action="<?=$_SERVER['PHP_SELF']?>" method="post">
    <p>Выберите имя столбца таблицы:</p>
    <br><input type="radio" name="column" value="n" checked>Номер<br>
    <input type="radio" name="column" value="Lname">Название<br>
    <input type="radio" name="column" value="Ltype">Тип</br>
    <input type="radio" name="column" value="company">Фирма</p>
    <p><input type="submit" value="Выполнить"></p>
</form>

<?php
    $column = $_POST["column"];

    if($column)
    {
        print "<p style='font-weight:bold'>Значения столбца '$column':</p>";
        $sql = "SELECT $column FROM $TABLE";
        $result = mysqli_query($conn, $sql);
        if(!$result)
			die("<p>Не удалось выбрать записи из таблицы $table</p>" . mysqli_error($conn));
        print "<ul type='square'>";

        while($row = mysqli_fetch_array($result)) {
            print "<li>" . $row[0] . "</li>";
        }
        print "</ul>";
        
    }
?>
</body>
</html>