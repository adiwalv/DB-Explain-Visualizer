<?php
$file = 'temp.json';

function deleteRubbish($file) {
  $cmd = "sed '1,4d' $file";
  $output = shell_exec($cmd);
  file_put_contents("temp.json",$output);
}

function createExplain(){
  $cmd = "node parser/flatten.js temp.json 2>&1";
  exec($cmd,$output);
  return $output;
}


function displayExplain($output){
 
  foreach($output as $key => $value)
  {
    echo '<pre>';
    echo $value;
    /**
    $keywords = preg_split("/[^a-z0-9]+/", $value);
    for($i = 0;$i < count($keywords); $i++){
      echo $keywords[$i];
    }
    **/
    echo '</pre>';
  }
}
?>
