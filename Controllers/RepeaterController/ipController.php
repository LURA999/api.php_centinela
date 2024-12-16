<?php
include "../../Application/Repeater/ip.php";

class ipController {

    private $obj;

    function __construct(){
        $this->obj = new ip();
    }
    
    function countActiveIpSegmento($segmento){
        $this->obj = $this->obj->countActiveIpSegmento($segmento);
        if(count($this->obj)==0){
        return json_encode(array(
            "info" => "not found",
            "status" => "not there Ips",
            "container" => []
        ));
        }else{
        return json_encode(array(
            "info" => "found",
            "status" =>"there Ips",
            "container" => $this->obj
        ));
      }
    }
    function createIp($input){
    try{
        $this->obj = $this->obj->insertIp($input);
        return json_encode(array(
            "info" => "inserted",
            "status" => "inserted achieved"
        ));
    }catch(Exception $e){
        return json_encode(array(
            "info" => "fail",
            "status" => "inserted not successful"
        ));
    }
    }

   function showIps(){
    
        $this->obj = $this->obj->selectIps();
        if(count($this->obj)==0){
        return json_encode(array(
            "info" => "not found",
            "status" => "not there Ips",
            "container" => []
        ));
        }else{
        return json_encode(array(
            "info" => "found",
            "status" =>"there Ips",
            "container" => $this->obj
        ));
        }
    }



    function showIp($segmento, $segmentoFinal,$condicion,$condicion2){

	$this->obj = $this->obj->selectIp($segmento, $segmentoFinal,$condicion,$condicion2);
	   if(count($this->obj)==0){
        return json_encode(array(
            "info" => "not found",
            "status" => "not there Ips",
            "container" => []
        ));
        }else{
        return json_encode(array(
            "info" => "found",
            "status" =>"there Ips",
            "container" => $this->obj
        ));
        }
    }

    function showIpOnly($seg1, $seg2, $seg3){
        $this->obj = $this->obj->selectIpOnly($seg1, $seg2, $seg3);
	   if(count($this->obj)==0){
        return json_encode(array(
            "info" => "not found",
            "status" => "not there Ips",
            "container" => []
        ));
        }else{
        return json_encode(array(
            "info" => "found",
            "status" =>"there Ips",
            "container" => $this->obj
        ));
        }
    }

    function showIpOnlySinParam($seg1){
        $this->obj = $this->obj->selectIpOnlySinParam($seg1);
	   if(count($this->obj)==0){
        return json_encode(array(
            "info" => "not found",
            "status" => "not there Ips",
            "container" => []
        ));
        }else{
        return json_encode(array(
            "info" => "found",
            "status" =>"there Ips",
            "container" => $this->obj
        ));
        }
    }

}