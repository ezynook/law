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
    .btnlaw2 {
        box-shadow: 2px 2px 2px green;
    }
    table{
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
    require_once 'include/Function/Thaidate.inc.php';
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
    $obj = new UserManage;
    $result = $obj->showUser();
    if (isset($_GET['id'])){
        $del = $obj->deleteUser($_GET['id']);
        if ($del == 'success'){
            echo "<script>window.location.href='index?menu=user-mgt'</script>";
        }else{
            echo '<script>
                    setTimeout(function() {
                        swal({
                            title:  "ไม่สามารถลบข้อมูลได้",
                            text: "",
                            type: "error",
                            confirmButtonText: "Close"
                        }, function() {
                            window.location.href = "index?menu=user-mgt"
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
        <i class="	fa fa-home" style="font-size:20px"></i> จัดการ >> จัดการผู้ใช้
        <hr />
    </div>
    <div class="container mt-3" align="center">
        <table class="table table-sm table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>ชื่อผู้ใช้</th>
                    <th>สิทธิการใช้งาน</th>
                    <th>วันที่บันทึก</th>
                    <th>จัดการ</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $role = '';
                    $status_fortb = '';
                    $status_class = '';
                    foreach($result as $val){
                        if ($val['role'] == 0){
                            $role = 'Admin';
                        }else{
                            $role = 'User';
                        }
                        if ($val['status'] == 0){
                            $status_fortb = 'เปิดใช้งาน';
                            $status_class = 'btn-success btnlaw2';
                        }else{
                            $status_fortb = 'ปิดใช้งาน';
                            $status_class = 'btn-danger btnlaw';
                        }
                ?>
                <tr>
                    <td><?=$val['username']?></td>
                    <td><?=$role?></td>
                    <td><?=convertDate($val['update_dt'])?></td>
                    <td colspan="2">
                        <a href="include/API/ActiveUser.php?sid=<?=$val['id']?>" class="btn <?=$status_class?> btn-sm">
                            <?=$status_fortb?>
                        </a>
                        <a href="#" class="btn btn-danger btnlaw btndel btn-sm" data-id="<?=$val['id']?>">
                            <i class="fa fa-trash-o"></i> ลบ
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
            window.location.href = "index?menu=user-mgt&id=" + deleteid;
    });
});

</script>
</html>
