<?php
//Inicio la sesion 
session_start();
include("../conexion.php");
include("../funciones.php");

$mensaje='';

if(isset($_POST["hacer"]))
{
    if($_POST["hacer"] == "addestatus")
    {
        $nombre = mysqli_real_escape_string($conn, $_POST["nombre"]);

        $sql = "INSERT INTO cat_estatus_proyectos (Estatus, Orden) 
                                            VALUES (
                                                        '".$nombre."',
                                                        (
                                                            SELECT Orden
                                                            FROM (
                                                                SELECT IFNULL(MAX(Orden), 0) + 1 AS Orden
                                                                FROM cat_estatus_proyectos
                                                            ) AS tmp
                                                        )
                                                    );";

        if (mysqli_query($conn, $sql)) {
            $mensaje='<div class="mesaje" id="mesaje"><i class="fas fa-thumbs-up"></i> Estatus de proyecto agregado correctamente</div>';
        } else {
            $mensaje='<div class="mesaje" id="mesaje"><i class="fas fa-exclamation-triangle"></i> Error al agregar estatus de proyecto: ' . mysqli_error($conn) . '</div>';
        }
    }

    if($_POST["hacer"] == 'moverposicion')
    {
        $ResPos = mysqli_fetch_array(mysqli_query($conn, "SELECT Orden FROM cat_estatus_proyectos WHERE Id = '".$_POST["idstatus"]."' LIMIT 1"));

        $posicion = $ResPos["Orden"];

        if($_POST["posicion"] == 'down')
        {
            $new_posicion = $posicion + 1;
            
        }
        else if($_POST["posicion"] == 'up')
        {
            $new_posicion = $posicion - 1;
        }

        
        mysqli_query($conn, "UPDATE cat_estatus_proyectos SET Orden = '".$posicion."' WHERE Orden = '".$new_posicion."'");
        mysqli_query($conn, "UPDATE cat_estatus_proyectos SET Orden = '".$new_posicion."' WHERE Id = '".$_POST["idstatus"]."'");
    }
}

$cadena=$mensaje.'<div class="c100 card">
            <h2><i class="ri-progress-5-line"></i> Estatus Proyectos</h2>
            <table id="table_estatus_proyectos" class="stripe row-border order-column nowrap">
                <thead>
                    <tr>
                        <th></th>
                        <th></th>
                        <th>Orden</th>
                        <th>Nombre</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>';
$ResEstatusProyectos=mysqli_query($conn, "SELECT * FROM cat_estatus_proyectos ORDER BY Orden ASC");
$J=1; $NumEstatus = mysqli_num_rows($ResEstatusProyectos);
while($RResEP=mysqli_fetch_array($ResEstatusProyectos))
{
    $cadena.='      <tr>
                        <td align="center">'.($J == $NumEstatus ? '' : '<a href="javascript:void(0)" onclick="mover_estatus('.$RResEP["Id"].', \'down\')"><i class="ri-arrow-down-fill"></i></a>').'</td>
                        <td align="center">'.(($J > 1 && $J <= $NumEstatus) ? '<a href="javascript:void(0)" onclick="mover_estatus('.$RResEP["Id"].', \'up\')"><i class="ri-arrow-up-fill"></i></a>' : '').'</td>
                        <td>'.$RResEP["Orden"].'</td>
                        <td>'.$RResEP["Estatus"].'</td>
                        <td>'.(permisos($_SESSION["perfil"], 'edit.estatusproyectos') ? '<i class="fa-solid fa-pen-to-square"></i>' : '').(permisos($_SESSION["perfil"], 'delete.estatusproyectos') ? ' <i class="fa-solid fa-trash"></i>' : '').'</td>
                    </tr>';
    $J++;
}
$cadena.='      </tbody>
            </table>';

echo $cadena;
?>
<script>
$(document).ready( function () {
    var table = $('#table_estatus_proyectos').DataTable({
        language: {
            decimal: '.',
            thousands: ',',
            url: '//cdn.datatables.net/plug-ins/1.10.16/i18n/Spanish.json'
        },
        dom: 'Bfrtip',
        buttons: [
            <?php if(permisos($_SESSION["perfil"], 'add.estatusproyectos')): ?>
            {
                text: 'Agregar Estatus',
                action: function ( e, dt, node, config ) {
                    limpiar();
                    abrirmodal();
                    agregar_estatus_proyectos();
                }
            }
            <?php endif; ?>
        ],
        paging: false,
        order: [[2, 'asc']]
    });
} );

function agregar_estatus_proyectos(){
    limpiar();
    abrirmodal();
    $.ajax({
				type: 'POST',
				url : 'configuracion/agregar_estatus_proyectos.php'
	}).done (function ( info ){
		$('#modal-body').html(info);
	});
}

function mover_estatus(idstatus, posicion){
    $.ajax({
        type: 'POST',
        url: 'configuracion/status_proyectos.php',
        data: { idstatus: idstatus, posicion: posicion, hacer: 'moverposicion' }
    }).done (function ( info ){
		$('#contenido2').html(info);
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
