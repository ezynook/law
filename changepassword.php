<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Law: เปลี่ยนรหัสผ่าน</title>
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
    if (!isset($_SESSION['Username'])){
        echo "<script>window.location.href='Auth'</script>";
        exit;
    }
    require_once 'autoload/module.inc.php';
    $username = '';
    if (isset($_GET['username'])){
        $username = $_GET['username'];
    }else{
        echo "
            <script>
                alert('ไม่มีการล็อกอินเข้ามาในระบบ ไม่สามารถเปลี่ยนรหัสผ่านได้')
                window.location.href='index?menu=home'
            </script>
        ";
        exit;
    }
    $obj = new UserManage;
    if (isset($_POST['password'])){
        $res = $obj->ChangePassword($_POST['username'], base64_encode($_POST['password2']));
        if ($res == 'success'){
            echo '<script>
                    setTimeout(function() {
                        swal({
                            title:  "เปลี่ยนรหัสผ่านเรียบร้อยแล้ว",
                            text: "",
                            type: "success",
                            confirmButtonText: "Close"
                        }, function() {
                            window.location.href = "index?menu=home"
                        });
                    }, 300);
                    </script>';
                exit;
        }else{
            echo '<script>
                    setTimeout(function() {
                        swal({
                            title:  "ไม่สามารถเปลี่ยนรหัสผ่านได้",
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

<body>
  <div class="container" align="left">
        <i class="	fa fa-home" style="font-size:20px"></i> จัดการ >> เปลี่ยนรหัสผ่าน
        <hr />
  </div>
  <div class="container mt-3" align="center">
    <span class="badge bg-info text-dark"><h6>ชื่อผู้ใช้ : <?=$username?></h6></span>
    <form action="" method="post" id="formpasswd">
      <label for="">รหัสผ่านใหม่</label>
      <input type="password" name="password" class="w3-input" id="passwd1" placeholder="รหัสผ่านใหม่"
        style="width: 250px;">
      <input type="password" name="password2" class="w3-input" id="passwd2" placeholder="ยืนยันรหัสผ่าน"
        style="width: 250px;">
      <input type="hidden" name="username" value="<?=$username?>">
      <br>
      <button type="submit" class="btn btn-success btnsave"><i class="fa fa-download" style="font-size:24px"></i> บันทึกรหัสผ่านใหม่</button>
    </form>
  </div>
</body>
<script>
document.getElementById("formpasswd").onsubmit = function() {
  if (!document.getElementById("passwd1").value) {
    swal("กรุณากรอกรหัสผ่าน (1)", "", "error");
    return false;
  }
  if (!document.getElementById("passwd2").value) {
    swal("กรุณากรอกรหัสผ่าน (2)", "", "error");
    return false;
  }
  if (document.getElementById("passwd1").value != document.getElementById("passwd2").value) {
    swal("รหัสผ่านไม่ตรงกัน", "", "error");
    return false;
  }
}
</script>

</html>
