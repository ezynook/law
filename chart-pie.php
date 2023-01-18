<?php
require 'autoload/module.inc.php';
$obj = new Law;
$resultchart = $obj->barChart();

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>รายงานสรุปข้อมูลแบบกราฟ</title>
    <style>
    @media print {
        * {
            visibility: hidden;
        }

        .container-fluid * {
            visibility: visible;
        }

        #piechart {
            position: absolute;
            left: 0;
            top: 0;
        }

        #print {
            visibility: hidden;
        }
    }
    </style>
    <style>
/* Center the loader */
#loader {
  position: absolute;
  left: 50%;
  top: 50%;
  z-index: 1;
  width: 120px;
  height: 120px;
  margin: -76px 0 0 -76px;
  border: 16px solid #f3f3f3;
  border-radius: 50%;
  border-top: 16px solid #3498db;
  -webkit-animation: spin 1s linear infinite;
  animation: spin 1s linear infinite;
}

@-webkit-keyframes spin {
  0% { -webkit-transform: rotate(0deg); }
  100% { -webkit-transform: rotate(360deg); }
}

@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}

/* Add animation to "page content" */
.animate-bottom {
  -webkit-animation-name: animatebottom;
  -webkit-animation-duration: 1s;
  animation-name: animatebottom;
  animation-duration: 1s
}

@-webkit-keyframes animatebottom {
  from { bottom:-100px; opacity:0 } 
  to { bottom:0px; opacity:1 }
}

@keyframes animatebottom { 
  from{ bottom:-100px; opacity:0 } 
  to{ bottom:0; opacity:1 }
}

/* #myDiv {
    visibility: hidden;
} */
</style>
</head>

<body onload="myFunction()" style="margin:0;">
    <div id="loader"></div>
    <div style="visibility: hidden;" id="myDiv" class="animate-bottom">
        <div class="container" align="left">
            <i class="fa fa-home" style="font-size:20px"></i> รายงานข้อมูล >> สรุปข้อมูลข่าวแบบกราฟ (Pie Chart)
            <hr />
        </div>
        <button class="btn btn-secondary" id="print">Print</button>
        <div class="container-fluid" align="center">
            <div id="piechart" style="width: 1000px; height: 500px;">></div>
        </div>
    </div>

</body>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.6.0/Chart.bundle.js"></script>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script src="assets/plugins/jquery/jquery.min.js"></script>
<script type="text/javascript">
google.charts.load('current', {
    'packages': ['corechart']
});
google.charts.setOnLoadCallback(drawChart);

function drawChart() {
    var data = google.visualization.arrayToDataTable([
        ['strgroup', 'total'],
        <?php
            while ($row = mysqli_fetch_array($resultchart)) {
                echo "['".$row["strgroup"].
                "', ".$row["total"].
                "],";
            } ?>
    ]);
    var options = {
        title: '',
        is3D: true,
        legend: 'right',
        //   pieHole: 0.4  
    };
    var chart = new google.visualization.PieChart(document.getElementById('piechart'));
    chart.draw(data, options);
}
</script>
<script>
$('#print').click(function() {
    window.print()
});
</script>
<script>
var myVar;

function myFunction() {
    myVar = setTimeout(showPage, 1000);
}

function showPage() {
    document.getElementById("loader").style.display = "none";
    document.getElementById("myDiv").style.visibility = 'visible';
}
</script>

</html>