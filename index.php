<?php
    if (!isset($_SESSION)){
        session_start();
    }
    if (!isset($_SESSION['Username'])){
        echo "<script>window.location.href='Auth'</script>";
        exit;
    }
    error_reporting(0);
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
<nav class="navbar navbar-expand-lg navbar-light" style="background-color: #e3f2fd;">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">
            <img src="img/logo.png" width="50" alt="">
            การพัฒนาระบบวิเคราะห์ข้อความข่าวอัจฉริยะ
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup"
            aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
            <div class="navbar-nav">
                <a class="nav-link <?php if($menu == 'home'){echo 'active';}else{echo '';} ?>" href="index?menu=home"><i
                        class="fa fa-cloud-download" style="font-size:25px"></i> นำเข้าข้อมูล</a>
                <a class="nav-link <?php if($menu == 'report'){echo 'active';}else{echo '';} ?>"
                    href="index?menu=report"><i class="fa fa-pie-chart" style="font-size:24px"></i> รายงาน</a>
                <a class="nav-link <?php if($menu == 'law-report'){echo 'active';}else{echo '';} ?>"
                    href="index?menu=law-report"><i class="fa fa-balance-scale" style="font-size:24px"></i>
                    สืบค้นบทบัญญัติกฎหมาย</a>
                <div class="dropdown3">
                    <a class="nav-link <?php if($menu == 'chart' || $menu == 'summery' || $menu == 'chart-pie'){echo 'active';}else{echo '';} ?>"
                        href="#">
                        <i class="fa fa-area-chart" style="font-size:24px"></i> สรุปข้อมูล
                    </a>
                    <div class="dropdown-content3">
                        <a class="nav-link <?php if($menu == 'summery'){echo 'active';}else{echo '';} ?>"
                            href="index?menu=summery"><i class="fa fa-exchange" style="font-size:24px"></i>
                            สรุปข้อมูลข่าว</a>
                        <a class="nav-link <?php if($menu == 'chart'){echo 'active';}else{echo '';} ?>"
                            href="index?menu=chart"><i class="fa fa-bar-chart-o" style="font-size:24px"></i>
                            สรุปข้อมูลข่าวแบบกราฟ (Bar)</a>
                        <a class="nav-link <?php if($menu == 'chart-pie'){echo 'active';}else{echo '';} ?>"
                            href="index?menu=chart-pie"><i class="fa fa-pie-chart" style="font-size:24px"></i>
                            สรุปข้อมูลข่าวแบบกราฟ (Pie)</a>
                    </div>
                </div>
                <!-- Admin Zone -->
                <?php if ($userid == 'Admin'){ ?>
                <div class="dropdown2">
                    <a class="nav-link <?php if($menu == 'user-mgt' || $menu == 'line-token'){echo 'active';}else{echo '';} ?>"
                        href="#">
                        <i class="fa fa-cog" style="font-size:24px"></i> จัดการ
                    </a>
                    <div class="dropdown-content2">
                        <a class="nav-link <?php if($menu == 'user-mgt'){echo 'active';}else{echo '';} ?>"
                            href="index?menu=user-mgt"><i class="fa fa-user" style="font-size:24px"></i>
                            จัดการผู้ใช้</a>
                        <a class="nav-link <?php if($menu == 'line-token'){echo 'active';}else{echo '';} ?>"
                            href="index?menu=line-token"><i class='fa fa-comment' style='font-size:24px'></i>
                            Line Token</a>
                    </div>
                </div>
                <?php } ?>
            </div>
        </div>
        <div class="dropdown">
            <button class="dropbtn">
                <i class="fa fa-user-circle-o" style="font-size:24px"></i>
                &nbsp; User :&nbsp;<strong><span class="badge bg-secondary"><?=$_SESSION['Username']?></span></strong>
            </button>
            <div class="dropdown-content">
                <a href="index.php?menu=cpass&username=<?=$_SESSION['Username']?>"><i class="fa fa-key"
                        style="font-size:24px"></i> เปลี่ยนรหัสผ่าน</a>
                <a class="btnlogout" href="#"><i class="fa fa-sign-out" style="font-size:24px"></i>
                    ออกจากระบบ</a>
            </div>
        </div>
    </div>
</nav>
<div class="container-fluid mt-2">
    <?php
        if (empty($_GET['menu'])){
            echo "<script>window.location.href='index?menu=index'</script>";
            exit;
        }
        if ($_GET['menu'] == 'index'){
            require 'home.php';
        }elseif ($_GET['menu'] == 'home'){
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
</div>
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