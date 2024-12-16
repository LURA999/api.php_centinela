<?php

include_once '../../Application/Users/user.php';

class usersController
{
    private $obj;

    function __construct() {
        $this->obj = new user();
    } 

    function listUsers ($clave){
        $this->obj = $this->obj -> getUsers($clave);
        if(count($this->obj) == 0){
            echo json_encode(array(
                'status' => 'not found',
                'info' => 'User not found',
                'container' => []
            ));
        }else{
            echo json_encode(array(
                'status' => 'ok',
                'info' => 'User found',
                'container' => $this->obj
            ));
        }
    }

    function listUsersCities($id){
        $this->obj = $this->obj -> getUsersCities($id);
        if(count($this->obj) == 0){
            echo json_encode(array(
                'status' => 'not found',
                'info' => 'User not found',
                'container' => []
            ));
        }else{
            echo json_encode(array(
                'status' => 'ok',
                'info' => 'User found',
                'container' => $this->obj
            ));
        }
    }

    function insertUser($input){
        try{
            $this->obj->insertUser($input);
            return  json_encode(array('status'=>"ok",
            'info'=>"user add",
            'container'=>null));
        }catch(Exception $e){
            return  json_encode(array('status'=>"error",
            'info'=>$e->getMessage(),
            'container'=>null));
        }
    }

    function changeUser($cve){
        try{
            $this->obj->updatedUser($cve);
            return  json_encode(array('status'=>"ok",
            'info'=>"updated user",
            'container'=>null));
        }catch(Exception $e){
            return  json_encode(array('status'=>"error",
            'info'=>$e->getMessage(),
            'container'=>null));
        }
    }

    function deleteUser(){
        try{
            $this->obj->deleteUser();
            return  json_encode(array('status'=>"ok",
            'info'=>"User Updated",
            'container'=>null));
        }catch(Exception $e){
            return  json_encode(array('status'=>"error",
            'info'=>$e->getMessage(),
            'container'=>null));
        }
    }

    function getUsuariobyid()
    {
        try{
            $this->obj = $this->obj->usuarioById();
            if(count($this->obj) == 0){
                return  json_encode(array('status'=>"not found",
                'info'=>"Sin resultados",
                'container'=>null));
            }else{
                return  json_encode(array('status'=>"ok",
                'info'=>"user found",
                'container'=>$this->obj));
            }
        }catch(Exception $e){
            return  json_encode(array('status'=>"error",
            'info'=>$e->getMessage(),
            'container'=>null));
        }
    }

    function listAllUsers(){
        $this->obj = $this->obj -> selectAllUsers();
        if(count($this->obj) == 0){
            echo json_encode(array(
                'status' => 'not found',
                'info' => 'User not found',
                'container' => []
            ));
        }else{
            echo json_encode(array(
                'status' => 'ok',
                'info' => 'Users found',
                'container' => $this->obj
            ));
        }
    }


    function listUsersRol($cve){
        $this->obj = $this->obj-> showUsersRol($cve);
        if(count($this->obj) == 0){
            echo json_encode(array(
                'status' => 'not found',
                'info' => 'User not found',
                'container' => []
            ));
        }else{
            echo json_encode(array(
                'status' => 'ok',
                'info' => 'Users found',
                'container' => $this->obj
            ));
        }
    }

    function listUsersGroup($cve){
        $this->obj = $this->obj-> showUsersGroup($cve);
        if(count($this->obj) == 0){
            echo json_encode(array(
                'status' => 'not found',
                'info' => 'User not found',
                'container' => []
            ));
        }else{
            echo json_encode(array(
                'status' => 'ok',
                'info' => 'Users found',
                'container' => $this->obj
            ));
        }
    }
}
