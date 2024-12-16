<?php
require "../../Config/database.php";

class logs_clienteEmpresa extends database{


function insertLog($input,$cond){
    $nombre = "";
    $mas = "";
    $mas2 = "";
    $mas3= "";

    switch($cond){
        case 1 :
            if($input["cve"] == ""){
                $sql = $this->connect()->prepare("select MAX(idContacto) max from contacto;");
                $sql->execute();
                $row = $sql->fetch(PDO::FETCH_NUM);
                $nombre = " el contacto ".$row[0];
                //$mas2 = ", los servicios dados de alta fueron: ".$input["serviciosAltas"];
                //$mas3 = ", los servicios dados de baja fueron: ".$input["serviciosBajas"];
            }else{
                //$mas3 = "y los servicios en donde se encontraba son: ".$input["serviciosBajas"];
                $nombre = " el contacto ".$input["cve"];
            }

        break;
        case 2 :
            if($input["cve"] == ""){
                $sql = $this->connect()->prepare("select MAX(idServicio) max from servicio;");
                $sql->execute();
                $row = $sql->fetch(PDO::FETCH_NUM);
                $nombre = " el servicio ".$row[0];
            }else{
                $nombre = " el servicio ".$input["cve"];
            }
        break;
        case 3 :
            if($input["cve"] == ""){
                $sql = $this->connect()->prepare("select MAX(idRazonSocial) max from razon_social;");
                $sql->execute();
                $row = $sql->fetch(PDO::FETCH_NUM);
                $nombre = " la razon social num. '".$row[0]."'";
            }else{
                $nombre = " la razon social  num. '".$input["cve"]."'";
            }
        break;
    }
   
        
    /*Este codigo sirve para identificar si se han modificado campos especificos , pero nomas aplica para dos tablas */
    /*if($input["tipo"][0] == 0 && $cond >=2 ){
        $mas = " en los campos ".$input["campos"];
    }*/

    $descripciones = array("Se ha actualizado ","Se ha dado de alta ","Se ha dado de baja ");
    
    $fecha= date('Y-m-d');
    $hora = date('H:i:s', time()-32400);

    $descripcionExtendida = $descripciones[$input["tipo"][0]].$nombre.$mas;

    /*for($i = 0; $i<count($input["tipo"]); $i++){
    $fecha= date('Y-m-d');
    $hora = date('H:i:s', time()-32400);

    if($cond >=2){
        $descripcionExtendida = $descripciones[$input["tipo"][$i]].$nombre.$mas;
    }else{
        if($input["serviciosBajas"] == ""){
            $descripcionExtendida = $descripciones[$input["tipo"][$i]].$nombre.$mas.$mas2;
        }else if ($input["serviciosAltas"] == ""){
            $descripcionExtendida = $descripciones[$input["tipo"][$i]].$nombre.$mas.$mas3;
        }else if($input["serviciosAltas"] !== "" && $input["serviciosBajas"] !== ""){
            $mas2= $this->str_replace_first(",", "y", $mas2);
            $descripcionExtendida = $descripciones[$input["tipo"][$i]].$nombre.$mas.$mas3.$mas2;
        }
    }*/
    $sql = $this->connect()->prepare("
    insert log_cliente_empresa (descripcion,tipo,fecha,cveUsuario,cveCliente,hora,categoria) 
    value (:descripcion,:tipo,:fecha,:cveUsuario,:cveCliente,:hora,:categoria);");
    $sql->bindParam(":descripcion",$descripcionExtendida,PDO::PARAM_STR,350);
    $sql->bindParam(":tipo",$input["tipo"][0],PDO::PARAM_INT);
    $sql->bindParam(":fecha",$fecha,PDO::PARAM_STR,45);
    $sql->bindParam(":cveUsuario",$input["cveUsuario"],PDO::PARAM_INT);
    $sql->bindParam(":cveCliente",$input["cveCliente"],PDO::PARAM_INT);
    $sql->bindParam(":hora",$hora,PDO::PARAM_STR);
    $sql->bindParam(":categoria",$input["categoria"],PDO::PARAM_INT);
    $sql->execute();       
    //}
    
    return $sql;

}

function selectLog($cve){
    $sql= $this->connect()->prepare("
    select idLog,descripcion,lg.tipo,concat(fecha,' - ',hora) fecha,usuario 
    from log_cliente_empresa lg, usuario where cveCliente = :cveCliente and cveUsuario = idUsuario order by idLog desc;");
    $sql->bindParam(":cveCliente", $cve, PDO::PARAM_INT);
    $sql->execute();
    return $sql ->fetchAll(PDO::FETCH_ASSOC);
}

function deleteLog($cve){
    $sql= $this->connect()->prepare("
    delete  from log_cliente_empresa where idLog = :cve");
    $sql->bindParam(":cve", $cve, PDO::PARAM_INT);
    $sql->execute();
    return $sql ->fetchAll(PDO::FETCH_ASSOC);
}


function str_replace_first($from, $to, $subject){
    $from = '/'.preg_quote($from, '/').'/';
    return preg_replace($from, $to, $subject, 1);
}

}