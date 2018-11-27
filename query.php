<?php 

require('lib/definitions.php');



$cmd = "mongo localhost/{$_POST["db_name"]} --eval \"db.{$_POST["collection_name"]}.find({$_POST["query"]}).explain('executionStats')\"";
$output = shell_exec($cmd);
file_put_contents($file, $output);
deleteRubbish($file);
$output = createExplain();
displayExplain($output);
?>
