<?php
  include "../../Config/config.php";
  require "../../Controllers/UsersController/usersModuleController.php";
   
    
    $obj = new usersModuleController();

    try{
        $input = json_decode(file_get_contents("php://input"),true);
         switch($_SERVER["REQUEST_METHOD"]){
          case "POST":
            if(isset($_GET["Group"])){
              echo $obj->createGroups($input);

              }else{
                echo $obj->createUsers($input);
              }
          break;
          case "GET":
            if(isset($_GET["Group"])){
              echo $obj->showGroup();
            }else if(isset($_GET["GroupList"])){
              echo $obj->showGroupList();
            }else if(isset($_GET["Rol"]))
            {
              echo $obj->showRol();

            }else if(isset($_GET["id"])){
            
              echo $obj->showUsersList($_GET["id"]);

            }else if(isset($_GET["Info"])){

              echo $obj->showUsersInfo($_GET["Info"]);
            
            }else if(isset($_GET["InfoGroup"])) {
              
              echo $obj->showGroupInfo($_GET["InfoGroup"]);
            }else{
              echo $obj->showUsers();
            }
    
          break;
          case "PATCH":
            if(isset($_GET["UpdateUser"])){
                echo $obj->changeUser($input);
            }else{
              echo $obj->changeGroup($input);
            }
          break;
          case "DELETE":
            if(isset($_GET["DeleteUser"])){
              echo $obj->removeUser($_GET["DeleteUser"]);
          }else if(isset($_GET["DeleteGroup"])){
            echo $obj->removeGroup($_GET["DeleteGroup"]);

          }

          break;
        }
        }catch(Exception $e){
          echo json_encode(array('status'=> "error",
            "info" => "error server",
            "container" => $e));
        }
    