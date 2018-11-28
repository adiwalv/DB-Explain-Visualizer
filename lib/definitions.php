<?php
$file = 'temp.json';


function removeDilimiters($output){
  $new_output = [];
  foreach($output as $key => $value)
  {
    $keywords = preg_split("/[^a-zA-Z0-9.]+/", $value);
    array_push($new_output,implode(" ",$keywords));
  }
  return $new_output;
}


function getValue($output,$key) {
  $output = removeDilimiters($output);
  for($i = 0; $i < count($output); $i++){
    $words = explode(" ",$output[$i]);
    $index = array_search($key,$words);
    if($index != FALSE)
      return $words[$index+1];
  }
}




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

function makeString($array){

$array = str_split($array);
$output = [];
$i = 0;
foreach($array as $char){
  if($char == "$"||$char == "\""){
     array_push($output,"\\",$char);
     continue;
  }
   array_push($output,$char);
}

return implode("",$output);
}
?>
