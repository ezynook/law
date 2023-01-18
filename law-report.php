<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.3/css/buttons.bootstrap5.min.css">
    <title>Law: สืบค้นบทบัญญัติกฎหมาย</title>
    <style>
    .btnfind {
        box-shadow: 5px 5px 5px blue;
    }

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
  -webkit-animation: spin 1s linear infinite;
  animation: spin 1s linear infinite;
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
  -webkit-animation-duration: 1s;
  animation-name: animatebottom;
  animation-duration: 1s
}

@-webkit-keyframes animatebottom {
  from { bottom:-100px; opacity:0 } 
  to { bottom:0px; opacity:1 }
}

@keyframes animatebottom { 
  from{ bottom:-100px; opacity:0 } 
  to{ bottom:0; opacity:1 }
}

#myDiv {
  display: none;
}
</style>
</head>
<!-- PHP Code -->
<?php
    require 'autoload/module.inc.php';
    $obj = new Law;
    $result = $obj->lawReport($_GET['search']);
?>
<!-- End PHP Code -->

<body onload="myFunction()" style="margin:0;">
<div id="loader"></div>
    <div class="container" align="left">
        <i class="	fa fa-home" style="font-size:20px"></i> สืบค้นบทบัญญัติกฎหมาย
        <hr />
    </div>
    <div class="container mt-3 mb-3 animate-bottom" style="overflow-x: hidden;display:none;" id="myDiv">
        <form action="" method="get" id="formreport">
            <div class="row">
                <div class="col-auto">
                    <input type="text" name="search" class="form-control" placeholder="คำค้นหา" style="width: 200px;">
                </div>
                <div class="col-auto">
                    <button type="submit" name="btnsearch" class="btn btn-success"><i class="fa fa-mouse-pointer"></i>
                        ค้นหา</button>
                    <input type="hidden" name="menu" value="law-report">
                </div>
            </div>
        </form>
        <hr>
        <table class="table table-bordered table-striped table-sm" id="myTable" width="100%">
            <thead class="table-dark">
                <tr>
                    <th scope="col">บทบัญญัติกฎหมาย</th>
                    <th scope="col">ประเภทบทบัญญัติกฎหมาย</th>
                    <th scope="col">มาตราบทบัญญัติกฎหมาย</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($result as $row){ ?>
                <tr>
                    <td><?=$row['details']?></td>
                    <td><?=$row['group']?></td>
                    <td>
                    <a href="#myModal" data-bs-toggle="modal" data-bs-target="#myModal"
                            id="<?=$row['law_id']; ?>"
                            data-id="<?=$row['law_id']; ?>"
                            data-law="<?=$row['law'];?>"
                            class="btnlaw"><strong><?= $row['law'];?></strong>
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
                    <h5 class="modal-title" id="Mymodallabel">คำเสมือน</h5>
                </div>
                <div class="modal-body table-responsive" id="fetched-data"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
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
        $('#Mymodallabel').html('คำเสมือน: '+$(e.relatedTarget).data('law'))
        $.ajax({
            url: 'include/Function/LawOnly.php',
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