<?php
//Inicio la sesion 
session_start();
include("../conexion.php");
include("../funciones.php");

$ResUsuario=mysqli_query($conn, "SELECT * FROM usuarios WHERE Id='".$_POST["idusuario"]."'");
$ResUSueldo=mysqli_query($conn, "SELECT * FROM usuarios_sueldos WHERE IdUsuario='".$_POST["idusuario"]."' ORDER BY Fecha DESC LIMIT 1");
$RResUsuario=mysqli_fetch_array($ResUsuario);
$RResUSueldo=mysqli_fetch_array($ResUSueldo);

$cadena='<div class="c100 card">
            <h2>Editar usuario</h2>
            <form name="fedituser" id="fedituser">
                <div class="c30">
                    <label class="l_form">Nombre :</label>
                    <input type="text" name="nombre" id="nombre" value="'.$RResUsuario["Nombre"].'">
                </div>
                <div class="c30">
                    <label class="l_form">Telefono :</label>
                    <input type="text" name="telefono" id="telefono" value="'.$RResUsuario["Telefono"].'">
                </div>
                <div class="c30">
                    <label class="l_form">Correo Electrónico:</label>
                    <input type="text" name="correoe" id="correoe" value="'.$RResUsuario["CorreoE"].'">
                </div>
                <div class="c30">
                    <label class="l_form">Usuario :</label>
                    <input type="text" name="usuario" id="usuario" value="'.$RResUsuario["Usuario"].'">
                </div>
                <div class="c30">
                    <label class="l_form">Contraseña :</label>
                    <input type="text" name="contrasena" id="contrasena">
                </div>
                <div class="c30">
                    <label class="l_form">Perfil :</label>
                    <select name="perfil" id="perfil">
                        <option value="0">Seleccione</option>';
$ResPerfiles=mysqli_query($conn, "SELECT * FROM perfiles WHERE Id!=1 ORDER BY Nombre ASC");
while($RResPer=mysqli_fetch_array($ResPerfiles))
{
    $cadena.='          <option value="'.$RResPer["Id"].'"'.($RResUsuario["Perfil"] == $RResPer["Id"] ? ' selected' : '').'>'.$RResPer["Nombre"].'</option>';
}
$cadena.='          </select>
                </div>
                <div class="c30">
                    <label class="l_form">Sueldo Fijo:</label>
                    <input type="number" name="sueldofijo" id="sueldofijo" step="0.01" min="0" value="'.$RResUSueldo["SueldoFijo"].'">
                </div>
                <div class="c30">
                    <label class="l_form">Sueldo Variable:</label>
                    <input type="number" name="sueldovariable" id="sueldovariable" step="0.01" min="0" value="'.$RResUSueldo["SueldoVariable"].'">
                </div>
                <div class="c30">
                    <label class="l_form">Tipo de Sueldo:</label>
                    <select name="tiposueldo" id="tiposueldo">
                        <option value="Hora"'.($RResUSueldo["TipoSueldo"] == 'Hora' ? ' selected' : '').'>Hora</option>
                        <option value="Dia"'.($RResUSueldo["TipoSueldo"] == 'Dia' ? ' selected' : '').'>Día</option>
                        <option value="Semana"'.($RResUSueldo["TipoSueldo"] == 'Semana' ? ' selected' : '').'>Semana</option>
                        <option value="Quincena"'.($RResUSueldo["TipoSueldo"] == 'Quincena' ? ' selected' : '').'>Quincena</option>
                        <option value="Mes"'.($RResUSueldo["TipoSueldo"] == 'Mes' ? ' selected' : '').'>Mes</option>
                    </select>
                </div>
                <div class="c100">
                    <input type="hidden" name="hacer" id="hacer" value="editusuario">
                    <input type="hidden" name="idusuario" id="idusuario" value="'.$RResUsuario["Id"].'">
                    <input type="submit" name="botaduser" id="botaduser" value="Editar>>" onclick="cerrarmodal()">
                </div>
            </form>
            </div>';

echo $cadena;
?>
<script>
    $("#fedituser").on("submit", function(e){
	e.preventDefault();
	var formData = new FormData(document.getElementById("fedituser"));

	$.ajax({
		url: "configuracion/usuarios.php",
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