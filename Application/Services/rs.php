<?php
    include "../../Config/database.php";
class rs extends database {

    function insertRS($input){
		$sql = "insert into razon_social (razonSocial,fechaAlta,estatus,cveCliente)
		values (:razonSocial,:fechaAlta,:estatus,:cveCliente)";
		$sql = $this->connect()->prepare($sql);
		$sql->bindParam(':razonSocial',$input['rs'], PDO::PARAM_STR,40);
		$sql->bindParam(':fechaAlta',$input['fecha'], PDO::PARAM_STR,40);
		$sql->bindParam(':estatus',$input['estatus'], PDO::PARAM_STR,40);
		$sql->bindParam(':cveCliente',$input['cveCliente'], PDO::PARAM_INT);
		$sql->execute();
	return $sql;
	}
 
	function selectRS($cve){
		$sql = "select * from razon_social where cveCliente = :cveCliente and eliminado = 0 order by idRazonSocial desc";
		$sql = $this->connect()->prepare($sql);
		$sql->bindParam(':cveCliente',$cve, PDO::PARAM_INT);
		$sql->execute();
    return $sql->fetchAll(PDO::FETCH_ASSOC);
	}

	function selectRSOnly($cve){
		$sql = "select razonSocial from razon_social where idRazonSocial = :id";
		$sql = $this->connect()->prepare($sql);
		$sql->bindParam(':id',$cve, PDO::PARAM_INT);
		$sql->execute();
    return $sql->fetchAll(PDO::FETCH_ASSOC);
	}
	function updateRS($input){
		$sql = "update razon_social set razonSocial = :razonSocial, 
		fechaAlta = :fechaAlta, estatus = :estatus where idRazonSocial = :cveCliente";
		$sql = $this->connect()->prepare($sql);
		$sql->bindParam(':cveCliente',$input['cveCliente'], PDO::PARAM_INT);
		$sql->bindParam(':razonSocial',$input['rs'], PDO::PARAM_STR,40);
		$sql->bindParam(':fechaAlta',$input['fecha'], PDO::PARAM_STR,40);
		$sql->bindParam(':estatus',$input['estatus'], PDO::PARAM_STR,40);
		$sql->execute();
	return $sql;
	}

	function deleteRS($cve){
    	$sql = $this->connect()->prepare("update razon_social set eliminado = 1 where idRazonSocial = :cve");
    	$sql -> bindParam(":cve", $cve, PDO::PARAM_INT);
    	$sql ->execute();
    	return $sql; 
	}
	
 }


    



