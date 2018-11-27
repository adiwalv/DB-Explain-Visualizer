<?php 

$cmd = "mongo localhost/test --eval \"{$_POST["query"]}.explain()\"";

$output = shell_exec($cmd);

$file = 'temp.json';
file_put_contents($file, $output);

$cmd = "sed '1,4d' $file";
$output = shell_exec($cmd);
file_put_contents($file,$output);

$cmd = "node parser/flatten.js $file 2>&1";
exec($cmd,$output);

echo '<pre>';print_r($output);echo '<pre>';



?>
