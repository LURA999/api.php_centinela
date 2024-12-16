<?php
    include "../../Config/database.php";
class services extends database {

	function insertService($input){
		$sql2 = "select IFNULL((select contador+1 from servicio  where identificador like (concat(substring_index(:identificador, '-',1),'-',(select abreviado from ciudad where idCiudad = strSplit(:identificador,'-',2)),'-%')) order by contador desc limit 1),1);";
		$sql2 = $this->connect()->prepare($sql2);
		$sql2->bindParam(':identificador',$input["identificador2"], PDO::PARAM_STR,40);
		$sql2->execute();
		$cont = $sql2 ->fetch(PDO::FETCH_NUM);


		$sql = "insert into servicio 
		(nombre,identificador,estatus,cveCiudad,latitud,longitud,estado,codigoPostal,colonia,avenida,numero,cvePlan,dominio,contador,cveRs)
		values 
		(:nombre,
		concat(substring_index(:identificador, '-',1),'-',
		(select abreviado from ciudad where idCiudad = strSplit(:identificador,'-',2)),'-',
		substring_index(:identificador, '-',-1)),
		:estatus,:cveCiudad,:latitud,:longitud,:estado,:codigoPostal,:colonia,:avenida,:numero,
		:cvePlan, :dominio
		, :contador, :cveRs)";

		$sql = $this->connect()->prepare($sql);
		$sql->bindParam(':nombre',$input['nombre'], PDO::PARAM_STR,40);
		$sql->bindParam(':identificador',$input["identificador2"], PDO::PARAM_STR,40);
		$sql->bindParam(':estatus',$input['cveEstatus'], PDO::PARAM_INT);
		$sql->bindParam(':cveCiudad',$input['cveCiudad'], PDO::PARAM_INT);
		$sql->bindParam(':latitud',$input['latitud'], PDO::PARAM_STR,40);
		$sql->bindParam(':longitud',$input['longitud'], PDO::PARAM_STR,40);
		$sql->bindParam(':estado',$input['estado'], PDO::PARAM_STR,40);
		$sql->bindParam(':codigoPostal',$input['codigoPostal'], PDO::PARAM_STR,40);
		$sql->bindParam(':colonia',$input['colonia'], PDO::PARAM_STR,40);
		$sql->bindParam(':avenida',$input['avenida'], PDO::PARAM_STR,40);
		$sql->bindParam(':numero',$input['numero'], PDO::PARAM_STR,40);
		$sql->bindParam(':cvePlan',$input['cvePlan'], PDO::PARAM_INT);
		$sql->bindParam(':dominio',$input['dominio'], PDO::PARAM_STR,40);
		$sql->bindParam(':contador',$cont[0], PDO::PARAM_INT);
		$sql->bindParam(':cveRs',$input['idRazonSocial'], PDO::PARAM_STR,40);

		$sql->execute();

		/*$sql = "insert into servicio_rs
		(cveServicio, cveRs)
		values 
		((select MAX(idServicio) from servicio),:cveRs)";
		$sql = $this->connect()->prepare($sql);
		$sql->execute();*/
		return $sql;
	}

