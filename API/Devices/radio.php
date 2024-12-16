<?php
  include "../../Config/config.php";
  require "../../Controllers/DevicesController/radioController.php";
   
    $obj = new radioController();

    try{
        $input = json_decode(file_get_contents("php://input"),true);

        switch($_SERVER["REQUEST_METHOD"]){
          case "POST":
            echo $obj->createRadio($input);
          break;
          case "GET":
            if(isset($_GET["id"])){
              echo $obj->showRadioOnly($_GET['id']);
            }else{
              if(isset($_GET["identificador"])){
                echo $obj->showRadio($_GET["identificador"], $_GET["contador"]);
              }else{
                echo $obj->showAutoIncrement();
              }  
            }
          break;
          case "PATCH":
            echo $obj->changeRadio($input);
          break;
          case "DELETE":
            echo $obj->removeRadio($_GET["id"]);
          break;
        }
        }catch(Exception $e){
          echo json_encode(array('status'=> "error",
            "info" => "error server",
            "container" => $e));
        }
    