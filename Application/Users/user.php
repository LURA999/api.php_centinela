<?php
    include "../../Config/database.php";
    
    class user extends database {
    function getUsers($cve){
        if($cve == -1) {
            $sql = "select cve_usuario,nombre,nivel,email from tusuario u  where u.estatus=1 and idUsuario > 0";
            $sql = $this->connect()->prepare($sql);		
        }else{
            $sql = "select cve_usuario,nombre, email, nivel from tusuario u
            where u.cve_usuario = :cve and u.estatus=1 and idUsuario > 0";
            $sql = $this->connect()->prepare($sql);		
            $sql->bindParam(':cve',$cve, PDO::PARAM_INT);

        }
        $sql->execute();
        return $sql->fetchAll(PDO::FETCH_ASSOC);
    }

    function getUsersCities($id){
        $sql = "select * from usuario_ciudad us inner join Ciudades c on us.cve_ciudad = c.idciudad where us.cve_usuario = :cve_usuario";
        $sql = $this->connect()->prepare($sql);
        $sql->bindParam(':cve_usuario',$id, PDO::PARAM_INT);
        $sql->execute();
        return $sql->fetchAll(PDO::FETCH_ASSOC);
    }

    function updatedUser($cve){
        $sql = "update tusuario u set estatus=0 where u.cve_usuario = :cve";
        $sql = $this->connect()->prepare($sql);
        $sql->bindParam(':cve',$cve, PDO::PARAM_STR,20);
        $sql->execute();
        return $sql;
    }

    function deleteUser($cve) {
       
    }

    function insertUser($input){
        $sql = "insert into tusuario(nombre, email, nivel, contrasena, estatus)
        values(:nombre,:email,:nivel, :password ,1)";
        $sql = $this->connect()->prepare($sql);
        $sql->bindParam(':nombre',$input['nombre'], PDO::PARAM_STR,40);
        $sql->bindParam(':email',$input['email'], PDO::PARAM_STR,40);
        $sql->bindParam(':nivel',$input['nivel'], PDO::PARAM_INT);
        $sql->bindParam(':password', password_hash( $input['password'] , PASSWORD_DEFAULT), PDO::PARAM_STR);
        $sql->execute();
       $sql->setFetchMode(PDO::FETCH_ASSOC);
       $usuario = $sql->fetchAll();
        foreach($input['ciudades'] as $ciudad){
            $sql = $this->connect()->prepare("insert into usuario_ciudad VALUES(:ciudad,:cve,1,CURDATE()");
            $sql = bindParam(':cve',$usuario[0]['cve_usuario'], PDO::PARAM_INT);
            $sql = bindParam(':ciudad',$ciudad['idciudad'], PDO::PARAM_INT);
            $sql->execute();
        }
       return $sql;
    }

    function selectAllUsers(){
        $sql = "select idUsuario, usuario, nombres,apellidoPaterno,apellidoMaterno,correo from usuario where idUsuario > 0;";
        $sql = $this->connect()->prepare($sql);
        $sql->execute();
        return $sql->fetchAll(PDO::FETCH_ASSOC);
    }

    function showUsersRol($cve){
        $sql = $this->connect()->prepare("select idUsuario,usuario,nombres,apellidoPaterno,
        appelidoMaterno, u.correo from usuario where estatus = 1 and cveRol = :cve and idUsuario > 0");
        $sql -> bindParam(':cve', $cve , PDO::PARAM_INT);
        $sql->execute();
        return $sql->fetchAll(PDO::FETCH_ASSOC);      
    }

    function showUsersGroup($cveGroup){
        $sql = $this->connect()->prepare("select idUsuario,usuario,nombres,apellidoPaterno,
        apellidoMaterno, u.correo from usuario u inner join grupo on cveGroup = idGrupo where u.estatus = 1 and cveGroup = :cve and idUsuario > 0");
        $sql -> bindParam(':cve', $cveGroup , PDO::PARAM_INT);
        $sql -> execute();
        return $sql->fetchAll(PDO::FETCH_ASSOC);      
    }
}
    