	function selectServiceOnly($cve){
		$sql = $this->connect()->prepare("
		select nombre 
		from servicio 
		where  idServicio = :id");
		$sql->bindParam(':id',$cve, PDO::PARAM_INT);
		$sql->execute();
		return $sql->fetchAll(PDO::FETCH_ASSOC);
	}

	function selectService($cve){
		$sql = $this->connect()->prepare("
		select idServicio, s.nombre servicio,idRazonSocial,razonSocial,latitud,longitud,estado,codigoPostal,colonia,avenida,numero,cvePlan, pl.nombre plan,identificador,contador,cveCiudad,dominio,c.nombre ciudad, s.estatus 
		from servicio s inner join razon_social on cveRs = idRazonSocial 
		inner join ciudad c on cveCiudad= idCiudad inner join  cliente cl on idCliente = cveCliente inner join plan pl on cvePlan = idPlan where  cveCliente = :cveCliente and s.eliminado = 0 order by idServicio desc;");
		$sql->bindParam(':cveCliente',$cve, PDO::PARAM_INT);
		$sql->execute();
		return $sql->fetchAll(PDO::FETCH_ASSOC);
	}

	function updateService($input){
		$sql = "update servicio set nombre = :nombre,estatus = :estatus,
	cveCiudad = :cveCiudad,  latitud = :latitud, longitud = :longitud,estado= :estado,codigoPostal= :codigoPostal,colonia= :colonia,avenida= :avenida,numero= :numero,cvePlan = :cvePlan,
	dominio = :dominio, cveRs = :cveRs where idServicio =:id"; 
		$sql = $this->connect()->prepare($sql);
		$sql->bindParam(':nombre',$input['nombre'], PDO::PARAM_STR,40);
		$sql->bindParam(':estatus',$input['cveEstatus'], PDO::PARAM_STR,40);
		$sql->bindParam(':cveCiudad',$input['cveCiudad'], PDO::PARAM_INT);
		$sql->bindParam(':latitud',$input['latitud'], PDO::PARAM_STR,40);
		$sql->bindParam(':longitud',$input['longitud'], PDO::PARAM_STR,40);
		$sql->bindParam(':estado',$input['estado'], PDO::PARAM_STR,40);
		$sql->bindParam(':codigoPostal',$input['codigoPostal'], PDO::PARAM_STR,40);
		$sql->bindParam(':colonia',$input['colonia'], PDO::PARAM_STR,40);
		$sql->bindParam(':avenida',$input['avenida'], PDO::PARAM_STR,40);
		$sql->bindParam(':numero',$input['numero'], PDO::PARAM_STR,40);
		$sql->bindParam(':cvePlan',$input['cvePlan'], PDO::PARAM_INT);
		$sql->bindParam(':dominio',$input['dominio'], PDO::PARAM_STR,40);
		$sql->bindParam(':id',$input['id'], PDO::PARAM_STR,40);
		$sql->bindParam(':cveRs',$input['idRazonSocial'], PDO::PARAM_STR,40);
		$sql->execute();

	/*	$sql = "update servicio_rs set  cveRs = :cveRs where cveServicio = :id;";
		$sql = $this->connect()->prepare($sql);
		$sql->bindParam(':id',$input['id'], PDO::PARAM_STR,40);
		$sql->execute();*/

		return $sql;
	}

	function selectServiceIdMax(){
		$sql = "select idServicio from  servicio order by idServicio desc limit 1";
		$sql = $this->connect()->prepare($sql);
		$sql->execute();
		return $sql->fetchAll(PDO::FETCH_ASSOC);
	}

	function deleteService($cve){
		$sql = $this->connect()->prepare("update servicio set eliminado = 1 where idServicio = :cveServicio");
		$sql->bindParam(':cveServicio',$cve, PDO::PARAM_INT);
		$sql->execute();
	}

	function selectViewService($cve, $cve2,$condicion){
		//echo "$cve, $cve2,$condicion";
		$inner = "";
		$select = "";
		if($condicion == 1){
			$select = "idCliente, cl.nombre nombreCliente, cl.estatus estatusCliente, nombreCorto,idServicio, s.nombre servicio,razonSocial, s.estatus estatusRS, dominio, 
			identificador, pl.nombre plan, descripcion, c.nombre ciudad,cveCiudad, concat(latitud,' , ',longitud) coordenadas,estado,codigoPostal,colonia,avenida,numero ";
			$inner = "inner join ciudad c on cveCiudad =idCiudad";
		}else{
			$select = "cl.nombre cliente, s.nombre servicio, pl.nombre plan, s.estatus,idServicio,idCliente";
		}	

		$sql = "select ".$select."
		from servicio s
		inner join razon_social on cveRs = idRazonSocial 
		inner join cliente cl on cveCliente = idCliente 
		inner join plan pl on cvePlan = idPlan
		".$inner." where identificador = :identificador and contador = :contador and s.eliminado = 0";
		//echo $sql;

		$sql = $this->connect()->prepare($sql);
		$sql->bindParam(':identificador',$cve, PDO::PARAM_STR);
		$sql->bindParam(':contador',$cve2, PDO::PARAM_INT);
		$sql->execute();
		return $sql->fetchAll(PDO::FETCH_ASSOC);
	}

	function selectServiceIdFalseMax($cve){
		$cve = $cve."%";
		$sql = $this->connect()->prepare("
		select contador from  servicio  where identificador like :identificadorUltimo order by contador desc limit 1");
		$sql->bindParam(':identificadorUltimo',$cve, PDO::PARAM_STR);
		$sql->execute();
		return $sql->fetchAll(PDO::FETCH_ASSOC);

	}

}



    

