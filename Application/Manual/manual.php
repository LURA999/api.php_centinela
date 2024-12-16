<?php
    include "../../Config/database.php";
    
    class manual extends database {
        function insertManual($input){
            $sql = $this->connect()->prepare("insert into manual
            (nombre,ubicacion,fecha,tipo,cveUsuario,cveAsunto,archivo,tamano) values(:nombre,:ubicacion,:fecha,:tipo,:cveUsuario,:cveAsunto,:archivo,:tamano)");
            $sql->bindParam(":nombre",$input["nombre"],PDO::PARAM_STR);
            $sql->bindParam(":ubicacion",$input["ubicacion"],PDO::PARAM_STR);
            $sql->bindParam(":fecha",$input["fecha"],PDO::PARAM_STR);
            $sql->bindParam(":tipo",$input["tipo"],PDO::PARAM_INT);
            $sql->bindParam(":cveUsuario",$input["cveUsuario"],PDO::PARAM_INT);
            $sql->bindParam(":cveAsunto",$input["cveAsunto"],PDO::PARAM_INT);
            $sql->bindParam(":archivo",$input["archivo"],PDO::PARAM_STR);
            $sql->bindParam(":tamano",$input["tamano"],PDO::PARAM_STR);

            $sql ->execute();
            return $sql;
        }
        function selectManualcount(){
        $sql = $this->connect()->prepare("SELECT AUTO_INCREMENT as max
        FROM  INFORMATION_SCHEMA.TABLES
        WHERE
        TABLE_NAME   = 'manual' 
        limit 1;");
            $sql ->execute();
            return $sql->fetchAll(PDO::FETCH_ASSOC);
        }


        function selectManual(){
            $sql = $this->connect()->prepare("select idManual,m.nombre,ubicacion,fecha,m.tipo tipo,cveAsunto,cveUsuario,archivo,tamano,u.usuario usuario,a.nombre  asunto from manual m inner join usuario u on cveUsuario=idUsuario inner join asunto a on cveAsunto=idAsunto");
            $sql ->execute();
            return $sql->fetchAll(PDO::FETCH_ASSOC); 
 
        }

        function selectManualbyuser(){
            $sql = $this->connect()->prepare("select idManual,m.nombre,ubicacion,fecha,m.tipo tipo,
            cveAsunto,cveUsuario,archivo,tamano,u.usuario usuario,a.nombre asunto from manual m inner join 
            usuario u on cveUsuario=idUsuario inner join asunto a on cveAsunto=idAsunto and idUsuario > 0 order by usuario;
            ");
            $sql ->execute();
            return $sql->fetchAll(PDO::FETCH_ASSOC); 
        }

        function selectAsunto(){
            $sql = $this->connect()->prepare("select idAsunto,nombre from asunto");
            $sql ->execute();
            return $sql->fetchAll(PDO::FETCH_ASSOC); 
        }

        function updateManual($input){
            echo var_dump($input);
            $sql = $this->connect()->prepare("update manual set nombre = :nombre where idManual = :id");
            $sql->bindParam(":nombre",$input["nombre"],PDO::PARAM_STR);
            $sql -> bindParam(":id", $input["id"], PDO::PARAM_INT);

            $sql ->execute();
            return $sql; 


        }
            function deleteManual($id){
                echo var_dump($id);
                $sql = $this->connect()->prepare("delete from manual where idManual = :id");
                $sql -> bindParam(":id", $id, PDO::PARAM_INT);
                $sql ->execute();
                return $sql; 
        }
        
        }
        
        
        