<?php 
require_once(__DIR__ .'/../includes/autoload.php');

$data = array('something' => '$main_content', 'loader' => '$loader', 'navigation' => '$navigation');
echo json_encode($data, JSON_UNESCAPED_SLASHES); 
