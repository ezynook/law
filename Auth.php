<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Law System : Login</title>
    <link rel="stylesheet" href="assets/plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" href="assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <link rel="stylesheet" href="assets/dist/css/adminlte.min.css">
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Kanit:400" rel="stylesheet">
    <link href="assets/plugins/bootstrap-tagsinput/tagsinput.css?v=11" rel="stylesheet" type="text/css">
    <script src="assets/adminlte/bower_components/ckeditor/ckeditor.js"></script>
    <link rel="stylesheet" href="vendor/sweetalert/sweetalert.css">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <script src="vendor/sweetalert/sweetalert-dev.js"></script>
    <style>
    body {
        font-family: 'Kanit', sans-serif;

        /*font-size: 14px;*/
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
<code>
    <!-- PHP Code -->
<?php
    if (!isset($_SESSION)){session_start();}
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
                                text: "โปรดติดต่อผู้ดูแลระบบ",
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
            setcookie("Username", $_POST['username'], time() + 2678400);
            setcookie("Role", $_POST['role'], time() + 2678400);
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
</code>

<body onload="myFunction()" style="min-height: 496.797px;">
    <div id="loader"></div>
    <div class="container" align="center">
        <div class="login-box animate-bottom" style="display:none;" id="myDiv">
            <div class="login-logo">
                <a href="#"><b>Law</b> System</a>
            </div>
            <div class="card">
                <div class="card-body login-card-body">
                    <p class="login-box-msg">Login as Administrator</p>
                    <form action="" method="POST" autocomplete='off' id="formlogin">
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" id="login_user" name="username"
                                placeholder="Username" autofocus>
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-user"></span>
                                </div>
                            </div>
                        </div>
                        <div class="input-group mb-3">
                            <input type="password" class="form-control" id="login_pass" name="password"
                                placeholder="Password">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-lock"></span>
                                </div>
                            </div>
                        </div>
                        <div class="social-auth-links text-center">
                            <button type="submit" class="btn btn-block btn-primary cmd1">
                                <i class="fas fa-arrow-right mr-2 text-white"></i> Login
                            </button>
                        </div>
                        <div class="social-auth-links text-center">
                            <a href="index?menu=index" class="btn btn-block btn-success cmd1">
                                <i class="fas fa-arrow-right mr-2 text-white"></i> Go to public view
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="assets/plugins/jquery/jquery.min.js"></script>
    <script src="assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/plugins/bootstrap-tagsinput/tagsinput.js?v=1"></script>
    <script src="assets/plugins/select2/js/select2.full.min.js"></script>
    <script src="assets/dist/js/adminlte.min.js"></script>
    <script>
    document.getElementById("formlogin").onsubmit = function() {
        if (!document.getElementById("login_user").value) {
            swal("กรุณากรอกชื่อผู้ใช้", "", "error");
            return false;
        }
        if (!document.getElementById("login_pass").value) {
            swal("กรุณากรอกรหัสผ่าน", "", "error");
            return false;
        }
    }
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
</body>

</html>