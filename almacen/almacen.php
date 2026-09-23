<?php
//Inicio la sesion 
session_start();
include ("../conexion.php");
include ("../funciones.php");

$mensaje='';

if(isset($_POST["hacer"]))
{
    if($_POST["hacer"] == "addmaterial")
    {
        $nombre = mysqli_real_escape_string($conn, $_POST["nombre"]);
        $unidad_medida = mysqli_real_escape_string($conn, $_POST["unidad_medida"]);
        $almacen = mysqli_real_escape_string($conn, $_POST["almacen"]);
        $stock_minimo = mysqli_real_escape_string($conn, $_POST["stock_minimo"]);
        $stock_maximo = mysqli_real_escape_string($conn, $_POST["stock_maximo"]);
        $cantidad = mysqli_real_escape_string($conn, $_POST["cantidad"]);
        $proveedor = mysqli_real_escape_string($conn, $_POST["proveedor"]);
        $descripcion = mysqli_real_escape_string($conn, $_POST["descripcion"]);

        $sql = "INSERT INTO material (Nombre, CantidadMin, CantidadMax, Descripcion) 
                                VALUES ('$nombre', '$stock_minimo', '$stock_maximo', '$descripcion')";

        if (mysqli_query($conn, $sql)) {
            $Result = mysqli_fetch_array(mysqli_query($conn, "SELECT Id FROM material ORDER BY Id DESC LIMIT 1"));
            $idmaterial = $Result["Id"];

            $sql2 = "INSERT INTO material_proveedor (IdMaterial, IdProveedor) 
                                    VALUES ('$idmaterial', '$proveedor')";

            if(mysqli_query($conn, $sql2)){
                $sql3 = "INSERT INTO Inventario (IdMaterial, IdAlmacen, Cantidad, Movimiento, Balance, Fecha) 
                                        VALUES ('$idmaterial', '$almacen', '$cantidad', 'I', '$cantidad', '".time()."')";
                if(mysqli_query($conn, $sql3)){
                    $mensaje='<div class="mesaje" id="mesaje"><i class="fas fa-thumbs-up"></i> Material agregado correctamente</div>';
                }
                else{
                    $mensaje='<div class="mesaje" id="mesaje"><i class="fas fa-exclamation-triangle"></i> Error al agregar material: ' . mysqli_error($conn) . '</div>';
                }
            }
            else{
                $mensaje='<div class="mesaje" id="mesaje"><i class="fas fa-exclamation-triangle"></i> Error al agregar material: ' . mysqli_error($conn) . '</div>';
            }
        } else {
            $mensaje='<div class="mesaje" id="mesaje"><i class="fas fa-exclamation-triangle"></i> Error al agregar material: ' . mysqli_error($conn) . '</div>';
        }
    }
}

$cadena=$mensaje.'<div class="c100 card agc ber bff bfz">
            <h2><i class="fa-solid fa-warehouse"></i> Almacen</h2>
            <table id="table_almacen" class="stripe row-border order-column nowrap">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Material</th>
                        <th>Cantidad</th>
                        <th>Descripción</th>
                        <th>Almacen</th>
                        <th>Ultima Compra</th>
                        <th>Proveedor</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>';
$ResAlmacen = mysqli_query($conn, "SELECT m.Id, m.Nombre, I.Balance, m.Descripcion, I.Fecha, p.Nombre AS NombreProveedor, ca.Nombre AS NombreAlmacen 
                                    FROM material AS m
                                    INNER JOIN Inventario AS I ON I.IdMaterial = m.Id
                                    INNER JOIN material_proveedor AS mp ON mp.IdMaterial = m.Id
                                    INNER JOIN proveedores AS p ON p.Id= mp.IdProveedor
                                    INNER JOIN cat_almacenes AS ca ON ca.Id = I.IdAlmacen
                                    ORDER BY I.Fecha DESC LIMIT 1");
while($row = mysqli_fetch_array($ResAlmacen)){
    $cadena.='<tr>
                <td>'.$row["Id"].'</td>
                <td>'.$row["Nombre"].'</td>
                <td>'.$row["Balance"].'</td>
                <td>'.$row["Descripcion"].'</td>
                <td>'.$row["NombreAlmacen"].'</td>
                <td>'.fecha(date("Y-m-d", $row["Fecha"])).'</td>
                <td>'.$row["NombreProveedor"].'</td>
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
    var table = $('#table_almacen').DataTable({
        language: {
            decimal: '.',
            thousands: ',',
            url: 'https://cdn.datatables.net/plug-ins/1.10.16/i18n/Spanish.json'
        },
        dom: 'Bfrtip',
        buttons: [
            <?php if(permisos($_SESSION["perfil"], "add.material")): ?>
            {
                text: 'Agregar Material',
                action: function ( e, dt, node, config ) {
                    limpiar();
                    abrirmodal();
                    agregar_material();
                }
            }
            <?php endif; ?>
        ],
        paging: false
    });
} );

function agregar_material(){
    limpiar();
    abrirmodal();
    $.ajax({
        url: 'almacen/agregar_material.php',
        type: 'POST',
        data: {},
        success: function(response) {
            $('#modal-body').html(response);
        }
    });
}


//mostrar mensaje despues de los cambios
setTimeout(function() { 
    $('#mesaje').fadeOut('fast'); 
}, 1000)
</script>