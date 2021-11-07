<?php

require_once '../config/Conexion.php';

Class Usuario{

    public function __construct(){

    }

    public function insertar($nombre, $apellido, $tipo_documento, $num_documento, $telefono, $email, $cargo, $login, $clave, $imagen, $permisos){
        $sql="INSERT INTO usuario(nombre, apellido, tipo_documento, num_documento, telefono, email, cargo, login, clave, imagen, estado) 
        VALUES('$nombre', '$apellido', '$tipo_documento', '$num_documento', '$telefono', '$email', '$cargo', '$login', '$clave', '$imagen', '1')";
       // return ejecutarConsulta($sql);
        
        $idusuarionew=ejecutarConsulta_retornarID($sql);

        $num_elemento=0;

        $sw=true;

        while ($num_elemento < count($permisos)){
            $sql_detalle="INSERT INTO usuario_permiso(idusuario, idpermiso) VALUES('$idusuarionew', '$permisos[$num_elemento]')";
            ejecutarConsulta($sql_detalle) or $sw=false;
            $num_elemento=$num_elemento+1;
        }
        return $sw;
    }

    public function editar($id, $nombre, $apellido, $tipo_documento, $num_documento, $telefono, $email, $cargo, $login, $clave, $imagen, $permisos){
		$sql="UPDATE usuario SET nombre='$nombre', apellido='$apellido', tipo_documento='$tipo_documento', num_documento='$num_documento', telefono='$telefono', email='$email', cargo='$cargo', login='$login', clave='$clave', imagen='$imagen' WHERE id='$id'";
        ejecutarConsulta($sql);

        //eliminar todos los registros asignados para volverlos a registrar
        $sqldel="DELETE FROM usuario_permiso WHERE idusuario='$id'";
        ejecutarConsulta($sqldel);

        $num_elemento=0;
        $sw=true;

        while ($num_elemento < count($permisos)){
            $sql_detalle="INSERT INTO usuario_permiso(idusuario, idpermiso) VALUES('$id', '$permisos[$num_elemento]')";
            ejecutarConsulta($sql_detalle) or $sw=false;
            $num_elemento=$num_elemento+1;
        }
        return $sw;
        
    }

    public function activar($id){
        $sql="UPDATE usuario SET estado='1' WHERE id='$id'";
        return ejecutarConsulta($sql);      
    }

    public function desactivar($id){
        $sql="UPDATE usuario SET estado='0' WHERE id='$id'";
        return ejecutarConsulta($sql);      
    }

    public function mostrar($id){
        $sql="SELECT * FROM usuario WHERE id='$id'";
        return ejecutarConsultaSimpleFila($sql); 
    }

    public function listar(){
        $sql="SELECT * FROM usuario";
        return ejecutarConsulta($sql); 
    }

    public function verificar($login, $clave){
        $sql="SELECT id, nombre, tipo_documento, num_documento, telefono, email, cargo, imagen, login 
        FROM usuario WHERE login='$login' AND clave='$clave' AND estado='1'";
        return ejecutarConsulta($sql); 
    }

        public function listarmarcados($id){
        $sql="SELECT * FROM usuario_permiso WHERE idusuario='$id'";
        return ejecutarConsulta($sql); 
    }

}

?>