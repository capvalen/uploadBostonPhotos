<?php include "conexion.php"; ?>

<!DOCTYPE html>

<html lang="es">

<head>

  <meta charset="UTF-8">

  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <meta http-equiv="X-UA-Compatible" content="ie=edge">

  <title>Boston Abregú Realty - BIENES RAICES</title>

  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  
  <link href="https://fonts.googleapis.com/css?family=Barlow+Semi+Condensed:400,700&display=swap" rel="stylesheet">


  <link rel="icon" type="image/vnd.microsoft.icon" href="images/favicon.ico">

  <link rel="stylesheet" href="css/icofont.min.css">

</head>

<body>

<style>

    
img{max-width: 100vh;}

.divCinta{ height: 5px; background-color: #C59641; }

p{margin-bottom: .4rem;}

.divFoto, .divSello{ width: 40%; height: 130px; margin: 0 auto; border: 2px solid #C59641!important;  }

.divSello{height: 250px; width: 100%;}

@media print{

  img{max-width: 60vh;}

  .divCinta{ height: 7px!important; background-color: #C59641!important; -webkit-print-color-adjust: exact; }
	#fondoNegro{background: #1f191b!important; color:white!important; -webkit-print-color-adjust: exact; }
}

#h3Titulo, #h4Vino{color: #ae2c1a;}
    
a{color: #c79121;}

a:hover{color: #a5730d;}

    #pPrecio{ border: 6px solid #ae2c1a!important; color: #ae2c1a; font-weight: 700; font-size: 1.8rem!important; }

.col-7 { max-width: 54.5%; }

.col-6 { max-width: 49%; }

.col-4 { max-width: 32%; }

.col-8 { max-width: 67%; }

.col-5 { max-width: 44%; flex: 0 0 44%!important; }
/*#row1 p, #divContenido {font-size: 1.1rem;}
*/
#divAsesor p{  margin-bottom: 0.1rem; }
#fotoEmpleado{ max-height: 99%;
    margin-top: 1px;
    padding-bottom: 1px;}

#containerPadre, .border-abregu{
  border: 4px solid #C59641!important;
}
#colLogo{ width: 50%;}
#fondoNegro{background: #1f191b; color:white;}
#spanCorreo{ font-size: 0.8rem; }
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



<div class="container-fluid pt-0 px-0" id="containerPadre">



  <div class="row">

    <div class="col text-center">

      <div id="colLogo" style="margin: 0 auto;"><img src="images/logo.png?v=1.0.3" class="img-fluid" style="padding-top:2px" ></div>

      <p class="p-0 m-0"><strong>BIENES RAICES</strong></p>

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
                  <button class="btn button btn-success btn-sm" onClick="cambiarPrecio(<?= $rowInmueble['idFicha']; ?>, '<?= $rowInmueble['fichPrecio']; ?>');" ><i class="icofont-edit"></i></button>  

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

  <div class="row mt-2 divCinta"></div>

  <div class="p-2" id="fondoNegro">
  	<h4 class="text-center m-0"><strong>AHORA ES MÁS FÁCIL EN HUANCAYO VENDER,<br> COMPRAR Y ALQUILAR SU PROPIEDAD CON GARANTÍA</strong></h4>
  </div>

  

  <div class="row divCinta"></div>

  <div class='row p-3 text-center justify-content-center'><h3 class="m-0" id="h3Titulo"><strong>INFORMACIÓN DE LA PROPIEDAD</strong></h3></div>

  <div class="row mb-1 px-3" id="row1">

    <div class="col-7 rounded border border-abregu p-0 mr-1 ml-1"><img src="<?php

                                $foto1= './images/inmuebles/'.$_GET['cursor']."_foto1";

                                if(file_exists($foto1.".jpg")){ echo $foto1.".jpg"; } 

                                if(file_exists($foto1.".png")){ echo $foto1.".png"; } 

                                if(file_exists($foto1.".jpeg")){ echo $foto1.".jpeg"; } ?>"  class="img-fluid"></div>

    <div class="col-5 rounded border border-abregu p-2 ml-1">
      <div class=" ">
       <p class="float-right py-1 px-3 ml-3" id="pPrecio"> <?= $row['fichPrecio'];?></p>
       </div>

      <p class="text-uppercase"><strong>Dirección: </strong> <span><?= $row['fichDireccion'];?></span> </p>

      <p class="text-uppercase"><strong>Tipo de propiedad: </strong> <span><?= $row['fichTipoPropiedad'];?></span></p>

      <p class="text-uppercase"> <strong>Área del terreno</strong> <span><?= $row['fichAreaTerreno'];?></span></p>

      <p class="text-uppercase"><strong>Área de la construcción: </strong> <span><?= $row['fichAreaConstruccion'];?></span></p>

      <p class="text-uppercase"><strong>Frontis: </strong> <span><?= $row['fichFrontis'];?></span></p>

      <p class="text-uppercase"><strong>Dormitorios: </strong> <span><?= $row['fichDormitorios'];?></span></p>

      <p class="text-uppercase"><strong>Baños: </strong> <span><?= $row['fichBanios'];?></span></p>

      <p class="text-uppercase"><strong>Cochera: </strong> <span><?= $row['fichCochera'];?></span></p>

    </div>

  </div>

  <div class="row mb-1 px-3" id="row2">

    <div class="col-7  p-0 mr-1 ml-1">

    	<div class="rounded border border-abregu ">
        <img src="<?php

                                $foto2= './images/inmuebles/'.$_GET['cursor']."_foto2";

                                if(file_exists($foto2.".jpg")){ echo $foto2.".jpg"; } 

                                if(file_exists($foto2.".png")){ echo $foto2.".png"; } 

                                if(file_exists($foto2.".jpeg")){ echo $foto2.".jpeg"; } ?>" class="img-fluid">
		</div>
      <div class="my-1 rounded border border-abregu ">

        <img src="<?php

                                $foto3= './images/inmuebles/'.$_GET['cursor']."_foto3";

                                if(file_exists($foto3.".jpg")){ echo $foto3.".jpg"; } 

                                if(file_exists($foto3.".png")){ echo $foto3.".png"; } 

                                if(file_exists($foto3.".jpeg")){ echo $foto3.".jpeg"; } ?>" class="img-fluid">

      </div>

    </div>

    <div class="col-5 my-1 rounded border border-abregu p-2 ml-1 text-justify" id="rowDescripcion">

      <div class="text-uppercase"> <h5><strong>Descripción:</strong></h5> </div>
      <div class="px-4" id="divContenido"><?= str_replace(array("\r\n", "\n\r", "\r", "\n"), "<br />", $row['fichDescipcion']);?></div>
    </div>

  </div>


  <?php if(isset($_GET['asesor'])): ?>
  <div class="row mb-1 px-3 mt-0" id="divAsesor">

    <div class="col-4 rounded border border-abregu p-1 mr-1 ml-1">

      <p class="text-center text-uppercase"><strong>Asesor Inmobiliario</strong></p>

        <?php $sqlAsesor="SELECT `idAsesor`, lower(`aseNombre`) as aseNombre, `aseCelular`, `aseCorreo`, `aseActivo` FROM `asesor` WHERE idAsesor= {$_GET['asesor']} "; //{$row['idAsesor']}

        $resultadoAsesor=$cadena->query($sqlAsesor);

        $rowAsesor=$resultadoAsesor->fetch_assoc(); ?>

      <div class="divFoto text-center">

        <img id="fotoEmpleado" src="<?php $foto1= './images/empleado/'.$_GET['asesor']."_foto1";

                                if(file_exists($foto1.".jpg")){ echo $foto1.".jpg"; }else{ echo "images/empleado/user.png";}  ?>" class="img-fluid" style="max-height: 100%;">

      </div>

      <p class="text-uppercase"><strong>Nombre: </strong> <?= $rowAsesor['aseNombre'];?> </p>

      <p class="text-uppercase"><strong>Celular: </strong> <?= $rowAsesor['aseCelular'];?></p>

      <p class="text-uppercase"><strong>Correo: </strong> <span id="spanCorreo"><?= $rowAsesor['aseCorreo'];?></span> </p>

    </div>

    <div class="col-8 rounded border border-abregu ml-1">

      <!-- <div class="row d-flex align-items-center">

        <div class="col-8"><br>

          <h4 style="font-weight: 600;">BOSTON  ABREGU REALTY</h4>

          <h5>Jr. San Antonio N° 260 – San Carlos</h5>

          <h5>Tel. Oficina: (064) 217  255</h5>
        <h5>Correo: contacto@bostonabregurealty.com</h5>

            <h4 style="font-weight: 600;" class="mt-2">Facebook: bostonabregurealty</h4>
            <h4 style="font-weight: 600;" class="mt-0 ">WWW.BOSTONABREGUREALTY.COM</h4>
        </div>

        <div class="col-3 d-flex align-items-center">

          <img src="images/qr.png" width="230" height="230" class="img-fluid">

        </div> -->
        <img src="images/firma.png?v=1" class="img-fluid">

      </div>

    </div>

    <div class="col text-center"></div>

  </div>
  <?php endif; ?>  

</div>

<?php  } } ?>

  
<div class="modal fade" id="modalNuevoPrecio" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalCenterTitle">Cambio de precio</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>Ingrese el nuevo precio que desea poner:</p>
        <input type="text" class="form-control" id="txtNuevoPrecio">
      </div>
      <div class="modal-footer">
       
        <button type="button" class="btn btn-primary" id="btnActualizarPrecio"> <i class="icofont-refresh"></i> Actualizar precio</button>
      </div>
    </div>
  </div>
</div>

<?php if( isset($_GET['cursor']) && !isset($_GET['asesor'])): ?>
<div class="modal fade" id="modalSeleccioneAsesor" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalCenterTitle">Ver asesor</h5>
      </div>
      <div class="modal-body">
        <p>¿Con qué asesor desea ver el inmueble?</p>
        <select class="form-control text-capitalize" id="slpAsesor">
          <?php $sqlAsesores = 'SELECT idAsesor, aseNombre from asesor where aseActivo =1 order by aseNombre asc;'; 
          $resultadoAsesores = $cadena -> query($sqlAsesores);
          while($rowAsesor = $resultadoAsesores->fetch_assoc()){ ?>
            <option class="text-capitalize" value="<?= $rowAsesor['idAsesor']; ?>" ><?= $rowAsesor['aseNombre']; ?></option>
          <?php }?>
        </select>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" id="btnVerConAsesor"> <i class="icofont-business-man-alt-1"></i> Mostrar</button>
      </div>
    </div>
  </div>
</div>
<?php endif; ?>




<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>

<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>





<script type="text/javascript">

<?php if(isset($_GET['cursor'])  && !isset($_GET['asesor'])): ?>
  $('#modalSeleccioneAsesor').modal('show');

  $('#btnVerConAsesor').click(function(){
    window.location.href = window.location.href+'&asesor='+$('#slpAsesor').val();
  })
<?php endif; ?>

<?php if($_COOKIE['ckPower']==1): ?>

function borrarFicha(idFicha){

  $.ajax({url:"borrarficha.php", type: 'POST', data:{ficha:idFicha}}).done(function(resp){

    location.reload();

  })

}

function cambiarPrecio(idFicha, precio){
  $('#txtNuevoPrecio').val(precio);
  $('#btnActualizarPrecio').attr('data-id', idFicha);

  $('#modalNuevoPrecio').modal('show');

}
$('#btnActualizarPrecio').click(function(){
  $.ajax({url: 'actualizarPrecio.php', type: 'POST', data: {ficha: $('#btnActualizarPrecio').attr('data-id') , precio: $('#txtNuevoPrecio').val() }}).done(function(resp){ console.log(resp);
    if(resp=='todo ok'){
      location.reload();
    }else{
      $('#modalNuevoPrecio').modal('hide');
      alert('Hubo un error actualizando el precio, contáctelo a soporte.');
    }
  });
});

<?php endif; ?>

</script>

</body>

</html>