<?php
$file = "uploads/temp.json";


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


function showRawJSON(){
    $myfile = fopen("uploads/temp.json", "r") or die("Unable to open file!");
// Output one line until end-of-file
    while(!feof($myfile)) {
        echo fgets($myfile) . "<br>";
    }
    fclose($myfile);
}


function deleteRubbish($file) {
    $cmd = "sed '1,4d' $file";
    $output = shell_exec($cmd);
    file_put_contents($file,$output);
}

function createExplain(){
    $cmd = "node parser/flatten.js uploads/temp.json 2>&1";
    exec($cmd,$output);
    /**if (!unlink('temp.json')) {
       echo ("Error deleting temp.json");
       }**/
    return $output;
}

function checkExtension($path){
    $allowed =  array('json','JSON');
    $ext = pathinfo($path, PATHINFO_EXTENSION);
    if(!in_array($ext,$allowed) ) {
        return FALSE;
    }
    return TRUE;
}

function displayExplain($output){

    foreach($output as $key => $value)
    {
        if (strpos($value, 'internal/modules/cjs/loader') !== false) {
            echo "<br>There seems to be an error in your Query Or File! <a href = 'index.php'>Go Back</a><br>";
            break;
        }
        echo '<pre>';
        echo $value;
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
