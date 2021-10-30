<?php

require_once '../models/Permiso.php';

$permiso=new Permiso();

//evaluar las operaciones mediante peticiones y devolver lo requerido
switch($_GET['op']){
     
    case 'listar':
        $rspta=$permiso->listar();
        //declarar un array
        $data = Array();

        while($reg=$rspta->fetch_object()){

            $data[]= array(
                "0"=>$reg->nombre,
            );
        }

        $results = array(
            "sEcho"=>1, //informacion para el datatables
            "iTotalRecords"=>count($data), //enviamos el total registros al datatable
            "iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
            "aaData"=>$data);
        echo json_encode($results);
        
        break;     


}

?>