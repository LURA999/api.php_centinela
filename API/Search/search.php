<?php
  include "../../Config/config.php";
  require "../../Controllers/SearchController/searchController.php";
   
    
    $obj = new searchController();

    try{
        $input = json_decode(file_get_contents("php://input"),true);
        
        
        switch($_SERVER["REQUEST_METHOD"]){
          case "POST":
            echo $obj->createManual($input);
          break;
          case "GET":
           {
            if(isset($_GET["id"])){
              echo $obj->showServiceEstatus($_GET['id']);
            }else 
            
              echo $obj->showService();

            }
          break;
          case "PATCH":
                echo $obj->changeManual($input);
          
          break;
          case "DELETE":
            echo $obj->removeManual($_GET["id"]);

          break;
        }
        }catch(Exception $e){
          echo json_encode(array('status'=> "error",
            "info" => "error server",
            "container" => $e));
        }
    