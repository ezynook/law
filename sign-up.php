<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include 'autoload/autoload.php'; ?>
    <title>Law: สมัครสมาชิก</title>
    <style>
    body {
        background-color: #ebeef0;
    }

    .cmd1 {
        box-shadow: 5px 5px 5px green;
        margin-right: 10px;
    }

    .cmd2 {
        box-shadow: 5px 5px 5px blue;
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

        /* right:50%; */

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
    require 'autoload/module.inc.php';
    $obj = new Authentication;
    if (isset($_POST['username']) && isset($_POST['password2'])){
        $response = $obj->Signup($_POST['username'], $_POST['password2'], $_POST['role']);
        if ($response == 'success'){
            echo '<script>
                    setTimeout(function() {
                        swal({
                            title: "สมัครสมาชิกเรียบร้อย",
                            text: "",
                            type: "success",
                            confirmButtonText: "Close"
                        }, function() {
                            window.location.href = "Auth"
                        });
                    }, 300);
                    </script>';
                exit;
        }else{
            echo '<script>
                    setTimeout(function() {
                        swal({
                            title:  "เกิดข้อผิดพลาดหรือ Username ซ้ำกับที่มีแล้วในระบบ",
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
                <h3 class="card-title">สมัครสมาชิก</h3>
            </div>
            <form action="" method="POST" autocomplete='off' id="formsignup">
                <div class="card-body">
                    <div class="form-group row mb-3">
                        <label for="inputEmail3" class="col-sm-2 col-form-label">Username</label>
                        <div class="col-sm-10">
                            <input type="text" class="w3-input rounded-0" id="signup_user" name="username"
                                placeholder="Username" autofocus>
                        </div>
                    </div>
                    <div class="form-group row mb-3">
                        <label for="inputPassword3" class="col-sm-2 col-form-label">Password</label>
                        <div class="col-sm-10">
                            <input type="password" class="w3-input" id="signup_pass1" name="password"
                                placeholder="Password">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputPassword3" class="col-sm-2 col-form-label">Confirm Password</label>
                        <div class="col-sm-10">
                            <input type="password" class="w3-input" id="signup_pass2" name="password2"
                                placeholder="Confirm Password">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputPassword3" class="col-sm-2 col-form-label">สิทธิเข้าถึง</label>
                        <div class="col-sm-10">
                        <select class="w3-input" name="role" required>
                            <option selected disabled>Choose...</option>
                            <option value="0">Admin</option>
                            <option value="1">User</option>
                        </select>
                        </div>
                    </div>
                </div>
                <div class="card-footer ">
                    <button type="submit" class="btn btn-success cmd1">
                        Sign-Up
                    </button>
                    <a href="home" class="btn btn-primary cmd2">กลับสู่หน้าแรก</a>
            </form>
        </div>
    </div>
    <div align="center">
        <span class="badge badge-dark text-dark">พัฒนาโดย กิตติคุณ ขุนพรหม 6421512663
    </div>
</body>
<script>
document.getElementById("formsignup").onsubmit = function() {
    if (!document.getElementById("signup_user").value) {
        swal("กรุณากรอกชื่อผู้ใช้", "", "error");
        return false;
    }
    if (!document.getElementById("signup_pass2").value) {
        swal("กรุณากรอกรหัสผ่าน", "", "error");
        return false;
    }
    if (document.getElementById("signup_pass1").value != document.getElementById("signup_pass2").value) {
        swal("รหัสผ่านไม่ตรงกัน", "", "error");
        return false;
    }
}
</script>

</html>