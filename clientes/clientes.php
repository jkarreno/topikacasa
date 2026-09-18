<?php
//Inicio la sesion 
session_start();
include ("../conexion.php");
include ("../funciones.php");

$mensaje='';

if(isset($_POST["hacer"]))
{
    if($_POST["hacer"] == "addcliente")
    {
        $nombre = mysqli_real_escape_string($conn, $_POST["nombre"]);
        $razon_social = mysqli_real_escape_string($conn, $_POST["razon_social"]);
        $rfc = mysqli_real_escape_string($conn, $_POST["rfc"]);
        $direccion = mysqli_real_escape_string($conn, $_POST["direccion"]);
        $telefono = mysqli_real_escape_string($conn, $_POST["telefono"]);
        $correoe = mysqli_real_escape_string($conn, $_POST["correoe"]);

        $sql = "INSERT INTO clientes (Nombre, RazonSocial, RFC, Direccion, Telefono, CorreoE) VALUES ('$nombre', '$razon_social', '$rfc', '$direccion', '$telefono', '$correoe')";

        if (mysqli_query($conn, $sql)) {
            $mensaje='<div class="mesaje" id="mesaje"><i class="fas fa-thumbs-up"></i> Cliente agregado correctamente</div>';
        } else {
            $mensaje='<div class="mesaje" id="mesaje"><i class="fas fa-exclamation-triangle"></i> Error al agregar cliente: ' . mysqli_error($conn) . '</div>';
        }
    }

    if($_POST["hacer"] == "editcliente")
    {
        $nombre = mysqli_real_escape_string($conn, $_POST["nombre"]);
        $razon_social = mysqli_real_escape_string($conn, $_POST["razon_social"]);
        $rfc = mysqli_real_escape_string($conn, $_POST["rfc"]);
        $direccion = mysqli_real_escape_string($conn, $_POST["direccion"]);
        $telefono = mysqli_real_escape_string($conn, $_POST["telefono"]);
        $correoe = mysqli_real_escape_string($conn, $_POST["correoe"]);
        $idcliente = mysqli_real_escape_string($conn, $_POST["idcliente"]);

        $sql = "UPDATE clientes SET Nombre='$nombre', 
                                    RazonSocial='$razon_social', 
                                    RFC='$rfc', 
                                    Direccion='$direccion', 
                                    Telefono='$telefono', 
                                    CorreoE='$correoe' 
                            WHERE Id='$idcliente'";

        if (mysqli_query($conn, $sql)) {
            $mensaje='<div class="mesaje" id="mesaje"><i class="fas fa-thumbs-up"></i> Cliente editado correctamente</div>';
        } else {
            $mensaje='<div class="mesaje" id="mesaje"><i class="fas fa-exclamation-triangle"></i> Error al editar cliente: ' . mysqli_error($conn) . '</div>';
        }
    }
}

$cadena=$mensaje.'<div class="c100 card agc ber bff bfz">
            <h2><i class="fa-solid fa-users-between-lines"></i> Clientes</h2>
            <table id="table_clientes" class="stripe row-border order-column nowrap">
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
$ResClientes = mysqli_query($conn, "SELECT * FROM clientes ORDER BY Nombre ASC");
while($RResClientes = mysqli_fetch_array($ResClientes))
{
    $cadena.='<tr>
                    <td>'.$RResClientes["Id"].'</td>
                    <td>'.$RResClientes["Nombre"].'</td>
                    <td>'.$RResClientes["Telefono"].'</td>
                    <td>'.$RResClientes["CorreoE"].'</td>
                    <td>'.$RResClientes["Direccion"].'</td>
                    <td>
                        <a href="javascript:void(0)" onclick="editar_cliente('.$RResClientes["Id"].')"><i class="ri-edit-2-fill"></i></a>
                        <a href="javascript:void(0)" onclick="eliminar_cliente('.$RResClientes["Id"].')"><i class="ri-delete-bin-6-fill"></i></a>
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
    var table = $('#table_clientes').DataTable({
        language: {
            decimal: '.',
            thousands: ',',
            url: 'https://cdn.datatables.net/plug-ins/1.10.16/i18n/Spanish.json'
        },
        dom: 'Bfrtip',
        buttons: [
            <?php if(permisos($_SESSION["perfil"], "add.cliente")): ?>
            {
                text: 'Agregar Cliente',
                action: function ( e, dt, node, config ) {
                    limpiar();
                    abrirmodal();
                    agregar_cliente();
                }
            }
            <?php endif; ?>
        ],
        paging: false
    });
} );

function agregar_cliente(){
    $.ajax({
				type: 'POST',
				url : 'clientes/agregar_cliente.php'
	}).done (function ( info ){
		$('#modal-body').html(info);
	});
}

function editar_cliente(idcliente){
    limpiar();
    abrirmodal();
    $.ajax({
				type: 'POST',
				url : 'clientes/editar_cliente.php',
				data: { idcliente: idcliente }
	}).done (function ( info ){
		$('#modal-body').html(info);
	});
}


//mostrar mensaje despues de los cambios
setTimeout(function() { 
    $('#mesaje').fadeOut('fast'); 
}, 1000)
</script>
