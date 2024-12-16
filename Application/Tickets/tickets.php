<?php
    include "../../Config/database.php";
class tickets extends database {

	function insertComment($input){
		$sql= "
		insert into log_ticket (cveTicket,comentario, cveUsuario,tipo) 
		values(:cveTicket,:comentario,:cveUsuario,:tipo)";
		$sql = $this->connect()->prepare($sql);
 		$sql->bindParam(':cveTicket',$input["cveTicket"], PDO::PARAM_INT);
		$sql->bindParam(':comentario',$input["comentario"], PDO::PARAM_STR, 350);
 		$sql->bindParam(':cveUsuario',$input["cveUsuario"], PDO::PARAM_INT);
		 $sql->bindParam(':tipo',$input["tipo"], PDO::PARAM_INT);
		$sql->execute();
		return $sql->fetchAll(PDO::FETCH_ASSOC);
	}

	function selectAllHistorial($cve ){
		$sql = "select idLog, lt.comentario,concat(u.nombres,' ',u.apellidoPaterno,' ',u.apellidoMaterno) usuario, fechaCompleta fechaUpdate, 
		concat(u2.nombres,' ',u2.apellidoPaterno,' ',u2.apellidoMaterno) agente,  gr.nombre grupo, lt.tipo
		from log_ticket lt 
		left join log_ticket_det ltd on cveLog = idLog 
		left join usuario u on u.idUsuario = lt.cveUsuario
		left join usuario u2 on u2.idUsuario  = cveAgente
		left join grupo gr on cveGrupo = idGrupo
		where lt.cveTicket = :cve order by idLog desc";
		$sql = $this->connect()->prepare($sql);
 		$sql->bindParam(':cve',$cve, PDO::PARAM_INT);
		$sql->execute();
		return $sql->fetchAll(PDO::FETCH_ASSOC);
	}

	function selectOneTicket($cve){
		$sql = "select cveUsuario,t.estado,t.tipo,t.prioridad,cveGrupo, u2.usuario, con.nombre contacto,con.correo,con.celular,
		puesto, cl.nombre cliente, serv.nombre servicio, pl.nombre plan, serv.estatus, identificador, org.nombre origen, con.nombre contacto,contador
        , u.usuario creador,u.correo correoAbierto, asu.nombre asunto, t.descripcion 
        from ticket t 
		inner join contacto con on cveContacto = idContacto 
		inner join servicio serv on cveServicio = idServicio
        inner join razon_social rs on cveRs = idRazonSocial
        inner join usuario u on u.idUsuario = abiertoUsuario
		inner join usuario u2 on  u2.idUsuario =cveUsuario
        inner join cliente cl on rs.cveCliente = idCliente
        inner join origenTicket org on idOrigenTicket = origen
        inner join plan pl on cvePlan = idPlan
        inner join asunto asu on cveAsunto = idAsunto
		where idTicket =  :cve";
		$sql = $this->connect()->prepare($sql);
 		$sql->bindParam(':cve',$cve, PDO::PARAM_INT);
		$sql->execute();
		return $sql->fetchAll(PDO::FETCH_ASSOC);
	}

	function insertTicket($input){
	$fechaAbierto = date("Y-m-d");
	$horaAbierta = date("H:i:s");

	$sql = "insert into ticket(cveCliente,cveServicio,cveGrupo,cveAsunto,abiertoUsuario,
	cveUsuario,fechaAbierta,horaAbierta,tipo,prioridad,descripcion,origen,cveIncidencia,cveContacto)
	values(:cveCliente, :cveServicio, :cveGrupo, :asunto, :abiertoUsuario,
	:cveUsuario, :fechaAbierta, :horaAbierta, :tipo, :prioridad, :descripcion, :origen, :cveIncidencia, :cveContacto)";

	$sql = $this->connect()->prepare($sql);

