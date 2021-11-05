var tabla;

//funcion q se ejecuta al inicio
function init(){
mostrarform(false);
listar();

//mandar los valores insertados del usuario
$("#formulario").on("submit", function(e){
    guardaryeditar(e);
});

 $("#imagenmuestra").hide();
 //mostramos los permisos
 $.post("../ajax/usuario.php?op=permisos&id=", function(r){
     $("#permisos").html(r);
 });

}

//funcion limpiar
function limpiar(){

    $("#apellido").val("");
    $("#nombre").val("");
    $("#num_documento").val("");
    $("#email").val("");
    $("#imagenmuestra").attr("src", "");
    $("#imagenactual").val("");
    $("#cargo").val("");
    $("#login").val("");
    $("#clave").val("");    
    $("#id").val("");

    //$("#mostrarform").hide();
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
            url: '../ajax/usuario.php?op=listar',
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
        url: "../ajax/usuario.php?op=guardaryeditar",
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
$.post("../ajax/usuario.php?op=mostrar", {id : id}, function(data, status){

    data = JSON.parse(data);
    mostrarform(true);
    $("#apellido").val(data.apellido);
    $("#nombre").val(data.nombre);
    $("#tipo_documento").val(data.tipo_documento);
    $("#num_documento").val(data.num_documento);  
    $("#telefono").val(data.telefono);
    $("#email").val(data.email); 
    $("#cargo").val(data.cargo);
    $("#login").val(data.login); 
    $("#clave").val(data.clave);
    $("#imagenmuestra").show();
    $("#imagenmuestra").attr("src", "../files/usuarios/"+data.imagen);
    $("#imagenactual").val(data.imagen);
    $("#id").val(data.id);
    });

    $.post("../ajax/usuario.php?op=permisos&id="+id, function(r){
    $("#permisos").html(r);
    });
}

function desactivar(id){
    
    bootbox.confirm("¿Estas seguro de desactivar el registro?", function(result){
        if(result){
            $.post("../ajax/usuario.php?op=desactivar", {id:id}, function(e){
                bootbox.alert(e);
                tabla.ajax.reload();
            });
        }
    })
}

function activar(id){
    
    bootbox.confirm("¿Estas seguro de activar el registro?", function(result){
        if(result){
            $.post("../ajax/usuario.php?op=activar", {id:id}, function(e){
                bootbox.alert(e);
                tabla.ajax.reload();
            });
        }
    })
}

init();