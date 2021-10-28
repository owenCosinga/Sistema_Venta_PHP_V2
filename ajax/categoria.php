<?php

require_once '../models/Categoria.php';

$categoria=new Categoria();

$id=isset($_POST['id'])? limpiarCadena($_POST['id']):"";
$nombre=isset($_POST['nombre'])? limpiarCadena($_POST['nombre']):"";
$descripcion=isset($_POST['descripcion'])? limpiarCadena($_POST['descripcion']):"";

//evaluar las operaciones mediante peticiones y devolver lo requerido
switch($_GET['op']){

    case 'guardaryeditar':

        if(empty($id)){
            $rspta=$categoria->insertar($nombre, $descripcion);
            echo $rspta ? 'categoria registrada' : 'categoria no se pudo registrar';
        }else{
            $rspta=$categoria->editar($id, $nombre, $descripcion);
            echo $rspta ? 'categoria actualizada' : 'categoria no se pudo actualizar';
        }
        break;

    case 'desactivar':
        $rspta=$categoria->desactivar($id);
        echo $rspta ? 'categoria desactivada' : 'categoria no se pudo desactivar';
        break;

    case 'activar':
        $rspta=$categoria->activar($id);
        echo $rspta ? 'categoria activada' : 'categoria no se pudo activar';
        break;

    case 'mostrar':
        $rspta=$categoria->mostrar($id);
        //codificar el resultado utilizando json
        echo json_encode($rspta);
        break; 
        
    case 'listar':
        $rspta=$categoria->listar();
        //declarar un array
        $data = Array();

        while($reg=$rspta->fetch_object()){

            $data[]= array(
                "0"=>$reg->id,
                "1"=>$reg->nombre,
                "2"=>$reg->descripcion,
                "3"=>$reg->estado,
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