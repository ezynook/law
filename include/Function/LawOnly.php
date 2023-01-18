<?php
    require_once '../Database/DatabaseConnect.inc.php';
    
    function lawDetail($id){
        $dbcon = (new class {use Database\DatabaseConnect;})->Connect();
        $outp = "";
        $sql = "
            SELECT
                synonyms as synonyms
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
                    <td><b>คำเสมือน</b></td>
                    <td>$synonyms</td>
                </tr>
            </table>
        ";
        echo $outp;
    }
    $id = $_POST['id'];
    lawDetail($id);