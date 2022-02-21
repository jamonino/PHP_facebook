<?php

 function return_response($status, $statusMessage, $data) {
  header("HTTP/1.1 $status $statusMessage");
  header("Content-Type: application/json; charset=UTF-8");

  echo json_encode($data);
 }
 
 
 $connectionURI = explode("/", $_SERVER['REQUEST_URI']);

 $bodyRequest = file_get_contents("php://input");

 
 switch ($_SERVER['REQUEST_METHOD']) {
  case 'POST':
   
   
   return_response(200, "OK", $data);
   break;
  
  default:
   
   return_response(405, "Method Not Allowed", null);
   break;
 }


 