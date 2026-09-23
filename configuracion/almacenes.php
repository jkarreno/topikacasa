<?php
//Inicio la sesion 
session_start();
include("../conexion.php");
include("../funciones.php");

$mensaje='';

if(isset($_POST["hacer"]))
{
    //agregar perfil
    if($_POST["hacer"]=='addalmacen')
    {
        mysqli_query($conn, "INSERT INTO cat_almacenes (Nombre, Ubicacion, Descripcion) 
                                                VALUES('".$_POST["nombre"]."', '".$_POST["ubicacion"]."', '".$_POST["descripcion"]."')");

        $mensaje='<div class="mesaje" id="mesaje"><i class="fas fa-thumbs-up"></i> Se agrego el almacén '.$_POST["nombre"].'</div>';
    }
    //editar perfil
    if($_POST["hacer"]=='editalmacen')
    {
        mysqli_query($conn, "UPDATE cat_almacenes SET Nombre = '".$_POST["nombre"]."', 
                                                    Ubicacion = '".$_POST["ubicacion"]."', 
                                                    Descripcion = '".$_POST["descripcion"]."' 
                                            WHERE Id = '".$_POST["idalmacen"]."'");

        $mensaje='<div class="mesaje" id="mesaje"><i class="fas fa-thumbs-up"></i> Se actualizo el almacén '.$_POST["nombre"].'</div>';
    }
}

$cadena=$mensaje.'<div class="c100 card">
            <h2><i class="fa-solid fa-warehouse"></i> Almacenes</h2>
            <table id="table_almacenes" class="stripe row-border order-column nowrap">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Nombre</th>
                        <th>Ubicación</th>
                        <th>Descripción</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>';
$ResAlmacenes=mysqli_query($conn, "SELECT * FROM cat_almacenes ORDER BY Nombre ASC");
while($RResAlmacen=mysqli_fetch_array($ResAlmacenes))
{
    $cadena.='<tr>
                    <td>'.$RResAlmacen["Id"].'</td>
                    <td>'.$RResAlmacen["Nombre"].'</td>
                    <td>'.$RResAlmacen["Ubicacion"].'</td>
                    <td>'.$RResAlmacen["Descripcion"].'</td>
                    <td>
                        '.(permisos($_SESSION["perfil"], 'edit.almacenes') ? '<a href="javascript:void(0)" onclick="edit_almacen('.$RResAlmacen["Id"].')"><i class="ri-edit-2-fill"></i></a>' : '').'
                    </td>
                </tr>';
}
$cadena.='      </tbody>
            </table>';

echo $cadena;
?>
<script>
$(document).ready( function () {
    var table = $('#table_almacenes').DataTable({
        language: {
            decimal: '.',
            thousands: ',',
            url: 'https://cdn.datatables.net/plug-ins/1.10.16/i18n/Spanish.json'
        },
        dom: 'Bfrtip',
        buttons: [
            <?php if(permisos($_SESSION["perfil"], 'add.almacenes')): ?>{
                text: 'Agregar Almacen',
                action: function ( e, dt, node, config ) {
                    limpiar();
                    abrirmodal();
                    agregar_almacen();
                }
            }
            <?php endif; ?>
        ],
        paging: false
    });
} );

function agregar_almacen(){
    $.ajax({
				type: 'POST',
				url : 'configuracion/agregar_almacen.php'
	}).done (function ( info ){
		$('#modal-body').html(info);
	});
}

function edit_almacen(idalmacen){
    limpiar();
    abrirmodal();
    $.ajax({
                type: 'POST',
                url : 'configuracion/editar_almacen.php',
                data: {idalmacen: idalmacen}
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