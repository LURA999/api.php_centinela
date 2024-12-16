<?php
  include "../../Config/config.php";
  require "../../Controllers/SearchController/searchController.php";
   
    
    $obj = new searchController();

    try{
        $input = json_decode(file_get_contents("php://input"),true);
        
        
        switch($_SERVER["REQUEST_METHOD"]){
        case "POST":
            echo $obj->showTicketNav($input);
        break;
    }
}catch(Exception $e){
    echo json_encode(array('status'=> "error",
    "info" => "error server",
    "container" => $e));
}