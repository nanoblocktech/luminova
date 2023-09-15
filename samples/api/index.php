<?php 
require_once(__DIR__ . '/../../system/autoload.api.php');
header("Content-type:application/json");
/*
All your ajax request should be in this folder
*/
$Response = [
    'status' => 200, 
    'message' => 'Request completed successfully'
];
echo json_encode($Response, true);
exit();