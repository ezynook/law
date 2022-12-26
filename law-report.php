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
    $obj = new Law;
    $result = $obj->lawReport($_GET['search']);
?>
<!-- End PHP Code -->

<body>
    <div class="container mt-3 mb-3" style="overflow-x: hidden;">
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