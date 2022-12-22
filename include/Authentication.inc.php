<?php
/*
--------------------------------------------
    Class Authentication นี้ใช้ในการจัดการผู้ใช้
        - Login -> ใช้ในการ Login เข้าสู่ระบบ
        - Signup -> ใช้ในการลงทะเบียนชื่อผู้ใช้
--------------------------------------------
*/
date_default_timezone_set('Asia/Bangkok');
require_once 'Database/DatabaseConnect.inc.php';
require_once 'LineNotify.inc.php';

class Authentication{
    use Database\DatabaseConnect;
    use LineNotify;
    private $datetime;

    function __construct(){
        $this->datetime = date('d/m/Y H:i:s', strtotime(date('Y-m-d H:i:s')));
    }
    function Login($user, $password){
        $data_arr = array();
        $password2 = base64_encode($password);
        $sql = "
            SELECT
                *
            FROM
                tbl_user
            WHERE
                username = '{$user}' AND `password` = '{$password2}'
            LIMIT 1
        ";
        $query = $this->Connect()->query($sql);
        if ($query->num_rows > 0){
            $data_arr = [
                "ประเภทการแจ้งเตือน : เข้าสู่ระบบ",
                "เวลา/วันที่ : ".$this->datetime,
                "ผู้ที่เข้าสู่ระบบ: ".$user
            ];
            $this->findToken($data_arr);
            return $query->fetch_assoc();
        }else{
            return false;
        }
    }
    function Signup($user, $password, $role){
        $data_arr = array();
        $password2 = base64_encode($password);
        $sql = "
           INSERT INTO
                tbl_user
            SET
                username = '".$user."',
                `password` = '".$password2."',
                role = '".$role."',
                `status` = 0
        ";
        $query = $this->Connect()->query($sql);
        if ($query){
            $data_arr = [
                "ประเภทการแจ้งเตือน : สมัครสมาชิกใหม่",
                "เวลา/วันที่ : ". $this->datetime,
                "ชื่อผู้ใช้ที่สมัคร : ".$user
            ];
            $this->findToken($data_arr);
            return 'success';
        }else{
            return NULL;
        }
    }
    function __destruct(){
      $this->Connect()->close();
    }
}
