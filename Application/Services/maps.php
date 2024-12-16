<?php
    include "../../Config/database.php";
class maps extends database {

    function selectMaps(){
        $sql = $this->connect()->prepare("select * from cliente");
        $sql ->execute();
        return $sql->fetchAll(PDO::FETCH_ASSOC); 

    }
    function updateMaps($input){
        $sql = $this->connect()->prepare("update servicio set cveCiudad= :cveCiudad,codigoPostal = :codigoPostal,colonia=:colonia,estado =:estado,latitud= :latitud,avenida=:avenida, longitud= :longitud, numero = :numero  where idServicio = :id");
        $sql -> bindParam(":cveCiudad",$input["cveCiudad"],PDO::PARAM_INT);
        $sql -> bindParam(":latitud",$input["latitud"],PDO::PARAM_STR);
        $sql -> bindParam(":longitud",$input["longitud"],PDO::PARAM_STR);
        $sql -> bindParam(":codigoPostal",$input["codigoPostal"],PDO::PARAM_STR);
        $sql -> bindParam(":estado",$input["estado"],PDO::PARAM_STR);
        $sql -> bindParam(":colonia",$input["colonia"],PDO::PARAM_STR);
        $sql -> bindParam(":avenida",$input["avenida"],PDO::PARAM_STR);
        $sql -> bindParam(":numero",$input["numero"],PDO::PARAM_STR);
        $sql -> bindParam(":id", $input["id"], PDO::PARAM_INT);
        $sql -> execute();
        return $sql; 


    }

}