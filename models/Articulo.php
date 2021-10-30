<?php

require_once '../config/Conexion.php';

Class Articulo{

    public function __construct(){

    }

    public function insertar($idcategoria, $codigo, $nombre, $stock, $descripcion, $imagen){
        $sql="INSERT INTO articulo(idcategoria, codigo, nombre, stock, descripcion, imagen, estado) 
        VALUES('$idcategoria', '$codigo', '$nombre', '$stock', '$descripcion', '$imagen', '1')";
        return ejecutarConsulta($sql);      
    }

    public function editar($id ,$idcategoria, $codigo, $nombre, $stock, $descripcion, $imagen){
        $sql="UPDATE articulo SET idcategoria='$idcategoria', codigo='$codigo', nombre='$nombre', stock='$stock', descripcion='$descripcion', imagen='$imagen' WHERE id='$id'";
        return ejecutarConsulta($sql);      
    }

    public function activar($id){
        $sql="UPDATE articulo SET estado='1' WHERE id='$id'";
        return ejecutarConsulta($sql);      
    }

    public function desactivar($id){
        $sql="UPDATE articulo SET estado='0' WHERE id='$id'";
        return ejecutarConsulta($sql);      
    }

    public function mostrar($id){
        $sql="SELECT * FROM articulo WHERE id='$id'";
        return ejecutarConsultaSimpleFila($sql); 
    }

    public function listar(){
        $sql="SELECT a.id, a.idcategoria, c.nombre as categoria, a.codigo, a.nombre, a.stock, a.descripcion, a.imagen, a.estado FROM articulo a INNER JOIN categoria c ON a.idcategoria=c.id";
        return ejecutarConsulta($sql); 
    }

}

?>