<?php
    include "../../Config/database.php";
    
    class asunto extends database {
        function insertAsunto($input){
            
            $sql = $this->connect()->prepare("insert into manual
            (nombre,estatus,tipo) values(:nombre,:estatus,:tipo) ");
            $sql->bindParam(":nombre",$input["nombre"],PDO::PARAM_STR);
            $sql->bindParam(":estatus",$input["estatus"],PDO::PARAM_STR);
            $sql->bindParam(":tipo",$input["tipo"],PDO::PARAM_STR);
         

            $sql ->execute();
            return $sql;
        }
        
      
        

        function selectAsunto(){
            $sql = $this->connect()->prepare("select idAsunto,nombre,estatus,tipo from asunto");
            $sql ->execute();
            return $sql->fetchAll(PDO::FETCH_ASSOC); 
        }

        function updateAsunto($input){
            $sql = $this->connect()->prepare("update asunto set nombre = :nombre, estatus = :estatus, tipo = :tipo where idsmtp_config = id");
            $sql->bindParam(":nombre",$input["nombre"],PDO::PARAM_STR);
            $sql->bindParam(":estatus",$input["estatus"],PDO::PARAM_STR);
            $sql->bindParam(":tipo",$input["tipo"],PDO::PARAM_STR);

            $sql ->execute();
            return $sql; 


        }
            function deleteAsunto($id){
                echo var_dump($id);
                $sql = $this->connect()->prepare("delete from manual where idManual = :id");
                $sql -> bindParam(":id", $id, PDO::PARAM_INT);
                $sql ->execute();
                return $sql; 
        }
        
        }
        
        
        