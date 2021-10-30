<?php

require_once '../config/Conexion.php';

Class Persona{

    public function __construct(){

    }

    public function insertar($tipo_persona, $nombre, $tipo_documento, $num_documento, $direccion, $telefono, $email){
        $sql="INSERT INTO persona(tipo_persona, nombre, tipo_documento, num_documento, direccion, telefono, email) 
        VALUES('$tipo_persona', '$nombre', '$tipo_documento', '$num_documento', '$direccion', '$telefono', '$email')";
        return ejecutarConsulta($sql);      
    }

    public function editar($id, $tipo_persona, $nombre, $tipo_documento, $num_documento, $direccion, $telefono, $email){
        $sql="UPDATE persona SET tipo_persona='$tipo_persona', nombre='$nombre', tipo_documento='$tipo_documento', num_documento='$num_documento', direccion='$direccion', telefono='$telefono', email='$email' WHERE id='$id'";
        return ejecutarConsulta($sql);      
    }

    public function eliminar($id){
        $sql="DELETE FROM persona WHERE id='$id'";
        return ejecutarConsulta($sql);      
    }

    public function mostrar($id){
        $sql="SELECT * FROM persona WHERE id='$id'";
        return ejecutarConsultaSimpleFila($sql); 
    }

    public function listarp(){
        $sql="SELECT * FROM persona WHERE tipo_persona='Proveedor'";
        return ejecutarConsulta($sql); 
    }

    public function listarc(){
        $sql="SELECT * FROM persona WHERE tipo_persona='Cliente'";
        return ejecutarConsulta($sql); 
    }

}

?>