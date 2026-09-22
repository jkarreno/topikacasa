<?php
//Inicio la sesion 
session_start();
include("../conexion.php");
include("../funciones.php");

$cadena='<div class="c100 card">
            <h2>Nuevo proveedor</h2>
            <form name="fadproveedor" id="fadproveedor">
                <div class="c30">
                    <label class="l_form">Nombre :</label>
                    <input type="text" name="nombre" id="nombre">
                </div>
                <div class="c30">
                    <label class="l_form">Razón Social :</label>
                    <input type="text" name="razon_social" id="razon_social">
                </div>
                <div class="c30">
                    <label class="l_form">Rfc :</label>
                    <input type="text" name="rfc" id="rfc">
                </div>

                <div class="c30">
                    <label class="l_form">Dirección :</label>
                    <input type="text" name="direccion" id="direccion">
                </div>
                <div class="c30">
                    <label class="l_form">Telefono :</label>
                    <input type="text" name="telefono" id="telefono">
                </div>
                <div class="c30">
                    <label class="l_form">Correo Electrónico :</label>
                    <input type="text" name="correoe" id="correoe">
                </div>

                <div class="c100">
                    <input type="hidden" name="hacer" id="hacer" value="addproveedor">
                    <input type="submit" name="botadproveedor" id="botadproveedor" value="Agregar>>" onclick="cerrarmodal()">
                </div>
            </form>
        </div>';

echo $cadena;
?>
<script>
    $("#fadproveedor").on("submit", function(e){
	e.preventDefault();
	var formData = new FormData(document.getElementById("fadproveedor"));

	$.ajax({
		url: "proveedores/proveedores.php",
		type: "POST",
		dataType: "HTML",
		data: formData,
		cache: false,
		contentType: false,
		processData: false
	}).done(function(echo){
		$("#contenido").html(echo);
	});
});
</script>

<?php
//Created with human intelligence by @jkarreno 2026
//May the force be with you
//move your stars
//be prepared
?>