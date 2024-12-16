<?php

include '../../Config/database.php';

class contact extends database {

    function insertContact($input){
        $sql = $this->connect()->prepare("insert into contacto_repetidora
        (nombre, correo, estatus,telefono ,cveRepetidora) values(:nombre, :correo , :estatus ,:telefono,:cveRep )");
        $sql->bindParam(":nombre",$input["nombre"],PDO::PARAM_STR,45);
        $sql->bindParam(":correo",$input["correo"],PDO::PARAM_STR,45);
        $sql->bindParam(":estatus",$input["estatus"],PDO::PARAM_INT);
        $sql->bindParam(":telefono",$input["telefono"],PDO::PARAM_INT);
        $sql->bindParam(":cveRep",$input["repetidora"],PDO::PARAM_INT);
        $sql ->execute();
        return $sql;
    }

    function selectContact($cve){
        $sql = $this->connect()->prepare("select * from contacto_repetidora where eliminado = 0 and cveRepetidora = :id order by idContacto desc");
        $sql -> bindParam(":id", $cve,PDO::PARAM_INT);
        $sql ->execute();
        return $sql->fetchAll(PDO::FETCH_ASSOC); 
    }

    function deleteContact($cve){
        $sql = $this->connect()->prepare("update contacto_repetidora set eliminado = 1 where idContacto = :cve");
        $sql -> bindParam(":cve", $cve, PDO::PARAM_INT);
        $sql ->execute();
        return $sql; 
    }

    function updateContact($input){
        $sql = $this->connect()->prepare("update contacto_repetidora set nombre = :nombre, correo = :correo, estatus = :estatus, telefono = :telefono where idContacto = :id");
        $sql->bindParam(":nombre",$input["nombre"],PDO::PARAM_STR,45);
        $sql->bindParam(":correo",$input["correo"],PDO::PARAM_STR,45);
        $sql->bindParam(":estatus",$input["estatus"],PDO::PARAM_INT);
        $sql->bindParam(":telefono",$input["telefono"],PDO::PARAM_INT);
        $sql->bindParam(":id",$input["id"],PDO::PARAM_INT);
        $sql ->execute();
        return $sql; 
    }
}

