<?php

require_once '../models/Persona.php';

$persona=new Persona();

$id=isset($_POST['id'])? limpiarCadena($_POST['id']):"";
$tipo_persona=isset($_POST['tipo_persona'])? limpiarCadena($_POST['tipo_persona']):"";
$nombre=isset($_POST['nombre'])? limpiarCadena($_POST['nombre']):"";
$tipo_documento=isset($_POST['tipo_documento'])? limpiarCadena($_POST['tipo_documento']):"";
$num_documento=isset($_POST['num_documento'])? limpiarCadena($_POST['num_documento']):"";
$direccion=isset($_POST['direccion'])? limpiarCadena($_POST['direccion']):"";
$telefono=isset($_POST['telefono'])? limpiarCadena($_POST['telefono']):"";
$email=isset($_POST['email'])? limpiarCadena($_POST['email']):"";

//evaluar las operaciones mediante peticiones y devolver lo requerido
switch($_GET['op']){

    case 'guardaryeditar':

        if(empty($id)){
            $rspta=$persona->insertar($tipo_persona, $nombre, $tipo_documento, $num_documento, $direccion, $telefono, $email);
            echo $rspta ? 'Persona registrada' : 'Persona no se pudo registrar';
        }else{
            $rspta=$persona->editar($id, $tipo_persona, $nombre, $tipo_documento, $num_documento, $direccion, $telefono, $email);
            echo $rspta ? 'Persona actualizada' : 'Persona no se pudo actualizar';
        }
        break;

    case 'eliminar':
        $rspta=$persona->eliminar($id);
        echo $rspta ? 'Persona eliminada' : 'Persona no se pudo eliminar';
        break;

    case 'mostrar':
        $rspta=$persona->mostrar($id);
        //codificar el resultado utilizando json
        echo json_encode($rspta);
        break; 
        
    case 'listarp':
        $rspta=$persona->listarp();
        //declarar un array
        $data = Array();

        while($reg=$rspta->fetch_object()){

            $data[]= array(
                "0"=>'<button class="btn btn-warning" onclick="mostrar('.$reg->id.')"><i class="fa fa-pencil"></i></button>'.
                '<button class="btn btn-danger" onclick="eliminar('.$reg->id.')"><i class="fa fa-trash"></i></button>',
                "1"=>$reg->nombre,
                "2"=>$reg->tipo_documento,
                "3"=>$reg->num_documento,
                "4"=>$reg->telefono,
                "5"=>$reg->email,
            );
        }

        $results = array(
            "sEcho"=>1, //informacion para el datatables
            "iTotalRecords"=>count($data), //enviamos el total registros al datatable
            "iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
            "aaData"=>$data);
        echo json_encode($results);
        
        break; 
        
        case 'listarc':
            $rspta=$persona->listarc();
            //declarar un array
            $data = Array();
    
            while($reg=$rspta->fetch_object()){
    
                $data[]= array(
                    "0"=>'<button class="btn btn-warning" onclick="mostrar('.$reg->id.')"><i class="fa fa-pencil"></i></button>'.
                    '<button class="btn btn-danger" onclick="eliminar('.$reg->id.')"><i class="fa fa-trash"></i></button>',
                    "1"=>$reg->nombre,
                    "2"=>$reg->tipo_documento,
                    "3"=>$reg->num_documento,
                    "4"=>$reg->telefono,
                    "5"=>$reg->email,
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