<?php
    include "../../Config/database.php";
    
    class smtp extends database {
        function insertSmtp($input){
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
        
        function selectSmtp(){
            $sql = $this->connect()->prepare("select  lim_env,lim_corr,host,auth,username,password,smtp_secure,port
            from smtp");
            $sql ->execute();
            return $sql->fetchAll(PDO::FETCH_ASSOC); 
        }
        
        function updateSmtp($input){
            $sql = $this->connect()->prepare("update smtp set lim_env = :lim_env, lim_corr = :lim_corr, host = :host, auth = :auth, username = :username ,password = :password, smtp_secure = :smtp_secure, port = :port where idsmtp_config = 1");
            $sql->bindParam(":lim_env",$input["lim_env"],PDO::PARAM_INT);
            $sql->bindParam(":lim_corr",$input["lim_corr"],PDO::PARAM_INT);
            $sql->bindParam(":host",$input["host"],PDO::PARAM_STR);
            $sql->bindParam(":auth",$input["auth"],PDO::PARAM_INT);
            $sql->bindParam(":username",$input["username"],PDO::PARAM_STR);
            $sql->bindParam(":password",$input["password"],PDO::PARAM_STR);
            $sql->bindParam(":smtp_secure",$input["smtp_secure"],PDO::PARAM_INT);
            $sql->bindParam(":port",$input["port"],PDO::PARAM_STR);
            $sql ->execute();
            return $sql; 
        }
        
        }
        
        
        