<?php
include_once '../../Application/Users/userLogin.php';

class userLoginController {
    private $obj;

    function __construct() {
        $this->obj = new userLogin();
    } 

    function userLogin ($usuario, $contrasena, $tipo){
        $this->obj = $this->obj -> getLogin($usuario, $contrasena, $tipo);
      if($this->obj['error'] == 1){
            echo json_encode(array(
                'status' => 'not found',
                'info' => 'User not found',

            ));
        }else{
            echo json_encode(array(
                'status' => 'ok',
                'info' => 'User found',
                'container' => $this->createToken($this->obj)
            ));
        }
    }
    function userLoginPass ($input){
        try{
        $this->obj = $this->obj -> updateLoginPass($input);
        echo json_encode(array(
            'status' => 'ok',
            'info' => 'password updated',
            'container' => null
        ));
    }catch(Exception $e){
        return  json_encode(array('status'=>"error",
        'info'=>$e->getMessage(),
        'container'=>null));
    }
    }

    function userLoginLevel ($input){
        try{
        $this->obj = $this->obj -> updatedLoginLevel($input);
        echo json_encode(array(
            'status' => 'ok',
            'info' => 'password updated',
            'container' => null
        ));
    }catch(Exception $e){
        return  json_encode(array('status'=>"error",
        'info'=>$e->getMessage(),
        'container'=>null));
    }
    }
    
    function createToken($info)
    {
        $headers = ['alg' => 'HS256', 'typ' => 'JWT'];
        $headers_encoded = base64_encode(json_encode($headers));
        $payload = ['cveRol' => $info['cveRol'],
        'tipo'=> $info['tipo'],
        'estatus'=> $info['estatus'],
        'nombres'=> $info['nombres'],
        'correo'=> $info['correo'],
        'grupo'=> $info['grupo'],
        'id' => $info["id"],
         'expire'=>microtime(true)];
        $payload_encoded = base64_encode(json_encode($payload));
        $key = 'secret';
        $signature = hash_hmac('SHA256', "$headers_encoded.$payload_encoded", $key, true);
        $signature_encoded = base64_encode($signature);
        $token = "$headers_encoded.$payload_encoded.$signature_encoded";
        return $token;

    }
}

?>