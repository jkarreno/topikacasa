<?php
//Inicio la sesion 
session_start();
include("../conexion.php");
include("../funciones.php");

$mensaje='';

if(isset($_POST["hacer"]))
{
    //agregar perfil
    if($_POST["hacer"]=='addmedida')
    {
        mysqli_query($conn, "INSERT INTO cat_medidas (Nombre, Abreviacion, Descripcion) 
                                                VALUES('".$_POST["nombre"]."', '".$_POST["abreviacion"]."', '".$_POST["descripcion"]."')");

        $mensaje='<div class="mesaje" id="mesaje"><i class="fas fa-thumbs-up"></i> Se agrego la medida '.$_POST["nombre"].'</div>';
    }
    //editar perfil
    if($_POST["hacer"]=='editmedida')
    {
        mysqli_query($conn, "UPDATE cat_medidas SET Nombre = '".$_POST["nombre"]."', 
                                                    Abreviacion = '".$_POST["abreviacion"]."', 
                                                    Descripcion = '".$_POST["descripcion"]."' 
                                            WHERE Id = '".$_POST["idmedida"]."'");

        $mensaje='<div class="mesaje" id="mesaje"><i class="fas fa-thumbs-up"></i> Se actualizo la medida '.$_POST["nombre"].'</div>';
    }
}


$cadena=$mensaje.'<div class="c100 card">
            <h2><i class="fa-solid fa-users-gear"></i> Medidas</h2>
            <table id="table_medidas" class="stripe row-border order-column nowrap">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Nombre</th>
                        <th>Abreviación</th>
                        <th>Descripción</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>';
$ResMedidas=mysqli_query($conn, "SELECT * FROM cat_medidas ORDER BY Nombre ASC");
while($RResMedida=mysqli_fetch_array($ResMedidas))
{
    $cadena.='<tr>
                    <td>'.$RResMedida["Id"].'</td>
                    <td>'.$RResMedida["Nombre"].'</td>
                    <td>'.$RResMedida["Abreviacion"].'</td>
                    <td>'.$RResMedida["Descripcion"].'</td>
                    <td>
                        '.(permisos($_SESSION["perfil"], 'edit.medidas') ? '<a href="javascript:void(0)" onclick="edit_medida('.$RResMedida["Id"].')"><i class="ri-edit-2-fill"></i></a>' : '').'
                    </td>
                </tr>';
}
$cadena.='      </tbody>
            </table>';

echo $cadena;
?>
<script>
$(document).ready( function () {
    var table = $('#table_medidas').DataTable({
        language: {
            decimal: '.',
            thousands: ',',
            url: 'https://cdn.datatables.net/plug-ins/1.10.16/i18n/Spanish.json'
        },
        dom: 'Bfrtip',
        buttons: [
            <?php if(permisos($_SESSION["perfil"], 'add.medidas')): ?>{
                text: 'Agregar Medida',
                action: function ( e, dt, node, config ) {
                    limpiar();
                    abrirmodal();
                    agregar_medida();
                }
            }
            <?php endif; ?>
        ],
        paging: false
    });
} );

function agregar_medida(){
    $.ajax({
				type: 'POST',
				url : 'configuracion/agregar_medida.php'
	}).done (function ( info ){
		$('#modal-body').html(info);
	});
}

function edit_medida(idmedida){
    limpiar();
    abrirmodal();
    $.ajax({
                type: 'POST',
                url : 'configuracion/editar_medida.php',
                data: {idmedida: idmedida}
    }).done (function ( info ){
        $('#modal-body').html(info);
    });
}    

//mostrar mensaje despues de los cambios
setTimeout(function() { 
    $('#mesaje').fadeOut('fast'); 
}, 1000)
</script>

<?php
//Created with human intelligence by @jkarreno 2026
//May the force be with you
//move your stars
//be prepared
?>