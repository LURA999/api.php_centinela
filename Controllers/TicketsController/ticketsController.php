<?php
include "../../Application/Tickets/tickets.php";

class ticketsController {

    private $obj;

    function __construct(){
        $this->obj = new tickets();
    }

    function createTicket($input){
    try{
        $this->obj = $this->obj->insertTicket($input);
        return json_encode(array(
            "info" => "inserted",
            "status" => "inserted achieved"
        ));
    }catch(Exception $e){
        return json_encode(array(
            "info" => "fail",
            "status" => "inserted not successful"
        ));
    }
    }

   function showTicketCustomer($cve,$identificador){
    
        $this->obj = $this->obj->selectTicketCustomer($cve,$identificador);
        if(count($this->obj)==0){
        return json_encode(array(
            "info" => "not found",
            "status" => "not there tickets",
            "container" => []
        ));
        }else{
        return json_encode(array(
            "info" => "found",
            "status" =>"there tickets",
            "container" => $this->obj
        ));
        }
    }
    function showAllHistorial($cve){
        $this->obj = $this->obj->selectAllHistorial($cve);
        if(count($this->obj)==0){
        return json_encode(array(
            "info" => "not found",
            "status" => "not there ticket",
            "container" => []
        ));
        }else{
        return json_encode(array(
            "info" => "found",
            "status" =>"there ticket",
            "container" => $this->obj
        ));
        }
    }
    function showOneticket($cve){
        $this->obj = $this->obj->selectOneTicket($cve);
        if(count($this->obj)==0){
        return json_encode(array(
            "info" => "not found",
            "status" => "not there ticket",
            "container" => []
        ));
        }else{
        return json_encode(array(
            "info" => "found",
            "status" =>"there ticket",
            "container" => $this->obj
        ));
        }
    }

    function showTicket($cond,$cve){
    
        $this->obj = $this->obj->selectTicket($cond,$cve);
        if(count($this->obj)==0){
        return json_encode(array(
            "info" => "not found",
            "status" => "not there ticket",
            "container" => []
        ));
        }else{
        return json_encode(array(
            "info" => "found",
            "status" =>"there ticket",
            "container" => $this->obj
        ));
        }
    }
    function changeDeleteTicket($cve){
    
        try{
        $this->obj = $this->obj -> deleteTicket($cve);
        echo json_encode(array(
            'status' => 'ok',
            'info' => 'ticket deleted',
            'container' => null
        ));
    }catch(Exception $e){
        return  json_encode(array('status'=>"error",
        'info'=>$e->getMessage(),
        'container'=>null));
    }
   }

    function changeTicket($input){
       try{
        $this->obj = $this->obj -> deleteTicket($input);
        echo json_encode(array(
            'status' => 'ok',
            'info' => 'changed ticket',
            'container' => null
        ));
    }catch(Exception $e){
        return  json_encode(array('status'=>"error",
        'info'=>$e->getMessage(),
        'container'=>null));
    }
   }

   function changeEstate($input){
    try{
     $this->obj = $this->obj -> updateEstate($input);
     echo json_encode(array(
         'status' => 'ok',
         'info' => 'changed ticket',
         'container' => null
     ));
 }catch(Exception $e){
     return  json_encode(array('status'=>"error",
     'info'=>$e->getMessage(),
     'container'=>null));
 }
}

function insertComment($input){
$this->obj = $this->obj -> insertComment($input);
if(count($this->obj)==0){
        return json_encode(array(
            "info" => "not found",
            "status" => "not there tickets",
            "container" => []
        ));
        }else{
        return json_encode(array(
            "info" => "found",
            "status" =>"there tickets",
            "container" => $this->obj
        ));
        }
}

function changeProperty($input){
    try{
     $this->obj = $this->obj -> updateProperty($input);
     echo json_encode(array(
         'status' => 'ok',
         'info' => 'changed ticket',
         'container' => null
     ));
 }catch(Exception $e){
     return  json_encode(array('status'=>"error",
     'info'=>$e->getMessage(),
     'container'=>null));
 }
}

function changeGroup($input){
    try{
     $this->obj = $this->obj -> updateGroup($input);
     echo json_encode(array(
         'status' => 'ok',
         'info' => 'changed ticket',
         'container' => $this->obj
     ));
 }catch(Exception $e){
     return  json_encode(array('status'=>"error",
     'info'=>$e->getMessage(),
     'container'=>null));
 }
}
function changeType($input){
    try{
     $this->obj = $this->obj -> updateType($input);
     echo json_encode(array(
         'status' => 'ok',
         'info' => 'changed ticket',
         'container' => null
     ));
 }catch(Exception $e){
     return  json_encode(array('status'=>"error",
     'info'=>$e->getMessage(),
     'container'=>null));
 }
}
function changeAgente($input){
    try{
     $this->obj = $this->obj -> updateAgente($input);
     echo json_encode(array(
         'status' => 'ok',
         'info' => 'changed ticket',
         'container' => null
     ));
 }catch(Exception $e){
     return  json_encode(array('status'=>"error",
     'info'=>$e->getMessage(),
     'container'=>null));
 }
}
}
