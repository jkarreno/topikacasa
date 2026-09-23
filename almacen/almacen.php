<?php
//Inicio la sesion 
session_start();
include ("../conexion.php");
include ("../funciones.php");

$mensaje='';

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
                    </tr>
                </thead>
                <tbody>';
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