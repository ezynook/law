<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.3/css/buttons.bootstrap5.min.css">
    <title>Law: รายงานข้อมูล</title>
    <style>
    .btnfind {
        box-shadow: 5px 5px 5px blue;
    }

    /* .btnlaw {
        box-shadow: 5px 5px 5px gray;
    } */

    table {
        box-shadow: 5px 5px 5px #CCC;
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
  -webkit-animation: spin 0.5s linear infinite;
  animation: spin 0.5s linear infinite;
}

@-webkit-keyframes spin {
  0% { -webkit-transform: rotate(0deg); }
  100% { -webkit-transform: rotate(360deg); }
}

@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}

/* Add animation to "page content" */
.animate-bottom {
  position: relative;
  -webkit-animation-name: animatebottom;
  -webkit-animation-duration: 0.5s;
  animation-name: animatebottom;
  animation-duration: 0.5s
}
.btn_match{
    pointer-events: none;
    font-weight: bold;
}
@-webkit-keyframes animatebottom {
  from { bottom:-100px; opacity:0 } 
  to { bottom:0px; opacity:3 }
}

@keyframes animatebottom { 
  from{ bottom:-100px; opacity:0 } 
  to{ bottom:0; opacity:3 }
}

#myDiv {
  display: none;
}

</style>
</head>
<!-- PHP Code -->
<?php
    require 'autoload/module.inc.php';
    require_once 'include/Function/Thaidate.inc.php';
    $obj = new Law;
    $result = $obj->showData($_GET['dt'], $_GET['dts']);
?>
<!-- End PHP Code -->

