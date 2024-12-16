<?php
    include "../../Config/database.php";
class contacts extends database {

    function insertContact($input){ 
	$sql = "insert into contacto (nombre,apellidoPaterno,apellidoMaterno,telefono,celular,correo,cveRol,puesto,estatus,contrasena,cveEmpresa)
			values   (:nombre,:apellidoPaterno,:apellidoMaterno,:telefono,:celular,:correo,:cveRol,:puesto, :estatus, :contrasena,:idCliente)";
	$sql = $this->connect()->prepare($sql);
	$sql->bindParam(':nombre',$input['nombre'], PDO::PARAM_STR,40);
	$sql->bindParam(':apellidoPaterno',$input['paterno'], PDO::PARAM_STR,40);
	$sql->bindParam(':apellidoMaterno',$input['materno'], PDO::PARAM_STR,40);
	$sql->bindParam(':telefono',$input['telefono'], PDO::PARAM_INT);
	$sql->bindParam(':celular',$input['celular'], PDO::PARAM_INT);
	$sql->bindParam(':correo',$input['correo'], PDO::PARAM_STR,40);
	$sql->bindParam(':cveRol',$input['cveRol'], PDO::PARAM_INT);
	$sql->bindParam(':puesto',$input['puesto'], PDO::PARAM_STR);
	$sql->bindParam(':estatus',$input['estatus'], PDO::PARAM_INT);
	$sql->bindParam(':contrasena',$input['contrasena'], PDO::PARAM_STR);
	$sql->bindParam(':idCliente',$input['idCliente'], PDO::PARAM_INT);

	$sql->execute();
	
	$sql2 = $this->connect()->prepare("select MAX(idContacto) from contacto");
	$sql2->execute();
	$sql2 = $sql2->fetch(PDO::FETCH_NUM);	
	
	for ($i = 0; $i < count($input['cveServicioArray']); $i++) {
		$sql = "insert into contacto_servicio (cveServicio,cveContacto) 
		values (:cveServicio,:cveContacto )";
		$sql = $this->connect()->prepare($sql);
		$sql->bindParam(':cveServicio',$input['cveServicioArray'][$i], PDO::PARAM_INT);
		$sql->bindParam(':cveContacto',$sql2[0], PDO::PARAM_INT);
		$sql->execute();
	}
	return $sql;

	}

	/**Este trae todos los servicios de un cliente */
	function selectServicios_Contactos($cve){
	$sql = "select idServicio, s.nombre
	from  servicio s on cveServicio = idServicio
	inner join  razon_social on cveRs = idRazonSocial
	inner join ciudad c on cveCiudad = idCiudad inner join  cliente cl on cveCliente = idCliente
	where  idCliente = :cveCliente and s.estatus < 5 order by idServicio desc";
	$sql = $this->connect()->prepare($sql);
	$sql->bindParam(':cveCliente',$cve, PDO::PARAM_INT);
	$sql->execute();
	return $sql->fetchAll(PDO::FETCH_ASSOC);
	}
	
	/**Este trae todos los contactos de un cliente */
	function selectContactos_Servicios($cveCliente, $identificador){	
		$sql = "select distinct idContacto,c.nombre, apellidoMaterno,contrasena, apellidoPaterno, correo, c.estatus, celular,telefono, puesto,cveRol, r.nombre rol,idServicio, s.nombre servicio
		from servicio s inner join contacto_servicio cs on cveServicio = idServicio  inner join contacto c on cveContacto = idContacto 
        inner join rol  r on cveRol = idRol
		where  idServicio IN
			(select idServicio 
			from servicio s inner join razon_social on cveRs = idRazonSocial inner join
			ciudad c on cveCiudad= idCiudad inner join cliente cl on idCliente = cveCliente where cveCliente = :cveCliente order by idServicio desc) 
		and c.eliminado = 0 and identificador = :identificador order by idContacto desc";
	
	$sql = $this->connect()->prepare($sql);
	$sql->bindParam(':cveCliente',$cveCliente, PDO::PARAM_INT);
	$sql->bindParam(':identificador',$identificador, PDO::PARAM_STR);
	$sql->execute();
        return $sql->fetchAll(PDO::FETCH_ASSOC);
	}

