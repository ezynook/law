<?php
    require_once '../Database/DatabaseConnect.inc.php';
    
    function lawDetail($id){
        $dbcon = (new class {use Database\DatabaseConnect;})->Connect();
        $outp = "";
        $sql = "
            SELECT
                *
            FROM
                tbl_law
            WHERE
                law_id = $id
            ";
        $query = $dbcon->query($sql);
        $row = $query->fetch_assoc();
        $synonyms = '';
        if ($row['synonyms'] == '') {
            $synonyms = '-';
        }else{
            $synonyms = $row['synonyms'];
        }
        $outp = "
            <table class='table table-bordered'>
                <tr>
                    <td><b>มาตรา</b></td>
                    <td>$row[law]</td>
                </tr>
                <tr>
                    <td><b>รายละเอียดมาตรา</b></td>
                    <td>$row[details]</td>
                </tr>
                <tr>
                    <td><b>แบ่งประเภทมาตรา</b></td>
                    <td>$row[group]</td>
                </tr>
                <tr>
                    <td><b>คำเสมือน</b></td>
                    <td>$synonyms</td>
                </tr>
            </table>
        ";
        echo $outp;
    }
    $id = $_POST['id'];
    lawDetail($id);