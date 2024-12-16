<?php
    include "../Config/config.php";
    require "../Controllers/cityController.php";
    
    $obj = new cityController();

    try{                
        $input = json_decode(file_get_contents('php://input'),true);
        switch($_SERVER['REQUEST_METHOD']){
            case 'GET':
                if(!isset($_GET["cve"])){
                echo $obj -> listCities();
                }else{
                    echo $obj -> listCityOnly($_GET["cve"]);
                }
            break;
        }
    }catch(Exception $e){
        echo  json_encode(array('status'=>"error",
        'info'=>"server error",
        'contenido'=>$e));
    }
    