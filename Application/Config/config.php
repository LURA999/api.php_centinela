<?php
    include "../../Config/database.php";
    
    class config extends database {
        function insertEmpresa($input){
           
            $sql = $this->connect()->prepare("insert into empresa 
            (nombre,direccion,telefono,rfc,rs,ciudad,imagen,correo) values(:nombre,:direccion,:telefono,:rfc,:rs,:ciudad,:imagen,:correo) ");
            $sql->bindParam(":nombre",$input["nombre"],PDO::PARAM_STR);
            $sql->bindParam(":direccion",$input["direccion"],PDO::PARAM_STR);
            $sql->bindParam(":telefono",$input["telefono"],PDO::PARAM_STR);
            $sql->bindParam(":rfc",$input["rfc"],PDO::PARAM_STR);
            $sql->bindParam(":rs",$input["rs"],PDO::PARAM_STR);
            $sql->bindParam(":ciudad",$input["ciudad"],PDO::PARAM_STR);
            $sql->bindParam(":imagen",$input["img"],PDO::PARAM_STR);
            $sql->bindParam(":correo",$input["correo"],PDO::PARAM_STR);

            $sql ->execute();
            return $sql;
        }
        
        function selectEmpresa(){
            $sql = $this->connect()->prepare("select nombre,direccion,telefono,rfc,rs,ciudad,imagen,correo,logo
            from empresa where idempresa= 1 ");
            $sql ->execute();
            return $sql->fetchAll(PDO::FETCH_ASSOC); 
        }
        
        function selectRepeaterOnly($cve){
            $sql = $this->connect()->prepare("select idRepetidora, r.nombre nombreRepetidora, latitud , longitud, c.nombre nombreCiudad, r.estatus 
            from repetidora r, ciudad c where cveCiudad = idCiudad and eliminado = 0 and idRepetidora= :cve order by idRepetidora desc");
            $sql -> bindParam(":cve",$cve, PDO::PARAM_INT);
            $sql ->execute();
            return $sql->fetchAll(PDO::FETCH_ASSOC); 
        }
        
        function updateImage($input){
           
            $sql = $this->connect()->prepare("update empresa set imagen = :imagen where idempresa = 1");
            $sql->bindParam(":imagen",$input["imagen"],PDO::PARAM_STR);
            $sql ->execute();
            return $sql->fetchAll(PDO::FETCH_ASSOC); 
            

        }



        function updateLogo($input){
           
            $sql = $this->connect()->prepare("update empresa set logo = :logo where idempresa = 1");
            $sql->bindParam(":logo",$input["logo"],PDO::PARAM_STR);
            $sql ->execute();
            return $sql->fetchAll(PDO::FETCH_ASSOC); 
            

        }
        
        function updateEmpresa($input){
            
            $sql = $this->connect()->prepare("update empresa set nombre = :nombre, direccion = :direccion, telefono = :telefono, rfc = :rfc, rs = :rs, ciudad = :ciudad, correo =:correo where idempresa = 1");
            $sql->bindParam(":nombre",$input["nombre"],PDO::PARAM_STR);
            $sql->bindParam(":direccion",$input["direccion"],PDO::PARAM_STR);
            $sql->bindParam(":telefono",$input["telefono"],PDO::PARAM_STR);
            $sql->bindParam(":rfc",$input["rfc"],PDO::PARAM_STR);
            $sql->bindParam(":rs",$input["rs"],PDO::PARAM_STR);
            $sql->bindParam(":ciudad",$input["ciudad"],PDO::PARAM_STR);
            $sql->bindParam(":correo",$input["correo"],PDO::PARAM_STR);
            $sql ->execute();
            return $sql;
        }
        
        }
        
        