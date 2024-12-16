<?php
include "../../Config/config.php";


    class CheckDevice {
        
        public function myOS(){
            if (strtoupper(substr(PHP_OS, 0, 3)) === (chr(87).chr(73).chr(78)))
                return true;
            return false;
        }
        public function ping($ip_addr){
            $mensaje = "";

            
            if ($this->myOS()){ 
                if (!exec("ping -n 1 -w 1 ".$ip_addr." 2>NUL > NUL && (echo 0) || (echo 1)")){
                $mensaje = exec("ping -n 1 -w 1 ".$ip_addr."");
                $word =explode(",", $mensaje);
                $mensaje = array(
                    "container" =>  [
                        "status" => "200",
                        "time"=>explode("=",$word[2])[1]
                    ]);
                return $mensaje;
                }else{
                    $mensaje = array(
                        "container" =>  [
                        "status" => "400",
                        "time"=>"N/A"
                        ]);
                    return $mensaje;
                }
            } else {
                if (!exec("ping -q -c1 ".$ip_addr." >/dev/null 2>&1 ; echo $?")){
                $mensaje = exec("ping -q -c1 ".$ip_addr."");
                $word =explode(",", $mensaje);
                $mensaje = array(
                    "container" =>  [
                        "status" => "200",
                        "time"=>explode("=",$word[2])[1]
                    ]);
                return $mensaje;
                }else{
                    $mensaje = array(
                        "container" =>  [
                        "status" => "400",
                        "time"=>"N/A"
                        ]);
                    return $mensaje;
                }
            }
        }
    }

$ip_addr = $_GET["ip"]; #DNS: www.phpcentral.com
echo(json_encode((new CheckDevice())->ping($ip_addr)));
