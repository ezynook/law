<?php
require 'autoload/module.inc.php';
if (!isset($_SESSION)){
    session_start();
}
if (!isset($_SESSION['Username'])){
    echo "<script>window.location.href='Auth'</script>";
    exit;
}
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
</head>

<body>
    <div class="container" align="left">
        <i class="	fa fa-home" style="font-size:20px"></i> รายงานข้อมูล >> สรุปข้อมูลข่าวแบบกราฟ (Pie Chart)
        <hr />
    </div>
    <button class="btn btn-secondary" id="print">Print</button>
    <div class="container-fluid" align="center">
        <div id="piechart" style="width: 1000px; height: 700px;"></div>
    </div>
</body>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.6.0/Chart.bundle.js"></script>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
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
    $('#print').click(function(){
        window.print()
    });
</script>
</html>