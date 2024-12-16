<?php
    include "../../Config/config.php";
    require "../../Controllers/UsersController/usersController.php";
    
    $obj = new usersController();

    try{                
        $input = json_decode(file_get_contents('php://input'),true);
        switch($_SERVER['REQUEST_METHOD']){
            case 'GET':
                if(isset($_GET['cve'])){
                    echo $obj -> listUsers($_GET['cve']);
                }
                
                if(isset($_GET["id"])){
                    echo $obj ->listUsersCities($_GET['id']);
                }
                    
                if(isset($_GET['cveRol']))
                {
                    echo $obj ->listUsersRol($_GET['cveRol']);
                }

                if(isset($_GET['cveGroup']))
                {
                    echo $obj ->listUsersGroup($_GET['cveGroup']);
                }

                if(!isset($_GET['cve']) && !isset($_GET["id"]) && !isset($_GET['cveRol']) && !isset($_GET['cveGroup'])){
                    echo $obj ->listAllUsers(); 
                }        
            break;
            case 'PATCH':
                echo $obj -> changeUser($_GET['cve']); 
            break;
            case 'DELETE':
                echo $obj -> deleteUser();
            break;            
            case 'POST':
                echo $obj -> insertUser($input);
                
            break;
        }
    }catch(Exception $e){
        echo  json_encode(array('status'=>"error",
        'info'=>"server error",
        'contenido'=>$e));
    }
    