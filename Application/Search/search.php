<?php
    include "../../Config/database.php";
    
    class search extends database {
        

        function selectNames($var,$cond){
            $var1 = "%".$var."%";
            $var2 = $var."%";
            $var3 = "%".$var;
            $sql = "";
            
            switch($cond){
                case 1:           
                    $sql = "select idCliente id ,nombre from cliente where  eliminado=0 and (nombre like :var1 or nombre like :var2 
                    or nombre like :var3) limit 10";
                    break;
                case 2:
                    $sql = "select idRazonSocial id ,razonSocial nombre from razon_social where  eliminado=0 and (razonSocial like :var1 or razonSocial like :var2 
                    or  razonSocial like :var3) limit 10";
                    break;
                case 3:
                    $sql = "select idServicio id,nombre from servicio where  eliminado=0 and (nombre like :var1 or nombre like :var2 
                    or nombre like :var3) limit 10";
                    break;
            }
            $sql = $this->connect()->prepare($sql);
            $sql->bindParam(':var1',$var1, PDO::PARAM_STR);
            $sql->bindParam(':var2',$var2, PDO::PARAM_STR);
            $sql->bindParam(':var3',$var3, PDO::PARAM_STR);
             
            $sql ->execute();
            return $sql->fetchAll(PDO::FETCH_ASSOC); 
        }

        function selectIdentifier($var,$cond){
            $where = "";
            $select ="";
            switch($cond){
                case 1:
                    $select = "idCliente";
                    $where = " idCliente = :var";
                    break;
                case 2:
                    $select = "idRazonSocial";
                    $where = " idRazonSocial = :var";
                    break;
                case 3:
                    $select = "idServicio";
                    $where = " idServicio = :var";
                    break;
            }
            $sql = $this->connect()->prepare("select ".$select." id, concat(SUBSTRING_INDEX(identificador, '-', 2),'-',LPAD(contador, 4, 0),'-',SUBSTRING_INDEX(identificador, '-', -1)) identificador, s.nombre
            from servicio s inner join razon_social rs on cveRs = idRazonSocial inner join cliente cl on idCliente = cveCliente where s.eliminado=0 and ".$where." ");
            $sql->bindParam(':var',$var, PDO::PARAM_INT);
            $sql ->execute();
            return $sql->fetchAll(PDO::FETCH_ASSOC); 
        }

        function selectService(){
            $sql = $this->connect()->prepare("select  concat(SUBSTRING_INDEX(identificador, '-', 2),'-',LPAD(contador, 4, 0),'-',SUBSTRING_INDEX(identificador, '-', -1)) as servicio from servicio");
            $sql ->execute();
            return $sql->fetchAll(PDO::FETCH_ASSOC); 
 
        }

        function selectServiceEstatus($cve){
            $sql = $this->connect()->prepare("select estatus  from servicio where idServicio= :id");
            $sql->bindParam(':id',$cve, PDO::PARAM_INT);
            $sql ->execute();
            return $sql->fetchAll(PDO::FETCH_ASSOC); 
 
        }
        

        //Esta consulta se encarga de buscar identificadores, en el buscador del layout y en el de solicitud de tickets
        function selectTicketEntryAll($var,$opc){

            if($var !== ""){
                $where = "";
                $having = "";
                if($opc == 1){
                    $where = "and ( s.identificador = :var or s.identificador like :var or s.identificador like :var2 or contador = :var)";
                }else{
                    $having = "having identificador like :var";
                }

            $var = $var."%";
            $var2 = "%".$var;
            $sql = $this->connect()->prepare("
            select concat(SUBSTRING_INDEX(identificador, '-', 2),'-',LPAD(contador, 4, 0),'-',SUBSTRING_INDEX(identificador, '-', -1),' ', s.nombre/*,' ',cveCliente*/ ) identificador from servicio s
            inner join razon_social on cveRs = idRazonSocial  
            inner join cliente c on cveCliente = idCliente  where s.eliminado = 0
              ".$where."  ".$having);
            $sql->bindParam(':var',$var, PDO::PARAM_STR);
            if($opc == 1){
            $sql->bindParam(':var2',$var2, PDO::PARAM_STR);
            }
            
          
            $sql ->execute();
            return $sql->fetchAll(PDO::FETCH_COLUMN,0);
            } else{
                return [];
            }
        }
        //Esta consulta busca un identificador completo de acuerdo a su identificador sin contador
        function selectServiceSearch($var){
            if($var !== ""){
            $var =  "%".$var."%";
            $sql = $this->connect()->prepare("
            select  concat(SUBSTRING_INDEX(s.identificador, '-', 2),'-',LPAD(s.contador, 4, 0),'-',SUBSTRING_INDEX(s.identificador, '-', -1),' | ',c.nombre, ' | ', cveCliente, ' | ', s.estatus) as identificador from servicio s
            inner join razon_social on cveRs = idRazonSocial 
            inner join cliente c on cveCliente = idCliente
            having lower(identificador) like lower(:var)");
            $sql->bindParam(':var',$var, PDO::PARAM_STR);
            $sql ->execute();
            
            return $sql->fetchAll(PDO::FETCH_COLUMN,0);
            } else{
                return [];
            }
        }

        //Esta consulta busca un Contactos 
        function selectContactSearch($var){
            if($var !== ""){
            $var = $var."%";
            $var2 = "%".$var;
            $sql = $this->connect()->prepare("
            select concat(nombre,' ', apellidoPaterno ,' ', apellidoMaterno ,' | ', correo,' | ',cveEmpresa) as Nombre from contacto c
                having lower(Nombre) like lower(:var) or lower(Nombre) like lower(:var) or lower(Nombre) like lower(:var2) ");
            $sql->bindParam(':var',$var, PDO::PARAM_STR);
            $sql->bindParam(':var2',$var2, PDO::PARAM_STR);
            $sql ->execute();
            return $sql->fetchAll(PDO::FETCH_COLUMN,0);
            } else{
                return [];
            }
        }
         //Esta consulta busca un tickets 
        function selectTicketSearch($var){  
            if($var !== ""){
            $var = $var."%";
            $var2 = "%".$var;
            $sql = $this->connect()->prepare("
            select concat(idTicket,' | ',a.nombre,' | ', t.tipo) as ticket from ticket t inner join asunto a on cveAsunto=idAsunto
    having lower(ticket) like lower(:var) or lower(ticket) like  lower(:var) or lower(ticket) like lower(:var2) ");
            $sql->bindParam(':var',$var, PDO::PARAM_STR);
            $sql->bindParam(':var2',$var2, PDO::PARAM_STR);
            $sql ->execute();
          
            return $sql->fetchAll(PDO::FETCH_COLUMN,0);
            } else{
                return [];
            }
        }

        function selectTicketNav($input){
            $cont = 0;
            $where2 = "";
            $where = "";
            $consulta = "";
            $buscarizq  = "";
            $buscardch  = "";
            $buscarAmb = "";
            $orderby = "";
            $buscarNormal = "";

            switch ($input["condicion"]) {
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
            if($input["cveGrupo"] > 1){
                $where = " (abiertoUsuario =  :cve or t.cveUsuario = :cve or t.cveGrupo = :cveGrupo) ";
            }
            
            if($input["cveGrupo"] > 1 || $input["cveGrupo"] ==1 && $input["condicion2"] == 1){
                switch ($input["condicion2"]) {
                    case 1:
                        $where = " and (abiertoUsuario =  :cve) ";
                    break;
                    case 2:
                        $where = " and (abiertoUsuario =  :cve or t.cveUsuario = :cve or t.cveGrupo = (select cveGroup from usuario where idUsuario = :cve)) ";
                    break;
                    case 3:
                        $where = " and ( (abiertoUsuario =  :cve or t.cveUsuario = :cve or t.cveGrupo = (select cveGroup from usuario where idUsuario = :cve)) and idEstadoTicket between 1 and 3 )";
                    break;
                    case 4:
                        $where = " and ( (abiertoUsuario =  :cve or t.cveUsuario = :cve or t.cveGrupo = (select cveGroup from usuario where idUsuario = :cve)) and idEstadoTicket between 1 and 3 )";
                    break;
                }
            }else{
                switch ($input["condicion2"]) {
                    case 3:
                        $where = " and  idEstadoTicket between 1 and 3 ";
                    break;
                    case 4:
                        $where = " and idEstadoTicket = 1 and nuevo = 0 ";
                    break;
                }
            }

            if( $input["buscar"] != NULL  || strlen($input["buscar"]) > 0 ){
                $input["buscar"] = strtolower($input["buscar"]);

                $buscarNormal = $input["buscar"]; 
               // $buscarizq ="%".$input["buscar"];
               // $buscardch = $input["buscar"]."%";
                $buscarAmb = "%".$input["buscar"]."%";
                $where2 = $where2." ( idTicket = :buscarNormal or
                lower(s.nombre) like  :buscarAmb or
                lower(g.nombre) like  :buscarAmb or 
                lower(u.usuario) like :buscarAmb or 
                lower(tt.nombre) like :buscarAmb or 
                lower(pt.nombre) like :buscarAmb or 
                lower(et.nombre) like :buscarAmb or 
                lower(ot.nombre) like  :buscarAmb or
                concat(fechaAbierta,', ',horaAbierta) like :buscarAmb or 
                concat(fechaCerrada,', ',horaCerrada) like :buscarAmb ";
                $cont = $cont +1 ;
            }

            if((int)$input["grupo"] != NULL || (int)$input["grupo"] > 0 ){
                if($cont == 0){
                    $where2 = $where2." ( idGrupo = :cveGrupo ";  
                }else{
                    $where2 = $where2." and idGrupo = :cveGrupo ";
                }
                $cont = $cont +1 ;
            }

            if(isset($input["agente"]) ){                
                if($input["agente"] > 0){
                    if($cont == 0){
                        $where2 = $where2." ( idUsuario = :usuario ";
                    }else{
                        $where2 = $where2." and idUsuario = :usuario ";
                    }
                    $cont = $cont +1;
                }
            }

            if((int)$input["tipo"] != NULL || $input["tipo"] > 0){
                if($cont == 0){
                    $where2 = $where2." ( t.tipo = :tipo ";
                }else{
                    $where2 = $where2." and t.tipo = :tipo ";
                }
                $cont = $cont +1 ;
            }

            if(isset($input["creador"]) ){
                if($input["creador"] > 0){
                if($cont == 0){
                    $where2 = $where2." ( abiertoUsuario = :cveCreado ";
                }else{
                    $where2 = $where2." and abiertoUsuario = :cveCreado ";
                }
                $cont = $cont +1 ;
                }
            }

            if($input["estados"] != NULL  || strlen($input["estados"]) > 0){
                if($cont == 0){
                    $where2 = $where2." ( t.estado in (".$input['estados'].") ";
                }else{
                    $where2 = $where2." and t.estado in (".$input['estados'].") ";
                }
                $cont = $cont +1 ;
            }

            if((int)$input["prioridad"] != NULL || $input["prioridad"] > 0){
                if($cont == 0){
                    $where2 = $where2." ( prioridad = :prioridad ";
                }else{
                    $where2 = $where2." and prioridad = :prioridad ";
                }
                    $cont = $cont +1 ;
            }

            if((int)$input["fuente"] != NULL || $input["fuente"] > 0){
                if($cont == 0){
                    $where2 = $where2." ( origen = :fuente ";
                }else{
                    $where2 = $where2." and origen = :fuente ";
                }
                $cont = $cont +1 ;
            }


            if($cont >0 ){
                $where2 = "where ".$where2." ) and t.eliminado = 0 ".$where;
            }else{
                $where2 = "where t.eliminado = 0 ".$where;
            }

            $consulta = "select concat(SUBSTRING_INDEX(identificador, '-', 2),'-',LPAD(contador, 4, 0),'-',SUBSTRING_INDEX(identificador, '-', -1)) identificador,idTicket, 
            s.nombre servicio, concat(fechaCerrada,', ',horaCerrada) fechaCerrada, 
            concat(fechaAbierta,', ',horaAbierta) fechaAbierta, t.estado,u.idUsuario, u.usuario agente, u.correo correoAgente, cveCliente, 
            c.nombre, idGrupo grupo, t.tipo,prioridad,origen,abiertoUsuario,  u2.correo correoAbiertoUsuario, u2.nombres nombreContacto,
            g.correo correoGrupo
            from 
            ticket t inner join grupo g on cveGrupo = idGrupo 
            inner join servicio s on cveServicio = idServicio 
            inner join usuario u on cveUsuario = u.idUsuario 
            inner join usuario u2 on abiertoUsuario = u2.idUsuario
            inner join cliente c on cveCliente = idCliente 
            inner join estadoTicket et on t.estado = idEstadoTicket
            inner join prioridadTicket pt on t.prioridad = idPrioridadTicket
            inner join tipoTicket tt on t.tipo = idTipoTicket
            inner join origenTicket ot on t.origen = idOrigenTicket  
            ".$where2." ".$orderby;
            $sql = $this->connect()->prepare($consulta);
        
            if((int)$input["grupo"] != NULL || $input["grupo"] > 0 ) {
                $sql->bindParam(':cveGrupo',$input["grupo"], PDO::PARAM_INT);
            }

            if($input["cveGrupo"] > 1 || $input["cveGrupo"] ==1 && $input["condicion2"] == 1) {
                $sql->bindParam(':cve',$input["cve"], PDO::PARAM_INT);
            }

            if(isset($input["agente"])) {
                if($input["agente"] > 0){
                    $sql->bindParam(':usuario',$input["agente"], PDO::PARAM_INT);
                }
            }

            if((int)$input["tipo"] != NULL || $input["tipo"] > 0 ) {
                $sql->bindParam(':tipo',$input["tipo"], PDO::PARAM_INT);
            }

            if(isset($input["creador"])) {
                if($input["creador"] > 0){
                    $sql->bindParam(':cveCreado',$input["creador"], PDO::PARAM_INT);
                }
            }

            if((int)$input["fuente"] != NULL || $input["fuente"] > 0){
                $sql->bindParam(':fuente',$input["fuente"], PDO::PARAM_INT);
            }

            if((int)$input["prioridad"] != NULL || $input["prioridad"] > 0){
                 $sql->bindParam(':prioridad',$input["prioridad"], PDO::PARAM_INT);
             }
           
             if( $input["buscar"] != NULL  || strlen($input["buscar"]) > 0 ){
               // $sql->bindParam(':buscarizq',$buscarizq, PDO::PARAM_STR,50);
               // $sql->bindParam(':buscardch',$buscardch, PDO::PARAM_STR,50);
                $sql->bindParam(':buscarAmb',$buscarAmb, PDO::PARAM_STR,50);
                $sql->bindParam(':buscarNormal',$buscarNormal, PDO::PARAM_STR,50);

             }
            $sql ->execute();

            return $sql->fetchAll(PDO::FETCH_ASSOC);
            
        }
    }
        