<?php
include "../../Config/database.php";

class ip extends database {
    function insertIp($input){
        $sql = $this->connect()->prepare("insert into ip (cveSegmento,ip) values(:cveSegmento,:ip)");
        $sql->bindParam(":cveSegmento",$input['cveSegmento'],PDO::PARAM_INT);
        $sql->bindParam(':ip', $input['ip'], PDO::PARAM_STR,100);
        $sql->execute();
        return $sql;
    }

    /**Esto es para la tabla de control ips*/
    function selectIps(){
            $sql = $this->connect()->prepare("select ip,tipo, (select nombre from radio where cveIp = idIp union all
            select nombre from ip_otro, otro_dispositivo where idOtro = cveOtro  and cveIp = idIp union all 
           select nombre from ip_router, router where idRouter = cveRouter  and cveIp = idIp) nombre, ( concat(ifnull((select 'router' from ip_router where cveIp = idIp),''),'', ifnull((select 'otro dispositivo' from ip_otro where cveIp = idIp),''),ifnull((select 'radio' from radio where cveIp = idIp),'') ) )   dispositivo
            from ip p inner join  segmento  on cveSegmento = idSegmento; ");
        $sql->execute();
        return $sql -> fetchAll(PDO::FETCH_ASSOC);
   }

   /**Esto es para la tabla de control ips, para los filtros y en formularios*/
   function selectIp($segmento, $segmentoFinal ,$condicion,$condicion2 ){
    $param = "";
    $sql2= "";
    $select = "";
        if($condicion!='undefined'){
            $sql2 = "and idIp not in($condicion)";
            $param = "and i.estatus = 0";
        }else{
            if($condicion2 == 1){
                $param = "and i.estatus = 0";
            }else{
                $select = ", (select nombre from radio where cveIp = idIp union all
                select nombre from ip_otro, otro_dispositivo where idOtro = cveOtro  and cveIp = idIp union all 
               select nombre from ip_router, router where idRouter = cveRouter  and cveIp = idIp) nombre, ( concat(ifnull((select 'router' from ip_router where cveIp = idIp),''),'', ifnull((select 'otro dispositivo' from ip_otro where cveIp = idIp),''),ifnull((select 'radio' from radio where cveIp = idIp),'') ) )   dispositivo ";
            }
        }

        $sql = $this->connect()->prepare('select idIp,ip,tipo,i.estatus '.$select.' from ip  i inner join segmento on cveSegmento = idSegmento inner join repetidora r on cveRepetdora = idRepetidora  
        where idIp between (select idIp from ip where ip = :segmento) and (select idIp from ip where ip = :segmentoFinal) '.$param." ".$sql2);
       
        $sql->bindParam(":segmento",$segmento,PDO::PARAM_STR,30);
        $sql->bindParam(":segmentoFinal",$segmentoFinal,PDO::PARAM_STR,30);
        $sql->execute();
        
        return $sql->fetchAll(PDO::FETCH_ASSOC);
    }

    function selectIpOnly($segmento, $segmentoFinal, $segmentoBuscar){
        
        $sql = $this->connect()->prepare("select ip,tipo 
        , (select nombre from radio where cveIp = idIp union all
                select nombre from ip_otro, otro_dispositivo where idOtro = cveOtro  and cveIp = idIp union all 
               select nombre from ip_router, router where idRouter = cveRouter  and cveIp = idIp) nombre
               , ( concat(ifnull((select 'router' from ip_router where cveIp = idIp),''),'', ifnull((select 'otro dispositivo' from ip_otro where cveIp = idIp),''),ifnull((select 'radio' from radio where cveIp = idIp),'') ) )   dispositivo 
        from ip p inner join segmento on cveSegmento = idSegmento inner join repetidora r on cveRepetdora = idRepetidora 
        where idIp between (select idIp from ip where ip = :segmento) and (select idIp from ip where ip = :segmentoFinal) and ip =  :segmentoBuscar");
        $sql->bindParam(":segmento",$segmento,PDO::PARAM_STR,30);
        $sql->bindParam(":segmentoFinal",$segmentoFinal,PDO::PARAM_STR,30);
        $sql->bindParam(":segmentoBuscar",$segmentoBuscar,PDO::PARAM_STR,30);
        $sql->execute();
        return $sql->fetchAll(PDO::FETCH_ASSOC);
    }

    function selectIpOnlySinParam($segmento){
        
            $sql = $this->connect()->prepare("select ip,tipo , (select nombre from radio where cveIp = idIp union all
            select nombre from ip_otro, otro_dispositivo where idOtro = cveOtro  and cveIp = idIp union all 
           select nombre from ip_router, router where idRouter = cveRouter  and cveIp = idIp) nombre, ( concat(ifnull((select 'router' from ip_router where cveIp = idIp),''),'', ifnull((select 'otro dispositivo' from ip_otro where cveIp = idIp),''),ifnull((select 'radio' from radio where cveIp = idIp),'') ) )   dispositivo from ip p inner join segmento on cveSegmento = idSegmento inner join repetidora r on cveRepetdora = idRepetidora
        where ip = :segmentoBuscar");
     
        $sql->bindParam(":segmentoBuscar",$segmento,PDO::PARAM_STR,30);
        $sql->execute();
        return $sql->fetchAll(PDO::FETCH_ASSOC);
    }

    function countActiveIpSegmento($segmento){
        $sql = $this->connect()->prepare("select count(estatus) cantidad
        from ip where cveSegmento = :cveSegmento and estatus = 1");
        $sql->bindParam(":cveSegmento",$segmento,PDO::PARAM_INT);
        $sql->execute();
        return $sql->fetchAll(PDO::FETCH_ASSOC);
    }
  
}

