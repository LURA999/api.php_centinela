<?php
    include "../../Config/config.php";
    require "../../Controllers/ConfigController/configController.php";
    
    $obj = new configController();

    try{
      

        $input = json_decode(file_get_contents("php://input"),true);

        switch($_SERVER["REQUEST_METHOD"]){
          case "POST":
            
            echo $obj->createEmpresa($input);
          break;
          case "GET":
            if(isset($_GET["id"])){
              echo $obj->showEmpresaOnly($_GET['id']);
            }else{
              echo $obj->showEmpresa();
            }
          break;
          case "PATCH":
            if(isset($input["nombre"])){
              echo $obj->changeEmpresa($input);
            }else if(isset($input["logo"])){
              echo $obj->changeLogo($input);
            }else
            {
              
                echo $obj->changeImage($input);
            }
          break;
          case "DELETE":
        
          break;
        }
        }catch(Exception $e){
          echo json_encode(array('status'=> "error",
            "info" => "error server",
            "container" => $e));
        }
    