	function selectContact($cve){
	$sql = "select idContacto,nombre, apellidoMaterno,contrasena, apellidoPaterno, correo, c.estatus, celular,telefono, puesto,cveRol 
	from contacto_cliente inner join contacto c on idContacto = cveContacto where cveCliente =:cveCliente and c.eliminado = 0 order by cveContacto desc";
	$sql = $this->connect()->prepare($sql);
	$sql->bindParam(':cveCliente',$cve, PDO::PARAM_INT);
	$sql->execute();
        return $sql->fetchAll(PDO::FETCH_ASSOC);
	}

	function updateContact($input){
	$sql = "update contacto set nombre = :nombre, 
	apellidoPaterno = :apellidoPaterno, apellidoMaterno = :apellidoMaterno, telefono = :telefono , puesto = :puesto, celular = :celular, correo =:correo , cveRol = :cveRol,
	estatus = :estatus, contrasena = :contrasena
	where idContacto = :cveContacto";
	$sql = $this->connect()->prepare($sql);
	$sql->bindParam(':nombre',$input['nombre'], PDO::PARAM_STR,40);
	$sql->bindParam(':apellidoPaterno',$input['paterno'], PDO::PARAM_STR,40);
	$sql->bindParam(':apellidoMaterno',$input['materno'], PDO::PARAM_STR,40);
	$sql->bindParam(':telefono',$input['telefono'], PDO::PARAM_INT);
	$sql->bindParam(':puesto',$input['puesto'], PDO::PARAM_STR,40);
	$sql->bindParam(':celular',$input['celular'], PDO::PARAM_INT);
	$sql->bindParam(':correo',$input['correo'], PDO::PARAM_STR,40);
	$sql->bindParam(':estatus',$input['estatus'], PDO::PARAM_INT);
	$sql->bindParam(':cveRol',$input['cveRol'], PDO::PARAM_INT);
	$sql->bindParam(':cveContacto',$input['cveContacto'], PDO::PARAM_INT);
	$sql->bindParam(':contrasena',$input['contrasena'], PDO::PARAM_INT);
	$sql->execute();

	$sql = "delete from contacto_servicio where cveContacto = :cveContacto";
	$sql = $this->connect()->prepare($sql);
	$sql->bindParam(':cveContacto',$input['cveContacto'], PDO::PARAM_INT);
	$sql->execute();

	for ($i = 0; $i < count($input['cveServicioArray']); $i++) {
		$sql = "insert into contacto_servicio (cveServicio,cveContacto) 
		values (:cveServicio, :cveContacto)";
		$sql = $this->connect()->prepare($sql);
		$sql->bindParam(':cveContacto',$input['cveContacto'], PDO::PARAM_INT);
		$sql->bindParam(':cveServicio',$input['cveServicioArray'][$i], PDO::PARAM_INT);
		$sql->execute();
	}
	return $sql;
	
	}
	
	function deleteContact($cve){
		$sql = $this->connect()->prepare("update contacto set eliminado = 1 where idContacto = :cve;");
    	$sql -> bindParam(":cve", $cve, PDO::PARAM_INT);
    	$sql ->execute();
    	return $sql; 
	}

	function selectContactIdMax(){
		$sql = "SELECT `AUTO_INCREMENT` as max
		FROM  INFORMATION_SCHEMA.TABLES
		WHERE /*TABLE_SCHEMA = 'DatabaseName'*/
		TABLE_NAME   = 'contacto';";
		$sql = $this->connect()->prepare($sql);
		$sql->execute();
        return $sql->fetchAll(PDO::FETCH_ASSOC);
	}


