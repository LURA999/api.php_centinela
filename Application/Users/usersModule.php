<?php
    include "../../Config/database.php";
    
    class usersModule extends database {
        function insertUsers($input){
            
            $sql = $this->connect()->prepare("insert into usuario
            (usuario,nombres,apellidoPaterno,apellidoMaterno,correo,contrasena,estatus,cveGroup) values(:usuario, :nombres , :apellidoPaterno, :apellidoMaterno, :correo, :contrasena , :estatus , :cveGroup)");
            $sql->bindParam(":usuario",$input["usuario"],PDO::PARAM_STR);
            $sql->bindParam(":nombres",$input["nombres"],PDO::PARAM_STR);
            $sql->bindParam(":apellidoPaterno",$input["apellidoPaterno"],PDO::PARAM_STR,40);
            $sql->bindParam(":apellidoMaterno",$input["apellidoMaterno"],PDO::PARAM_STR,40);
            $sql->bindParam(":correo",$input["correo"],PDO::PARAM_STR,60);
            $sql->bindparam(':contrasena', password_hash( $input["contrasena"], PASSWORD_DEFAULT) , PDO::PARAM_STR);
            $sql->bindParam(":estatus",$input["estatus"],PDO::PARAM_STR);
            $sql->bindParam(":cveGroup",$input["cveGroup"],PDO::PARAM_STR);

            $sql ->execute();
            return $sql;
        }

        function insertGroups($input){
          
            $sql = $this->connect()->prepare("insert into grupo
            (nombre,cveRol,estatus,correo) values( :nombre , :cveRol, :estatus, :correo)");
            $sql->bindParam(":cveRol",$input["cveRol"],PDO::PARAM_INT);
            $sql->bindParam(":nombre",$input["nombre"],PDO::PARAM_STR);
            $sql->bindParam(":estatus",$input["estatus"],PDO::PARAM_INT);
            $sql->bindParam(":correo",$input["correo"],PDO::PARAM_STR);

            $sql ->execute();
            return $sql;
        }

     
        function selectGroup(){
            $sql = $this->connect()->prepare(" select idGrupo,correo, nombre from grupo where eliminado=0");
            $sql ->execute();
            return $sql->fetchAll(PDO::FETCH_ASSOC); 
      }

      function selectRol(){
        $sql = $this->connect()->prepare(" select idRol, nombre from rol");
        $sql ->execute();
        return $sql->fetchAll(PDO::FETCH_ASSOC); 
  }


      function selectGroupList(){
        $sql = $this->connect()->prepare(" select idGrupo,count(cveGroup)  as agentes  , g.nombre, g.correo from usuario u right join grupo g on cveGroup=idgrupo where g.eliminado=0 group by idGrupo");
        $sql ->execute();
        return $sql->fetchAll(PDO::FETCH_ASSOC); 

    }

      function selectUsers(){
            $sql = $this->connect()->prepare(" select idUsuario, u.usuario, g.nombre grupo, u.estatus, r.nombre rol from usuario u 
            inner join grupo g  on cveGroup = idgrupo 
            inner join rol r on cveRol = idrol where u.eliminado= 0 order by idUsuario asc ");
            $sql ->execute();
            return $sql->fetchAll(PDO::FETCH_ASSOC); 
 
        }

        function selectUsersList($input){
            $sql = $this->connect()->prepare(" select idUsuario, usuario, concat(nombres,' ',apellidoPaterno,' ',apellidoMaterno) as nombre from usuario where cveGroup= :id and eliminado= 0" );
            
            $sql->bindParam(":id",$input,PDO::PARAM_INT);
            $sql ->execute();
            return $sql->fetchAll(PDO::FETCH_ASSOC); 
 
        }

        function selectUsersInfo($input){
            $sql = $this->connect()->prepare("  select usuario, nombres, apellidoPaterno, apellidoMaterno, correo, estatus,cveGroup from usuario where idUsuario= :id");
            
            $sql->bindParam(":id",$input,PDO::PARAM_INT);
            $sql ->execute();
            return $sql->fetchAll(PDO::FETCH_ASSOC); 
 
        }

        function selectGroupInfo($input){
            $sql = $this->connect()->prepare("  select nombre, cveRol, estatus, correo from grupo where idGrupo= :id");
            $sql->bindParam(":id",$input,PDO::PARAM_INT);
            $sql ->execute();
            return $sql->fetchAll(PDO::FETCH_ASSOC); 
 
        }

        function updateUser($input){
            $sql = $this->connect()->prepare(" update usuario set nombres = :nombres , usuario= :usuario, apellidoPaterno= :apellidoPaterno, apellidoMaterno= :apellidoMaterno, correo= :correo, estatus= :estatus ,cveGroup= :cveGroup where idUsuario = :id");
            $sql->bindParam(":id",$input["id"],PDO::PARAM_INT);
            $sql->bindParam(":nombres",$input["nombres"],PDO::PARAM_STR);
            $sql->bindParam(":estatus",$input["estatus"],PDO::PARAM_INT);
            $sql->bindParam(":usuario",$input["usuario"],PDO::PARAM_STR);
            $sql->bindParam(":apellidoPaterno",$input["apellidoPaterno"],PDO::PARAM_STR);
            $sql->bindParam(":apellidoMaterno",$input["apellidoMaterno"],PDO::PARAM_STR);
            $sql->bindParam(":correo",$input["correo"],PDO::PARAM_STR);
            $sql->bindParam(":cveGroup",$input["cveGroup"],PDO::PARAM_INT);
            $sql ->execute();
            return $sql->fetchAll(PDO::FETCH_ASSOC); 
 
        }

        function updateGroup($input){
           
            $sql = $this->connect()->prepare(" update grupo set nombre = :nombre, estatus= :estatus, cveRol= :cveRol, correo= :correo where idGrupo = :id");
            $sql->bindParam(":id",$input["id"],PDO::PARAM_INT);
            $sql->bindParam(":nombre",$input["nombre"],PDO::PARAM_STR);
            $sql->bindParam(":estatus",$input["estatus"],PDO::PARAM_INT);
            $sql->bindParam(":cveRol",$input["cveRol"],PDO::PARAM_INT);
            $sql->bindParam(":correo",$input["correo"],PDO::PARAM_STR);

            $sql ->execute();
            return $sql->fetchAll(PDO::FETCH_ASSOC); 
 
        }

        function deleteUser($input){
            $sql = $this->connect()->prepare("update usuario set eliminado=1 where idUsuario = :id ;");
            $sql->bindParam(":id",$input,PDO::PARAM_INT);
            $sql ->execute();
            return $sql->fetchAll(PDO::FETCH_ASSOC); 
        }

        function deleteGroup($input){

            $sql = $this->connect()->prepare("update grupo set eliminado=1 where idGrupo = :id");
            $sql->bindParam(":id",$input,PDO::PARAM_INT);
            $sql ->execute();
            return $sql->fetchAll(PDO::FETCH_ASSOC); 
        }
        
        
        }
        
        
        