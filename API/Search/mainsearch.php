<?php
  include "../../Config/config.php";
  require "../../Controllers/SearchController/searchController.php";
   
    
    $obj = new searchController();

    try{
        $input = json_decode(file_get_contents("php://input"),true);
        
        
        switch($_SERVER["REQUEST_METHOD"]){
        case "GET":
            
            if(isset($_GET["var"])){
            echo $obj->showService($_GET["var"]);
            }

             if(isset($_GET["contacto"])){
                echo $obj->showContact($_GET["contacto"]);
             }

             if(isset($_GET["ticket"])){
                echo $obj->showTicket($_GET["ticket"]);
             }

        break;
    }
}catch(Exception $e){
    echo json_encode(array('status'=> "error",
    "info" => "error server",
    "container" => $e));
}