<?php

if(strlen(session_id()) < 1)
    session_start();

require_once '../models/Ingreso.php';

$ingreso=new Ingreso();

$id=isset($_POST['id'])? limpiarCadena($_POST['id']):"";
$idproveedor=isset($_POST['idproveedor'])? limpiarCadena($_POST['idproveedor']):"";
$idusuario=$_SESSION['id'];
$tipo_comprobante=isset($_POST['tipo_comprobante'])? limpiarCadena($_POST['tipo_comprobante']):"";
$serie_comprobante=isset($_POST['serie_comprobante'])? limpiarCadena($_POST['serie_comprobante']):"";
$num_comprobante=isset($_POST['num_comprobante'])? limpiarCadena($_POST['num_comprobante']):"";
$fecha_hora=isset($_POST['fecha_hora'])? limpiarCadena($_POST['fecha_hora']):"";
$impuesto=isset($_POST['impuesto'])? limpiarCadena($_POST['impuesto']):"";
$total_compra=isset($_POST['total_compra'])? limpiarCadena($_POST['total_compra']):"";

//evaluar las operaciones mediante peticiones y devolver lo requerido
switch($_GET['op']){

    case 'guardaryeditar':

        if(empty($id)){
            $rspta=$ingreso->insertar($idproveedor, $idusuario, $tipo_comprobante, $serie_comprobante, 
            $num_comprobante, $fecha_hora, $impuesto, $total_compra, $_POST['idusuario'], $_POST['cantidad'], 
            $_POST['precio_compra'], $_POST['precio_venta']);
            echo $rspta ? 'ingreso registrado' : 'No se pudieron registrar todos los datos del ingreso';
        }else{
        }
        break;

    case 'anular':
        $rspta=$ingreso->anular($id);
        echo $rspta ? 'ingreso anulado' : 'ingreso no se pudo anular';
        break;

    case 'mostrar':
        $rspta=$ingreso->mostrar($id);
        //codificar el resultado utilizando json
        echo json_encode($rspta);
        break; 
        
    case 'listar':
        $rspta=$ingreso->listar();
        //declarar un array
        $data = Array();

        while($reg=$rspta->fetch_object()){

            $data[]= array(
                "0"=>($reg->estado=='Aceptado')?'<button class="btn btn-warning" onclick="mostrar('.$reg->id.')"><i class="fa fa-pencil"></i></button>'.
                '<button class="btn btn-danger" onclick="anular('.$reg->id.')"><i class="fa fa-close"></i></button>':
                '<button class="btn btn-warning" onclick="mostrar('.$reg->id.')"><i class="fa fa-pencil"></i></button>',
                "1"=>$reg->fecha,
                "2"=>$reg->proveedor,
                "3"=>$reg->usuario,
                "4"=>$reg->tipo_comprobante,
                "5"=>$reg->serie_comprobante. '-' .$reg->num_comprobante,
                "6"=>$reg->total_compra,
                "7"=>($reg->estado=='Aceptado')?'<span class="label bg-green">Aceptado</span>':'<span class="label bg-red">Anulado</span>',
            );
        }

        $results = array(
            "sEcho"=>1, //informacion para el datatables
            "iTotalRecords"=>count($data), //enviamos el total registros al datatable
            "iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
            "aaData"=>$data);
        echo json_encode($results);
        
        break;     

        case 'selectProveedor':
            require_once "../models/Persona.php";
            $persona = new Persona();

            $rspta=$persona->listarp();

            while($reg=$rspta->fetch_object()){
                    echo '<option value=' .$reg->id . '>' . $reg->nombre . '</option>';
            }
        break;     

            case 'listarArticulos':
                require_once "../models/Articulo.php";
                $articulo=new Articulo();
        
                $rspta=$articulo->listarActivos();
                //Vamos a declarar un array
                $data= Array();
        
                while ($reg=$rspta->fetch_object()){
                    $data[]=array(
                        "0"=>'<button class="btn btn-warning" onclick="agregarDetalle('.$reg->id.',\''.$reg->nombre.'\')"><span class="fa fa-plus"></span></button>',
                        "1"=>$reg->nombre,
                        "2"=>$reg->categoria,
                        "3"=>$reg->codigo,
                        "4"=>$reg->stock,
                        "5"=>"<img src='../files/articulos/".$reg->imagen."' height='50px' width='50px' >"
                        );
                }
                $results = array(
                    "sEcho"=>1, //Información para el datatables
                    "iTotalRecords"=>count($data), //enviamos el total registros al datatable
                    "iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
                    "aaData"=>$data);
                echo json_encode($results);
            break;    

}

?>