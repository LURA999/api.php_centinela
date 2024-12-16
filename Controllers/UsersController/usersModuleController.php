<?php

include_once '../../Application/Users/usersmodule.php';

class usersmoduleController
{
    private $obj;

    function __construct() {
        $this->obj = new usersModule();
    } 


    function createUsers($input){
        try{
        $this->obj = $this->obj->insertUsers($input);
        return  json_encode(
         array("status"=> "acepted",
            "info"=> "User add"));
 
        }catch(Exception $e){
        return json_encode(array("status"=> "error",
            "info"=> "error"));
        }
     }

     function createGroups($input){
        try{
        $this->obj = $this->obj->insertGroups($input);
        return  json_encode(
         array("status"=> "acepted",
            "info"=> "Group add"));
 
        }catch(Exception $e){
        return json_encode(array("status"=> "error",
            "info"=> "error"));
        }
     }


    function showUsers(){
        $this->obj = $this->obj->selectUsers();
        if(count($this->obj) == 0){
            return json_encode(array("status"=> "not found",
           "info"=> "not there Users",
           "container"=> []));
        }else{
            return json_encode(array("status"=> "found",
           "info"=> "yes there Users",
           "container"=> $this->obj));
        }
             
          }    

          function showUsersList($input){
            $this->obj = $this->obj->selectUsersList($input);
            if(count($this->obj) == 0){
                return json_encode(array("status"=> "not found",
               "info"=> "not there Lista",
               "container"=> []));
            }else{
                return json_encode(array("status"=> "found",
               "info"=> "yes there Lista",
               "container"=> $this->obj));
            }
                 
              }   



              function showUsersInfo($input){
                $this->obj = $this->obj->selectUsersInfo($input);
                if(count($this->obj) == 0){
                    return json_encode(array("status"=> "not found",
                   "info"=> "not there Info",
                   "container"=> []));
                }else{
                    return json_encode(array("status"=> "found",
                   "info"=> "yes there Info",
                   "container"=> $this->obj));
                }
                     
                  }   

                  function showGroupInfo($input){
                    $this->obj = $this->obj->selectGroupInfo($input);
                    if(count($this->obj) == 0){
                        return json_encode(array("status"=> "not found",
                       "info"=> "not there Info",
                       "container"=> []));
                    }else{
                        return json_encode(array("status"=> "found",
                       "info"=> "yes there Info",
                       "container"=> $this->obj));
                    }
                         
                      }   


          function showGroup(){
            $this->obj = $this->obj->selectGroup();
            if(count($this->obj) == 0){
                return json_encode(array("status"=> "not found",
               "info"=> "not there Users",
               "container"=> []));
            }else{
                return json_encode(array("status"=> "found",
               "info"=> "yes there Users",
               "container"=> $this->obj));
            }
                 
              }  


              function showRol(){
                $this->obj = $this->obj->selectRol();
                if(count($this->obj) == 0){
                    return json_encode(array("status"=> "not found",
                   "info"=> "not there Users",
                   "container"=> []));
                }else{
                    return json_encode(array("status"=> "found",
                   "info"=> "yes there Users",
                   "container"=> $this->obj));
                }
                     
                  }  
              
              function showGroupList(){
          
                $this->obj = $this->obj->selectGroupList();
                if(count($this->obj) == 0){
                    return json_encode(array("status"=> "not found",
                   "info"=> "not there Grupo",
                   "container"=> []));
                }else{
                    return json_encode(array("status"=> "found",
                   "info"=> "yes there Grupo",
                   "container"=> $this->obj));
                }
                     
                  }  

                  function changeUser($input){
          
                    $this->obj = $this->obj->updateUser($input);
                    if(count($this->obj) == 0){
                        return json_encode(array("status"=> "not found",
                       "info"=> "not Update User",
                       "container"=> []));
                    }else{
                        return json_encode(array("status"=> "found",
                       "info"=> "yes Update user",
                       "container"=> $this->obj));
                    }
                         
                      }  

                      function changeGroup($input){
          
                        $this->obj = $this->obj->updateGroup($input);
                        if(count($this->obj) == 0){
                            return json_encode(array("status"=> "not found",
                           "info"=> "not Update Grupo",
                           "container"=> []));
                        }else{
                            return json_encode(array("status"=> "found",
                           "info"=> "yes Update Grupo",
                           "container"=> $this->obj));
                        }
                             
                          }  

                      function removeUser($input){
          
                        $this->obj = $this->obj->deleteUser($input);
                        if(count($this->obj) == 0){
                            return json_encode(array("status"=> "not found",
                           "info"=> "not Remove user",
                           "container"=> []));
                        }else{
                            return json_encode(array("status"=> "found",
                           "info"=> "yes Remove user",
                           "container"=> $this->obj));
                        }
                             
                          }  


                          function removeGroup($input){
          
                            $this->obj = $this->obj->deleteGroup($input);
                            if(count($this->obj) == 0){
                                return json_encode(array("status"=> "not found",
                               "info"=> "not Remove Grupo",
                               "container"=> []));
                            }else{
                                return json_encode(array("status"=> "found",
                               "info"=> "yes Remove Grupo",
                               "container"=> $this->obj));
                            }
                                 
                              }  
}
