<?php
//Inicio la sesion 
session_start();

include('../conexion.php');
include('../funciones.php');

$mensaje='';

$cadena='<div class="c100">
            <div class="menucard">
                <ul>
					'.(permisos($_SESSION["perfil"], 'ver.usuarios')==TRUE ? '<li><a href="#" onclick="usuarios()" class = "mytooltip"><i class="ri-group-2-fill"></i><span class = "mytext">Usuarios</span></a></li>' : '').'
                    '.(permisos($_SESSION["perfil"], 'ver.medidas')==TRUE ? '<li><a href="#" onclick="medidas()" class = "mytooltip"><i class="ri-pencil-ruler-2-fill"></i><span class = "mytext">Medidas</span></a></li>' : '').'
					'.(permisos($_SESSION["perfil"], 'ver.almacenes')==TRUE ? '<li><a href="#" onclick="almacenes()" class = "mytooltip"><i class="ri-store-2-fill"></i><span class = "mytext">Almacenes</span></a></li>' : '').'
                </ul>
            </div>
            <div id="contenido2" class="contenido2">
                
            </div>
        </div>';

echo $cadena;

?>
<script>
function usuarios(){
    $('#contenido2').html('<div class="loading"><img src="/images/loading-forever.gif" alt="loading" width="60px" /></div>');

	$.ajax({
				type: 'POST',
				url : 'configuracion/usuarios.php'
	}).done (function ( info ){
		$('#contenido2').html(info);
	});
}
function medidas(){
	$.ajax({
				type: 'POST',
				url : 'configuracion/medidas.php'
	}).done (function ( info ){
		$('#contenido2').html(info);
	});
}

function almacenes(){
	$.ajax({
				type: 'POST',
				url : 'configuracion/almacenes.php'
	}).done (function ( info ){
		$('#contenido2').html(info);
	});
}


$(document).ready(usuarios());
</script>

<?php
//Created with human intelligence by @jkarreno 2023 - 2024 -2025
//May the force be with you
//move your stars
//always ready
?>