<?php

include '../../Config/database.php';

class repeater extends database {

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

function selectRepeater($cve){
    $sql = $this->connect()->prepare("select distinct idRepetidora, r.nombre nombreRepetidora, latitud , longitud, c.nombre nombreCiudad, r.estatus, tipo 
    from repetidora r inner join ciudad c on cveCiudad = idCiudad inner join segmento on cveRepetdora = idRepetidora 
    where r.eliminado = 0 and tipo = :tipo order by idRepetidora,tipo desc");
    $sql -> bindParam(":tipo",$cve, PDO::PARAM_INT);
    $sql ->execute();
    return $sql->fetchAll(PDO::FETCH_ASSOC); 
}

function selectRepeater2(){
    $sql = $this->connect()->prepare("select idRepetidora, r.nombre nombreRepetidora, latitud , longitud, c.nombre nombreCiudad, r.estatus 
    from repetidora r inner join ciudad c on cveCiudad = idCiudad where eliminado = 0 order by idRepetidora desc");
    $sql ->execute();
    return $sql->fetchAll(PDO::FETCH_ASSOC); 
}

function selectRepeaterOnly($cve){
    $sql = $this->connect()->prepare("select idRepetidora, r.nombre nombreRepetidora, latitud , longitud, c.nombre nombreCiudad, r.estatus 
    from repetidora r inner join ciudad c on cveCiudad = idCiudad where eliminado = 0 and idRepetidora= :cve order by idRepetidora desc");
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

function selectAllRepeater($cve){
   /// echo "hola";
    $sql = $this->connect()->prepare("select * from segmento where cveRepetdora=:cve and eliminado = 0");
    $sql->bindParam(":cve",$cve,PDO::PARAM_INT);
    $sql ->execute();
    return $sql->fetchAll(PDO::FETCH_ASSOC); 
}
function selectSegmentRepeaterTipo($repetear,$tipo){
   // echo "hola";
    $sql = $this->connect()->prepare("select idSegmento, segmentoInicial segmento, segmentoFinal, s.nombre repetidora from segmento inner join repetidora  s on cveRepetdora = idRepetidora where idRepetidora =  :repetidora and tipo = :tipo;");
   $sql->bindParam(":repetidora", $repetear, PDO::PARAM_INT);
   $sql->bindParam(":tipo", $tipo, PDO::PARAM_INT);
   $sql->execute();
   return $sql->fetchAll(PDO::FETCH_ASSOC);
   }
function selectSegmentRepeater($repetear){
   // echo $repetear;
    $sql = $this->connect()->prepare("select idSegmento, segmentoInicial segmento, segmentoFinal, s.nombre repetidora from segmento inner join repetidora  s on cveRepetdora = idRepetidora where idRepetidora =  :repetidora;");
   $sql->bindParam(":repetidora", $repetear, PDO::PARAM_INT);
   $sql->execute();
   return $sql->fetchAll(PDO::FETCH_ASSOC);
   }
}

