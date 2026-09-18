<?php
//Inicio la sesion 
session_start();
include("../conexion.php");
include("../funciones.php");

$ResCliente=mysqli_query($conn, "SELECT * FROM clientes WHERE Id='".$_POST["idcliente"]."'");
$RResCliente=mysqli_fetch_array($ResCliente);

$cadena='<div class="c100 card">
            <h2>Editar cliente</h2>
            <form name="feditcliente" id="feditcliente">
                <div class="c30">
                    <label class="l_form">Nombre :</label>
                    <input type="text" name="nombre" id="nombre" value="'.$RResCliente["Nombre"].'">
                </div>
                <div class="c30">
                    <label class="l_form">Razón Social :</label>
                    <input type="text" name="razon_social" id="razon_social" value="'.$RResCliente["RazonSocial"].'">
                </div>
                <div class="c30">
                    <label class="l_form">Rfc :</label>
                    <input type="text" name="rfc" id="rfc" value="'.$RResCliente["RFC"].'">
                </div>

                <div class="c30">
                    <label class="l_form">Dirección :</label>
                    <input type="text" name="direccion" id="direccion" value="'.$RResCliente["Direccion"].'">
                </div>
                <div class="c30">
                    <label class="l_form">Telefono :</label>
                    <input type="text" name="telefono" id="telefono" value="'.$RResCliente["Telefono"].'">
                </div>
                <div class="c30">
                    <label class="l_form">Correo Electrónico :</label>
                    <input type="text" name="correoe" id="correoe" value="'.$RResCliente["CorreoE"].'">
                </div>

                <div class="c100">
                    <input type="hidden" name="hacer" id="hacer" value="editcliente">
                    <input type="hidden" name="idcliente" id="idcliente" value="'.$RResCliente["Id"].'">
                    <input type="submit" name="boteditcliente" id="boteditcliente" value="Guardar Cambios" onclick="cerrarmodal()">
                </div>
            </form>
        </div>';

echo $cadena;
?>
<script>
$("#feditcliente").on("submit", function(e){
    e.preventDefault();
    var formData = new FormData(document.getElementById("feditcliente"));

    $.ajax({
        url: "clientes/clientes.php",
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