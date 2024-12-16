<?php

include '../../Config/database.php';

class plan extends database {

function insertRepeater($input){
    $sql = $this->connect()->prepare("insert into repetidora 
    (cveCiudad, nombre, latitud, longitud, estatus) values(:cve, :nombre , :latitud ,:longitud ,:estatus ) ");
    $sql->bindParam(":cve",$input["cveCiudad"],PDO::PARAM_INT);
    $sql->bindParam(":nombre",$input["nombre"],PDO::PARAM_STR,45);
    $sql->bindParam(":latitud",$input["latitud"],PDO::PARAM_STR,50);
    $sql->bindParam(":longitud",$input["longitud"],PDO::PARAM_STR,50);
    $sql->bindParam(":estatus",$input["estatus"],PDO::PARAM_INT);
    $sql ->execute();
    return $sql;
}

function selectPlan(){
    $sql = $this->connect()->prepare("select * 
    from plan order by idPlan desc");
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

function deleteRepeater($cve){
    $sql = $this->connect()->prepare("update repetidora set eliminado = 1 where idRepetidora = :cve");
    $sql -> bindParam(":cve", $cve, PDO::PARAM_INT);
    $sql ->execute();
    return $sql->fetchAll(PDO::FETCH_ASSOC); 
}

function updateRepeater($input){
    $sql = $this->connect()->prepare("update repetidora set cveCiudad = :cve, nombre = :nombre, latitud = :latitud, longitud = :longitud, estatus = :estatus where idRepetidora = :repetidora");
    $sql->bindParam(":cve",$input["cveCiudad"],PDO::PARAM_INT);
    $sql->bindParam(":nombre",$input["nombre"],PDO::PARAM_STR,45);
    $sql->bindParam(":latitud",$input["latitud"],PDO::PARAM_STR,50);
    $sql->bindParam(":longitud",$input["longitud"],PDO::PARAM_STR,50);
    $sql->bindParam(":estatus",$input["estatus"],PDO::PARAM_INT);
    $sql->bindParam(":repetidora",$input["idRepetidora"],PDO::PARAM_INT);
    $sql ->execute();
    return $sql->fetchAll(PDO::FETCH_ASSOC); 
}

function selectSegmentRepetear($cve){
    $sql = $this->connect()->prepare("select * from segmento where cveRepetdora=:cve and eliminado = 0");
    $sql->bindParam(":cve",$cve,PDO::PARAM_INT);
    $sql ->execute();
    return $sql->fetchAll(PDO::FETCH_ASSOC); 
}


}