<body onload="myFunction()" style="margin:0;">
<div id="loader"></div>
    <div class="container" align="left">
        <i class="	fa fa-home" style="font-size:20px"></i> รายงานข้อมูล
        <hr />
    </div>
    <div class="container mt-3 mb-3 animate-bottom" style="overflow-x: hidden;"  style="display:none;" id="myDiv">
        <form action="" method="get" id="formreport">
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="">จากวันที่-ถึงวันที่</span>
                </div>
                <input type="hidden" name="menu" value="report">
                <input type="date" name="dt" class="form-control" placeholder="จากวันที่"
                    value="<?php echo $_GET['dt'] ?>">
                <input type="date" name="dts" class="form-control" placeholder="ถึงวันที่"
                    value="<?php echo $_GET['dts'] ?>">
            </div>
            <button type="submit" class="btn btn-primary btnfind"><i class="fa fa-mouse-pointer"></i>
                ค้นหาข้อมูล</button>
        </form>
        <hr>
        <table class="table table-bordered table-hover table-sm" id="myTable" width="100%">
            <thead style="background-color: #0c2e72;" class="text-white">
                <tr>
                    <th scope="col" align="center">หัวข้อข่าว</th>
                    <th scope="col" align="center">รายละเอียดข่าว</th>
                    <th scope="col" align="center">วันที่ลงข่าว</th>
                    <th scope="col" align="center">จังหวัด</th>
                    <th scope="col" align="center">
                        ค่าความแม่นยำ &nbsp;&nbsp;
                        <a href="#" class="text-white" data-bs-toggle="modal" data-bs-target="#tooltip">
                        <i class="fa fa-info-circle"></i>
                        </a>
                    </th>
                    <th scope="col" align="center">บทบัญญัติกฎหมายที่เกี่ยวข้อง</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $class_match = "";
                    foreach($result as $val){
                        if ($val['matching'] == '~10%'){
                            $class_match = 'btn btn-outline-danger text-danger';
                        }elseif($val['matching'] == '~70%'){
                            $class_match = 'btn btn-outline-warning text-warning';
                        }elseif($val['matching'] == '80~%'){
                            $class_match = 'btn btn-outline-info text-info';
                        }elseif($val['matching'] == '90~%'){
                            $class_match = 'btn btn-outline-primary text-primary';
                        }else{
                            $class_match = 'btn btn-outline-success text-success';
                        }
                ?>
                <tr>
                    <td>
                        <?=$val['Subject']?>
                    </td>
                    <td data-toggle="tooltip" data-placement="buttom" title="<?= $val['Detail'];?>">
                        <?=mb_substr($val['Detail'], 0, 100)?></td>
                    <td><?=convertDate($val['Datetimes']);?></td>
                    <td><?=$val['Location']?></td>
                    <td align="center">
                        <span class="<?=$class_match?> btn_match">
                            <?=$val['matching']?>
                        </span>
                    </td>
                    <td align="center">
                        <a href="#myModal" data-bs-toggle="modal" data-bs-target="#myModal"
                            id="data-id=<?php echo $val['law_id']; ?>" data-id="<?php echo $val['law_id']; ?>"
                            class="btn btn-outline-secondary"><strong><i><?= $val['Law'];?></i></strong>
                        </a>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
    <!-- Modal View -->
    <div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="Mymodallabel">รายละเอียดข้อมูลมาตรา</h5>
                </div>
                <div class="modal-body table-responsive" id="fetched-data"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal  Tooltip -->
    <div class="modal fade" id="tooltip" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">ค่าความแม่นยำ</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <strong><u>ค่าความแม่นยำคือ</u></strong>&nbsp; กระบวนการนี้คือนำข้อมูลข่าวที่ได้มาจากการนำเข้า และนำข้อมูลข่าวนั้นมาทำการ
            ประมวลผลร่วมกับข้อมูลกฎหมาย <i>(Compare & Mapping)</i> โดยหลักการคำนวณความแม่นยำนั้นจะนำข้อมูลข่าวมาทำการ <i>Merge</i> และ
            หาค่าความแม่นยำออกมาเป็น <i>Percentage</i> โดยเรียงลำดับตามความแม่นยำจากน้อยไปหามาก ดังนี้: <br><hr>
            <b class="text-danger">~10% </b> &nbsp; ค่าความแม่นยำต่ำ 0-10 <br>
            <b class="text-warning">~70% </b> &nbsp; ค่าความแม่นยำปานกลาง 10-70 <br>
            <b class="text-info">80~% </b> &nbsp; ค่าความแม่นยำดี 70-80 <br>
            <b class="text-primary">90~% </b> &nbsp; ค่าความแม่นยำดีมาก 80-90 <br>
            <b class="text-success">100% </b> &nbsp; ค่าความแม่นยำดีมากที่สุด 90-100 <br> <hr>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิดหน้าจอ</button>
        </div>
        </div>
    </div>
    </div>
</body>
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.bootstrap5.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.print.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.colVis.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/vfs_fonts.js"></script>
<script>
var myVar;

function myFunction() {
  myVar = setTimeout(showPage, 2000);
}

function showPage() {
  document.getElementById("loader").style.display = "none";
  document.getElementById("myDiv").style.display = "block";
}
</script>
<script>
$(document).ready(function() {
    var dt = new Date();
    var dt2 = dt.getDate() + '_' + dt.getMonth() + '_' + dt.getFullYear() + '_' + dt.getHours() + "_" + dt
        .getMinutes();
    $('#myTable').dataTable({
        dom: 'Blfrtip',
        "lengthMenu": [10, 25, 50],
        "columnDefs": [ {
            "targets": 4,
            "orderable": false
        } ],
        buttons: [{
                extend: 'csv',
                charset: 'UTF-8',
                fieldSeparator: ',',
                bom: true,
                filename: 'export_csv_report_' + dt2,
                title: 'Export to csv'
            },
            {
                extend: 'excel',
                charset: 'UTF-8',
                bom: true,
                filename: 'export_excel_report_' + dt2,
                title: 'Export to Excel'
            },
            {
                extend: "print",
                exportOptions: {
                    stripHtml: true,
                    orthogonal: "myDocument"
                },
            },
        ],
        "scrollX": false,
        responsive: true,
        "oLanguage": {
            "sLengthMenu": "แสดง _MENU_ รายการ ต่อหน้า",
            "sZeroRecords": "ไม่เจอข้อมูลที่ค้นหา",
            "sInfo": "แสดง _START_ ถึง _END_ ของ _TOTAL_ รายการ",
            "sInfoEmpty": "แสดง 0 ถึง 0 ของ 0 เร็คคอร์ด",
            "sInfoFiltered": "(จากรายการทั้งหมด _MAX_ รายการ)",
            "sSearch": "ค้นหา :",
            "oPaginate": {
                "sFirst": "หน้าแรก",
                "sPrevious": "ก่อนหน้า",
                "sNext": "ถัดไป",
                "sLast": "หน้าสุดท้าย"
            }
        }
    });
});
$(document).ready(function() {
    $('#myModal').on('show.bs.modal', function(e) {
        $('#myModal').trigger('reset');
        var rowid = $(e.relatedTarget).data('id');
        $.ajax({
            url: 'include/Function/LawDetail.php',
            method: 'POST',
            data: {
                id: rowid
            },
            success: function(data) {
                $('#fetched-data').html(data);
            }
        });
    });
});
</script>

</html>