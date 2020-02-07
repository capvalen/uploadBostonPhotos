<?php include "conexion.php";
if( isset($_COOKIE['ckPower'])){
  if($_COOKIE['ckPower']=='2'){
  header('Location: fichas.php');    
  }

}else{ header('Location: index.php'); }

?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Boston Abregú Realty - BIENES RAICES</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<link rel="stylesheet" href="css/icofont.min.css">
	<link rel="icon" type="image/vnd.microsoft.icon" href="images/favicon.ico">

</head>
<body class=" mb-5">
<style>
  img{max-width: 100vh;}
.form-row{ margin-top:20px;}
.form-row label{ font-weight:700; }
.fixed-top{top: 50px;}
#overlay {
    position: fixed; /* Sit on top of the page content */
    display: none; /* Hidden by default */
    width: 100%; /* Full width (cover the whole page) */
    height: 100%; /* Full height (cover the whole page) */
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: rgba(0,0,0,0.75); /* Black background with opacity */
    z-index: 1051; /* Specify a stack order in case you're using a different order for other elements */
   /* Add a pointer on hover */
}
#overlay .text{position: absolute;
    top: 50%;
    left: 50%;
    font-size: 18px;
    color: white;
    user-select: none;
    transform: translate(-50%,-50%);
}
#hojita{font-size: 36px; display: inline; animation: cargaData 6s ease infinite;}
#pFrase{ display: inline; }
#pFrase span{ font-size: 13px;}
@keyframes cargaData {
    0%  {color: #96f368;}
    25%  {color: #f3dd68;}
    50% {color: #f54239;}
    75% {color: #c173ce;}
    100% {color: #33dbdb;}
}
</style>
<!-- As a heading -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <span class="navbar-brand mb-0 h1">Boston Abregú Realty</span>
  <div class="collapse navbar-collapse">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item ">
        <a class="nav-link" href="ficha.php">Fichas </a>
      </li>
      <li class="nav-item active">
        <a class="nav-link" href="subida.php">Nueva ficha</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="asesor.php">Nuevo asesor</a>
      </li>
    </ul>
  </div>
</nav>

  <div class="row container">
    <div class="col text-center">
      <img src="images/logo.png?v=1.0.1" class="">
      <p><strong>Bienes Raices</strong></p>
    </div>
  </div>
  <div class="container">
	<form id="formUploadImage" action="upload.php" method="post">
  <div class="card ">
    <div class="card-body">
    
      <p>Por favor rellene cuidadosamente los campos para que pueda colgar una ficha nueva.</p>
        <div class="form-row">
          <div class="col-3">
            <label for="">Título de la ficha</label>
          </div>
          <div class="col-7">
            <input type="text" class="form-control" name="txtTitulo" autocomplete="off">
          </div>
        </div>
        <div class="form-row">
          <div class="col-3">
            <label for="">Precio</label>
          </div>
          <div class="col-7">
            <input type="text" class="form-control" name="txtPrecio" value="S/ " autocomplete="off">
          </div>
        </div>
        <div class="form-row">
          <div class="col-3">
            <label for="">Dirección</label>
          </div>
          <div class="col-7">
            <input type="text" class="form-control" name="txtDireccion" autocomplete="off">
          </div>
        </div>
        <div class="form-row">
          <div class="col-3">
            <label for="">Tipo de propiedad</label>
          </div>
          <div class="col-7">
            <input type="text" class="form-control" name="txtPropiedad" autocomplete="off">
          </div>
        </div>
        <div class="form-row">
          <div class="col-3">
            <label for="">Área del terreno</label>
          </div>
          <div class="col-7">
            <input type="text" class="form-control" name="txtATerreno" autocomplete="off">
          </div>
        </div>
        <div class="form-row">
          <div class="col-3">
            <label for="">Área de construcción</label>
          </div>
          <div class="col-7">
            <input type="text" class="form-control" name="txtAConstruccion" autocomplete="off">
          </div>
        </div>
        <div class="form-row">
          <div class="col-3">
            <label for="">Frontis</label>
          </div>
          <div class="col-7">
            <input type="text" class="form-control" name="txtFrontis" autocomplete="off">
          </div>
        </div>
        <div class="form-row">
          <div class="col-3">
            <label for="">Dormitorios</label>
          </div>
          <div class="col-7">
            <input type="text" class="form-control" name="txtDormitorios" autocomplete="off">
          </div>
        </div>
        <div class="form-row">
          <div class="col-3">
            <label for="">Baños</label>
          </div>
          <div class="col-7">
            <input type="text" class="form-control" name="txtBanio" autocomplete="off">
          </div>
        </div>
        <div class="form-row">
          <div class="col-3">
            <label for="">Cochera</label>
          </div>
          <div class="col-7">
            <input type="text" class="form-control" name="txtCochera" autocomplete="off">
          </div>
        </div>
        <div class="form-row">
          <div class="col-3">
            <label for="">Descripción</label>
          </div>
          <div class="col-7">
              <textarea class="form-control" name="txtDescripcion" autocomplete="off"></textarea>
          </div>
        </div>
        <div class="form-row">
          <div class="col-3">
            <label for="">Asesor</label>
          </div>
          <div class="col-7">
            <select class="form-control" name="txtAsesor" >
                <?php $sqlAsesor="SELECT `idAsesor`, upper(`aseNombre`) as aseNombre, `aseCelular`, `aseCorreo`, `aseActivo` FROM `asesor` WHERE aseActivo=1 order by aseNombre asc;";
                $resultadoAsesor=$cadena->query($sqlAsesor);
                while($rowAsesor=$resultadoAsesor->fetch_assoc()){ ?>
                <option value="<?= $rowAsesor['idAsesor']; ?>"><?= $rowAsesor['aseNombre']; ?></option>
                <?php } ?>
            </select>
          </div>
        </div>
    </div>
		</div>
<div class="fixed-top">
<div class="toast ml-auto mr-3 mt-3" role="alert" id="tostadaError" data-delay="700" data-autohide="false">
    <div class="toast-header">
        <strong class="mr-auto text-danger">Advertencias para subir</strong>
        <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
            <span aria-hidden="true">×</span>
        </button>
    </div>
    <div class="toast-body" id="toastError">
    </div>
</div>
</div>
	
	<div class="card mt-3">
      <div class="card-body">
        <div class="form-row">
          <div class="col-3">
            <label for="">Foto 1</label>
          </div>
          <div class="col-7">
            <input type="file" class="form-control" accept="image/*" id="txtFoto1" name="txtFoto1" />
          </div>
        </div>
        <div class="form-row">
          <div class="col-3">
            <label for="">Foto 2</label>
          </div>
          <div class="col-7">
            <input type="file" class="form-control" accept="image/*" id="txtFoto2" name="txtFoto2" />
          </div>
        </div>
        <div class="form-row">
          <div class="col-3">
            <label for="">Foto 3</label>
          </div>
          <div class="col-7">
            <input type="file" class="form-control" accept="image/*" id="txtFoto3" name="txtFoto3" />
          </div>
        </div>
        <div class="d-flex justify-content-center mt-4">
		  <input type="submit" class="btn btn-outline-warning btn-lg" id="btnGuardarFicha" value=" Guardar ficha">
        </div>
      </div>
    </div>
	
	</form>
<div id="overlay">
	<div class="text"><span id="hojita"><i class="icofont-leaf"></i></span> <p id="pFrase"> Subiendo los datos... <span id="porcentajeSub"></span> <br> <span>«Pregúntate si lo que estás haciendo hoy <br> te acerca al lugar en el que quieres estar mañana» <br> Walt Disney</span></p></div>
</div>
</div>
    


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.2.2/jquery.form.js"></script> <!-- extraido de https://jquery-form.github.io/form/ -->

<script>
function pantallaOver(tipo) {
	if(tipo){$('#overlay').css('display', 'initial');}
	else{ $('#overlay').css('display', 'none'); }
}

$('#formUploadImage').submit(function () {
    event.preventDefault();
    var basicoRellenado = false;
    pantallaOver(true);
    $.each( $("input[type='text']"), function(i, elem){
       if($(elem).val()==''){
           $(elem).focus();
           basicoRellenado=true;
           return false;
       }
    });
    if( basicoRellenado ){
        $('#toastError').text("Todos los campos tienen que ser rellenados"); $('#tostadaError').toast('show');
        pantallaOver(false);
    }else{
        if($('#txtFoto1').val() && $('#txtFoto2').val() && $('#txtFoto3').val() ){
            //console.log('algo para subir')
            $(this).ajaxSubmit({
                beforeSubmit: function () {
                    $('#porcentajeSub').text("0%");
                },
                uploadProgress: function(event, position, total, percentageComplete){
                    $('#porcentajeSub').text(percentageComplete + '%');
                },
                success:function( resp ){ //console.log(resp)
                    if(resp=='vacio'){
                        $('#toastError').text("No se subieron las fotos por falta de fotos"); $('#tostadaError').toast('show');
                    }
                    if( $.isNumeric(resp)){
                        location.href = "ficha.php?cursor="+resp;
                    }
                    pantallaOver(false);
                },
                //resetForm: true
            });
        }else{
            //console.log('nada para subir')
            $('#toastError').text("Tiene que ingresar 3 fotos para poder subir la ficha"); $('#tostadaError').toast('show');
            pantallaOver(false);
            return false;
        }
    }
});
</script>
</body>
</html>