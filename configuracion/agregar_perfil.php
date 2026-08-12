<?php
//Inicio la sesion 
session_start();
include("../conexion.php");
include("../funciones.php");

$cadena='<div class="c100 card">
            <h2>Nuevo Perfil</h2>
            <form name="fadperfil" id="fadperfil">
                <div class="c100">
                    <label class="l_form">Nombre perfil:</label>
                    <input type="text" name="nombre" id="nombre">
                </div>
                <div class="c100">';
$ResPermisos=mysqli_query($conn, "SELECT Modulo FROM perfiles GROUP BY Modulo ORDER BY Modulo ASC");
while($RResPerm=mysqli_fetch_array($ResPermisos))
{
    $cadena.='<div class="c100">
                    <h3>'.$RResPerm["Modulo"].'</h3>';
    $ResFuncion=mysqli_query($conn, "SELECT * FROM perfiles WHERE Modulo = '".$RResPerm["Modulo"]."' ORDER BY Funcion ASC");
    while($RResFunc=mysqli_fetch_array($ResFuncion))
    {
        $cadena.='<div class="c100">
                    <label class="l_form">'.$RResFunc["Funcion"].':</label>
                    <input type="checkbox" name="permisos[]" id="permisos[]" value="'.$RResFunc["Id"].'">
                </div>';
    }
    $cadena.='</div>';
}
$cadena.='      </div>
                <div class="c100">
                    <input type="hidden" name="hacer" id="hacer" value="addperfil">
                    <input type="submit" name="botaduser" id="botaduser" value="Agregar>>" onclick="cerrarmodal()">
                </div>
			</form>
        </div>';
    
echo $cadena;

?>

<script>
$("#fadperfil").on("submit", function(e){
	e.preventDefault();
	var formData = new FormData(document.getElementById("fadperfil"));

	$.ajax({
		url: "mesacontrol/configuracion/usuarios/perfiles.php",
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
//Created with human intelligence by @jkarreno 2023 - 2024
//May the force be with you
//move your stars
//always ready
?>