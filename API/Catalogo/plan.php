<?php
    include "../../Config/config.php";
    require "../../Controllers/CatalogoController/planController.php";
    
    $obj = new planController();

    try{                
        $input = json_decode(file_get_contents('php://input'),true);
        switch($_SERVER['REQUEST_METHOD']){
            case 'GET':
                echo $obj -> listPlan();
            break;
        }
    }catch(Exception $e){
        echo  json_encode(array('status'=>"error",
        'info'=>"server error",
        'contenido'=>$e));
    }
    