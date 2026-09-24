<?php
//Inicio la sesion 
session_start();
include("../conexion.php");
include("../funciones.php");

$ResProyecto = mysqli_fetch_array(mysqli_query($conn, "SELECT p.Id, p.NombreProyecto, p.FechaCreacion, p.FechaInicio, p.FechaFin, p.FechaEntrega, p.Estatus, 
                                                            p.Descripcion, p.UbicacionMontaje, c.Nombre AS NombreCliente 
                                                        FROM proyectos p 
                                                        INNER JOIN clientes c ON p.IdCliente = c.Id 
                                                        WHERE p.Id='".$_POST["idproyecto"]."'"));

$cadena='<div class="c100 card">
            <h2>Proyecto</h2>
            <form name="feditproyecto" id="feditproyecto">
                <div class="c30">
                    <label class="l_form">Cliente :</label>
                    <input type="text" name="cliente" id="cliente" value="'.$ResProyecto["NombreCliente"].'" disabled>
                </div>
                <div class="c30">
                    <label class="l_form">Nombre Proyecto:</label>
                    <input type="text" name="nombre_proyecto" id="nombre_proyecto" value="'.$ResProyecto["NombreProyecto"].'">
                </div>
                <div class="c30">
                    <label class="l_form">Fecha de entrega:</label>
                    <input type="date" name="fecha_entrega" id="fecha_entrega" value="'.($ResProyecto["FechaEntrega"]!=NULL ? date("Y-m-d", $ResProyecto["FechaEntrega"]) : '').'">
                </div>

                <div class="c30">
                    <label class="l_form">Fecha creación:</label>
                    <input type="date" name="fecha_creacion" id="fecha_creacion" value="'.date("Y-m-d", $ResProyecto["FechaCreacion"]).'" disabled>
                </div>
                <div class="c30">
                    <label class="l_form">Fecha inicio:</label>
                    <input type="date" name="fecha_inicio" id="fecha_inicio" value="'.($ResProyecto["FechaInicio"]!=NULL ? date("Y-m-d", $ResProyecto["FechaInicio"]) : '').'">
                </div>
                <div class="c30">
                    <label class="l_form">Fecha termino:</label>
                    <input type="date" name="fecha_termino" id="fecha_termino" value="'.($ResProyecto["FechaFin"]!=NULL ? date("Y-m-d", $ResProyecto["FechaFin"]) : '').'">
                </div>

                <div class="c30">
                    <label class="l_form">Estatus:</label>
                    <select name="estatus" id="estatus">
                        <option value="">Seleccione un estatus</option>';
$ResEstatusProyectos = mysqli_query($conn, "SELECT * FROM cat_estatus_proyectos ORDER BY Orden ASC");
while($RResEP = mysqli_fetch_array($ResEstatusProyectos))
{
    $cadena.='          <option value="'.$RResEP["Id"].'"'.($RResEP["Id"]==$ResProyecto["Estatus"] ? ' selected' : '').'>'.$RResEP["Estatus"].'</option>';
}
$cadena.='              <option value="0">Cancelado</option>
                    </select>
                </div>
                <div class="c30">
                    <label class="l_form">Ubicación Montaje: </label>
                    <input type="text" name="ubicacion_montaje" id="ubicacion_montaje" value="'.$ResProyecto["UbicacionMontaje"].'">
                </div>
                <div class="c30"></div>

                <div class="c100">
                    <label class="l_form">Descripción:</label>
                    <textarea name="descripcion" id="descripcion">'.$ResProyecto["Descripcion"].'</textarea>
                </div>';

if(permisos($_SESSION["perfil"], "edit.proyecto")) 
{
    $cadena.='  <div class="c100">
                    <input type="hidden" name="hacer" id="hacer" value="editproyecto">
                    <input type="hidden" name="idproyecto" id="idproyecto" value="'.$ResProyecto["Id"].'">
                    <input type="submit" name="botadproyecto" id="botadproyecto" value="Guardar Cambios" onclick="cerrarmodal()">
                </div>';
}
$cadena.='  </form>
        </div>';

echo $cadena;
?>
<script>
$("#feditproyecto").on("submit", function(e){
    e.preventDefault();
    var formData = new FormData(document.getElementById("feditproyecto"));

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