<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Law: จัดการผู้ใช้</title>
  <style>
  .btnfind {
    box-shadow: 5px 5px 5px blue;
  }

  .btnlaw {
    box-shadow: 2px 2px 2px red;
  }

  table {
    box-shadow: 5px 5px 5px #CCC;
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
    if ($_SESSION['Role'] != 0){
      echo '<script>
              setTimeout(function() {
                  swal({
                      title:  "คุณไม่มีสิทธิเข้าถึงหน้านี้",
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
    $token = new LineToken;
    $result = $token->showToken();

    if (isset($_POST['token'])){
        $insert = $token->insertToken($_POST['token']);
        if ($insert == 'success'){
            echo "<script>window.location.href = 'index?menu=line-token'</script>";
        }else{
            echo '<script>
                    setTimeout(function() {
                        swal({
                            title:  "ไม่สามารถเพิ่มข้อมูลได้",
                            text: "",
                            type: "error",
                            confirmButtonText: "Close"
                        }, function() {
                            window.location.href = "index?menu=line-token"
                        });
                    }, 300);
                    </script>';
            exit;
        }
    }

    if (isset($_GET['id'])){
        $delstatus = $token->deleteToken($_GET['id']);
        if ($delstatus == 'success'){
            echo "<script>window.location.href='index?menu=line-token'</script>";
        }else{
            echo '<script>
                    setTimeout(function() {
                        swal({
                            title:  "ไม่สามารถลบข้อมูลได้",
                            text: "",
                            type: "error",
                            confirmButtonText: "Close"
                        }, function() {
                            window.location.href = "index?menu=line-token"
                        });
                    }, 300);
                    </script>';
            exit;
        }
    }

?>
<!-- End PHP Code -->

<body>
  <div class="container mt-3" align="center">
    <form action="" method="post">
      <label for="">
        <span class="badge bg-info text-dark">Token ID</span>
      </label>
      <input type="text" name="token" placeholder="Line Token ID" class="w3-input" style="width: 250px;" required>
      <br>
      <button type="submit" class="btn btn-success"><i class="fa fa-download" style="font-size:24px"></i> บันทึก</button>
    </form>
    <hr />
    <table class="table table-sm table-bordered table-striped">
      <thead class="table-dark">
        <tr>
          <td>ลำดับ</td>
          <td>Line TokenID</td>
          <td>จัดการ</td>
        </tr>
      </thead>
      <tbody>
        <?php
                $i = 0;
                    foreach($result as $val){
                        $i++;
                ?>
        <tr>
          <td><?=$i?></td>
          <td><?=$val['token']?></td>
          <td>
            <a href="#" class="btn btn-danger btnlaw btndel btn-sm" data-id="<?=$val['id']?>">
              <i class="fa fa-trash-o"></i>
            </a>
          </td>
        </tr>
        <?php } ?>
      </tbody>
    </table>
  </div>
</body>
<script>
$('.btndel').on('click', function(e) {
  e.preventDefault();
  var deleteid = $(this).data('id');
  swal({
    title: "ลบข้อมูล ?",
    text: "กดปุ่ม ยืนยัน เพื่อลบข้อมูล",
    type: "warning",
    showCancelButton: true,
    confirmButtonColor: "#DD6B55",
    confirmButtonText: "ยืนยัน",
    closeOnConfirm: false
  }, function(isConfirm) {
    if (isConfirm)
      window.location.href = "index?menu=line-token&id=" + deleteid;
  });
});
</script>

</html>
