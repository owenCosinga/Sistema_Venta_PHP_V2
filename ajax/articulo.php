<?php

require_once '../models/Articulo.php';

$articulo=new Articulo();

$id=isset($_POST['id'])? limpiarCadena($_POST['id']):"";
$idcategoria=isset($_POST['idcategoria'])? limpiarCadena($_POST['idcategoria']):"";
$codigo=isset($_POST['codigo'])? limpiarCadena($_POST['codigo']):"";
$nombre=isset($_POST['nombre'])? limpiarCadena($_POST['nombre']):"";
$stock=isset($_POST['stock'])? limpiarCadena($_POST['stock']):"";
$descripcion=isset($_POST['descripcion'])? limpiarCadena($_POST['descripcion']):"";
$imagen=isset($_POST['imagen'])? limpiarCadena($_POST['imagen']):"";

//evaluar las operaciones mediante peticiones y devolver lo requerido
switch($_GET['op']){

    case 'guardaryeditar':

        if (!file_exists($_FILES['imagen']['tmp_name']) || !is_uploaded_file($_FILES['imagen']['tmp_name']))
		{
			$imagen=$_POST["imagenactual"];
		}
		else 
		{
			$ext = explode(".", $_FILES["imagen"]["name"]);
			if ($_FILES['imagen']['type'] == "image/jpg" || $_FILES['imagen']['type'] == "image/jpeg" || $_FILES['imagen']['type'] == "image/png")
			{
				$imagen = round(microtime(true)) . '.' . end($ext);
				move_uploaded_file($_FILES["imagen"]["tmp_name"], "../files/articulos/" . $imagen);
			}
		}

        if(empty($id)){
            $rspta=$articulo->insertar($idcategoria, $codigo, $nombre, $stock, $descripcion, $imagen);
            echo $rspta ? 'articulo registrado' : 'articulo no se pudo registrar';
        }else{
            $rspta=$articulo->editar($id, $idcategoria, $codigo, $nombre, $stock, $descripcion, $imagen);
            echo $rspta ? 'articulo actualizado' : 'articulo no se pudo actualizar';
        }
        break;

    case 'desactivar':
        $rspta=$articulo->desactivar($id);
        echo $rspta ? '<h2>articulo desactivado</h2>' : '<h2>articulo no se pudo desactivar</h2>';
        break;

    case 'activar':
        $rspta=$articulo->activar($id);
        echo $rspta ? '<h2>articulo activado</h2>' : '<h2>articulo no se pudo activar</h2>';
        break;

    case 'mostrar':
        $rspta=$articulo->mostrar($id);
        //codificar el resultado utilizando json
        echo json_encode($rspta);
        break; 

    case 'listar':
        $rspta=$articulo->listar();
        //declarar un array
        $data = Array();

        while($reg=$rspta->fetch_object()){

            $data[]= array(
                "0"=>($reg->estado)?'<button class="btn btn-warning" onclick="mostrar('.$reg->id.')"><i class="fa fa-pencil"></i></button>'.
                '<button class="btn btn-danger" onclick="desactivar('.$reg->id.')"><i class="fa fa-close"></i></button>':
                '<button class="btn btn-warning" onclick="mostrar('.$reg->id.')"><i class="fa fa-pencil"></i></button>'.
                '<button class="btn btn-primary" onclick="activar('.$reg->id.')"><i class="fa fa-check"></i></button>',
                "1"=>$reg->nombre,
                "2"=>$reg->categoria,
                "3"=>$reg->codigo,
                "4"=>$reg->stock,
                "5"=>"<img src='../files/articulos/".$reg->imagen."' height='70px' width='80px'>",
                "6"=>($reg->estado)?'<span class="label bg-green">Activado</span>':'<span class="label bg-red">Desactivado</span>',
            );
        }

        $results = array(
            "sEcho"=>1, //informacion para el datatables
            "iTotalRecords"=>count($data), //enviamos el total registros al datatable
            "iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
            "aaData"=>$data);
        echo json_encode($results);
        
        break;     

        case 'selectCategoria':
            require_once '../models/Categoria.php';
            $categoria = new Categoria();
            $rspta=$categoria->select();
            
            while($reg = $rspta->fetch_object()){
                echo '<option value=' . $reg->id . '>' . $reg->nombre . '</option>';
            }
        break;
}

?>