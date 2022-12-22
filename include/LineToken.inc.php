<?php
/*
-----------------------------------------------------
    Class LineToken ใช้ในการจัดการส่วนของหน้า Line Token
        - showToken -> แสดงข้อมูล Line Token
        - insertToken -> เพิ่ม Line Token
        - deleteToken -> ลบ Line Token
-----------------------------------------------------
*/
date_default_timezone_set('Asia/Bangkok');
require_once 'Database/DatabaseConnect.inc.php';

class LineToken{
    use Database\DatabaseConnect;

    function showToken(){
        $sql = "SELECT * FROM tbl_token ORDER BY id ASC";
        $query = $this->Connect()->query($sql);
        if ($query->num_rows > 0){
            return $query;
        }
    }
    function insertToken($token){
        $sql = "
            INSERT INTO
                tbl_token
            SET
                token = '".$token."'
        ";
        $query = $this->Connect()->query($sql);
        if ($query){
            return 'success';
        }else{
            return 'fail';
        }
    }
    function deleteToken($id){
        $sql = "DELETE FROM tbl_token WHERE id = '{$id}'";
        $query = $this->Connect()->query($sql);
        if ($query){
            return 'success';
        }else{
            return 'fail';
        }
    }
    function __destruct(){
      $this->Connect()->close();
    }
}
