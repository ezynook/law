<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Law: สรุปข้อมูลข่าว</title>
    <style>
    .box1 {
        box-shadow: 3px 3px 5px lightgreen;
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
  position: relative;
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

#myDiv {
  display: none;
}
</style>
</head>
<!-- PHP Code -->
<?php
    require 'autoload/module.inc.php';
    $obj = new Law;
    $data = $obj->Summery();
?>
<!-- End PHP Code -->

<body onload="myFunction()" style="margin:0;">
<div id="loader"></div>
    <div class="container" align="left">
        <i class="	fa fa-home" style="font-size:20px"></i> รายงานข้อมูล >> สรุปข้อมูลข่าว
        <hr />
    </div>
    <div class="container mt-3 animate-bottom" style="display:none;" id="myDiv">
        <div class="row">
            <?php foreach($data as $val){  ?>
            <div class="col-lg-3 col-md-6 col-sm-12 col-xs-12">
                <div class="card mb-3">
                    <div class="card-header bg-secondary text-white"><?=$val['Group'] ?></div>
                    <div class="card-body" align="center">
                        <h6 class="card-title">
                            <h5>
                                <span class="badge bg-success box1"><?='จำนวน '.$val['total'].' ข่าว'?></span>
                            </h5>
                        </h6>
                    </div>
                </div>
            </div>
            <?php } ?>
        </div>
    </div>
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
</body>

</html>