<?php
include '../../Application/Tickets/ticketDashboard.php';
class ticketControllerDashboard {
    private $obj;

    function __construct (){
        $this->obj = new ticketDashboard();
    }

    function selectType($fechaf,$fechai,$tipo,$cveGrupo){
        try {
            $this->obj = $this->obj->selectType($fechaf,$fechai,$tipo,$cveGrupo);
            if(count($this->obj) > 0){
                echo json_encode(array('estatus' => "found", 
                'info' => "found ticket",
                'container' => $this->obj));
            }else{
                echo json_encode(array('estatus' => "not found", 
                "info" => "not found ticket",
                "container" => []));
            }
        }catch(Exception $e){
            echo json_encode(array('estatus' => "error", 
            'info' => "error syntax",
            'container' => $e));
        }
    }
    function selectTicket($fechaf,$fechai,$filtro,$cliente,$cveGrupo){
        try {
            $this->obj = $this->obj->selectTicket($fechaf,$fechai,$filtro,$cliente,$cveGrupo);
            if(count($this->obj) > 0){
                echo json_encode(array('estatus' => "found", 
                'info' => "found ticket",
                'container' => $this->obj));
            }else{
                echo json_encode(array('estatus' => "not found", 
                "info" => "not found ticket",
                "container" => []));
            }
        }catch(Exception $e){
            echo json_encode(array('estatus' => "error", 
            'info' => "error syntax",
            'container' => $e));
        }
    }
}