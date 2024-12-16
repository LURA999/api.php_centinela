<?php
require '../../Config/database.php';

class rol extends database{

    function insertRol($input){
        $sql = $this->connect()->prepare("insert into cliente (nombre , estatus, nombreCorto) 
	    values(:nombre,:estatus,:nombrec)");

        $sql->bindParam(':nombre',$input['empresa'],PDO::PARAM_STR,45);
        $sql->bindParam(':estatus',$input['estatus'],PDO::PARAM_INT);
        $sql->bindParam(':nombrec',$input['nombre'],PDO::PARAM_STR,45);
        $sql->execute();
        return $sql;
    }

    function getRol(){
        $sql = $this->connect()->prepare("select * from rol order by idRol desc");
        $sql->execute();
        return $sql->fetchAll(PDO::FETCH_ASSOC);
    }

    function getRolAll(){
        $sql = $this->connect()->prepare("select * from cliente where eliminado = 0 order by idCliente desc");
        $sql->execute();
        return $sql->fetchAll(PDO::FETCH_ASSOC);
    }

    function getCountNombre($clave){
        $sql = $this->connect()->prepare("select count(*) repetido from cliente where LOWER(replace(nombre, ' ', '')) = :nombre ");
        $sql->bindParam(':nombre',$clave,PDO::PARAM_STR,45);
        $sql->execute();
        return $sql->fetchAll(PDO::FETCH_ASSOC);
    }	

    function updateEliminar($clave){
        $sql = $this->connect()->prepare("update  cliente  set eliminado = 1 where idcliente = :id");
        $sql->bindParam(':id',$clave,PDO::PARAM_INT);
        $sql->execute();
        return $sql;
    }

    function updateRol($input){
        $sql = $this->connect()->prepare("update  cliente  set nombre = :empresa,
	nombreCorto = :nombre, estatus = :estatus where idCliente = :id");
        $sql->bindParam(':empresa',$input['empresa'],PDO::PARAM_STR,45);
        $sql->bindParam(':nombre',$input['nombre'],PDO::PARAM_STR,45);
        $sql->bindParam(':estatus',$input['estatus'],PDO::PARAM_INT);
	$sql->bindParam(':id',$input['id'],PDO::PARAM_INT);
        $sql->execute();
        return $sql;
    }
}

