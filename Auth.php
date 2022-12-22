<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include 'autoload/autoload.php'; ?>
    <title>Law: เข้าสู่ระบบ</title>
    <style>
    body {
        background-color: #ebeef0;
    }
    .cmd1{
            box-shadow: 5px 5px 5px green;
            margin-right: 10px;
        }
    .cmd2{
            box-shadow: 5px 5px 5px skyblue;
    }
    .make-form {
        border: 1px solid;
        padding: 10px;
        box-shadow: 5px 10px 18px #888888;
        background-color: #5A5655;
        border-radius: 5%;
    }

    .cookies {
        top: 50%;
        outline: none;
        overflow: hidden;
    }

    .w3-input {
        padding: 8px;
        display: block;
        border: none;
        border-bottom: 1px solid #ccc;
        width: 100%
    }
    </style>
</head>
<!-- PHP Code -->
<?php
    if (isset($_SESSION['Username'])){
        echo "<script>window.location.href='index?menu=index'</script>";
        exit;
    }
    require 'autoload/module.inc.php';
    $obj = new Authentication;
    if (isset($_POST['username']) && isset($_POST['password'])){
        $response = $obj->Login($_POST['username'], $_POST['password']);
        if ($response){
            if ($response['status'] == 1){
                echo '<script>
                        setTimeout(function() {
                            swal({
                                title:  "ชื่อผู้ใช้ของคุณโดนระงับเข้าสู่ระบบ",
                                text: "โปรกติดต่อผู้ดูแลระบบ",
                                type: "warning",
                                confirmButtonText: "Close"
                            }, function() {
                                window.location.href = "Auth"
                            });
                        }, 300);
                    </script>';
                exit;
            }
            $_SESSION['Username'] = $response['username'];
            $_SESSION['Role'] = $response['role'];
            if (isset($_POST['cookie']) && $_POST['cookie'] == '1'){
                setcookie("Username", $_POST['username'], time() + 2678400);
                setcookie("Role", $_POST['role'], time() + 2678400);
            }
            echo "<script>window.location.href='index?menu=index'</script>";
        }else{
            echo '<script>
                        setTimeout(function() {
                            swal({
                                title:  "ชื่อผู้ใช้หรือรหัสผ่านผิดพลาด",
                                text: "",
                                type: "error",
                                confirmButtonText: "Close"
                            }, function() {
                                window.location.href = "Auth"
                            });
                        }, 300);
                    </script>';
                exit;
        }
    }
?>
<!-- End PHP Code -->
<body>
    <div class="container mt-5" align="center">
        <div class="card card-primary">
            <div class="card-header" style="background-color: #CCC;">
                <h3 class="card-title">เข้าสู่ระบบ</h3>
            </div>
            <form action="" method="POST" autocomplete='off' id="formlogin">
                <div class="card-body">
                    <div class="form-group row mb-3">
                        <label for="inputEmail3" class="col-sm-2 col-form-label">Username</label>
                        <div class="col-sm-10">
                            <input type="text" class="w3-input" id="login_user" name="username"
                                placeholder="Username" autofocus>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputPassword3" class="col-sm-2 col-form-label">Password</label>
                        <div class="col-sm-10">
                            <input type="password" class="w3-input" id="login_pass" name="password"
                                placeholder="Password">
                        </div>
                    </div>
                    <input type="checkbox" name="cookie" value="1"> Remember me
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-success cmd1">
                        Login
                    </button>
                    <a href="sign-up" class="btn btn-info cmd2">สมัครสมาชิก</a>
            </form>
        </div>
    </div>
    <div align="center">
        <span class="badge badge-dark text-dark">พัฒนาโดย กิตติคุณ ขุนพรหม 6421512663
    </div>
</body>
<script>
document.getElementById("formlogin").onsubmit = function () {
  if (!document.getElementById("login_user").value) {
      swal("กรุณากรอกชื่อผู้ใช้","","error");
      return false;
  }
  if (!document.getElementById("login_pass").value) {
      swal("กรุณากรอกรหัสผ่าน","","error");
      return false;
  }
}
</script>
</html>
