<?php
require_once ('array.php');
require_once ('function.php');
$check = new check($array);
$html = file_get_contents('main.html');
$html= str_replace('{style}', $check->style, $html);

foreach ($check->info as $val){
    $num = $val[0];
    $text = $val[1];
    $change = "{marker $num}";
    $html = str_replace($change, $text, $html);
}

echo $html;