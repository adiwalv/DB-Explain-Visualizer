<?php 

require('lib/definitions.php');

$cmd = "mongo localhost/test --eval \"{$_POST["query"]}.explain()\"";
$output = shell_exec($cmd);
file_put_contents($file, $output);
deleteRubbish($file);
$output = createExplain();
displayExplain($output);
?>
