<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title id="title_import">Law: นำเข้าข้อมูล</title>
  <style>
  .btn-click {
    width: 300px;
    height: 90px;
    text-size-adjust: 100px;
    box-shadow: 7px 7px 5px green;
  }

  .div1 {
    box-shadow: 5px 5px 15px grey;
  }
  </style>
</head>
<!-- PHP Code -->
<?php
if (!isset($_SESSION)){
    session_start();
}
if (!isset($_SESSION['Role'])){
    echo "<script>window.location.href='Auth'</script>";
    exit;
}
require 'autoload/module.inc.php';
$obj = new Python;
$msg = "";
if (isset($_GET['import'])){
    $output = $obj->callPython($_GET['import']);
    if ($output){
        $msg = "
            <div class='alert alert-success' role='alert'>
                {$output}
            </div>
        ";
    }else{
        echo '<script>
                    setTimeout(function() {
                        swal({
                            title:  "Import falure",
                            text: "",
                            type: "error",
                            confirmButtonText: "Close"
                        }, function() {
                            window.location.href = "index?menu=home"
                        });
                    }, 300);
                </script>';
            exit;
    }
}
?>
<!-- End PHP Code -->

<body id="bodydiv">
  <div class="container" align="left">
    <i class="	fa fa-home" style="font-size:20px"></i> นำเข้าข้อมูล
    <hr>
  </div>
  <div class="container mt-3" align="center">
    <div>
        <h2 id="datetime">
          <span class="badge bg-light text-dark"></span>
        </h2>
    </div>
    <?php if (isset($msg)){echo $msg;} ?>
    <form action="" method="get" id="form_import">
      <input type="hidden" name="menu" value="home">
      <input type="hidden" name="import" value="1">
      <button type="submit" class="btn btn-success btn-click" style="font-size:20px">
        <i class="fa fa-cloud-download" style="font-size:25px"></i> นำเข้าข้อมูลจาก CSV files
      </button>
    </form>
    <hr>
    <a href="#" data-bs-toggle="modal" data-bs-target="#helpModal">
      >> วิธีใช้งานการนำเข้าข้อมูล << </a>
  </div>
  <!-- Help Modal -->
  <div class="modal fade" id="helpModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">วิธีใช้งานการนำเข้าข้อมูล</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div align="center">
            <i class="fa fa-question-circle" style="font-size:52px; color: blue;"></i>
          </div>
          -> สร้างโฟลเดอร์ 2 โฟลเดอร์ ชื่อ csv tmp ที่ C:\ <br>
          -> นำไฟล์ csv ไปวางที่ C:\csv (วางได้มากกว่า 1 ไฟล์) <br>
          -> หลังจากมีการนำเข้าข้อมูลแล้ว ระบบจะย้ายจาก C:\csv ไปที่ C:\tmp
          <hr>
          <a href="backup/example.csv">ดาวน์โหลดตัวอย่างไฟล์ CSV</a><br>
          <i class="text-danger"><strong>** ไฟล์ CSV ต้องถูกคั่นด้วยเครื่องหมาย | เท่านั้น **</strong></i><br>
          <i class="text-danger"><strong>** CSV Separator By PIPE</strong></i><br>
          <i class="text-danger"><strong>วิธีทำ: <a href='https://www.automateexcel.com/how-to/convert-save-as-pipe-delimited/' target="_blank">ที่นี่</a></strong></i>
          <hr>
          <a href="readcsv.php" class="text-dark"><b>คลิกที่นี่เพื่อนำเข้าแบบ Local Storage</b></a>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
</body>
<script>
$('.btn-click').on('click', function(e) {
  e.preventDefault();
  swal({
    title: "นำเข้าข้อมูล ?",
    text: "กดปุ่ม ยืนยัน เพื่อนำเข้าข้อมูล",
    type: "success",
    showCancelButton: true,
    confirmButtonColor: "#DD6B55",
    confirmButtonText: "ยืนยัน",
    closeOnConfirm: false
  }, function(isConfirm) {
    if (isConfirm) {
      $('#title_import').html('กำลังนำเข้า...')
      $('#form_import').submit();
      $('.btn-click').prop('disabled', true);
      $('.btn-click').val('รอสักครู่...');
      return true;
    } else {
      $('.btn-click').prop('disabled', false);
      $('.btn-click').val('นำเข้าข้อมูลจาก CSV files');
      return false;
    }
  });
});
</script>
<script>
function showClockRealTime() {
  var d = new Date();
  document.getElementById("datetime").innerHTML = d.toLocaleString();
}
setInterval("showClockRealTime()", 1000);
</script>

</html>
