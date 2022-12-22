<?php
/*
---------------------------------------------------------------
    Trait LineNotify ใช้ในการส่งข้อมูลเข้าไปยัง Line
        - findToken -> นำ Line Token ใน Database เพื่อนำมาทำการส่ง
          หากมีมากกว่า 1 จะทำการทำวนซ้ำจนกว่าจะครบ
        - sendline -> ส่งไลน์
---------------------------------------------------------------
*/
date_default_timezone_set('Asia/Bangkok');
require_once 'Database/DatabaseConnect.inc.php';

trait LineNotify{
    use Database\DatabaseConnect;

    public function findToken($data = array()){
        $sql = "SELECT * FROM tbl_token";
        $query = $this->Connect()->query($sql);
        foreach($query as $token){
            $this->sendline($token['token'], $data);
        }

    }

    public function sendline($sToken, $data = array()){
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
        $sMessage = implode("\n", $data);
        //ได้มาแล้วก็ Loop ส่งจนกว่าจะครบ
        $chOne = curl_init();
        curl_setopt($chOne, CURLOPT_URL, "https://notify-api.line.me/api/notify");
        curl_setopt($chOne, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($chOne, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($chOne, CURLOPT_POST, 1);
        curl_setopt($chOne, CURLOPT_POSTFIELDS, "message=".$sMessage);
        $headers = array( 'Content-type: application/x-www-form-urlencoded', 'Authorization: Bearer '.$sToken.'', );
        curl_setopt($chOne, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($chOne, CURLOPT_RETURNTRANSFER, 1);
        $result = curl_exec($chOne);
        //Result error
        if(curl_error($chOne)){
            echo 'error:' . curl_error($chOne);
        }else{
            return json_decode($result, true);
        }
        curl_close( $chOne );
    }
    
    function __destruct(){
      $this->Connect()->close();
    }
}
