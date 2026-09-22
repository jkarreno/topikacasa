<?php
//Inicio la sesion 
session_start();
include("../conexion.php");
include("../funciones.php");

$ResProveedor = mysqli_query($conn, "SELECT * FROM proveedores WHERE Id='".$_POST["idproveedor"]."'");
$Proveedor = mysqli_fetch_assoc($ResProveedor);

$cadena='<div class="c100 card">
            <h2>Editar proveedor</h2>
            <form name="feditproveedor" id="feditproveedor">
                <div class="c30">
                    <label class="l_form">Nombre :</label>
                    <input type="text" name="nombre" id="nombre" value="'.$Proveedor["Nombre"].'">
                </div>
                <div class="c30">
                    <label class="l_form">Razón Social :</label>
                    <input type="text" name="razon_social" id="razon_social" value="'.$Proveedor["RazonSocial"].'">
                </div>
                <div class="c30">
                    <label class="l_form">Rfc :</label>
                    <input type="text" name="rfc" id="rfc" value="'.$Proveedor["RFC"].'">
                </div>

                <div class="c30">
                    <label class="l_form">Dirección :</label>
                    <input type="text" name="direccion" id="direccion" value="'.$Proveedor["Direccion"].'">
                </div>
                <div class="c30">
                    <label class="l_form">Telefono :</label>
                    <input type="text" name="telefono" id="telefono" value="'.$Proveedor["Telefono"].'">
                </div>
                <div class="c30">
                    <label class="l_form">Correo Electrónico :</label>
                    <input type="text" name="correoe" id="correoe" value="'.$Proveedor["CorreoE"].'">
                </div>

                <div class="c100">
                    <input type="hidden" name="hacer" id="hacer" value="editproveedor">
                    <input type="hidden" name="idproveedor" id="idproveedor" value="'.$Proveedor["Id"].'">
                    <input type="submit" name="boteditproveedor" id="boteditproveedor" value="Editar>>" onclick="cerrarmodal()">
                </div>
            </form>
        </div>';

echo $cadena;
?>
<script>
    $("#feditproveedor").on("submit", function(e){
	e.preventDefault();
	var formData = new FormData(document.getElementById("feditproveedor"));

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