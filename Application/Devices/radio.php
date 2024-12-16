<?php
    include "../../Config/database.php";
    
    class radio extends database {

        function insertRadio($input){
            $sql = $this->connect()->prepare("insert into radio
            (cveIp,cveUsuario,contrasena,modelo,comentario,cveServicio,nombre,estatus,snmp) 
            values
            (:cveIp,:cveUsuario,:contrasena,:modelo,:comentario,(select idServicio from servicio where identificador = :identificador and contador  = :contador ),:nombre,:estatus,:snmp)");
            $sql->bindParam(":cveIp",$input["idIp"],PDO::PARAM_INT);
            $sql->bindParam(":cveUsuario",$input["idUsuario"],PDO::PARAM_INT);
            $sql->bindParam(":contrasena",$input["contrasena"],PDO::PARAM_STR,30);
            $sql->bindParam(":modelo",$input["modelo"],PDO::PARAM_STR,400);
            $sql->bindParam(":comentario",$input["comentario"],PDO::PARAM_STR,400);
            $sql->bindParam(":nombre",$input["device"],PDO::PARAM_STR,40);
            $sql->bindParam(":estatus",$input["idEstatus"],PDO::PARAM_INT);
            $sql->bindParam(":snmp",$input["snmp"],PDO::PARAM_STR,40);
            $sql->bindParam(":identificador", $input["identificador"],PDO::PARAM_STR,40);
            $sql->bindParam(":contador",$input["contador"],PDO::PARAM_INT);
            $sql ->execute();

            $sql = $this->connect()->prepare("update ip set estatus = 1 where idIp = :cveIp");
            $sql->bindParam(":cveIp",$input["idIp"],PDO::PARAM_INT);
            $sql ->execute();
            return $sql;
        }
        
        function selectRadio($identificador, $contador){
            $sql = $this->connect()->prepare("select idRadio, r.nombre radio, r.estatus, 
            s.tipo, idRepetidora, rep.nombre repetidora, r.modelo,
            idSegmento,concat(segmento,'-',segmentoFinal) segmento,idIp, ip,
            idUsuario,usuario,r.contrasena, snmp,comentario 
            from radio r 
            inner join ip on cveIp = idIp 
            inner join usuario on cveUsuario = idUsuario 
            inner join servicio ser on cveServicio = idServicio
            inner join segmento s on cveSegmento = idSegmento
            inner join repetidora rep on cveRepetdora = idRepetidora where identificador = :identificador and contador = :contador and r.eliminado = 0 order by idRadio desc");
            $sql->bindParam(":identificador",$identificador,PDO::PARAM_STR);
            $sql->bindParam(":contador",$contador,PDO::PARAM_STR);
            $sql ->execute();
            return $sql->fetchAll(PDO::FETCH_ASSOC); 
        }
        
        function updateRadio($input){               
            //Busca los ips que usa y los habilita
            $sql = $this->connect()->prepare("update ip set estatus = 0 where idIp = (select cveIp from radio inner join ip on cveIp = idIp 
             where idRadio = :idDevice)");
            $sql->bindParam(":idDevice",$input["idDevice"],PDO::PARAM_INT);
            $sql ->execute();
            
            //ya despues cambia el Ip y sus demas atritubtos
            $sql = $this->connect()->prepare("update radio set cveIp = :cveIp, cveUsuario = :cveUsuario, contrasena = :contrasena,
            modelo = :modelo ,comentario = :comentario, cveServicio = (select idServicio from servicio 
            where identificador = :identificador and contador  = :contador ),snmp = :snmp, nombre = :nombre,estatus = :estatus where idRadio = :idRadio");
            $sql->bindParam(":cveIp",$input["idIp"],PDO::PARAM_INT);
            $sql->bindParam(":cveUsuario",$input["idUsuario"],PDO::PARAM_INT);
            $sql->bindParam(":contrasena",$input["contrasena"],PDO::PARAM_STR,30);
            $sql->bindParam(":modelo",$input["modelo"],PDO::PARAM_STR,400);
            $sql->bindParam(":comentario",$input["comentario"],PDO::PARAM_STR,400);
            $sql->bindParam(":nombre",$input["device"],PDO::PARAM_STR,40);
            $sql->bindParam(":estatus",$input["idEstatus"],PDO::PARAM_INT);
            $sql->bindParam(":snmp",$input["snmp"],PDO::PARAM_STR,40);
            $sql->bindParam(":identificador", $input["identificador"],PDO::PARAM_STR,40);
            $sql->bindParam(":contador",$input["contador"],PDO::PARAM_INT);
            $sql->bindParam(":idRadio",$input["idDevice"],PDO::PARAM_INT);
            $sql ->execute();

            //para transformar el actual ip a ocupado
            $sql = $this->connect()->prepare("update ip set estatus = 1 where idIp = :cveIp");
            $sql->bindParam(":cveIp",$input["idIp"],PDO::PARAM_INT);
            $sql ->execute();
            return $sql; 
        }

        function deleteRadio($input){
            $sql = $this->connect()->prepare("update ip  set estatus = 0 where idIp = (select cveIp from radio inner join ip on cveIp = idIp 
            where idRadio = :idRadio);");
            $sql->bindParam(":idRadio",$input,PDO::PARAM_INT);
            $sql ->execute();

            $sql = $this->connect()->prepare("delete from radio where idRadio = :idRadio");
            $sql->bindParam(":idRadio",$input,PDO::PARAM_INT);
            $sql ->execute();
            return $sql; 
        }

        function selectAutoIncrement(){
            $sql = $this->connect()->prepare("SELECT `AUTO_INCREMENT` as max
            FROM  INFORMATION_SCHEMA.TABLES
            WHERE /*TABLE_SCHEMA = 'DatabaseName'*/
            TABLE_NAME   = 'radio';");
            $sql ->execute();
            return $sql->fetchAll(PDO::FETCH_ASSOC); 

        }
        }
        
        
        