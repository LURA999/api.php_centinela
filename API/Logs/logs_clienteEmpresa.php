<?php
require "../../Config/config.php";
include "../../Controllers/LogsController/logsController_clienteEmpresa.php";

try {
    $input = json_decode(file_get_contents("php://input"),true);

    $obj = new logsController_clienteEmpresa();
    
    switch($_SERVER["REQUEST_METHOD"]){
        case "GET":
            echo $obj->showLog($_GET["cve"]);
        break;
        case "POST":
            echo $obj->addLog($input,$_GET["condicion"]);
        break;
        case "DELETE":
            echo $obj->removeLog($_GET["cve"]);
        break;
    }

    }catch(Exception $e){
        echo json_encode(array('status'=> "error",
        "info" => "error server",
        "container" => $e));
    }