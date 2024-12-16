<?php
require '../../Config/database.php';

class ticketDashboard extends database {
    function selectType($fechaf,$fechai,$tipo,$cveGrupo){
        $select = "";
        $groupby = "";
        $inner = "";
        $limit = "";
        
        $orderby = "count(idTicket)";
        $where =  " t.eliminado = 0 ";
        $sentGrupo = "";

        if ($cveGrupo > 1) {
            $sentGrupo = " cveGrupo = :cveGrupo and ";
        }

        switch ($tipo) {
            case 1:
                #tipos de tickets
                $select = "idTipoTicket, tt.nombre,count(idTicket) totalTicket";
                $groupby = "idTipoTicket";
                $inner = "inner join tipoTicket tt on tipo = idTipoTicket";
                break;
            case 2:
                #agentes con mas tickets
                $select = "cveUsuario,concat(nombres,' ',apellidoPaterno,' ',apellidoMaterno) nombre, fechaAbierta,count(idTicket) totalTicket";
                $groupby = "cveUsuario";
                $inner = " inner join usuario  on idUsuario = cveUsuario";
                $where=$where." and t.cveUsuario !=0";
                break;
            case 3:
                #empresas con mas tickets
                $select = "cveCliente,cl.nombre cliente, fechaAbierta, count(idTicket) totalTicket ";
                $groupby = "cliente ";
                $inner = "  inner join usuario  on idUsuario = cveUsuario 
                inner join cliente cl on cveCliente = idCliente ";
                $limit = " limit 10";
                break;
            case 4:
                # Tickets, abiertos, pausados, cerrados
                $select = " idEstadoTicket,et.nombre estado, count(idTicket) totalTicket ";
                $groupby = "idEstadoTicket ";
                $inner = "inner join estadoTicket et on estado = idEstadoTicket ";
                break;
            case 5:
                # Departamentos con mas tickets
                $select = "cveGrupo, g.nombre,count(idTicket) totalTicket,concat(fechaAbierta) fecha ";
                $groupby = " fechaAbierta ,cveGrupo  ";
                $inner = " inner join grupo g on cveGrupo = idGrupo ";
                $orderby = " g.nombre";
                break;
            case 6:
                # Servicios con mas tickets
                $select = "idServicio, s.nombre,count(idTicket) totalTicket,concat(fechaAbierta,' ',IFNULL(fechaCerrada,'') ) fecha";
                $groupby = " idServicio  ";
                $inner = " inner join servicio s on cveServicio = idServicio ";
               break;          
        }
        $sql = "select ".$select."
        from ticket t ".$inner."
        where ".$sentGrupo." ".$where."
        and ((fechaAbierta) between :fechaInicio  and :fechaFin or
        (fechaCerrada) between :fechaInicio and :fechaFin)   group by ".$groupby." order by ".$orderby." desc ".$limit.";";
        
        $sql = $this->connect()->prepare($sql);
        $sql->bindParam(":fechaInicio",$fechaf,PDO::PARAM_STR,20);
        $sql->bindParam(":fechaFin",$fechai,PDO::PARAM_STR,20);
        if ($cveGrupo > 1) {
            $sql->bindParam(":cveGrupo",$cveGrupo,PDO::PARAM_INT);    
        }
        
        $sql->execute();
        return $sql->fetchAll(PDO::FETCH_ASSOC);
    }

    function selectTicket($fechaf,$fechai,$filtro,$cliente,$cveGrupo){
        $where = "";
        $sentGrupo = "";

        if ($cveGrupo > 1) {
            $sentGrupo = " cveGrupo = :cveGrupo and ";
        }

        if($filtro > 0){
            $where = " et.idEstadoTicket = :filtro and ";
        }
        if ($cliente >0) {
            $where = " idCliente = :empresa and ";
        }
        $sql= "select idTicket, s.nombre servicio,  IF(concat(ifnull(fechaCerrada,''),', ',ifnull(horaCerrada,'')) = ', ' 
        ,null, 
         concat(ifnull(fechaCerrada,''),', ',ifnull(horaCerrada,''))) fechaCerrada, concat(fechaAbierta,', ',horaAbierta) fechaAbierta, 
        g.nombre grupo, et.nombre estado
        from ticket t 
        inner join grupo g on cveGrupo = idGrupo 
        inner join servicio s on cveServicio = idServicio 
        inner join usuario u on cveUsuario = idUsuario 
        inner join cliente c on cveCliente = idCliente 
        inner join asunto a on cveAsunto = idAsunto
        inner join estadoTicket et on t.estado = idEstadoTicket  
        where ".$sentGrupo." ".$where."
         ((fechaAbierta) between :fechaInicio  and :fechaFin or
        (fechaCerrada) between :fechaInicio and :fechaFin)   group by idTicket order by count(idTicket) desc";
       
        $sql = $this->connect()->prepare($sql);
        $sql->bindParam(":fechaInicio",$fechaf,PDO::PARAM_STR,20);
        $sql->bindParam(":fechaFin",$fechai,PDO::PARAM_STR,20);
        if($filtro > 0){
            $sql->bindParam(":filtro",$filtro,PDO::PARAM_INT);
        }
        if ($cliente >0) {
            $sql->bindParam(":empresa",$cliente,PDO::PARAM_INT);
        }
        if ($cveGrupo > 1) {
            $sql->bindParam(":cveGrupo",$cveGrupo,PDO::PARAM_INT);    
        }
        $sql->execute();
        return $sql->fetchAll(PDO::FETCH_ASSOC);
    }
    
}