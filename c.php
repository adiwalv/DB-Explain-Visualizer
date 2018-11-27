<html>
<body> 
<form action = 'text.php' method="post">
<select name = "db_name">
<?php
     require('./config/config.php');

foreach($connection->listDatabases() as $database)
{
    echo "<option value = \"{$database->getName()}\">{$database->getName()}</option>";
}
?>
</select>
<input type = "submit">
</body>
</html>