 	$sql->bindParam(':cveCliente',$input['cveCliente'], PDO::PARAM_INT);
	$sql->bindParam(':cveUsuario',$input['cveUsuario'], PDO::PARAM_INT);
 	$sql->bindParam(':cveServicio',$input['cveServicio'], PDO::PARAM_INT);
 	$sql->bindParam(':cveGrupo',$input['cveGrupo'], PDO::PARAM_INT);
 	$sql->bindParam(':asunto',$input['asunto'], PDO::PARAM_INT);
 	$sql->bindParam(':abiertoUsuario',$input['abiertoUsuario'], PDO::PARAM_INT);
 	$sql->bindParam(':fechaAbierta',$fechaAbierto, PDO::PARAM_STR,20);
	$sql->bindParam(':horaAbierta',$horaAbierta, PDO::PARAM_STR,40);
 	$sql->bindParam(':tipo',$input['tipo'], PDO::PARAM_INT);
	$sql->bindParam(':prioridad',$input['prioridad'], PDO::PARAM_INT);
 	$sql->bindParam(':descripcion',$input['descripcion'], PDO::PARAM_STR,350);
	$sql->bindParam(':origen',$input['origen'], PDO::PARAM_INT);
 	$sql->bindParam(':cveIncidencia',$input['cveIncidencia'], PDO::PARAM_INT);
	 $sql->bindParam(':cveContacto',$input['cveContacto'], PDO::PARAM_INT);

