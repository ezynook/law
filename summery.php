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
</head>
<!-- PHP Code -->
<?php
    if (!isset($_SESSION)){
        session_start();
    }
    if (!isset($_SESSION['Username'])){
        echo "<script>window.location.href='Auth'</script>";
        exit;
    }
    require 'autoload/module.inc.php';
    $obj = new Law;
    $data = $obj->Summery();
?>
<!-- End PHP Code -->

<body>
  <div class="container mt-3">
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
</body>

</html>