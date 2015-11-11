

//**  Funciones para la reproduccion de los videos**//

	var can=0;
	
    function init() {
        var video = document.getElementById("Video1");  

        if (video.canPlayType) {   // tests that we have HTML5 video support
            // if successful, display buttons and set up events
          
           

            //  button events
            //  Play
            document.getElementById("btnReproducir").addEventListener("click", vidplay, false);
            //  Restart
            document.getElementById("btnRecargar").addEventListener("click", function(){
                setTime(0);
             }, false);
            //  Skip backward 10 seconds
            document.getElementById("btnAtrazar").addEventListener("click", function(){
                setTime(-10);                
            }, false);
            //  Skip forward 10 seconds
            document.getElementById("btnAdelantar").addEventListener("click", function(){
                setTime(10);
            }, false);                
            //  set src == latest video file URL
            document.getElementById("btnSiguiente").addEventListener("click", function(){
                getVideo(1);
            }, false);
            document.getElementById("btnAnterior").addEventListener("click", function(){
                getVideo(-1);
            }, false);
            
                            
            // fail with message 
            video.addEventListener("error", function(err) {
                errMessage(err);
            }, true);

            //  button helper functions 
            //  skip forward, backward, or restart
            function setTime(tValue) {
            //  if no video is loaded, this throws an exception 
                try {
                    if (tValue == 0) {
                        video.currentTime = tValue;
                    }
                    else {
                        video.currentTime += tValue;
                    }
                    
                 } catch (err) {
                     // errMessage(err) // show exception
                 errMessage("Video content might not be loaded");
                   }
         }
             //  play video
             function vidplay(evt) {

             	var $objContenedorCancion=$('#olCanciones').children().eq(can);
             	$objContenedorCancion.addClass('clsSeleccionado');

             	//ocultamos suavemente los datos de la cancion anterior 
		$('#divInfoCancion').find('label').stop(true.true).animate({
			opacity: 0
		},function(){
			//obtenemos una instancia del elemento que contiene los datos de la cancion
			var $objContenedorCancion=$('#olCanciones').children().eq(can);
			
			//actualizamos la informacion de la cancion que se esta reproduciendo
			//duracion total
			$('#lblDuracion').find('span').text('00:00');
			//nombre de la cancion
			$('#lblCancion').find('span').text($objContenedorCancion.find('strong').text());
			//artista
			$('#lblArtista').find('span').text($objContenedorCancion.find('em').text());
			//tiempo transcurrido
			$('#lblEstado').find('span').text('00:00');
			 
			//mostramos suavemente la info. de la nueva cancion
			$(this).stop(true,true).animate({
				opacity: 1
			});
		});
			// final de obtenemos una instancia del elemento que contiene los datos de la cancion

			//obtenemos la duracion de la cancion
			var iTiempoTotal=video.duration;
		var objDuracion=$.fntTransformarSegundos(iTiempoTotal);
		$('#lblDuracion').find('span').text(objDuracion[0]+':'+objDuracion[1]);


                if (video.src == "") {  // on first run, src is empty, go get file
                    getVideo(0);
                    video.load();

                }
                button = evt.target; //  get the button id to swap the text based on the state                                    
                if (video.paused) {   // play the file, and display pause symbol
                   video.play();
                   
                } else {              // pause the file, and display play symbol  
                   video.pause();
                   
                }                                        
            }
            //  load video file from input field
            function getVideo(sing) {
   //var fileURL = document.getElementById("videoFile").value;  // get input field    
   var canciones = [
   	"1.mp4",
	"2.mp4",
	"3.mp4",
	"4.mp4",
	"5.mp4",
	"6.mp4",
	"7.mp4",
    "8.mp4"
	];



	if(can == canciones.length-1){
		can=0;
	}else if(can < 0){
    	can= 2;
    }
    else if(sing==1){
    	can=can+1;
    }else if(sing==-1){
    	can=can-1;
    }else{
    	can=can+0;
    }

/*var can1="Plan B - Fanatica Sensual.mp4";
var can2="Dalmata - Deseo Animal.mp4";
var can3="J. Balvin - Ginza.mp4"; */

var cancion=canciones[can];
/* if(can==0){
 cancion=can1;
}else if(can==1){
cancion=can2
}else if(can==2){
cancion=can3
} */


 
var fileURL = "/reproductorMusica/videos/"+cancion;  
//var fileURL = "http://www.youtube.com/embed/QBaIMZ8QjcU";
				
                if (fileURL != ""){
                   video.src = fileURL;
                   video.load();  // if HTML source element is used
                   
                   document.getElementById("btnReproducir").click();  // start play
                 } else {
                    errMessage("Enter a valid video URL");  // fail silently
                 }
            }

//  display an error message 
    function errMessage(msg) {
        // displays an error message for 5 seconds then clears it
                document.getElementById("errorMsg").textContent = msg;
                setTimeout("document.getElementById('errorMsg').textContent=''", 5000);
            }


            function loadSong(){
            	var video1 = document.getElementById("list1");
            	video1.rel ="/videos/";
            	$('#cancion1').find('em').text('jiji');
            }



            //funcion para formatear los segundos en minutos y segundos (retorna un Array)
	$.fntTransformarSegundos=function(iTiempoTranscurrido){
		//obtener los minutos
		var iMinutos=Math.floor(iTiempoTranscurrido/60);
		//se obtienen los segundos
		var iSegundos=Math.floor(iTiempoTranscurrido-iMinutos*60);
		
		//le agregamos un cero a los minutos y segundos, solo por estetica
		if(iSegundos<10) iSegundos='0'+iSegundos;
		if(iMinutos<10) iMinutos='0'+iMinutos;
		
		//devolvemos un array con el tiempo formateado
		return Array(iMinutos,iSegundos);
	};


    	//clic en el boton silencio
	$('#btnSilencio').on('click',function(){
		//colocamos el estado mute a su contrario, es decir... si esta mudo
		//volvemos a activar el sonido; si el sonido esta activado lo desactivamos
		video.muted=!video.muted;
		//quitamos o agregamos la clase que indica si el sonido esta activado o no
		$(this).toggleClass('clsSeleccionado');
	});



//evento al hacer clic en cualquiera de las canciones
	$('#olCanciones li').on('click',function(){
		//establecemos el numero de cancion (usando el indice del li clickeado)
		can=$(this).index();
		//llamamos a la funcion que reproduce los archivos de audio
		getVideo();
	});



        } // end of runtime


    }// end of master    