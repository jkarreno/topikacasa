<?php
//Inicio la sesion 
session_start();
include("../conexion.php");
include("../funciones.php");

$ResMedida=mysqli_query($conn, "SELECT * FROM cat_medidas WHERE Id = '".$_POST["idmedida"]."'");
$RResMedida=mysqli_fetch_array($ResMedida);

$cadena='<div class="c100 card">
            <h2>Editar medida</h2>
            <form name="feditmedida" id="feditmedida">
                <div class="c30">
                    <label class="l_form">Nombre :</label>
                    <input type="text" name="nombre" id="nombre" value="'.$RResMedida["Nombre"].'">
                </div>
                <div class="c30">
                    <label class="l_form">Abreviación :</label>
                    <input type="text" name="abreviacion" id="abreviacion" value="'.$RResMedida["Abreviacion"].'">
                </div>
                <div class="c30">
                    <label class="l_form">Descripción :</label>
                    <input type="text" name="descripcion" id="descripcion" value="'.$RResMedida["Descripcion"].'">
                </div>
                <div class="c100">
                    <input type="hidden" name="hacer" id="hacer" value="editmedida">
                    <input type="hidden" name="idmedida" id="idmedida" value="'.$RResMedida["Id"].'">
                    <input type="submit" name="botadmedida" id="botadmedida" value="Actualizar>>" onclick="cerrarmodal()">
                </div>
            </form>
            </div>';

echo $cadena;
?>
<script>
    $("#feditmedida").on("submit", function(e){
	e.preventDefault();
	var formData = new FormData(document.getElementById("feditmedida"));

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