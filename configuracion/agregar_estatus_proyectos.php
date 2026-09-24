<?php
//Inicio la sesion 
session_start();
include("../conexion.php");
include("../funciones.php");

$cadena='<div class="c100 card">
            <h2>Nuevo Estatus de Proyecto</h2>
            <form name="fadestatus" id="fadestatus">
                <div class="c100">
                    <label class="l_form">Nombre estatus:</label>
                    <input type="text" name="nombre" id="nombre">
                </div>
                <div class="c100">
                    <input type="hidden" name="hacer" id="hacer" value="addestatus">
                    <input type="submit" name="botadestatus" id="botadestatus" value="Agregar>>" onclick="cerrarmodal()">
                </div>
			</form>
        </div>';
    
echo $cadena;

?>

<script>
$("#fadestatus").on("submit", function(e){
	e.preventDefault();
	var formData = new FormData(document.getElementById("fadestatus"));

	$.ajax({
		url: "configuracion/status_proyectos.php",
		type: "POST",
		dataType: "HTML",
		data: formData,
		cache: false,
		contentType: false,
		processData: false
	}).done(function(echo){
		$("#contenido2").html(echo);
	});
});
</script>

<?php
//Created with human intelligence by @jkarreno 2026
//May the force be with you
//move your stars
//be prepared
?>