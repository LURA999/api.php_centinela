<?php

require '../../Application/Customer/customer.php';//tengo un error y se detenga el programa

class customerController
{
    private $obj;

    function __construct() {
        $this->obj = new customer();
    } 

    function listCustomer ($clave){
        $this->obj = $this->obj -> getCustomer($clave);
        if(count($this->obj) == 0){
            echo json_encode(array(
                'status' => 'not found',
                'info' => 'Customer not found',
                'container' => []
            ));
        }else{
            echo json_encode(array(
                'status' => 'ok',
                'info' => 'Customer found',
                'container' => $this->obj
            ));
        }
    }

    function listCustomerAll (){
        $this->obj = $this->obj -> getCustomerAll();
        if(count($this->obj) == 0){
            echo json_encode(array(
                'status' => 'not found',
                'info' => 'Customer not found',
                'container' => []
            ));
        }else{
            echo json_encode(array(
                'status' => 'ok',
                'info' => 'Customer found',
                'container' => $this->obj
            ));
        }
    }


    function insertCustomer($input){
        try{
            $this->obj->insertCustomer($input);
            return  json_encode(array('status'=>"ok",
            'info'=>"Customer add",
            'container'=>null));
        }catch(Exception $e){
            return  json_encode(array('status'=>"error",
            'info'=>$e->getMessage(),
            'container'=>null));
        }
    }

    function countNombre($clave){
         $this->obj = $this->obj -> getCountNombre($clave);
        if(count($this->obj) == 0){
            echo json_encode(array(
                'status' => 'not found',
                'info' => 'Customer not found',
                'container' => []
            ));
        }else{
            echo json_encode(array(
                'status' => 'ok',
                'info' => 'Customer found',
                'container' => $this->obj
            ));
        }
    }

    function searchCustomer($clave){
        $this->obj = $this->obj -> getCustomerOnly($clave);
       if(count($this->obj) == 0){
           echo json_encode(array(
               'status' => 'not found',
               'info' => 'Customer not found',
               'container' => []
           ));
       }else{
           echo json_encode(array(
               'status' => 'ok',
               'info' => 'Customer found',
               'container' => $this->obj
           ));
       }
   }
    function eliminarFalso($clave){
            $this->obj->updateEliminar($clave);
            return  json_encode(array('status'=>"ok",
            'info'=>"Customer updated",
            'container'=>null));
    }

    function actualizarCliente($clave){
        $this->obj->updateCliente($clave);
        return  json_encode(array('status'=>"ok",
        'info'=>"Customer updated",
        'container'=>null));
}

}

