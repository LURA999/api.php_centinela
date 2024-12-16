<?php
    include "../../Config/database.php";
    class log extends database {

	function insertLog($input){
	$sql = "insert into log_cliente_Empresa (tipo,descripcion,fecha,usuario)
	values(:tipo,:descripcion, NOW(), :usuario)";
	$sql = $this->connect()->prepare($sql);
	$sql->bindParam(':usuario',$input['usuario'], PDO::PARAM_STR,40);
	$sql->bindParam(':descripcion',$input['descripcion'], PDO::PARAM_STR,40);
	$sql->bindParam(':tipo',$input['tipo'], PDO::PARAM_STR,40);
	$sql->execute();
    return $sql;
	}
	
	function selectLog($cve){
        $sql = "select * from log_cliente_Empresa where cveCliente = :cve";
        $sql = $this->connect()->prepare($sql);
		$sql -> bindParam(":cve", $cve, PDO::PARAM_INT);	
        $sql->execute();
        return $sql->fetchAll(PDO::FETCH_ASSOC);
    }

	function updateLog($input){
	$sql = "update log_cliente_Empresa set usuario = :usuario,fecha=:fecha ,detalle = :detalle
	where idLog =:idLog"; 
	$sql = $this->connect()->prepare($sql);
	$sql->bindParam(':idLog',$input['idLog'], PDO::PARAM_STR,40);
	$sql->bindParam(':usuario',$input['usuario'], PDO::PARAM_STR,40);
	$sql->bindParam(':fecha',$input['fecha'], PDO::PARAM_STR,40);
	//$sql->bindParam(':ipPublica',$input['ipPublica'], PDO::PARAM_STR,40);
	$sql->bindParam(':detalle',$input['detalle'], PDO::PARAM_STR,40);
	 $sql->execute();
        return $sql;
	
	}

	function deleteLog($cve){
    	$sql = $this->connect()->prepare("update log_cliente_Empresa set eliminado = 1 where idLog = :cve");
		$sql = $this->connect()->prepare($sql);
    	$sql -> bindParam(":cve", $cve, PDO::PARAM_INT);
    	$sql ->execute();
    	return $sql->fetchAll(PDO::FETCH_ASSOC); 
	}

}	

