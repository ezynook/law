<?php
require 'autoload/module.inc.php';

$obj = new Law;
$resultchart = $obj->barChart();

$status_work = array();
$total = array();
while($rs = mysqli_fetch_array($resultchart)){
    $status_work[] = "\"".$rs['strgroup']."\"";
    $total[] = "\"".$rs['total']."\"";
}
$status_work = implode(",", $status_work);
$total = implode(",", $total);
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

        #myChart {
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
        0% {
            -webkit-transform: rotate(0deg);
        }

        100% {
            -webkit-transform: rotate(360deg);
        }
    }

    @keyframes spin {
        0% {
            transform: rotate(0deg);
        }

        100% {
            transform: rotate(360deg);
        }
    }

    /* Add animation to "page content" */
    .animate-bottom {
        position: relative;
        -webkit-animation-name: animatebottom;
        -webkit-animation-duration: 1s;
        animation-name: animatebottom;
        animation-duration: 1s
    }

    @-webkit-keyframes animatebottom {
        from {
            bottom: -100px;
            opacity: 0
        }

        to {
            bottom: 0px;
            opacity: 1
        }
    }

    @keyframes animatebottom {
        from {
            bottom: -100px;
            opacity: 0
        }

        to {
            bottom: 0;
            opacity: 1
        }
    }

    #myDiv {
        display: none;
    }
    </style>
</head>

<body onload="myFunction()" style="margin:0;">
    <div id="loader"></div>
    <div style="display:none;" id="myDiv" class="animate-bottom">
        <div class="container" align="left">
            <i class="	fa fa-home" style="font-size:20px"></i> รายงานข้อมูล >> สรุปข้อมูลข่าวแบบกราฟ (Bar Chart)
            <hr />
        </div>
        <div>
            <button class="btn btn-secondary" id="print">Print</button>
            <br>
        </div>
        <div class="container-fluid" align="center">
            <canvas id="myChart" width="700px" height="300px"></canvas>
        </div>
    </div>
</body>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.6.0/Chart.bundle.js"></script>
<script>
var ctx = document.getElementById("myChart").getContext('2d');
var myChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: [
            <?php echo $status_work;?>
        ],
        datasets: [{
            label: 'จำนวนประเภทมาตรากฏหมาย',
            data: [<?php echo $total;?>],
            backgroundColor: [
                'rgb(255, 0, 0)',
                'rgb(255, 64, 0)',
                'rgb(255, 128, 0)',
                'rgb(255, 191, 0)',
                'rgb(255, 255, 0)',
                'rgb(191, 255, 0)',
                'rgb(128, 255, 0)',
                'rgb(0, 255, 255)',
                'rgb(0, 191, 255)',
                'rgb(0, 128, 255)',
                'rgb(0, 0, 255)',
                'rgb(128, 0, 255)',
                'rgb(191, 0, 255)',
                'rgb(255, 0, 191)',
                'rgb(128, 128, 128)',
                'rgb(0, 0, 0)',
            ],
            borderColor: [
                'rgba(54, 108, 255, 1)',
                'rgba(255, 38, 0, 1)',
                'rgba(255, 130, 0, 0.7)',
                'rgba(42, 169, 71, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)'
            ],
            borderWidth: 1,
            font: {
                size: 1
            },
        }]
    },
    options: {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero: true
                }
            }],
            xAxes: [{
                ticks: {
                    fontColor: 'black',
                    fontSize: 12,
                }
            }]
        }
    }
});
</script>
<script>
$('#print').click(function() {
    window.print()
});
</script>
</script>
<script>
var myVar;

function myFunction() {
    myVar = setTimeout(showPage, 1000);
}

function showPage() {
    document.getElementById("loader").style.display = "none";
    document.getElementById("myDiv").style.display = "block";
}
</script>

</html>