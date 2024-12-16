<?php
require "../../Application/Logs/logs_clienteEmpresa.php";
class logsController_clienteEmpresa {

    private $obj;

    function __construct (){
        $this->obj = new logs_clienteEmpresa();
    }

    function showLog($cve){
        $this-> obj = $this->obj->selectLog($cve);
        if(count($this->obj)> 0){
            return json_encode(array(
            "info" => "ok",
            "container" => $this->obj));
        }else{
            return json_encode(array(
            "info" => "bad",
            "container" => null));
        }
    }

    function addLog($input,$cond){
      try{
        $this-> obj = $this->obj->insertLog($input,$cond);
        return json_encode(array("info" => "added log"));
        }catch(Exception $e){
            return json_encode(array("info" => "bad log insert"));
        }
    }

    function removeLog($cve){
        try{
          $this-> obj = $this->obj->deleteLog($cve);
          return json_encode(array("info" => "delete log"));
          }catch(Exception $e){
              return json_encode(array("info" => "bad delete insert"));
          }
      }
}