<?php

//POINT 3

define('ROOT', dirname(__FILE__));

require_once ROOT.'/verification/DataVerification.php';

error_reporting(E_ALL);

$request = json_decode($_POST['json'],TRUE);

$encryptData = utf8_decode($request['encryptData']);
$dataJson = $request['dataJSON'];

$result = (new DataVerification($encryptData, $dataJson))->execute();

$result = json_encode(utf8_encode($result));

/** The encode data */
echo $result;