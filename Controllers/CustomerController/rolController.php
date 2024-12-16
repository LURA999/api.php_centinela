<?php

require '../../Application/Customer/rol.php';//tengo un error y se detenga el programa

class rolController
{
    private $obj;

    function __construct() {
        $this->obj = new rol();
    } 

    function listRol(){
        $this->obj = $this->obj -> getRol();
        if(count($this->obj) == 0){
            echo json_encode(array(
                'status' => 'not found',
                'info' => 'Rol not found',
                'container' => []
            ));
        }else{
            echo json_encode(array(
                'status' => 'ok',
                'info' => 'Rol found',
                'container' => $this->obj
            ));
        }
    }

    function listRolAll (){
        $this->obj = $this->obj -> getCustomerAll();
        if(count($this->obj) == 0){
            echo json_encode(array(
                'status' => 'not found',
                'info' => 'Rol not found',
                'container' => []
            ));
        }else{
            echo json_encode(array(
                'status' => 'ok',
                'info' => 'Rol found',
                'container' => $this->obj
            ));
        }
    }


    function insertRol($input){
        try{
            $this->obj->insertRol($input);
            return  json_encode(array('status'=>"ok",
            'info'=>"Customer add",
            'container'=>null));
        }catch(Exception $e){
            return  json_encode(array('status'=>"error",
            'info'=>$e->getMessage(),
            'container'=>null));
        }
    }


    function eliminarFalso($clave){
            $this->obj->updateEliminar($clave);
            return  json_encode(array('status'=>"ok",
            'info'=>"Customer updated",
            'container'=>null));
    }

    function actualizarrol($clave){
        $this->obj->updateRol($clave);
        return  json_encode(array('status'=>"ok",
        'info'=>"Customer updated",
        'container'=>null));
}

}

