<?php

include '../../Config/database.php';

class segment extends database {

function insertSegment($input){
    $sql = $this->connect()->prepare("insert into segmento 
    ( cveRepetdora, nombre, segmento, diagonal, tipo, estatus, segmentoFinal,segmentoInicial) values(:cve, :nombre , :segmento , :diagonal, :tipo, :estatus, :segmento2, :segmento3) ");
    $sql->bindParam(":cve",$input["cveRepetdora"],PDO::PARAM_INT);
    $sql->bindParam(":nombre",$input["nombre"],PDO::PARAM_STR,45);
    $sql->bindParam(":segmento",$input["segmento"],PDO::PARAM_STR,50);
    $sql->bindParam(":diagonal",$input["diagonal"],PDO::PARAM_INT);
    $sql->bindParam(":tipo",$input["tipo"],PDO::PARAM_INT);
    $sql->bindParam(":estatus",$input["estatus"],PDO::PARAM_INT);
    $sql->bindParam(":segmento2",$input["segmento2"],PDO::PARAM_STR);
    $sql->bindParam(":segmento3",$input["segmento3"],PDO::PARAM_STR);
    $sql ->execute();
    return $sql;
}

function selectSegment(){
    $sql = $this->connect()->prepare("select idSegmento, s.nombre, segmento , diagonal,tipo, s.estatus,r.nombre repetidora, cveRepetdora,segmentoFinal,segmentoInicial from segmento s, repetidora r where s.eliminado=0 and cveRepetdora = idRepetidora order by idSegmento desc");
    $sql ->execute();
    return $sql->fetchAll(PDO::FETCH_ASSOC);
}

function changeSegment($id){
    $sql = $this->connect()->prepare("delete from segmento where idSegmento =:id");
    $sql -> bindParam(":id", $id, PDO::PARAM_INT);
    $sql ->execute();
    return $sql->fetchAll(PDO::FETCH_ASSOC); 
}

function updateSegment($input){
    $sql = $this->connect()->prepare("update segmento set  nombre = :nombre, tipo = :tipo, estatus = :estatus where idSegmento = :id");
 $sql->bindParam(":nombre",$input["nombre"],PDO::PARAM_STR);
    $sql->bindParam(":tipo",$input["tipo"],PDO::PARAM_INT);
    $sql->bindParam(":estatus",$input["estatus"],PDO::PARAM_INT);
    $sql->bindParam(":id",$input["idSegmento"],PDO::PARAM_INT);
   //{idSegmento:id,nombre:nombre,estatus:estatus,tipo:tipo}
    $sql ->execute();
    return $sql->fetchAll(PDO::FETCH_ASSOC); 
}


function selectExist($cve){
    $sql = $this->connect()->prepare("select count(*) ip from ip where ip= :segmento");
    $sql->bindParam(":segmento",$cve,PDO::PARAM_STR);
    $sql ->execute();
    return $sql->fetchAll(PDO::FETCH_ASSOC); 
}


function lastSegmento(){
    $sql = $this->connect()->prepare("select Max(idSegmento) max from segmento");
    $sql->execute();
    return $sql -> fetchAll(PDO::FETCH_ASSOC);
}


}