	function selectContactosOnlyServicio($cve,$contador,$condicion,$identificador){
		//Cuando inicia por default muestra todos los contactos del cliente
		$opc2 = " ";
		$opc = " ";
		$tabla = " ";
		//echo "$cve,$contador,$condicion,$identificador";
		if($condicion == 2){
			//Esta condicion es para que solo meustre los contactos de un servicio en especifico
			$opc = " and contador = :contador and identificador = :identificador";
			$tabla = " contacto_servicio ";
		}else if($condicion == 1){
			/**Este creo que no sirve de nada**/
			$opc2 = "  ";
			$tabla = " contacto_cliente ";
		}else if($condicion == 4){	
			/*esta condicion es para que muestre los contactos que no estan 
			en el servicio especifico*/
			$opc2 = " and idContacto not in (select cveContacto
			from servicio s 
			inner join contacto_servicio cs on cveServicio = idServicio
			inner join contacto c on idContacto = cveContacto
				where idServicio IN
			(select idServicio 
			from servicio s inner join razon_social on cveRs = idRazonSocial inner join
			ciudad c on cveCiudad= idCiudad inner join cliente cl on idCliente = cveCliente 
			where cveCliente = :cveCliente and contador = :contador and identificador = :identificador  
			order by idServicio desc) 
			and c.eliminado =0 order by cveContacto desc) ";
			$tabla = " contacto_cliente ";

		}else if($condicion == 5){
			/*esta condicion es para que muestre los contactos que no estan en 
			el servicio especifico, este nomas aplica */
			$opc2 = " and idContacto not in (select cveContacto
			from servicio s 
			inner join contacto_servicio cs on cveServicio = idServicio
			inner join contacto c on idContacto = cveContacto
			where idServicio IN
			(select idServicio 
			from servicio s inner join razon_social on cveRs = idRazonSocial inner join
			ciudad c on cveCiudad= idCiudad inner join cliente cl on idCliente = cveCliente 
			where cveCliente = :cveCliente and idServicio = :identificador
			order by idServicio desc) 
			and c.eliminado =0 order by cveContacto desc) ";
			$tabla = " contacto_cliente ";
		}

		$sql = "select idContacto,c.nombre, apellidoMaterno,contrasena, apellidoPaterno, correo, c.estatus, celular,telefono, puesto,cveRol, r.nombre rol,idServicio, s.nombre servicio
		from servicio s inner join ".$tabla." cs on cveServicio = idServicio  inner join contacto c on cveContacto = idContacto 
		inner join rol  r on cveRol = idRol where idServicio  IN
		(select idServicio 
		from servicio s inner join razon_social on cveRs = idRazonSocial inner join
		ciudad c on cveCiudad= idCiudad inner join cliente cl on idCliente = cveCliente where cveCliente = :cveCliente ".$opc."
		order by idServicio desc) 
		".$opc2."
		and c.eliminado = 0 group by cveContacto desc;";

		$sql = $this->connect()->prepare($sql);
		$sql->bindParam(':cveCliente',$cve, PDO::PARAM_INT);
		if($condicion != 1 && $condicion != 3){
			$sql->bindParam(':contador',$contador, PDO::PARAM_INT);
			$sql->bindParam(':identificador',$identificador, PDO::PARAM_STR);	
		}
		
		
		$sql->execute();
        return $sql->fetchAll(PDO::FETCH_ASSOC);
	}


	function insertDetailContact($input){
		for ($i = 0; $i < count($input['cveContactoArray']); $i++) {
			$sql = "insert into contacto_servicio (cveServicio,cveContacto) 
			values (:cveServicio, :cveContacto)";
			$sql = $this->connect()->prepare($sql);
			$sql->bindParam(':cveServicio',$input['cveServicio'], PDO::PARAM_INT);
			$sql->bindParam(':cveContacto',$input['cveContactoArray'][$i]["idContacto"], PDO::PARAM_INT);
			$sql->execute();
		}
		return $sql;
	}


	function selectServicePerContacto($identificador,$idContacto, $condicion){
		//Reune todos los servicios de un contacto en especifico
		$part1 = "";
		$part2 = "";
		$imprimir = "";
		if($condicion ==1){
			//este imprime todos los servicios que no estan en el contacto
			$part1 = "select idServicio, s.nombre servicio
			from servicio s inner join razon_social on cveRs = idRazonSocial 
			inner join ciudad c on cveCiudad= idCiudad inner 
			join  cliente cl on idCliente = cveCliente inner join plan pl on cvePlan = idPlan 
			where  cveCliente = 
			(select cveCliente from  servicio inner join razon_social on cveRs = idRazonSocial 
			where identificador = :identificador limit 1) and idServicio not in ( ";
		   $part2 = ") and s.eliminado = 0 order by idServicio asc";
		   $imprimir = "";
		}else{
			//este imprime todos los servicios que estan en el contacto
			$imprimir= ", s.nombre servicio, c.nombre contacto, identificador, contador";
		}

        $sql = $part1." select  idServicio ".$imprimir." 
        from contacto_servicio inner join contacto c on idContacto = cveContacto 
        inner join servicio s on idServicio = cveServicio where s.eliminado = 0 and 
		identificador = :identificador and idContacto = :idContacto ".$part2;
		$sql = $this->connect()->prepare($sql);
		$sql->bindParam(':identificador',$identificador, PDO::PARAM_STR);
		$sql->bindParam(':idContacto',$idContacto, PDO::PARAM_INT);
		$sql->execute();
		return $sql->fetchAll(PDO::FETCH_ASSOC);        
	}
}
    

