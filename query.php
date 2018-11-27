<?php 

$cmd = "mongo localhost/test --eval \"{$_POST["query"]}.explain()\";

$output = shell_exec($cmd);
$file = 'temp.json';
file_put_contents($file,$output);

$cmd = "sed '1,4d' {$file}";
$output = shell_exec($cmd);
file_put_contents($file,$output);

$cmd = "node parser/flatten.js $file";
$output = shell_exec($cmd);

echo $output;


?>
