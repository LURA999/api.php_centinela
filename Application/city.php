<?php
    include "../Config/database.php";
    
    class city extends database {
    function selectCities(){
        $sql = "select idCiudad,nombre,abreviado from ciudad";
        $sql = $this->connect()->prepare($sql);		
        $sql->execute();
        return $sql->fetchAll(PDO::FETCH_ASSOC);
    }

    function selectCityOnly( $cve){
        $sql = "select nombre,abreviado from ciudad where idCiudad=:id";
        $sql = $this->connect()->prepare($sql);		
        $sql->bindParam(':id',$cve, PDO::PARAM_INT);

        $sql->execute();
        return $sql->fetchAll(PDO::FETCH_ASSOC);
    }
    }