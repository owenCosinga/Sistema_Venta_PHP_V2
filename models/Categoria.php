<?php

require_once '../config/Conexion.php';

Class Categoria{

    public function __construct(){

    }

    public function insertar($nombre, $descripcion){
        $sql="INSERT INTO categoria(nombre, descripcion, estado) 
        VALUES('$nombre', '$descripcion', '1')";
        return ejecutarConsulta($sql);      
    }

    public function editar($id ,$nombre, $descripcion){
        $sql="UPDATE categoria SET nombre='$nombre', descripcion='$descripcion' WHERE id='$id'";
        return ejecutarConsulta($sql);      
    }

    public function activar($id){
        $sql="UPDATE categoria SET estado='1' WHERE id='$id'";
        return ejecutarConsulta($sql);      
    }

    public function desactivar($id){
        $sql="UPDATE categoria SET estado='0' WHERE id='$id'";
        return ejecutarConsulta($sql);      
    }

    public function mostrar($id){
        $sql="SELECT * FROM categoria WHERE id='$id'";
        return ejecutarConsultaSimpleFila($sql); 
    }

    public function listar(){
        $sql="SELECT * FROM categoria";
        return ejecutarConsulta($sql); 
    }

    public function select(){
        $sql="SELECT * FROM categoria WHERE estado=1";
        return ejecutarConsulta($sql); 
    }

}

?>