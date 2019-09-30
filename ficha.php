<?php include "conexion.php"; ?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Boston Abregú Realty - BIENES RAICES</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <link rel="icon" type="image/vnd.microsoft.icon" href="images/favicon.ico">
  <link rel="stylesheet" href="css/icofont.min.css">
</head>
<body>
<style>
img{max-width: 100vh;}
.divCinta{ height: 5px; background-color: #C59641; }
p{margin-bottom: .4rem;}
.divFoto, .divSello{ width: 75%; height: 130px; margin: 0 auto; border: 2px solid #C59641!important;  }
.divSello{height: 250px; width: 100%;}
@media print{
  img{max-width: 30vh;}
  .divCinta{ height: 5px!important; background-color: #C59641!important; -webkit-print-color-adjust: exact; }
}
a{color: #c79121;}
a:hover{color: #a5730d;}
#pPrecio{ border: 2px solid #000!important; font-weight: 700; font-size: 1.2rem; }
.col-7 { max-width: 56%; }
.col-6 { max-width: 49%; }
.col-4 { max-width: 32%; }
.col-8 { max-width: 65%; }
#divAsesor p{  margin-bottom: 0.1rem; }
.border-abregu{
  border: 2px solid #C59641!important;
}
</style>
<!-- As a heading -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <span class="navbar-brand mb-0 h1">Boston Abregú Realty</span>
  <div class="collapse navbar-collapse">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active">
        <a class="nav-link" href="ficha.php">Fichas </a>
      </li>
      <?php if($_COOKIE['ckPower']=="1"): ?>
      <li class="nav-item">
        <a class="nav-link" href="subida.php">Nueva ficha</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="asesor.php">Nuevo asesor</a>
      </li>
       <?php endif;?>
       <li class="nav-item">
        <a class="nav-link" href="desconectar.php">Desconectar</a>
      </li>
    </ul>
  </div>
</nav>

<div class="container-fluid pt-3">

  <div class="row">
    <div class="col text-center">
      <img src="images/logo.png?v=1.0.1" class="">
      <p><strong>Bienes Raices</strong></p>
    </div>
  </div>
<?php if(!isset($_GET['cursor'])){ ?>
<div class="container">
    <div class="row">
        <p>Listado de propiedades:</p>
        <table class="table table-hover">
            <thead>
								<tr>
										<th>N°</th> <th>Título de inmueble</th><th>Precio</th>
								</tr>
						</thead>
						<?php $sqlInmueble="SELECT `idFicha`, `fichTitulo`, `fichPrecio` FROM `fichas` WHERE `fichActivo`=1 order by fichFechaAuto desc; "; 
						$resultadoInmueble=$cadena->query($sqlInmueble); $i=1; ?>
						<tbody>
								<?php while($rowInmueble=$resultadoInmueble->fetch_assoc()){ ?>
								<tr>
										<td><?= $i; ?></td> <td><a class="text-decoration-none" href="ficha.php?cursor=<?= $rowInmueble['idFicha']; ?>"><?= $rowInmueble['fichTitulo']; ?></a></td><td><?= $rowInmueble['fichPrecio']; ?> <?php if($_COOKIE['ckPower']==1): ?>
                  <button class="btn button btn-danger btn-sm" onClick="borrarFicha(<?= $rowInmueble['idFicha']; ?>);" ><i class="icofont-close"></i></button>  
                <?php endif; ?></td>
                
								</tr>
								<?php $i++; } ?>
						</tbody>
        </table>
    </div>
</div>
<?php } else{ 
    $sql="SELECT `idFicha`, `fichTitulo`, `fichPrecio`, `fichDireccion`, `fichTipoPropiedad`, `fichAreaTerreno`, `fichAreaConstruccion`, `fichFrontis`, `fichDormitorios`, `fichBanios`, `fichCochera`, `fichDescipcion`, `idAsesor`, `fichFechaAuto` FROM `fichas` WHERE idFicha={$_GET['cursor']};";
    $resultado=$cadena->query($sql);
    $row=$resultado->fetch_assoc();
    if($resultado->num_rows==1){
?>
  <div class="row my-2 divCinta"></div>
  <h4 class="text-center"><strong>AHORA ES MÁS FÁCIL EN HUANCAYO VENDER, COMPRAR Y ALQUILAR SU PROPIEDAD CON GARANTÍA</strong></h4>
  <p class="text-center"><strong>INFORMACIÓN DE LA PROPIEDAD</strong></p>
  <div class="row my-2 divCinta"></div>
  <div class="row mb-2">
    <div class="col-7 rounded border border-abregu p-2 mr-2"><img src="<?php
                                $foto1= './images/inmuebles/'.$_GET['cursor']."_foto1";
                                if(file_exists($foto1.".jpg")){ echo $foto1.".jpg"; } 
                                if(file_exists($foto1.".png")){ echo $foto1.".png"; } 
                                if(file_exists($foto1.".jpeg")){ echo $foto1.".jpeg"; } ?>"  class="img-fluid"></div>
    <div class="col-5 rounded border border-abregu p-2 ml-2">
       <p class="float-right p-3" id="pPrecio"> <?= $row['fichPrecio'];?></p><br>
      <p><strong>Dirección: </strong> <span><?= $row['fichDireccion'];?></span> </p>
      <p><strong>Tipo de propiedad: </strong> <span><?= $row['fichTipoPropiedad'];?></span></p>
      <p><strong>Área del terreno</strong> <span><?= $row['fichAreaTerreno'];?></span></p>
      <p><strong>Área de la construcción: </strong> <span><?= $row['fichAreaConstruccion'];?></span></p>
      <p><strong>Frontis: </strong> <span><?= $row['fichFrontis'];?></span></p>
      <p><strong>Dormitorios: </strong> <span><?= $row['fichDormitorios'];?></span></p>
      <p><strong>Baños: </strong> <span><?= $row['fichBanios'];?></span></p>
      <p><strong>Cochera: </strong> <span><?= $row['fichCochera'];?></span></p>
    </div>
  </div>
  <!-- <div class="row my-3 rounded border border-abregu p-2 mr-2"></div>
  <div class="row mb-3">
    <div class="col-6 rounded border border-abregu p-2 mr-2">
      
    </div>
    <div class="col-6 rounded border border-abregu p-2 ml-2">
      <img src="images/inmuebles/GYM.RGB_color.0000.jpg" class="img-fluid">
    </div>
  </div> -->
  <div class="row ">
    <div class="col">
      <div class="my-1 rounded border border-abregu p-2 mr-2">
        <img src="<?php
                                $foto1= './images/inmuebles/'.$_GET['cursor']."_foto2";
                                if(file_exists($foto1.".jpg")){ echo $foto1.".jpg"; } 
                                if(file_exists($foto1.".png")){ echo $foto1.".png"; } 
                                if(file_exists($foto1.".jpeg")){ echo $foto1.".jpeg"; } ?>" class="img-fluid">
      </div>
      <div class="my-1 rounded border border-abregu p-2 mr-2">
        <img src="<?php
                                $foto1= './images/inmuebles/'.$_GET['cursor']."_foto3";
                                if(file_exists($foto1.".jpg")){ echo $foto1.".jpg"; } 
                                if(file_exists($foto1.".png")){ echo $foto1.".png"; } 
                                if(file_exists($foto1.".jpeg")){ echo $foto1.".jpeg"; } ?>" class="img-fluid">
      </div>
    </div>
    <div class="col my-1 rounded border border-abregu p-2 mr-2">
      <p><strong>Descripción:</strong></p>
        <span><?= str_replace(array("\r\n", "\n\r", "\r", "\n"), "<br />", $row['fichDescipcion']);?></span>
    </div>
  </div>

  <div class="row mb-3 mt-0" id="divAsesor">
    <div class="col-4  rounded border border-abregu p-1 mr-2">
      <p class="text-center"><strong>Asesor Inmobiliario</strong></p>
        <?php $sqlAsesor="SELECT `idAsesor`, lower(`aseNombre`) as aseNombre, `aseCelular`, `aseCorreo`, `aseActivo` FROM `asesor` WHERE idAsesor={$row['idAsesor']} ";
        $resultadoAsesor=$cadena->query($sqlAsesor);
        $rowAsesor=$resultadoAsesor->fetch_assoc(); ?>
      <div class="divFoto text-center">
        <img src="<?php $foto1= './images/empleado/'.$row['idAsesor']."_foto1";
                                if(file_exists($foto1.".jpg")){ echo $foto1.".jpg"; }else{ echo "images/empleado/user.png";}  ?>" class="img-fluid" style="max-height: 100%;">
      </div>
      <p class="text-capitalize"><strong>Nombre: </strong> <?= $rowAsesor['aseNombre'];?> </p>
      <p><strong>Celular: </strong> <?= $rowAsesor['aseCelular'];?></p>
      <p><strong>Correo: </strong> <?= $rowAsesor['aseCorreo'];?> </p>
    </div>
    <div class="col-8 rounded border border-abregu p-1 ml-2">
      <div class="row d-flex align-items-center">
        <div class="col-9">
          <h4>BOSTON  ABREGU REALTY</h4>
          <h5>Jr. San Antonio N° 260 – San Carlos</h5>
          <h5>Tel. Oficina: (064) 217  255</h5>
            <h4 class="mt-3">Facebook: bostonabregurealty</h4>
        </div>
        <div class="col">
          <img src="images/qr.png" class="img-fluid">
        </div>
      </div>
    </div>
    <div class="col text-center"><h4 class="mt-1 ">WWW.BOSTONABREGUREALTY.COM</h4></div>

  </div>
</div>
<?php  } } ?>
  


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>


<script type="text/javascript">
<?php if($_COOKIE['ckPower']==1): ?>
function borrarFicha(idFicha){
  $.ajax({url:"borrarficha.php", type: 'POST', data:{ficha:idFicha}}).done(function(resp){
    location.reload();
  })
}
<?php endif; ?>
</script>
</body>
</html>