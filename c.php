<html>
<body>
<form action = 'text.php' method="post">
<select>
<?php

     require('./config/config.php');

foreach($connection->listDatabases() as $database)
{
    echo "<option value = \"$database->getName()\" name = 'db_name'>{$database->getName()}</option>";
}
?>
</select>
<input type = "submit">
</body>
</html>
