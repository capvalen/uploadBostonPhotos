<?php include "conexion.php";
if( isset($_COOKIE['ckPower'])){
	if($_COOKIE['ckPower']=='1' && $_COOKIE['ckPower']=='2'){
	header('Location: ficha.php');    
	}

}else{ header('Location: index.php'); }

?>
<!DOCTYPE html>
<html lang="es">
<head>
	<?php include "headers.php";?>
	<?php include "nav.php";?>
</head>
<body>
<div class="container mb-5" id="app">
	<h3 class="text-center my-3">Documentos importantes</h3>
	<div class="row mb-2">
		<div class="col">
			<button class="btn btn-outline-primary" data-toggle="modal" data-target="#modalCrear"><i class="icofont-plus"></i> Adjuntar nuevo documento</button>
		</div>
	</div>
	<div class="card">
		<div class="card-body">
			<p><strong>Documentos adjuntados</strong></p>
			<table class="table table-hover">
				<thead>
					<tr>
						<th>N°</th>
						<th>Fecha</th>
						<th>Titulo</th>
						<th>Comentario</th>
						<th>Archivo</th>
						<th>@</th>
					</tr>
				</thead>
				<tbody>
					<tr v-for="(archivo, index) in registros">
						<td>{{index+1}}</td>
						<td>{{fechaLatam(archivo.fecha)}}</td>
						<td>{{archivo.nombre}}</td>
						<td>{{archivo.comentario}}</td>
						<td>
							<a class="btn btn-sm btn-outline-primary" :href="'https://bostonabregurealty.com/intranet/multimedia/'+archivo.ruta" :download="archivo.nombre"><i class="icofont-ui-folder"></i></a>
						</td>
						<td>
							<?php if($_COOKIE['ckPower']=='1') :?>
								<button class="btn btn-sm btn-outline-danger" @click="eliminar(index,archivo.id)"><i class="icofont-trash"></i></button>
							<?php endif; ?>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>

	<!-- Modal -->
	<div class="modal fade" id="modalCrear" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered">
			<div class="modal-content">
				<div class="modal-header border-0">
					<h5 class="modal-title" id="exampleModalLabel">Adjuntar archivo nuevo</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<label for="">Archivo</label>
					<div class="input-group mb-3">
						<div class="custom-file">
							<input type="file" class="custom-file-input" id="txtArchivo" aria-describedby="inputGroupFileAddon01" @change="cambiarNombre()">
							<label class="custom-file-label" for="txtArchivo">{{queArchivo}}</label>
						</div>
					</div>
					<label for="">Nombre del archivo</label>
					<input type="text" class="form-control" v-model="archivo.nombre">
					<label for="">Comentario extra</label>
					<textarea class="form-control" rows="2" v-model="archivo.comentario"></textarea>
					<button class="btn btn-outline-primary mt-2" @click="subirArchivo()"><i class="icofont-upload-alt"></i> Subir archivo</button>
				</div>
			</div>
		</div>
	</div>
</div>
	
<?php include "footers.php";?>	
<script>
	const { createApp, ref, onMounted, computed } = Vue

  createApp({
    setup() {
			let contador = ref(0)
			const numeros =ref([0,1,2])
			let registros = ref([])
			let archivo = ref({id:-1, nombre:'', ruta:'', comentario:''}), multimedia = ref(null)
			const queArchivo = computed(()=>{
				if(archivo.value.nombre=='') return 'Escoger el archivo'
				else return archivo.value.nombre
			})
			//Expone las variables o funciones de modo publico
			function sumar(){
				numeros.value[0]++
				contador.value++;
				console.log(numeros.value)
			}
			async function pedirDatos(){
				let datos = new FormData();
				datos.append('pedir', 'listar')
				const serv = await fetch('api/Archivos.php',{
					method:'POST', body:datos
				})
				registros.value = await serv.json()
			}
			function fechaLatam(fecha){
				return moment(fecha).format('DD/MM/YYYY')
			}
			function subirArchivo(){
				if(document.getElementById("txtArchivo").files.length>0){
					multimedia = document.getElementById("txtArchivo").files[0]
					let formData = new FormData();
					formData.append('pedir', 'subir' );
					formData.append('multimedia', multimedia );
					formData.append('metadata', JSON.stringify(archivo.value));
					
					axios.post('api/Archivos.php', formData, {
						headers: { 'Content-Type' : 'multipart/form-data' }
					}).then( function (response){
						console.log('data', response.data );
						if(response.data.ruta){
							archivo.value.ruta = response.data.ruta
							alertify.message('Subido con éxito')
							document.querySelector('#modalCrear .close').click()
							pedirDatos()
						}
							
					}).catch(function(ero){
						console.log( 'err2' + ero );
					})
				}
			}

			function eliminar(index, id){
				if( confirm(`¿Desea eliminar el archivo ${registros.value[index].nombre}?`)){
					let formData = new FormData();
					formData.append('pedir', 'eliminar' );
					formData.append('id', id );
					formData.append('archivo', registros.value[index].ruta );
					axios.post('api/Archivos.php', formData )
					.then( response =>{
						pedirDatos()
						console.log(response.data)
					})
				}
			}

			function cambiarNombre(){
				if(document.getElementById("txtArchivo").files.length>0)
					archivo.value.nombre = document.getElementById("txtArchivo").files[0].name.slice(0,-4)
				else archivo.value.nombre = ''
			}

			function obtenerExtension(texto) {
				// Buscar el índice del último punto
				const indiceUltimoPunto = texto.lastIndexOf(".");

				// Si no se encuentra un punto, devolver el texto completo
				if (indiceUltimoPunto === -1) {
					return texto;
				}
				// Extraer el texto desde el índice del último punto hasta el final
				const textoExtraido = texto.substring(indiceUltimoPunto + 1);
				return textoExtraido;
			}

			onMounted(()=> {
				pedirDatos();
			})


      return {
        contador, registros, archivo, queArchivo,
				sumar, fechaLatam, subirArchivo, cambiarNombre, obtenerExtension, eliminar
      }
    }
  }).mount('#app')
</script>

<style>
	.custom-file-input ~ .custom-file-label::after {
    content: "Seleccionar";
	}
</style>
</body>
</html>