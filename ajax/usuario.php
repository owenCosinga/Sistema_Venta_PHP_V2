<?php
session_start();
require_once '../models/Usuario.php';

$usuario=new Usuario();

$id=isset($_POST['id'])? limpiarCadena($_POST['id']):"";
$nombre=isset($_POST['nombre'])? limpiarCadena($_POST['nombre']):"";
$apellido=isset($_POST['apellido'])? limpiarCadena($_POST['apellido']):"";
$tipo_documento=isset($_POST['tipo_documento'])? limpiarCadena($_POST['tipo_documento']):"";
$num_documento=isset($_POST['num_documento'])? limpiarCadena($_POST['num_documento']):"";
$telefono=isset($_POST['telefono'])? limpiarCadena($_POST['telefono']):"";
$email=isset($_POST['email'])? limpiarCadena($_POST['email']):"";
$cargo=isset($_POST['cargo'])? limpiarCadena($_POST['cargo']):"";
$login=isset($_POST['login'])? limpiarCadena($_POST['login']):"";
$clave=isset($_POST['clave'])? limpiarCadena($_POST['clave']):"";
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
				move_uploaded_file($_FILES["imagen"]["tmp_name"], "../files/usuarios/" . $imagen);
			}
		}
        $clavehash=hash("SHA256", $clave);
        if(empty($id)){
            $rspta=$usuario->insertar($nombre, $apellido, $tipo_documento, $num_documento, $telefono, $email, $cargo, $login, $clavehash, $imagen, $_POST['permiso']);
            echo $rspta ? 'usuario registrado' : 'No se pudieron registrar todos los datos del usuario';
        }else{
            $rspta=$usuario->editar($id, $nombre, $apellido, $tipo_documento, $num_documento, $telefono, $email, $cargo, $login, $clavehash, $imagen, $_POST['permiso']);
            echo $rspta ? 'usuario actualizado' : 'usuario no se pudo actualizar';
        }
        break;

    case 'desactivar':
        $rspta=$usuario->desactivar($id);
        echo $rspta ? '<h2>usuario desactivado</h2>' : '<h2>usuario no se pudo desactivar</h2>';
        break;

    case 'activar':
        $rspta=$usuario->activar($id);
        echo $rspta ? '<h2>usuario activado</h2>' : '<h2>usuario no se pudo activar</h2>';
        break;

    case 'mostrar':
        $rspta=$usuario->mostrar($id);
        //codificar el resultado utilizando json
        echo json_encode($rspta);
        break; 

    case 'listar':
        $rspta=$usuario->listar();
        //declarar un array
        $data = Array();

        while($reg=$rspta->fetch_object()){

            $data[]= array(
                "0"=>($reg->estado)?'<button class="btn btn-warning" onclick="mostrar('.$reg->id.')"><i class="fa fa-pencil"></i></button>'.
                '<button class="btn btn-danger" onclick="desactivar('.$reg->id.')"><i class="fa fa-close"></i></button>':
                '<button class="btn btn-warning" onclick="mostrar('.$reg->id.')"><i class="fa fa-pencil"></i></button>'.
                '<button class="btn btn-primary" onclick="activar('.$reg->id.')"><i class="fa fa-check"></i></button>',
                "1"=>$reg->nombre,
                "2"=>$reg->tipo_documento,
                "3"=>$reg->num_documento,
                "4"=>$reg->telefono,
                "5"=>$reg->email,
                "6"=>$reg->login,
                "7"=>"<img src='../files/usuarios/".$reg->imagen."' height='70px' width='80px'>",
                "8"=>($reg->estado)?'<span class="label bg-green">Activado</span>':'<span class="label bg-red">Desactivado</span>',
            );
        }

        $results = array(
            "sEcho"=>1, //informacion para el datatables
            "iTotalRecords"=>count($data), //enviamos el total registros al datatable
            "iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
            "aaData"=>$data);
        echo json_encode($results);
        
        break;     
        
        case 'permisos':
            //Obtenemos todos los permisos de la tabla permisos
            require_once "../models/Permiso.php";
            $permiso = new Permiso();
            $rspta = $permiso->listar();
    
            //Obtener los permisos asignados al usuario
            $id=$_GET['id'];
            $marcados = $usuario->listarmarcados($id);
            //Declaramos el array para almacenar todos los permisos marcados
            $valores=array();
    
            //Almacenar los permisos asignados al usuario en el array
            while ($per = $marcados->fetch_object())
                {
                    array_push($valores, $per->idpermiso);
                }
    
            //Mostramos la lista de permisos en la vista y si están o no marcados
            while ($reg = $rspta->fetch_object())
                    {
                        $sw=in_array($reg->id,$valores)?'checked':'';
                        echo '<li> <input type="checkbox" '.$sw.'  name="permiso[]" value="'.$reg->id.'">'.$reg->nombre.'</li>';
                    }
        break;


        case 'verificar':

            $logina=$_POST['logina'];
            $clavea=$_POST['clavea'];
    
            //Hash SHA256 en la contraseña
            $clavehash=hash("SHA256",$clavea);
    
            $rspta=$usuario->verificar($logina, $clavehash);
    
            $fetch=$rspta->fetch_object();
    
            if (isset($fetch))
            {
                //Declaramos las variables de sesión
                $_SESSION['id']=$fetch->id;
                $_SESSION['nombre']=$fetch->nombre;
                $_SESSION['imagen']=$fetch->imagen;
                $_SESSION['login']=$fetch->login;

                //obtenemos los permisos del usuario
                $marcados = $usuario->listarmarcados($fetch->id);
                //declaramos el array para almacenar todos los permisos marcados
                $valores=array();
                //almacenar los permisos marcados en el array
                while($per = $marcados->fetch_object()){
                    array_push($valores,$per->idpermiso);
                }
                //determinar los accesos del usuario
                in_array(1, $valores)?$_SESSION['escritorio']=1:$_SESSION['escritorio']=0;
                in_array(2, $valores)?$_SESSION['almacen']=1:$_SESSION['almacen']=0;
                in_array(3, $valores)?$_SESSION['compras']=1:$_SESSION['compras']=0;
                in_array(4, $valores)?$_SESSION['ventas']=1:$_SESSION['ventas']=0;
                in_array(5, $valores)?$_SESSION['acceso']=1:$_SESSION['acceso']=0;
                in_array(6, $valores)?$_SESSION['consultac']=1:$_SESSION['consultac']=0;
                in_array(7, $valores)?$_SESSION['consultav']=1:$_SESSION['consultav']=0;
            }    
            echo json_encode($fetch);
        break;    
        
        case 'salir':
        //limpiar las variables del usuario
        session_unset();
        //destruir la session
        session_destroy();
        //redireccionar al login
        header("Location: ../index.php");
        break;    

}

?>