<!DOCTYPE html>
<html>
<head>
<script src="https://code.jquery.com/jquery.js"></script>
<script src="https://code.highcharts.com/stock/highstock.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script type="text/javascript">
        var int=self.setInterval("refresh()",10000);
        function refresh()
        {
                location.reload(true);
        }
</script>
	<title>adquirir datos</title>
</head>
<body>



<?php
   // connect to mongodb
   date_default_timezone_set("America/Bogota");
   $m = new MongoClient();

   $db = $m->cinturon;

   $coleccion = $db->ritmo;

   $document = array( 
      "hr" => "", 
      "hora" => "", 
      "fecha" => "",
      "rr" => ""
   );

    $cursor = $coleccion->find();

    $timeArray;
    $valorHR;
    $valorRR;
    $con=0;
    foreach ($cursor as $document) {
   		//guardamos en rawdata todos los vectores/filas que nos devuelve la consulta
      $valorHR[$con]=$document["hr"];
      $valorRR[$con]=$document["rr"];

      $time=$document["fecha"]." ".$document["hora"];
      $date = new DateTime($time);
      $timeArray[$con] = $date->getTimestamp()*1000;
      $con=$con+1;
  }

?>


<div id="contenedor"></div>

 <script>
 
chartCPU = new Highcharts.StockChart({
    chart: {
        renderTo: 'contenedor'
        //defaultSeriesType: 'spline'
 
    },
    rangeSelector : {
        enabled: false
    },
    title: {
        text: 'Grafica de tus niveles de HR'
    },
    xAxis: {
        type: 'datetime'
        
        //tickPixelInterval: 150,
        //maxZoom: 20 * 1000
    },
    yAxis: {
        minPadding: 0.2,
        maxPadding: 0.2,
        title: {
            text: 'Valores de HR',
            margin: 10
        }
    },
    series: [{
        name: 'Valor',
        data: (function() {
                // generate an array of random data
                var data = [];

                <?php
                   for($i = 0 ;$i<count($valorHR);$i++){
                 ?>
       
                data.push([<?php echo $timeArray[$i];?>,<?php echo $valorHR[$i];?>]);

                <?php } ?>

                return data;
            })()
    }],
    credits: {
            enabled: false
    }
});
 
</script>
 
<div id="contenedor2"></div>

<script>
 
chartCPU = new Highcharts.StockChart({
    chart: {
        renderTo: 'contenedor2'
        //defaultSeriesType: 'spline'
 
    },
    rangeSelector : {
        enabled: false
    },
    title: {
        text: 'Grafica de tus niveles de RR'
    },
    xAxis: {
        type: 'datetime'
        
        //tickPixelInterval: 150,
        //maxZoom: 20 * 1000
    },
    yAxis: {
        minPadding: 0.2,
        maxPadding: 0.2,
        title: {
            text: 'Valores de RR',
            margin: 10
        }
    },
    series: [{
        name: 'Valor',
        data: (function() {
                // generate an array of random data
                var data = [];

                <?php
                    for($i = 0 ;$i<count($valorHR);$i++){
                ?>
       
                data.push([<?php echo $timeArray[$i];?>,<?php echo $valorRR[$i];?>]);
                <?php } ?>

                return data;
            })()
    }],
    credits: {
            enabled: false
    }
});
 
</script>


</body>
</html>