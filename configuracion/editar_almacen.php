<?php
//Inicio la sesion 
session_start();
include("../conexion.php");
include("../funciones.php");

$ResAlmacen=mysqli_query($conn, "SELECT * FROM cat_almacenes WHERE Id = '".$_POST["idalmacen"]."'");
$RResAlmacen=mysqli_fetch_array($ResAlmacen);

$cadena='<div class="c100 card">
            <h2>Editar Almacén</h2>
            <form name="feditalmacen" id="feditalmacen">
                <div class="c30">
                    <label class="l_form">Nombre :</label>
                    <input type="text" name="nombre" id="nombre" value="'.$RResAlmacen["Nombre"].'">
                </div>
                <div class="c30">
                    <label class="l_form">Ubicación :</label>
                    <input type="text" name="ubicacion" id="ubicacion" value="'.$RResAlmacen["Ubicacion"].'">
                </div>
                <div class="c30">
                    <label class="l_form">Descripción :</label>
                    <input type="text" name="descripcion" id="descripcion" value="'.$RResAlmacen["Descripcion"].'">
                </div>
                <div class="c100">
                    <input type="hidden" name="hacer" id="hacer" value="editalmacen">
                    <input type="hidden" name="idalmacen" id="idalmacen" value="'.$RResAlmacen["Id"].'">
                    <input type="submit" name="boteditalmacen" id="boteditalmacen" value="Editar>>" onclick="cerrarmodal()">
                </div>
            </form>
            </div>';

echo $cadena;
?>
<script>
    $("#feditalmacen").on("submit", function(e){
	e.preventDefault();
	var formData = new FormData(document.getElementById("feditalmacen"));

	$.ajax({
		url: "configuracion/almacenes.php",
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