	$sql->execute();
	return $sql;
	}

	//este es para vista-empresa
	function selectTicketCustomer($cve,$identificador){
		$where = "";
	$arrayIdenti = "";
	
	if($identificador  !== ""){
		$arrayIdenti = explode(" ",$identificador);
		$where = "cveCliente = :cveCliente and 
		cveServicio = (select idServicio from servicio 
		inner join razon_social on cveRs = 
		idRazonSocial where cveCliente = :cveCliente and identificador = :identificador and contador = :contador)";
	}else{
		$where = "cveCliente = :cveCliente";
	}

	$sql = $this->connect()->prepare("select idTicket, g.nombre departamento, a.nombre asunto, 
	s.nombre servicio, IF(concat(ifnull(fechaCerrada,''),', ',ifnull(horaCerrada,'')) = ', ' 
	,null, 
	 concat(ifnull(fechaCerrada,''),', ',ifnull(horaCerrada,''))) fechaCerrada, concat(fechaAbierta,', ',horaAbierta) fechaAbierta, 
	t.estado, usuario agente, cveCliente, c.nombre 
	from ticket t  
	inner join grupo g on cveGrupo = idGrupo 
	inner join servicio s on cveServicio = idServicio 
	inner join usuario u on cveUsuario = idUsuario 
	inner join cliente c on cveCliente = idCliente 
	inner join asunto a on cveAsunto = idAsunto where ".$where." and t.eliminado = 0");
	$sql->bindParam(':cveCliente',$cve, PDO::PARAM_INT);
	if($identificador  !== ""){
		$sql->bindParam(':identificador',$arrayIdenti[0], PDO::PARAM_STR,50);
		$sql->bindParam(':contador',$arrayIdenti[1], PDO::PARAM_INT);
	}
	$sql->execute();
        return $sql->fetchAll(PDO::FETCH_ASSOC);
	}
	
	//esta es para la la vista de solicutd ticket y todos los ticket
	function selectTicket($cond,$cve){
		$orderby ='';
		$where = '';
		switch ($cond) {
			case 0:
				//vista previa de tickets
				$where = " where t.estado = 1 limit 2;";
			break;
			case 1:
				$orderby = " order by idTicket desc";
			break;
			case 2:
				$orderby = " order by prioridad desc;";
			break;
			case 3:
				$orderby = " order by estado asc;";
			break;
		}

		if($cond > 0  ){
			$where = " where abiertoUsuario =  :cve or t.cveUsuario = :cve or t.cveGrupo = (select cveGroup from usuario where idUsuario = :cve) ";
		}
		
		$sql = $this->connect()->prepare("select idTicket, s.nombre servicio, IF(concat(ifnull(fechaCerrada,''),', ',ifnull(horaCerrada,'')) = ', ' 
        ,null, 
         concat(ifnull(fechaCerrada,''),', ',ifnull(horaCerrada,''))) fechaCerrada, concat(fechaAbierta,', ',horaAbierta) fechaAbierta, t.estado,idUsuario, usuario agente, cveCliente, c.nombre, idGrupo grupo, t.tipo,prioridad  
		from ticket t  
		inner join grupo g on cveGrupo = idGrupo 
		inner join servicio s on cveServicio = idServicio 
		inner join usuario u on cveUsuario = idUsuario 
		inner join cliente c on cveCliente = idCliente ".$where." ".$orderby);

		if($cond > 0  ){
			$sql -> bindParam(":cve", $cve, PDO::PARAM_INT);
		}
		
		$sql->execute();

		return $sql->fetchAll(PDO::FETCH_ASSOC);
	}


	function updateTicket($input){
	$sql = "update ticket  set cveCliente = :cveCliente ,cveServicio = :cveServicio,cveGrupo = :cveGrupo ,cveAsunto = :asunto,cveAsuntoCerrado = :cveAsuntoCerrado, abiertoUsuario = :abiertoUsuario,
	cveContacto = :cveContacto, cveUsuario = :cveUsuario , cerradoUsuario =:cerradoUsuario, fechaAbierto =:fechaAbierto , fechaCerrado = :fechaCerrado,
	tipo = :tipo, descripcion = :descripcion, estado = :estado , origen = :origen, cveIncidencia = :cveIncidencia where cveCliente = :cveCliente";
	$sql = $this->connect()->prepare($sql);
 	$sql->bindParam(':cveCliente',$input['cveCliente'], PDO::PARAM_INT);
 	$sql->bindParam(':cveServicio',$input['cveServicio'], PDO::PARAM_INT);
 	$sql->bindParam(':cveGrupo',$input['cveGrupo'], PDO::PARAM_INT);
 	$sql->bindParam(':asunto',$input['asunto'], PDO::PARAM_STR,40);
 	$sql->bindParam(':cveAsuntoCerrado',$input['cveAsuntoCerrado'], PDO::PARAM_INT);
 	$sql->bindParam(':abiertoUsuario',$input['abiertoUsuario'], PDO::PARAM_STR,40);
 	$sql->bindParam(':cveContacto',$input['cveContacto'], PDO::PARAM_INT);
 	$sql->bindParam(':cveUsuario',$input['cveusuario'], PDO::PARAM_INT);
 	$sql->bindParam(':cerradoUsuario',$input['cerradoUsuario'], PDO::PARAM_INT);
 	$sql->bindParam(':fechaAbierto',$input['fechaAbierto'], PDO::PARAM_STR,20);
 	$sql->bindParam(':fechaCerrado',$input['fechaCerrado'], PDO::PARAM_STR,20);
 	$sql->bindParam(':tipo',$input['tipo'], PDO::PARAM_INT);
 	$sql->bindParam(':descripcion',$input['descripcion'], PDO::PARAM_STR,40);
 	$sql->bindParam(':estado',$input['estado'], PDO::PARAM_INT);
	$sql->bindParam(':origen',$input['origen'], PDO::PARAM_STR,40);
 	$sql->bindParam(':cveIncidencia',$input['cveIncidencia'], PDO::PARAM_INT);
	$sql->execute();
        return $sql;
	}

	function deleteTicket($input){
		
		$fecha = date('Y-m-d');
		$hora = date("H:i:s");
		
    	$sql = $this->connect()->prepare("update ticket  set eliminado = 1, fechaCerrada = :fecha , horaCerrada = :hora	 where idTicket = :cve");
		$sql -> bindParam(":cve", $input["cve"], PDO::PARAM_INT);
    	$sql -> bindParam(":fecha", $fecha, PDO::PARAM_STR,30);
    	$sql -> bindParam(":hora", $hora, PDO::PARAM_STR,30);
    	$sql ->execute();
    	return $sql; 
	}

	function updateEstate($input){
		//echo var_dump($input);
    	$sql = $this->connect()->prepare("update ticket  set estado = :cveEstado, nuevo = 1  where idTicket = :cve");
    	$sql -> bindParam(":cveEstado", $input["cve"], PDO::PARAM_INT);
    	$sql -> bindParam(":cve", $input["cve2"], PDO::PARAM_INT);
		$sql ->execute();


		if ($input["cve"] == 4) {
			$fecha = date('Y-m-d');
			$hora = date("H:i:s");
 				$sql = $this->connect()->prepare("update ticket  set fechaCerrada = :fecha, horaCerrada = :hora , nuevo = 1  where idTicket = :cve");
			$sql -> bindParam(":cve", $input["cve2"], PDO::PARAM_INT);
			$sql -> bindParam(":fecha", $fecha, PDO::PARAM_STR,30);
			$sql -> bindParam(":hora", $hora, PDO::PARAM_STR,30);
			$sql ->execute();
		}

		if($input["cve"] == 4){
			$this->insertarEnLogTicket($input, "Se ",6,"estadoTicket");
		}else{
			$this->insertarEnLogTicket($input, "Se actualizo el estado a ",3,"estadoTicket");
		}
    	return $sql; 
	}

	function updateProperty($input){
    	$sql = $this->connect()->prepare("update ticket  set prioridad = :prioridad where idTicket = :cve");
		$sql -> bindParam(":prioridad", $input["cve"], PDO::PARAM_INT);
    	$sql -> bindParam(":cve", $input["cve2"], PDO::PARAM_INT);
		$sql ->execute();

		$this->insertarEnLogTicket($input, "Se actualizo la prioridad a ",4,"prioridadTicket");
    	return $sql; 
	}

	function insertarEnLogTicket($input, $text, $tipo,$tabla){
		$sql = $this->connect()->prepare("insert into log_ticket (comentario,tipo,cveUsuario, cveTicket)  
		values(concat('".$text."',(select nombre from ".$tabla." where id".$tabla." = :prioridad)),:tipo,:cveUsuario,:cve)");
		$sql -> bindParam(":prioridad", $input["cve"], PDO::PARAM_INT);
    	$sql -> bindParam(":cve", $input["cve2"], PDO::PARAM_INT);    	
		$sql -> bindParam(":cveUsuario", $input["cveUsuario"], PDO::PARAM_INT);
		$sql -> bindParam(":tipo", $tipo, PDO::PARAM_INT);
		$sql ->execute();
	}

	function updateGroup($input){
    	$sql = $this->connect()->prepare("update ticket  set cveGrupo = :cveGrupo where idTicket = :cve");
    	$sql -> bindParam(":cveGrupo", $input["cve"], PDO::PARAM_INT);
    	$sql -> bindParam(":cve", $input["cve2"], PDO::PARAM_INT);
		$sql ->execute();


		$sql = $this->connect()->prepare("insert into log_ticket (tipo,cveUsuario, cveTicket)  
		values(5,:cveUsuario,:cve)");
		$sql -> bindParam(":cve", $input["cve2"], PDO::PARAM_INT);
		$sql -> bindParam(":cveUsuario", $input["cveUsuario"], PDO::PARAM_INT);
		$sql ->execute();

		$sql = $this->connect()->prepare("insert into log_ticket_det (cveLog,cveGrupo, cveAgente)
		values ((select max(idLog) from log_ticket),:cveGrupo,0)");
    	$sql -> bindParam(":cveGrupo", $input["cve"], PDO::PARAM_INT);
		$sql -> execute();

		$sql = $this->connect()->prepare("select Max(idLogDet) max from log_ticket_det");
    	$sql -> execute();
    	return $sql ->fetchAll(PDO::FETCH_ASSOC); 
	}

	function updateAgente($input){	
    	$sql = $this->connect()->prepare("update ticket  set cveUsuario = :cveUsuario where idTicket = :cve");
    	$sql -> bindParam(":cveUsuario", $input["cve"], PDO::PARAM_INT);
    	$sql -> bindParam(":cve", $input["cve2"], PDO::PARAM_INT);
		$sql ->execute();
		
		if(isset($input["cveLogDet"])){
			$sql = $this->connect()->prepare("update log_ticket_det set cveAgente = :cveUsuario where idLogDet = :cveLogDet;");
			$sql -> bindParam(":cveUsuario", $input["cve"], PDO::PARAM_INT);
			$sql -> bindParam(":cveLogDet", $input["cveLogDet"], PDO::PARAM_INT);
			$sql ->execute();
		}

    	return $sql; 
	}

	function updateType($input){
    	$sql = $this->connect()->prepare("update ticket  set tipo = :tipo where idTicket = :cve");
    	$sql -> bindParam(":tipo", $input["cve"], PDO::PARAM_INT);
    	$sql -> bindParam(":cve", $input["cve2"], PDO::PARAM_INT);
		$sql ->execute();
		$this->insertarEnLogTicket($input, "Se actualizo el tipo a ",2,"tipoTicket");

    	return $sql; 
	}
	
}
    
