<?php
//Inicio la sesion 
session_start();
include("../conexion.php");
include("../funciones.php");

$cadena='<div class="c100 card">
            <h2>Nuevo Proyecto</h2>
            <form name="fadproyecto" id="fadproyecto">
                <div class="c30">
                    <label class="l_form">Cliente :</label>
                    <select name="cliente" id="cliente">
                        <option value="">Seleccione un cliente</option>';
$ResClientes = mysqli_query($conn, "SELECT * FROM clientes ORDER BY Nombre");
while ($RResClientes = mysqli_fetch_assoc($ResClientes)) {
    $cadena.='          <option value="'.$RResClientes["Id"].'">'.$RResClientes["Nombre"].'</option>';
}
$cadena.='          </select>
                </div>
                <div class="c60">
                    <label class="l_form">Nombre Proyecto:</label>
                    <input type="text" name="nombre_proyecto" id="nombre_proyecto">
                </div>
                
                <div class="c100">
                    <input type="hidden" name="hacer" id="hacer" value="addproyecto">
                    <input type="submit" name="botadproyecto" id="botadproyecto" value="Agregar>>" onclick="cerrarmodal()">
                </div>
            </form>
        </div>';

echo $cadena;
?>
<script>
    $("#fadproyecto").on("submit", function(e){
	e.preventDefault();
	var formData = new FormData(document.getElementById("fadproyecto"));

	$.ajax({
		url: "proyectos/proyectos.php",
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