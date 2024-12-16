<?php

require '../../Config/database.php';

class userLogin extends database{

    function base64url_encode($data) {
        return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
    }

    function getLogin($contrasena, $usuario, $tipo){

    $usuario = base64_decode($usuario);
    $contrasena = base64_decode($contrasena);
    
    $query = $this->getUser($usuario,$tipo);
    $cuenta = $query -> rowCount();
    
    if($cuenta > 0)
    {
        while($row = $query->fetch(PDO::FETCH_NUM))
        {
           // echo var_dump($row);
            if(password_verify($contrasena,$row[5]))
            {
                $headers = ['alg'=>'HS256','typ'=>'JWT'];
                $headers_encoded = $this->base64url_encode(json_encode($headers));

                $payload = ['sub'=>$row[0],'name'=>$row[3],'email'=>$row[4],'time'=>3600];
                $payload_encoded = $this->base64url_encode(json_encode($payload));
                
                $key = 'secret';
                $signature = hash_hmac('SHA256',"$headers_encoded.$payload_encoded",$key,true);
                $signature_encoded = $this->base64url_encode($signature);

                $token = "$headers_encoded.$payload_encoded.$signature_encoded";
                return array("error"=>false,"cveRol"=>$row[0],"tipo"=>$row[1],"estatus"=>$row[2],"nombres"=>$row[3],"correo"=>$row[4],"id"=>$row[6], "grupo"=>$row[7]);
                exit();

            }else{
                $err = array('error' => true);
                return $err;
            }
        }
    }else{
        $err = array('error' => true);
        return $err;
    }
     
    }

    function getUser($usuario,$tipo){
        $sql = $this->connect()->prepare('select cveRol,tipo,u.estatus,u.nombres,u.correo,u.contrasena,idUsuario, 
        cveGroup grupo from usuario u inner join grupo g on cveGroup=idgrupo inner join rol r on cveRol=idRol  where u.correo = :usuario and u.estatus=1 and tipo='.$tipo);
        $sql->bindparam(':usuario', $usuario, PDO::PARAM_STR,50);
        $sql->execute();
        return $sql;
    }
   

    function updateLoginPass($input){
        $sql = $this->connect()->prepare('update usuario u set u.contrasena = :contrasena where u.cve_usuario = :cve_usuario');
        $sql->bindparam(':contrasena', password_hash( $input["contrasena"], PASSWORD_DEFAULT) , PDO::PARAM_STR);
        $sql->bindparam(':cve_usuario', $input['id'], PDO::PARAM_INT);
        $sql->execute();
        return $sql;
    }


    function updatedLoginLevel($input){
        $sql = $this->connect()->prepare('update usuario u set u.nivel = :nivel where u.cve_usuario = :id');
        $sql->bindparam(':nivel', $input['nivel'], PDO::PARAM_STR,40);
        $sql->bindparam(':id', $input['id'], PDO::PARAM_INT);
        $sql->execute();
        return $sql;
    }

}


?>