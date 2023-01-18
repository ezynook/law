<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ระบบวิเคราะห์ข้อความข่าวอัจฉริยะ</title>
    <link rel="stylesheet" href="assets/plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" href="assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <link rel="stylesheet" href="assets/dist/css/adminlte.min.css">
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Kanit:400" rel="stylesheet">
    <link href="assets/plugins/bootstrap-tagsinput/tagsinput.css?v=11" rel="stylesheet" type="text/css">
    <script src="assets/adminlte/bower_components/ckeditor/ckeditor.js"></script>
    <style>
    body {
        font-family: 'Kanit', sans-serif;

        /*font-size: 14px;*/
    }
    </style>
</head>
<code>
<?php
    error_reporting(0);
    if (!isset($_SESSION)){
        session_start();
    }
    require_once 'autoload/autoload.php';
    if (isset($_GET['menu'])){
        $menu = $_GET['menu'];
    }
    $userid = '';
    if ($_SESSION['Role'] == '0'){
        $userid = 'Admin';
    }else{
        $userid = 'User';
    }
?>
</code>

<body>

    <body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed text-sm">
        <div class="wrapper">
            <nav class="main-header  navbar navbar-expand navbar-navy navbar-dark" style="background-color: #0c2e72;">

                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link text-white" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white <?php if ($menu == "index"){echo "active";} ?>"
                            href="index.php"><i class="fas fa-home"></i> Home</a>
                    </li>
                </ul>
            </nav>
            <div class="content-wrapper">
                <!-- Main Sidebar Container -->
                <aside class="main-sidebar elevation-4" style="background-color: #0c2e72; color: white;">
                    <a href="#" class="brand-link" style="background-color: #0c2e72; text-decoration: none;">
                        <img src="assets/dist/img/Immigration.png" class="brand-image">
                        <span class="brand-text font-weight-light;">ระบบวิเคราะห์ข้อความข่าวอัจฉริยะ</span>
                    </a>
                    <!-- Sidebar -->
                    <div class="sidebar">
                        <!-- Sidebar Menu -->
                        <nav style="padding-top: 0px;">
                            <!-- nav-compact -->
                            <ul class="nav nav-pills nav-sidebar nav-child-indent flex-column" data-widget="treeview"
                                role="menu" data-accordion="false">
                                <li class="nav-header">เมนู</li>

                                <li class="nav-item">
                                    <a href="index?menu=report"
                                        class="nav-link text-white <?php if($menu == 'report'){echo 'active';}else{echo '';} ?> ">
                                        <i class="nav-icon fas fa-chart-area text-white"></i>
                                        <p>รายงาน</p>
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a href="index?menu=law-report"
                                        class="nav-link text-white <?php if($menu == 'law-report'){echo 'active';}else{echo '';} ?> ">
                                        <i class="nav-icon fas fa-search text-white"></i>
                                        <p>สืบค้นบทบัญญัติกฎหมาย</p>
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a href="index?menu=summery"
                                        class="nav-link text-white <?php if($menu == 'summery'){echo 'active';}else{echo '';} ?> ">
                                        <i class="nav-icon fas fa-check text-white"></i>
                                        <p>สรุปข้อมูลข่าว</p>
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a href="index?menu=chart"
                                        class="nav-link text-white <?php if($menu == 'chart'){echo 'active';}else{echo '';} ?> ">
                                        <i class="nav-icon fas fa-chart-bar text-white"></i>
                                        <p>สรุปข้อมูลข่าวแบบกราฟ (Bar)</p>
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a href="index?menu=chart-pie"
                                        class="nav-link text-white <?php if($menu == 'chart-pie'){echo 'active';}else{echo '';} ?> ">
                                        <i class="nav-icon fas fa-chart-pie text-white"></i>
                                        <p>สรุปข้อมูลข่าวแบบกราฟ (Pie)</p>
                                    </a>
                                </li>
                                <hr>
                                <?php if ($userid == 'Admin'){ ?>
                                <li class="nav-item">
                                    <a href="index?menu=import"
                                        class="nav-link text-white <?php if($menu == 'import'){echo 'active';}else{echo '';} ?>">
                                        <i class="nav-icon far fa-plus-square text-white"></i>
                                        <p class="text-white">นำเข้าข้อมูล </p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="index?menu=line-token"
                                        class="nav-link text-white <?php if($menu == 'line-token'){echo 'active';}else{echo '';} ?>">
                                        <i class="nav-icon far fa-comments text-white"></i>
                                        <p>Line-Token</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="index.php?menu=cpass&username=<?=$_SESSION['Username']?>"
                                        class="nav-link text-white <?php if($menu == 'cpass'){echo 'active';}else{echo '';} ?>">
                                        <i class="nav-icon fas fa-lock text-white"></i>
                                        <p>เปลี่ยนรหัสผ่าน</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="logout.php" class="nav-link text-danger btnlogout">
                                        <i class="nav-icon fas fa-power-off"></i>
                                        <p>ออกจากระบบ</p>
                                    </a>
                                </li>
                                <?php }else{ ?>
                                <li class="nav-item">
                                    <a href="logout" class="nav-link text-white">
                                        <i class="nav-icon fas fa-solid fa-arrow-right text-white"></i>
                                        <p>Login as Administrator</p>
                                    </a>
                                </li>
                                <?php } ?>
                            </ul>
                        </nav>
                    </div>
                </aside>
                <!-- <section class="content-header"></section> -->
                <section class="content">
                    <?php
                    if (empty($_GET['menu'])){
                        echo "<script>window.location.href='index?menu=report'</script>";
                        exit;
                    }
                    if ($_GET['menu'] == 'index'){
                        require 'home.php';
                    }elseif ($_GET['menu'] == 'import'){
                        require 'home.php';
                    }elseif ($_GET['menu'] == 'report'){
                        require 'report.php';
                    }elseif ($_GET['menu'] == 'law-report'){
                        require 'law-report.php';
                    }elseif ($_GET['menu'] == 'summery'){
                        require 'summery.php';
                    }elseif ($_GET['menu'] == 'chart'){
                        require 'chart.php';
                    }elseif ($_GET['menu'] == 'chart-pie'){
                        require 'chart-pie.php';
                    }elseif ($_GET['menu'] == 'user-mgt'){
                        require 'user-mgt.php';
                    }elseif ($_GET['menu'] == 'line-token'){
                        require 'line-token.php';
                    }elseif ($_GET['menu'] == 'cpass'){
                        require 'changepassword.php';
                    }else{
                        require '404.html';
                    }
                ?>
                </section>
            </div>
            <footer class="main-footer">
                <div class="float-right d-none d-sm-block">
                    <b>Project Version</b> 1.3 | 2023-01-18
                </div>
                <strong>พัฒนาโดย &copy; กิตติคุณ ขุนพรหม</strong> 6421512663
            </footer>

            <!-- Control Sidebar -->
            <aside class="control-sidebar control-sidebar-dark">
                <!-- Control sidebar content goes here -->
            </aside>
            <!-- /.control-sidebar -->
        </div>
        </div>
    </body>
    <!-- <script src="assets/plugins/jquery/jquery.min.js"></script> -->
    <script src="assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/plugins/bootstrap-tagsinput/tagsinput.js?v=1"></script>
    <script src="assets/plugins/select2/js/select2.full.min.js"></script>
    <script src="assets/dist/js/adminlte.min.js"></script>
    <script type="text/javascript">
    $('.btnlogout').on('click', function(e) {
        e.preventDefault();
        swal({
            title: "ออกจากระบบ ?",
            text: "กดปุ่ม ยืนยัน เพื่อออกจากระบบ",
            type: "info",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "ยืนยัน",
            closeOnConfirm: false
        }, function(isConfirm) {
            if (isConfirm)
                window.location.href = "logout";
        });
    });
    </script>

</html>