<?php
include "../../Application/Services/contacts.php";

class contactsControllers {
	
   private $obj;

    function __construct(){
        $this->obj = new contacts();
    }

    function createContact($input){ 
	 try{
        $this->obj = $this->obj->insertContact($input);
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

    function createDetailContact($input){ 
        try{
           $this->obj = $this->obj->insertDetailContact($input);
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

	function showContact($cve){
	 $this->obj = $this->obj->selectContact($cve);
     return $this->selectError($this->obj);
    }

    function showContactServices($cve){
        $this->obj = $this->obj->selectServicios_Contactos($cve);
        return $this->selectError($this->obj);
    }

	function changeContact($input){
	   try{
        $this->obj = $this->obj -> updateContact($input);
        echo json_encode(array(
            'status' => 'ok',
            'info' => 'contact updated',
            'container' => null
        ));
    }catch(Exception $e){
        return  json_encode(array('status'=>"error",
        'info'=>$e->getMessage(),
        'container'=>null));
    }
  }
	
	function deleteChangecontacts($cve){
    	   try{
        $this->obj = $this->obj -> deleteContact($cve);
        echo json_encode(array(
            'status' => 'ok',
            'info' => 'contacts deleted',
            'container' => null
        ));
    }catch(Exception $e){
        return  json_encode(array('status'=>"error",
        'info'=>$e->getMessage(),
        'container'=>null));
    }
  }  
  
  function showContactIdMax(){
    $this->obj = $this->obj->selectContactIdMax();
    return $this->selectError($this->obj);
  }

  function showContactsSelect($cve,$contador){
    $this->obj = $this->obj->selectContactsSelect($cve,$contador);  
    return $this->selectError($this->obj);
  }

  function showContactosOnlyServicio($cve,$contador,$condicion,$identificador){
    $this->obj = $this->obj->selectContactosOnlyServicio($cve,$contador,$condicion,$identificador);  
    return $this->selectError($this->obj);
  }

  function showContactos_Servicios($cveCliente, $identificador){
    $this->obj = $this->obj->selectContactos_Servicios($cveCliente, $identificador);
    return $this->selectError($this->obj);
  }

  function showServicePerContacto($identificador,$idContacto, $condicion){
    $this->obj = $this->obj->selectServicePerContacto($identificador,$idContacto,$condicion);
    return $this->selectError($this->obj);
  }

  function selectError($obj){
    if(count($obj)==0){
        return json_encode(array(
            "info" => "not found",
            "status" => "not there contacts",
            "container" => []
        ));
        }else{
        return json_encode(array(
            "info" => "found",
            "status" =>"there contacts",
            "container" => $this->obj
        ));
        }
  }
}
    
