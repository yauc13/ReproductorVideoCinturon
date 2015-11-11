<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>Monitorizacion de Ritmo cardiaco</title>
		<link rel="stylesheet" type="text/css" href="css/reproductor.css">
		<link href='https://fonts.googleapis.com/css?family=Fjalla+One' rel='stylesheet' type='text/css'>
	</head>
	<body  onload="init();">
	<?php 
		if(isset($_POST['enviar']))
		{
			$query='python numAleatorio.py -s sonda -i 1';
			//$output=array();
			//exec($query, $output);
			exec($query);
			/*foreach($output as &$valor)
			{
	            echo $valor.'<br/>';
			}*/
		}
	 ?>

		<div id="divContenedor">
			<div id="divReproductor">
				<div id="divInfo">
					<!--<div id="divLogo">
						<img src="img/logo.png" align="left">
					</div>-->



				<div  style="margin-left: 150px;"> 
					<h1>Monitorizaci&oacute;n del ritmo card&iacute;aco mientras la visualizaci&oacute;n de VoD </h1>
					<video id="Video1" style="border: 1px solid blue;" width="80%" height="300"  controls>      
					     HTML5 Video is required for this example
					</video>
  					
					   
					
					<div id="errorMsg" style="color:Red;" ></div>
				</div> 



					<div id="divInfoCancion">
						<label id="lblCancion"><strong>Nombre: </strong><span>-</span></label>
						<label id="lblArtista"><strong>Artista: </strong><span>-</span></label>
						<label id="lblDuracion"><strong>Duraci&oacute;n: </strong><span>-</span></label>
						<label id="lblEstado"><strong>Transcurrido: </strong><span>-</span></label>
					</div>
					<div style="clear: both"></div>
				</div>
				<div id="divControles">
					
					<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
						<input type="submit" id="btnReproducir" name="enviar"  />
						<input type="button" id="btnAnterior" title="Anterior">
						<input type="button" id="btnAtrazar" title="Atrazar">
						<input type="button" id="btnAdelantar" title="Adelantar">
						<input type="button" id="btnSiguiente" title="Siguiente">
						<input type="button" id="btnSilencio" title="Mute">
						<input type="button" id="btnRecargar" title="Recargar">
					</form>
				</div>
				<div id="divProgreso">
					<div id="divBarra"></div>
				</div>
				<div id="divLista">




					<ol id="olCanciones">
<li id="cancion1" onclick="loadSong()"><strong>Time Lapse- Hermosas flores abriendose</strong><em>-</em></li>
						
						<li rel="E:/Unicauca/2015-II/Enfasis IV/videos/">
							<strong>1</strong>
							
						</li>
						<li rel="audio/moldo/SomosProhibidos.mp4">
							<strong>2</strong>
							
						</li>
						<li  rel="audio/moldo/HastaAyer.mp4">
							<strong>3</strong>
							
						</li>
						<li id="list1" rel="audio/moldo/Bailando.mp4" onclick="loadSong()">
							<strong>4</strong>
							
						</li>
						<li rel="audio/moldo/Ginza.mp4">
							<strong>5</strong>
							
						</li>
						<li rel="audio/moldo/SomosProhibidos.mp4">
							<strong>6</strong>
							
						</li>
						<li rel="audio/moldo/7.mp4">
							<strong>7</strong>
							
						</li>
						<li rel="audio/moldo/8.mp4">
							<strong>8</strong>
							
						</li>
						
						
					</ol>
				</div>

				<div>
					<iframe src="conexion.php" width="100%" height="1000px"></iframe>
				</div>


				

				<div id="divCreditos">
					<h1>Monitorizaci&oacute;n de ritmo cardico mientras la visualizaci&oacute;n de ritmo cardiaco</h1>
					<!--<p>Ejemplo por Cali Rojas - <a href="http://www.lewebmonster.com" target="_blank">www.lewebmonster.com</a></p>
					<p>M&uacute;sica por el cantautor costarricense <a href="http://moldo.bandcamp.com" target="_blank">Moldo</a></p>-->
				</div>
			</div>
		</div>
		<script type="text/javascript" src="js/ext/jquery-1.7.2.min.js"></script>
		<script type="text/javascript" src="js/reproductor.js"></script>
	</body>
</html>