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

    .btnlaw {
        box-shadow: 5px 5px 5px orange;
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
    $obj = new Law;
    $result = $obj->showData($_GET['dt'], $_GET['dts']);
?>
<!-- End PHP Code -->

<body>
    <div class="container mt-3 mb-3" style="overflow-x: hidden;">
        <form action="" method="get" id="formreport">
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="">จากวันที่-ถึงวันที่</span>
                </div>
                <input type="hidden" name="menu" value="report">
                <input type="date" name="dt" class="form-control" placeholder="จากวันที่" value="<?php echo $_GET['dt'] ?>">
                <input type="date" name="dts" class="form-control" placeholder="ถึงวันที่" value="<?php echo $_GET['dts'] ?>">
            </div>
            <button type="submit" class="btn btn-primary btnfind"><i class="fa fa-mouse-pointer"></i>
                ค้นหาข้อมูล</button>
        </form>
        <hr>
        <table class="table table-bordered table-striped table-sm" id="myTable" width="100%">
            <thead class="table-dark">
                <tr>
                    <th scope="col">หัวข้อข่าว</th>
                    <th scope="col">รายละเอียดข่าว</th>
                    <th scope="col">วันที่ลงข่าว</th>
                    <th scope="col">จังหวัด</th>
                    <th scope="col">บทบัญญัติกฎหมายที่เกี่ยวข้อง</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $data = array();
                    foreach($result as $i){
                        $data[] = $i['id'];
                    }
                    $arrayValueCounts = array_count_values($data); 
                    $color = [
                        '#F2D7D5',
                        '#EBDEF0',
                        '#D4E6F1',
                        '#D1F2EB',
                        '#FCF3CF',
                        '#FDEBD0',
                        '#F6DDCC',
                        '#EAECEE',
                        '#CCCCFF',
                        ];
                    $oldid = '';
                    $oldcolor = '';
                    $oldrandom = '';
                    foreach($result as $val){
                        if($oldid == $val['id']){
                                $colorStyle = $oldcolor;
                        }else{
                            $random = rand(0,6);
                            if($oldrandom == $random){
                                    $random = rand(0,8);
                            }
                        // $colorStyle = 'style="background-color:'.$color[$random].'"';
                        $oldcolor =  $colorStyle;
                        $oldrandom = $random;
                        }
                       $colorStyle = ($arrayValueCounts[$val['id']] > 1) ? 'style="background-color:'.$color[$random].'"' : '';
                       $oldid = $val['id'];
                ?>
                <tr>
                    <td <?=$colorStyle?>>
                        <?=$val['Subject']?>
                    </td>
                    <td data-toggle="tooltip" data-placement="buttom" title="<?= $val['Detail'];?>">
                        <?=mb_substr($val['Detail'], 0, 100)?></td>
                    <td><?=convertDate($val['Datetimes']);?></td>
                    <td><?=$val['Location']?></td>
                    <td>
                        <a href="#myModal" id="data-id=<?php echo $val['law_id']; ?>" data-bs-toggle="modal"
                            data-bs-target="#myModal" data-id="<?php echo $val['law_id']; ?>"
                            class="btn btn-warning btnlaw"><strong><i><?= $val['Law'];?></i></strong>
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
    var dt2 = dt.getDate() +'_' + dt.getMonth() + '_' + dt.getFullYear() + '_' + dt.getHours() + "_" + dt.getMinutes();
    $('#myTable').dataTable({
        dom: 'Blfrtip',
        "lengthMenu": [ 10, 25, 50],
        buttons: [{
                extend: 'csv',
                charset: 'UTF-8',
                fieldSeparator: ',',
                bom: true,
                filename: 'export_csv_report_'+dt2,
                title: 'Export to csv'
            },
            {
                extend: 'excel',
                charset: 'UTF-8',
                bom: true,
                filename: 'export_excel_report_'+dt2,
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