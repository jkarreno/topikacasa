<?php
//Inicio la sesion 
session_start();
include("../conexion.php");
include("../funciones.php");

$cadena='<div class="c100 card">
            <h2>Nuevo material</h2>
            <form name="fadmaterial" id="fadmaterial">
                <div class="c30">
                    <label class="l_form">Nombre :</label>
                    <input type="text" name="nombre" id="nombre">
                </div>
                <div class="c30">
                    <label class="l_form">Unidad de medida:</label>
                    <select name="unidad_medida" id="unidad_medida">
                        <option value="0">Selecciona</option>';
$ResUnidadMedida = mysqli_query($conn, "SELECT * FROM cat_medidas ORDER BY Nombre ASC");
while($RResUM = mysqli_fetch_assoc($ResUnidadMedida)){
    $cadena.='          <option value="'.$RResUM["Id"].'">'.$RResUM["Nombre"].' '.$RResUM["Abreviacion"].'</option>';
}
$cadena.='          </select>
                </div>
                <div class="c30">
                    <label class="l_form">Almacen :</label>
                    <select name="almacen" id="almacen">
                        <option value="0">Selecciona</option>';
$ResAlmacen = mysqli_query($conn, "SELECT Id, Nombre FROM cat_almacenes ORDER BY Nombre ASC");
while($RResAlm = mysqli_fetch_assoc($ResAlmacen)){
    $cadena.='          <option value="'.$RResAlm["Id"].'">'.$RResAlm["Nombre"].'</option>';
}
$cadena.='          </select>
                </div>

                <div class="c30">
                    <label class="l_form">Stock Minimo :</label>
                    <input type="number" name="stock_minimo" id="stock_minimo" value="0" min="0" step="0.01">
                </div>
                <div class="c30">
                    <label class="l_form">Stock Maximo :</label>
                    <input type="number" name="stock_maximo" id="stock_maximo" value="0" min="0" step="0.01">
                </div>
                <div class="c30">
                    <label class="l_form">Cantidad :</label>
                    <input type="number" name="cantidad" id="cantidad" value="0" min="0" step="0.01">
                </div>

                <div class="c30">
                    <label class="l_form">Proveedor:</label>
                    <select name="proveedor" id="proveedor">
                        <option value="0">Selecciona</option>';
$ResProveedor = mysqli_query($conn, "SELECT Id, Nombre FROM proveedores ORDER BY nombre ASC");
while($RResProv = mysqli_fetch_assoc($ResProveedor)){
    $cadena.='          <option value="'.$RResProv["Id"].'">'.$RResProv["Nombre"].'</option>';
}
$cadena.='          </select>
                </div>
                <div class="c30">
                    <label class="l_form">Descripción :</label>
                    <input type="text" name="descripcion" id="descripcion">
                </div>
                <div class="c30"></div>

                <div class="c100">
                    <input type="hidden" name="hacer" id="hacer" value="addmaterial">
                    <input type="submit" name="botadmaterial" id="botadmaterial" value="Agregar>>" onclick="cerrarmodal()">
                </div>
            </form>
        </div>';

echo $cadena;
?>
<script>
    $("#fadmaterial").on("submit", function(e){
	e.preventDefault();
	var formData = new FormData(document.getElementById("fadmaterial"));

	$.ajax({
		url: "almacen/almacen.php",
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