<?php
    include "../../Config/database.php";
    
    class others extends database {
        //insertar otros dispositivos  parte 1
        function insertOthers($input){
            $sql = $this->connect()->prepare("insert into otro_dispositivo 
            (comentario,contrasena,modelo,cveServicio, nombre, estatus, snmp, cveUsuario)
            values(:comentario,:contrasena,:modelo, (select idServicio from servicio 
            where identificador = :identificador and contador  = :contador ), :nombre, :estatus, :snmp, :cveUsuario)");
            $sql->bindParam(":comentario",$input["comentario"],PDO::PARAM_STR,300);
            $sql->bindParam(":contrasena",$input["contrasena"],PDO::PARAM_STR,30);
            $sql->bindParam(":modelo",$input["modelo"],PDO::PARAM_STR,30);
            $sql->bindParam(":identificador",$input["identificador"],PDO::PARAM_STR,40);
            $sql->bindParam(":contador",$input["contador"],PDO::PARAM_INT);
            $sql->bindParam(":nombre",$input["device"],PDO::PARAM_STR,30);
            $sql->bindParam(":estatus",$input["idEstatus"],PDO::PARAM_INT);
            $sql->bindParam(":snmp",$input["snmp"],PDO::PARAM_STR,40);
            $sql->bindParam(":cveUsuario",$input["idUsuario"],PDO::PARAM_INT);
            $sql ->execute();

            $sql2 = $this->connect()->prepare("select MAX(idOtro) idOtro from otro_dispositivo;");
            $sql2 ->execute();
            $sql2  = $sql2->fetch(PDO::FETCH_NUM); 
            return $sql2;
        }

        function insertOthers2($input){
            $sql = $this->connect()->prepare("insert into ip_otro (cveIp, cveOtro) values(:cveIp, :cve );");
            $sql->bindParam(":cveIp",$input["cve2"],PDO::PARAM_INT);
            $sql->bindParam(":cve",$input["cve"],PDO::PARAM_INT);
            $sql ->execute();
        }

        function updateOthers2($input){
            $sql = $this->connect()->prepare("delete from ip_otro where cveIp = :cveIp");
            $sql->bindParam(":cveIp",$input,PDO::PARAM_INT);
            $sql ->execute();
        }
        
        function selectOthers($identificador, $contador,$condicion,$iddevice){
            $param = "";
          
            if($condicion == 1){
                $imprimir = "distinct idOtro, r.nombre otro, r.estatus, comentario, modelo,
                idUsuario, usuario, r.contrasena, snmp, rep.nombre repetidora, idRepetidora ";
            }else if($condicion == 2){
                $imprimir = " idIp,ip,concat(segmentoInicial,'-',segmentoFinal) segmento, idSegmento ";
                $param = " and idOtro = :iddevice ";
            }else {
                $imprimir = " idOtro,r.nombre,ip, rep.nombre repetidora ";
            }

            $sql = $this->connect()->prepare("select ".$imprimir."
            from otro_dispositivo  r
			inner join ip_otro on idOtro= cveOtro 
			inner join ip on cveIp= idIp
			inner join servicio on idServicio = cveServicio
			inner join segmento seg on cveSegmento = idSegmento
			inner join usuario on cveUsuario = idUsuario    
            inner join repetidora rep on cveRepetdora = idRepetidora
            where identificador = :identificador and contador = :contador and r.eliminado = 0 ".$param." and ip.estatus = 1 and idUsuario > 0 order by idOtro desc");

            $sql->bindParam(":identificador",$identificador,PDO::PARAM_STR);
            $sql->bindParam(":contador",$contador,PDO::PARAM_INT);

            if($condicion == 2){
                $sql->bindParam(":iddevice",$iddevice,PDO::PARAM_INT);
            }

            $sql ->execute();
            return $sql->fetchAll(PDO::FETCH_ASSOC); 
        }
        
        function updateOthers($input){
            $sql = $this->connect()->prepare("update otro_dispositivo set comentario = :comentario, contrasena= :contrasena, modelo = :modelo,
            nombre = :nombre ,estatus = :estatus, snmp = :snmp , cveUsuario= :cveUsuario
            where idOtro = :cveOtro ");
            $sql->bindParam(":comentario",$input["comentario"],PDO::PARAM_STR,300);
            $sql->bindParam(":contrasena",$input["contrasena"],PDO::PARAM_STR,30);
            $sql->bindParam(":modelo",$input["modelo"],PDO::PARAM_STR,30);
            $sql->bindParam(":nombre",$input["device"],PDO::PARAM_STR,30);
            $sql->bindParam(":estatus",$input["idEstatus"],PDO::PARAM_INT);
            $sql->bindParam(":snmp",$input["snmp"],PDO::PARAM_STR,40);
            $sql->bindParam(":cveUsuario",$input["idUsuario"],PDO::PARAM_INT);
            $sql->bindParam(":cveOtro",$input["idDevice"],PDO::PARAM_INT);
            $sql ->execute();
            return $sql; 
        }
        
        function deleteOthers($input){
            $sql = $this->connect()->prepare("update ip set estatus = 0 where idIp in (select cveIp from ip_otro inner join ip on cveIp = idIp 
            inner join otro_dispositivo on cveOtro = idOtro where idOtro = :idDevice)");
            $sql->bindParam(":idDevice",$input,PDO::PARAM_INT);
            $sql ->execute();
            
            $sql = $this->connect()->prepare("delete from otro_dispositivo where idOtro = :idOtro");
            $sql->bindParam(":idOtro",$input,PDO::PARAM_INT);
            $sql ->execute();
            return $sql; 
        }

        function selectAutoIncrement(){
            $sql = $this->connect()->prepare("SELECT `AUTO_INCREMENT` as max
            FROM  INFORMATION_SCHEMA.TABLES
            WHERE /*TABLE_SCHEMA = 'DatabaseName'*/
            TABLE_NAME   = 'otro_dispositivo';");
            $sql ->execute();
            return $sql->fetchAll(PDO::FETCH_ASSOC); 

        }
    }
        
        
        