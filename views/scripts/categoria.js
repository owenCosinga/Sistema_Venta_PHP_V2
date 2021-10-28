var tabla;

//funcion q se ejecuta al inicio
function init(){
 mostrarform(false);
 listar();

 //mandar los valores insertados del usuario
 $("#formulario").on("submit", function(e){
     guardaryeditar(e);
 })
}

//funcion limpiar
function limpiar(){

    $("#id").val("");
    $("#nombre").val("");
    $("#descripcion").val("");
}

//funcion mostrar form
function mostrarform(flag){

    limpiar();

    if(flag){
        $("#listadoregistros").hide();
        $("#formularioregistros").show();
        $("#btnGuardar").prop("disabled", false);
    }else{
        $("#listadoregistros").show();
        $("#formularioregistros").hide();
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
            url: '../ajax/categoria.php?op=listar',
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
        url: "../ajax/categoria.php?op=guardaryeditar",
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
$.post("../ajax/categoria.php?op=mostrar", {id : id}, function(data, status){

    data = JSON.parse(data);
    mostrarform(true);

    $("#nombre").val(data.nombre);
    $("#descripcion").val(data.descripcion);
    $("#id").val(data.id);
})
}

function desactivar(id){
    
    bootbox.confirm("¿Estas seguro de desactivar el registro?", function(result){
        if(result){
            $.post("../ajax/categoria.php?op=desactivar", {id:id}, function(e){
                bootbox.alert(e);
                tabla.ajax.reload();
            });
        }
    })
}

function activar(id){
    
    bootbox.confirm("¿Estas seguro de activar el registro?", function(result){
        if(result){
            $.post("../ajax/categoria.php?op=activar", {id:id}, function(e){
                bootbox.alert(e);
                tabla.ajax.reload();
            });
        }
    })
}

init();