<?php

 require "DB.php";
 require "User.php";


 function return_response($status, $statusMessage, $data) {
    header("HTTP/1.1 $status $statusMessage");
    header("Content-Type: application/json; charset=UTF-8");
    //CORS
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");  

    echo json_encode($data);
 }
 
 
 $connectionURI = explode("/", $_SERVER['REQUEST_URI']);
 
 //Se limpian los elementos en blanco para direcciones del tipo dominio.com/user/1/ que nos daría un último elemento del array en blanco
 foreach ($connectionURI as $key => $value) {
    if(empty($value)) {
        unset($connectionURI[$key]);
    }
 }

 //Obtenemos id (si es el caso) y entidad
 if(end($connectionURI)>0) {
    $id = $connectionURI[count($connectionURI)];
    $entity = $connectionURI[count($connectionURI) - 1];
 } else {
    $entity = $connectionURI[count($connectionURI)];
 }
 
 $bodyRequest = file_get_contents("php://input");

 
 switch ($_SERVER['REQUEST_METHOD']) {
    case 'POST':
        $myDb = new DB();
        $newUser = new User;
        $newUser->jsonConstruct($bodyRequest);
        $newUser->DB_insert($myDb->connection);
        return_response(200, "OK", $newUser);
        break;

    case 'GET':
        $myDb = new DB();
        if(isset($id)) {
            $userToGet = new User;
            $userToGet->setId($id);
            $userToGet->DB_selectOne($myDb->connection);
            return_response(200, "OK", $userToGet);
        }else{
            return_response(200, "OK", User::DB_selectAll($myDb->connection));
        }
        break;

    case 'PUT':
        if(isset($id)) {
            $myDb = new DB();
            $userToPut = new User;
            $userToPut->jsonConstruct($bodyRequest);
            $userToPut->setId($id);
            $userToPut->DB_update($myDb->connection);
            return_response(200, "OK", $userToPut);
        }else{
            return_response(405, "Method Not Allowed", null);
        }
        break;
    
    case 'DELETE':
        if(isset($id)) {
            $myDb = new DB();
            $userToDelete = new User;
            $userToDelete->setId($id);
            $userToDelete->DB_delete($myDb->connection);
            return_response(200, "OK", $userToDelete);
        }else{
            return_response(405, "Method Not Allowed", null);
        }
        break;
   
    default:
        return_response(405, "Method Not Allowed", null);
        break;
 }


 