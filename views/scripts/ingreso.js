var tabla;

//funcion q se ejecuta al inicio
function init(){
mostrarform(false);
listar();

//mandar los valores insertados del usuario
$("#formulario").on("submit", function(e){
    guardaryeditar(e);
});

//cargar los items al select proveedor
    $.post("../ajax/ingreso.php?op=selectProveedor", function(r){
        $("#idproveedor").html(r);
        $("#idproveedor").selectpicker('refresh');
    });

}

//funcion limpiar
function limpiar(){

    $("#idproveedor").val("");
    $("#proveedor").val("");
    $("#serie_comprobante").val("");
    $("#num_comprobante").val("");
    $("#fecha_hora").val("");
    $("#impuesto").val("");
}

//funcion mostrar form
function mostrarform(flag){

    limpiar();
    
    if(flag){      
        $("#listadoregistros").hide();
        $("#formularioregistros").show();
        $("#btnGuardar").prop("disabled", false);
        $("#btnagregar").hide();
    }else{
        $("#listadoregistros").show();
        $("#formularioregistros").hide();
        $("#btnagregar").show();
    }
}

//funcion cancerlar form
function cancelarform(){

    limpiar();
    mostrarform(false);
}

//funcion listar
function listar(){

    tabla=$('#tbllistado').dataTable({
        "aProcessing": true, //activamos el procesamiento del datatables
        "aServerSide": true, //paginacion y filtrado realizados por el servidor
        dom: 'Bfrtip', //definimos los elementos del control de tabla
        buttons: [
            'copyHtml5',
            'excelHtml5',
            'csvHtml5',
            'pdf'
        ],
        "ajax": {
            url: '../ajax/ingreso.php?op=listar',
            type: "get",
            dataType: "json",
            error: function(e){
                console.log(e.responseText);
            }
        },

        "bDestroy": true,
        "iDisplayLength": 5, //paginacion
        "order": [[ 0, "desc" ]] //ordenar columna y orden      
    }).DataTable();
}

function guardaryeditar(e) {
    e.preventDefault();
    $("#btnGuardar").prop("disabled", false);
    var formData = new FormData($("#formulario")[0]);

    $.ajax({
        url: "../ajax/ingreso.php?op=guardaryeditar",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,

        success: function(datos){
            bootbox.alert(datos);
            mostrarform(false);
            tabla.ajax.reload();
        }
    });
    limpiar();
}

function mostrar(id){
$.post("../ajax/mostrar.php?op=mostrar", {id : id}, function(data, status){

    data = JSON.parse(data);
    mostrarform(true);
    $("#idcategoria").val(data.idcategoria);
    $('#idcategoria').selectpicker('refresh');
    $("#codigo").val(data.codigo);
    $("#nombre").val(data.nombre);
    $("#stock").val(data.stock);
    $("#descripcion").val(data.descripcion);  
    $("#imagenmuestra").show();
    $("#imagenmuestra").attr("src", "../files/articulos/"+data.imagen);
    $("#imagenactual").val(data.imagen);
    $("#id").val(data.id);

    generarbarcode();
})
}

function anular(id){
    
    bootbox.confirm("¿Estas seguro de anular el registro?", function(result){
        if(result){
            $.post("../ajax/ingreso.php?op=anular", {id:id}, function(e){
                bootbox.alert(e);
                tabla.ajax.reload();
            });
        }
    })
}

init();