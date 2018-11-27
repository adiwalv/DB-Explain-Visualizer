<?php

require('./config/config.php');

$db_name = $_POST["db_name"];

$connection->selectDB($db_name);

?>

<!DOCTYPE HTML>
<html>  
<body>

<form action="query.php">
Query: <input type="text" name="query"><br>
<input type="submit">
</form>

</body>
</html>
