<?php
//Inicio la sesion 
session_start();
include ("../conexion.php");
include ("../funciones.php");

$mensaje='';

if(isset($_POST["hacer"]))
{
    if($_POST["hacer"] == "addproveedor")
    {
        $nombre = mysqli_real_escape_string($conn, $_POST["nombre"]);
        $razon_social = mysqli_real_escape_string($conn, $_POST["razon_social"]);
        $rfc = mysqli_real_escape_string($conn, $_POST["rfc"]);
        $direccion = mysqli_real_escape_string($conn, $_POST["direccion"]);
        $telefono = mysqli_real_escape_string($conn, $_POST["telefono"]);
        $correoe = mysqli_real_escape_string($conn, $_POST["correoe"]);

        $sql = "INSERT INTO proveedores (Nombre, RazonSocial, RFC, Direccion, Telefono, CorreoE) 
                                    VALUES ('$nombre', '$razon_social', '$rfc', '$direccion', '$telefono', '$correoe')";

        if (mysqli_query($conn, $sql)) {
            $mensaje='<div class="mesaje" id="mesaje"><i class="fas fa-thumbs-up"></i> Proveedor agregado correctamente</div>';
        } else {
            $mensaje='<div class="mesaje" id="mesaje"><i class="fas fa-exclamation-triangle"></i> Error al agregar proveedor: ' . mysqli_error($conn) . '</div>';
        }
    }

    if($_POST["hacer"] == "editproveedor")
    {
        $nombre = mysqli_real_escape_string($conn, $_POST["nombre"]);
        $razon_social = mysqli_real_escape_string($conn, $_POST["razon_social"]);
        $rfc = mysqli_real_escape_string($conn, $_POST["rfc"]);
        $direccion = mysqli_real_escape_string($conn, $_POST["direccion"]);
        $telefono = mysqli_real_escape_string($conn, $_POST["telefono"]);
        $correoe = mysqli_real_escape_string($conn, $_POST["correoe"]);
        $idproveedor = mysqli_real_escape_string($conn, $_POST["idproveedor"]);

        $sql = "UPDATE proveedores SET Nombre='$nombre', 
                                    RazonSocial='$razon_social', 
                                    RFC='$rfc', 
                                    Direccion='$direccion', 
                                    Telefono='$telefono', 
                                    CorreoE='$correoe' 
                            WHERE Id='$idproveedor'";

        if (mysqli_query($conn, $sql)) {
            $mensaje='<div class="mesaje" id="mesaje"><i class="fas fa-thumbs-up"></i> Proveedor editado correctamente</div>';
        } else {
            $mensaje='<div class="mesaje" id="mesaje"><i class="fas fa-exclamation-triangle"></i> Error al editar proveedor: ' . mysqli_error($conn) . '</div>';
        }
    }
}

$cadena=$mensaje.'<div class="c100 card agc ber bff bfz">
            <h2><i class="fa-solid fa-users-between-lines"></i> Proveedores</h2>
            <table id="table_proveedores" class="stripe row-border order-column nowrap">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Nombre</th>
                        <th>Telefono</th>
                        <th>Correo Electrónico</th>
                        <th>Dirección</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>';
$ResProveedores = mysqli_query($conn, "SELECT * FROM proveedores ORDER BY Nombre ASC");
while($RResProveedores = mysqli_fetch_array($ResProveedores))
{
    $cadena.='<tr>
                    <td>'.$RResProveedores["Id"].'</td>
                    <td>'.$RResProveedores["Nombre"].'</td>
                    <td>'.$RResProveedores["Telefono"].'</td>
                    <td>'.$RResProveedores["CorreoE"].'</td>
                    <td>'.$RResProveedores["Direccion"].'</td>
                    <td>
                        '.(permisos($_SESSION["perfil"], "edit.proveedor") ? '<a href="javascript:void(0)" onclick="editar_proveedor('.$RResProveedores["Id"].')"><i class="ri-edit-2-fill"></i></a>' : '').'
                        '.(permisos($_SESSION["perfil"], "del.proveedor") ? '<a href="javascript:void(0)" onclick="eliminar_proveedor('.$RResProveedores["Id"].')"><i class="ri-delete-bin-6-fill"></i></a>' : '').'
                    </td>
                </tr>';
}
$cadena.='      </tbody>
            </table>
        </div>';

echo $cadena;
?>
<script>
$(document).ready( function () {
    var table = $('#table_proveedores').DataTable({
        language: {
            decimal: '.',
            thousands: ',',
            url: 'https://cdn.datatables.net/plug-ins/1.10.16/i18n/Spanish.json'
        },
        dom: 'Bfrtip',
        buttons: [
            <?php if(permisos($_SESSION["perfil"], "add.proveedor")): ?>
            {
                text: 'Agregar Proveedor',
                action: function ( e, dt, node, config ) {
                    limpiar();
                    abrirmodal();
                    agregar_proveedor();
                }
            }
            <?php endif; ?>
        ],
        paging: false
    });
} );

function agregar_proveedor(){
    limpiar();
    abrirmodal();
    $.ajax({
				type: 'POST',
				url : 'proveedores/agregar_proveedor.php'
	}).done (function ( info ){
		$('#modal-body').html(info);
	});
}

function editar_proveedor(idproveedor){
    limpiar();
    abrirmodal();
    $.ajax({
				type: 'POST',
				url : 'proveedores/editar_proveedor.php',
				data: { idproveedor: idproveedor }
	}).done (function ( info ){
		$('#modal-body').html(info);
	});
}


//mostrar mensaje despues de los cambios
setTimeout(function() { 
    $('#mesaje').fadeOut('fast'); 
}, 1000)
</script>
