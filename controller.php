<?php

 function return_response($status, $statusMessage, $data) {
  header("HTTP/1.1 $status $statusMessage");
  header("Content-Type: application/json; charset=UTF-8");

  echo json_encode($data);
 }
 
 
 $connectionURI = explode("/", $_SERVER['REQUEST_URI']);

 $bodyRequest = file_get_contents("php://input");

 
 switch ($_SERVER['REQUEST_METHOD']) {
  case 'GET':
   
   if(isset($id)) {
    $data->property = 'Here we go';
    $data->id = $id;
   // Si no existe, solicita todos los elementos
   } else {
    $data->property = 'Here we go 2';
   }
   return_response(200, "OK", $data);
   break;
  case 'POST':
   $array = json_decode($bodyRequest, true);
   $data = new stdClass();
   $data->ask = $array;
      
   if(isset($id)) {
    // Decodifica el cuerpo de la solicitud y lo guarda en un array de PHP
    
    $data->property = 'Here we go 3';
    $data->id = $id;
    
   // Si no existe, solicita todos los elementos
   } else {
    $data->property = 'Here we go 4';
   }
   return_response(200, "OK", $data);
   


   break;
 
  default:
   // Acciones cuando el metodo no se permite
   // En caso de que el Metodo Solicitado no sea ninguno de los cuatro disponible, envia la siguiente respuesta
   return_response(405, "Method Not Allowed", null);
   break;
 }


 