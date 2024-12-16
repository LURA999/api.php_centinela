<?php
    include "../../Config/database.php";
    
    class date extends database {
        function insertDate($input){
            $sql = $this->connect()->prepare("insert into smtp
            (lim_env,lim_corr,host,auth,username,password,smtp_secure,port) values(:lim_env,:lim_corr,:host,:auth,:username,:password,:smtp_secure,:port) ");
            $sql->bindParam(":lim_env",$input["lim_env"],PDO::PARAM_INT);
            $sql->bindParam(":lim_corr",$input["lim_corr"],PDO::PARAM_INT);
            $sql->bindParam(":host",$input["host"],PDO::PARAM_STR);
            $sql->bindParam(":auth",$input["auth"],PDO::PARAM_INT);
            $sql->bindParam(":username",$input["username"],PDO::PARAM_STR);
            $sql->bindParam(":password",$input["password"],PDO::PARAM_STR);
            $sql->bindParam(":smtp_secure",$input["smtp_secure"],PDO::PARAM_INT);
            $sql->bindParam(":port",$input["port"],PDO::PARAM_INT);
            $sql ->execute();
            return $sql;
        }
        
        function selectDate(){
            $sql = $this->connect()->prepare("select hora,fecha,zona_horaria from date where id_date = 1");
            $sql ->execute();
            return $sql->fetchAll(PDO::FETCH_ASSOC); 
        }
        
        function updateDate($input){
            
            $sql = $this->connect()->prepare("update date set hora = :hora, fecha = :fecha, zona_horaria = :zona_horaria where id_date = 1");
            $sql->bindParam(":hora",$input["hora"],PDO::PARAM_STR);
            $sql->bindParam(":fecha",$input["fecha"],PDO::PARAM_STR);
            $sql->bindParam(":zona_horaria",$input["zona_horaria"],PDO::PARAM_INT);
            
            $sql ->execute();
            return $sql; 
        }
        
        }
        
        
        