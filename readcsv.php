<?php
require '../vendor/autoload.php';
require_once 'include/Database/DatabaseConnect.inc.php';
 
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$alert = '';
$tempdt = date('dmy');
$timestamp = round(microtime(true));
$dbcon = (new class {use Database\DatabaseConnect;})->Connect();
#Check POST File uploads
if (isset($_POST['submit'])){
    $file_name = $_FILES['fileToUpload']['name'];
    $file_tmp = $_FILES['fileToUpload']['tmp_name'];

    $tempname = explode(".", $_FILES["fileToUpload"]["name"]);
    $newfilename = $tempdt.$timestamp . '.' . end($tempname);

    move_uploaded_file($file_tmp, "temp/" . $newfilename);
    $inputFileName = 'temp/'.$newfilename;
    $spreadsheet = IOFactory::load($inputFileName);
    $sheetData = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);
    
    $i = 0;
    $j = 1;
    $data = [];
    foreach($sheetData as $s => $k){
        foreach($k as $g){
            $i++;
            $data[$j][] = $g;
        }
        $j++;
    }

    $i = 1;
    foreach($data as $q){
        if($i > 1){
            $subject = trim($q[0]);
            $details = trim($q[1]);
            $update_dt = trim($q[2]);
            $province = trim($q[3]);
            if (isset($_POST['savedata']) && $_POST['savedata'] == '1'){
                $sql = "
                INSERT INTO 
                    `tbl_data`(`subject`, `details`, `update_dt`, `province_location`)
                VALUES
                    ('{$subject}','{$details}','{$update_dt}','{$province}')
            ";
                $query = $dbcon->query($sql);
                if ($query){
                    $alert = '
                        <div class="alert alert-success" role="alert">
                            นำเข้าข้อมูลเรียบร้อยแล้ว
                        </div>
                    ';
                }else{
                    $alert = '
                        <div class="alert alert-danger" role="alert">
                            นำเข้าข้อมูลไม่สำเร็จ
                        </div>
                    ';
                }
            }
        }
        $i++;
    }
    unlink($inputFileName);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="vendor/bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="vendor/bootstrap/bootstrap.bundle.min.js">
    <title>Import CSV/Excel</title>
</head>

<body>
    <div class="container mt-2">
        <?php if(isset($alert)){echo $alert;} ?>
        <div class="alert alert-success" role="alert">
            นำเข้าข้อมูลข่าวจากไฟล์ Excel / CSV
        </div>
        <form action="" method="post" enctype="multipart/form-data">
            <div class="input-group mb-3">
                <input type="file" class="form-control" name="fileToUpload" id="fileToUpload">
                <label class="input-group-text" for="inputGroupFile02">Upload file</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" value="1" name="preview" id="flexCheckChecked">
                <label class="form-check-label" for="flexCheckChecked">
                    แสดงข้อมูล
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" value="1" name="savedata" id="flexCheckChecked" checked>
                <label class="form-check-label" for="flexCheckChecked">
                    บันทึกข้อมูลลงฐานข้อมูล
                </label>
            </div>
            <input type="submit" value="Save / Preview" name="submit" class="btn btn-primary">
            <a href="index.php?menu=home" class=" btn btn-dark">กลับสู่หน้าหลัก</a>
        </form>
        <p></p>
        <div class="alert alert-warning" role="alert">
            การนำเข้ารูปแบบนี้จะเป็นการนำเข้าโดยตรงที่ไม่ได้ผ่านการ Cleasing และ Text Analytics ใดๆ <br>
            สำรองไว้ในกรณีไม่ต้องการนำเข้าแบบ Python (ไม่ต้องใช้ Plugins หรือ Extension ใดๆ)
        </div>
        <?php if (isset($_POST['preview'])){ ?>
        <br>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <td>Subject</td>
                    <td>Detail</td>
                    <td>Update</td>
                    <td>Province</td>
                </tr>
            </thead>
            <?php
            $i = 1;
            foreach($data as $q){
                if($i > 1){
                    $subject = trim($q[0]);
                    $details = trim($q[1]);
                    $update_dt = trim($q[2]);
                    $province = trim($q[3]);
                    echo "
                        <tr>
                            <td>{$subject}</td>
                            <td>{$details}</td>
                            <td>{$update_dt}</td>
                            <td>{$province}</td>
                        </tr>
                    ";
                }
                $i++;
            }
            ?>
        </table>
        <?php } ?>
    </div>
</body>

</html>