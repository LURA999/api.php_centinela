<?php
    include "../../Config/database.php";
    
    class notify extends database {
        function insertNotify($input){
            $sql = $this->connect()->prepare("insert into notificaciones
            (asunto,contenido) values(:asunto,:contenido ) ");
            $sql->bindParam(":asunto",$input["asunto"],PDO::PARAM_STR);
            $sql->bindParam(":contenido",$input["contenido"],PDO::PARAM_STR);
            $sql ->execute();
            return $sql;
        }
        
        function selectNotify(){
            $sql = $this->connect()->prepare("select asunto ,contenido 
            from notificaciones where eliminado = 0 ");
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
        
        function updateNotify($cve){
            echo $cve ;
            
            $sql = $this->connect()->prepare("update notificaciones set eliminado = 1 where idnotificaciones = :cve");
            $sql -> bindParam(":cve", $cve, PDO::PARAM_INT);
            $sql ->execute();
            return $sql;
        }

        function updateNotification($input){
            $sql = $this->connect()->prepare("update notify_config set correo_caido = :correo_caido, correo_pago = :correo_pago, no_movil = :no_movil where idnotify_config = 1");
            $sql->bindParam(":correo_caido",$input["correo_caido"],PDO::PARAM_STR);
            $sql->bindParam(":correo_pago",$input["correo_pago"],PDO::PARAM_STR);
            $sql->bindParam(":no_movil",$input["no_movil"],PDO::PARAM_STR);
            $sql ->execute();
            return $sql; 
        }
        function selectNotification(){
            $sql = $this->connect()->prepare("select correo_caido ,correo_pago,no_movil
            from notify_config where idnotify_config = 1 ");
            $sql ->execute();
            return $sql->fetchAll(PDO::FETCH_ASSOC); 
        }
        
        
        }
        
        
        