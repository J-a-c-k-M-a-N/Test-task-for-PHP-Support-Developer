<?php

//POINT 2

define('ROOT', dirname(__FILE__));

require_once ROOT.'/services/DataService.php';

error_reporting(E_ALL);

$request = $_POST['json'];

$dataJson = (new DataService($request))->execute();

echo $dataJson;