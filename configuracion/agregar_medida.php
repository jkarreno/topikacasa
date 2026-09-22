<?php
//Inicio la sesion 
session_start();
include("../conexion.php");
include("../funciones.php");

$cadena='<div class="c100 card">
            <h2>Nueva medida</h2>
            <form name="fadmedida" id="fadmedida">
                <div class="c30">
                    <label class="l_form">Nombre :</label>
                    <input type="text" name="nombre" id="nombre">
                </div>
                <div class="c30">
                    <label class="l_form">Abreviación :</label>
                    <input type="text" name="abreviacion" id="abreviacion">
                </div>
                <div class="c30">
                    <label class="l_form">Descripción :</label>
                    <input type="text" name="descripcion" id="descripcion">
                </div>
                <div class="c100">
                    <input type="hidden" name="hacer" id="hacer" value="addmedida">
                    <input type="submit" name="botadmedida" id="botadmedida" value="Agregar>>" onclick="cerrarmodal()">
                </div>
            </form>
            </div>';

echo $cadena;
?>
<script>
    $("#fadmedida").on("submit", function(e){
	e.preventDefault();
	var formData = new FormData(document.getElementById("fadmedida"));

	$.ajax({
		url: "configuracion/medidas.php",
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