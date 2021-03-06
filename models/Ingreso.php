<?php

require_once '../config/Conexion.php';

Class Ingreso{

    public function __construct(){

    }

	public function insertar($idproveedor,$idusuario,$tipo_comprobante,$serie_comprobante,$num_comprobante,$fecha_hora,$impuesto,$total_compra,$idarticulo,$cantidad,$precio_compra,$precio_venta)
	{
		$sql="INSERT INTO ingreso (idproveedor,idusuario,tipo_comprobante,serie_comprobante,num_comprobante,fecha_hora,impuesto,total_compra,estado)
		VALUES ('$idproveedor','$idusuario','$tipo_comprobante','$serie_comprobante','$num_comprobante','$fecha_hora','$impuesto','$total_compra','Aceptado')";
		//return ejecutarConsulta($sql);
		$idingresonew=ejecutarConsulta_retornarID($sql);

		$num_elementos=0;
		$sw=true;

            while ($num_elementos < count($idarticulo))
            {
                $sql_detalle = "INSERT INTO detalle_ingreso(idingreso, idarticulo,cantidad,precio_compra,precio_venta) VALUES ('$idingresonew', '$idarticulo[$num_elementos]','$cantidad[$num_elementos]','$precio_compra[$num_elementos]','$precio_venta[$num_elementos]')";
                ejecutarConsulta($sql_detalle) or $sw = false;
                $num_elementos=$num_elementos + 1;
            }

		return $sw;
	}

    public function anular($id){
        $sql="UPDATE ingreso SET estado='Anulado' WHERE id='$id'";
        return ejecutarConsulta($sql);      
    }

    public function mostrar($id){
        $sql="SELECT i.id, DATE(i.fecha_hora) as fecha, i.idproveedor, p.nombre as proveedor, u.id, u.nombre as usuario, i.tipo_comprobante, 
        i.serie_comprobante, i.num_comprobante, i.total_compra, i.impuesto, i.estado 
        FROM ingreso i INNER JOIN persona p ON i.idproveedor=p.id INNER JOIN usuario u ON i.idusuario=u.id WHERE i.id='$id'";
        return ejecutarConsultaSimpleFila($sql); 
    }

    public function listar(){
        $sql="SELECT i.id, DATE(i.fecha_hora) as fecha, i.idproveedor, p.nombre as proveedor, u.id, u.nombre as usuario, i.tipo_comprobante, 
        i.serie_comprobante, i.num_comprobante, i.total_compra, i.impuesto, i.estado 
        FROM ingreso i INNER JOIN persona p ON i.idproveedor=p.id INNER JOIN usuario u ON i.idusuario=u.id";
        return ejecutarConsulta($sql); 
    }


}

?>