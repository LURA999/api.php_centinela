<?php
    include "../../Config/database.php";
    class router extends database {

        function insertRouter($input){

            $sql = $this->connect()->prepare("insert into router 
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
                        
            $sql2 = $this->connect()->prepare("select MAX(idRouter) idRouter from router");
            $sql2 ->execute();
            $sql2  = $sql2->fetch(PDO::FETCH_NUM); 
            return $sql2;
        }
        
        function  insertRouter2($input){
            $sql = $this->connect()->prepare("insert into ip_router (cveIp, cveRouter) values(:cveIp, :cve);");
            $sql->bindParam(":cveIp",$input["cve2"],PDO::PARAM_INT);
            $sql->bindParam(":cve",$input["cve"],PDO::PARAM_INT);
            $sql ->execute();  
        }

        function  updateRouter2($input){
            $sql = $this->connect()->prepare("delete from  ip_router where cveIp = :cveIp");
            $sql->bindParam(":cveIp",$input,PDO::PARAM_INT);
            $sql ->execute();  
        }

        function selectRouter($identificador, $contador,$condicion,$iddevice){
            $param = " "; 
            if($condicion == 1){
                $imprimir = "distinct idRouter, r.nombre router, r.estatus, comentario, modelo,
                idUsuario, usuario, r.contrasena, snmp, idRepetidora, rep.nombre repetidora ";
            }else if($condicion == 2){
                $imprimir = " idIp,ip,concat(segmentoInicial,'-',segmentoFinal) segmento, idSegmento, ip.estatus, seg.tipo ";
                $param = " and idRouter = :iddevice ";
            }else if($condicion == 3){
                $imprimir = " r.idRouter, r.nombre, ip, rep.nombre repetidora ";

            }

            $sql = $this->connect()->prepare("select ".$imprimir."
            from router r 
            inner join ip_router on cveRouter = idRouter 
            inner join servicio on cveServicio = idServicio 
            inner join ip on cveIp = idIp
            inner join usuario on cveUsuario = idUsuario
            inner join segmento seg on cveSegmento = idSegmento
            inner join repetidora rep on cveRepetdora = idRepetidora
            where identificador = :identificador and contador = :contador ".$param." and ip.estatus = 1  order by idRouter desc;");
            $sql->bindParam(":identificador",$identificador,PDO::PARAM_STR);
            $sql->bindParam(":contador",$contador,PDO::PARAM_STR);

            if($condicion == 2){
                $sql->bindParam(":iddevice",$iddevice,PDO::PARAM_INT);
            }


            $sql ->execute();
            return $sql->fetchAll(PDO::FETCH_ASSOC); 
        }
        
        function updateRouter($input){
            $sql = $this->connect()->prepare("update router set comentario = :comentario, contrasena= :contrasena, modelo = :modelo,
            nombre = :nombre ,estatus = :estatus, snmp = :snmp , cveUsuario= :cveUsuario
            where idRouter = :cveRouter");
            $sql->bindParam(":comentario",$input["comentario"],PDO::PARAM_STR,300);
            $sql->bindParam(":contrasena",$input["contrasena"],PDO::PARAM_STR,30);
            $sql->bindParam(":modelo",$input["modelo"],PDO::PARAM_STR,30);
            $sql->bindParam(":nombre",$input["device"],PDO::PARAM_STR,30);
            $sql->bindParam(":estatus",$input["idEstatus"],PDO::PARAM_INT);
            $sql->bindParam(":snmp",$input["snmp"],PDO::PARAM_STR,40);
            $sql->bindParam(":cveUsuario",$input["idUsuario"],PDO::PARAM_INT);
            $sql->bindParam(":cveRouter",$input["idDevice"],PDO::PARAM_INT);
            $sql ->execute();
            return $sql; 
        }
        
        function deleteRouter($id){
            
            $sql = $this->connect()->prepare("update ip set estatus = 0 where idIp in (select cveIp from ip_router inner join ip on cveIp = idIp 
            inner join router on cveRouter = idRouter where idRouter = :idDevice)");
            $sql->bindParam(":idDevice",$id,PDO::PARAM_INT);
            $sql ->execute();

            $sql = $this->connect()->prepare("delete from router where idRouter = :idDevice");
            $sql->bindParam(":idDevice",$id,PDO::PARAM_INT);
            $sql ->execute();
            return $sql; 
        }
        
        function selectAutoIncrement(){
            $sql = $this->connect()->prepare("SELECT `AUTO_INCREMENT` as max
            FROM  INFORMATION_SCHEMA.TABLES
            WHERE /*TABLE_SCHEMA = 'DatabaseName'*/
            TABLE_NAME   = 'router';");
            $sql ->execute();
            return $sql->fetchAll(PDO::FETCH_ASSOC); 

        }
    }
        
        
        