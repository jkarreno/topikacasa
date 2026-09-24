<?php
//Inicio la sesion 
session_start();
include ("../conexion.php");
include ("../funciones.php");

$mensaje='';

if(isset($_POST["hacer"]))
{
    if($_POST["hacer"] == "addproyecto")
    {
        $cliente = mysqli_real_escape_string($conn, $_POST["cliente"]);
        $nombre_proyecto = mysqli_real_escape_string($conn, $_POST["nombre_proyecto"]);
        $fecha_entrega = mysqli_real_escape_string($conn, $_POST["fecha_entrega"]);

        $sql = "INSERT INTO proyectos (IdCliente, NombreProyecto, FechaCreacion, FechaEntrega, Estatus) 
                                    VALUES ('".$cliente."', '".$nombre_proyecto."', '".time()."', '".strtotime($fecha_entrega)."', '1')";

        if (mysqli_query($conn, $sql)) {
            $mensaje='<div class="mesaje" id="mesaje"><i class="fas fa-thumbs-up"></i> Proyecto agregado correctamente</div>';
        } else {
            $mensaje='<div class="mesaje" id="mesaje"><i class="fas fa-exclamation-triangle"></i> Error al agregar proyecto: ' . mysqli_error($conn) . '</div>';
        }
    }

    if($_POST["hacer"] == "editproyecto")
    {
        $fecha_entrega = mysqli_real_escape_string($conn, $_POST["fecha_entrega"]);
        $fecha_inicio = mysqli_real_escape_string($conn, $_POST["fecha_inicio"]);
        $fecha_termino = mysqli_real_escape_string($conn, $_POST["fecha_termino"]);
        $estatus = mysqli_real_escape_string($conn, $_POST["estatus"]);
        $nombre_proyecto = mysqli_real_escape_string($conn, $_POST["nombre_proyecto"]);
        $descripcion = mysqli_real_escape_string($conn, $_POST["descripcion"]);
        $ubicacion_montaje = mysqli_real_escape_string($conn, $_POST["ubicacion_montaje"]);

        $sql = "UPDATE proyectos SET NombreProyecto='".$nombre_proyecto."'";
        if(strtotime($fecha_entrega)!=NULL AND strtotime($fecha_entrega)!=0){ $sql.=", FechaEntrega='".strtotime($fecha_entrega)."'"; }
        if(strtotime($fecha_inicio)!=NULL AND strtotime($fecha_inicio)!=0){ $sql.=", FechaInicio='".strtotime($fecha_inicio)."'"; }
        if(strtotime($fecha_termino)!=NULL AND strtotime($fecha_termino)!=0){ $sql.=", FechaFin='".strtotime($fecha_termino)."'"; }
        $sql.="                     , Estatus='".$estatus."', 
                                    Descripcion='".$descripcion."', 
                                    UbicacionMontaje='".$ubicacion_montaje."' 
                                WHERE Id='".$_POST["idproyecto"]."'";
                                        

        if (mysqli_query($conn, $sql)) {
            $mensaje='<div class="mesaje" id="mesaje"><i class="fas fa-thumbs-up"></i> Proyecto actualizado correctamente</div>';
        } else {
            $mensaje='<div class="mesaje" id="mesaje"><i class="fas fa-exclamation-triangle"></i> Error al actualizar proyecto: ' . mysqli_error($conn) . '</div>';
        }
    }
}

$cadena=$mensaje.'<div class="c100 card agc ber bff bfz">
            <h2><i class="fa-solid fa-diagram-project"></i> Proyectos</h2>
            <table id="table_proyectos" class="stripe row-border order-column nowrap">
                <thead>
                    <tr>
                        <th>Num Proyecto</th>
                        <th>Nombre</th>
                        <th>Cliente</th>
                        <th>Fecha Creación</th>
                        <th>Fecha Inicio</th>
                        <th>Fecha Termino</th>
                        <th>Fecha Entrega</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>';
$ResProyectos = mysqli_query($conn, "SELECT p.Id, p.NombreProyecto, p.FechaCreacion, p.FechaInicio, p.FechaFin, p.FechaEntrega, p.Estatus, c.Nombre AS NombreCliente 
                                        FROM proyectos p 
                                        INNER JOIN clientes c ON p.IdCliente = c.Id 
                                        ORDER BY p.Id DESC");
while ($RResProyectos = mysqli_fetch_assoc($ResProyectos)) {
    $cadena.='          <tr>
                            <td>'.$RResProyectos["Id"].'</td>
                            <td>'.(permisos($_SESSION["perfil"], "ver.proyecto") ? '<a href="javascript:void(0)" onclick="ver_proyecto('.$RResProyectos["Id"].')">'.$RResProyectos["NombreProyecto"].'</a>' : $RResProyectos["NombreProyecto"]).'</td>
                            <td>'.$RResProyectos["NombreCliente"].'</td>
                            <td data-order="'.$RResProyectos["FechaCreacion"].'">'.fecha(date("Y-m-d", $RResProyectos["FechaCreacion"])).'</td>
                            <td data-order="'.$RResProyectos["FechaInicio"].'">'.($RResProyectos["FechaInicio"]!=NULL ? fecha(date("Y-m-d", $RResProyectos["FechaInicio"])) : '---').'</td>
                            <td data-order="'.$RResProyectos["FechaFin"].'">'.($RResProyectos["FechaFin"]!=NULL ? fecha(date("Y-m-d", $RResProyectos["FechaFin"])) : '---').'</td>
                            <td data-order="'.$RResProyectos["FechaEntrega"].'">'.($RResProyectos["FechaEntrega"]!=NULL ? fecha(date("Y-m-d", $RResProyectos["FechaEntrega"])) : '---').'</td>
                            <td>'.($RResProyectos["Estatus"]!=NULL ? $RResProyectos["Estatus"] : '---').'</td>
                            <td></td>
                        </tr>';
}
$cadena.='      </tbody>
            </table>
        </div>';

echo $cadena;
?>
<script>
$(document).ready( function () {
    var table = $('#table_proyectos').DataTable({
        language: {
            decimal: '.',
            thousands: ',',
            url: 'https://cdn.datatables.net/plug-ins/1.10.16/i18n/Spanish.json'
        },
        dom: 'Bfrtip',
        buttons: [
            <?php if(permisos($_SESSION["perfil"], "add.proyecto")): ?>
            {
                text: 'Agregar Proyecto',
                action: function ( e, dt, node, config ) {
                    limpiar();
                    abrirmodal();
                    agregar_proyecto();
                }
            }
            <?php endif; ?>
        ],
        paging: false
    });
});
function agregar_proyecto(){
    limpiar();
    abrirmodal();
    $.ajax({
                type: 'POST',
                url : 'proyectos/agregar_proyecto.php'
    }).done (function ( info ){
        $('#modal-body').html(info);
    });
}

function ver_proyecto(idproyecto){
    limpiar();
    abrirmodal();
    $.ajax({
				type: 'POST',
				url : 'proyectos/ver_proyecto.php',
				data: { idproyecto: idproyecto }
	}).done (function ( info ){
		$('#modal-body').html(info);
	});
}


//mostrar mensaje despues de los cambios
setTimeout(function() { 
    $('#mesaje').fadeOut('fast'); 
}, 1000)
</script>