<?php
/*
    Class Python ใช้ในการนำเข้าข้อมูลข่าวจากไฟล์ CSV โดยการเอาข้อมูลมาทำการ cleansing data
    แล้วเพิ่มเข้าไปยังฐานข้อมูล
*/
date_default_timezone_set('Asia/Bangkok');
require_once 'LineNotify.inc.php';

class Python{
    protected $datenow;
    use LineNotify;

    function __construct(){
        $this->datenow = date('d/m/Y H:i:s', strtotime(date('Y-m-d H:i:s')));
    }
    function callPython($import){
        $data_arr = array();
        if (isset($import)){
            if (file_exists('c:\\xampp\\htdocs\\law\\script\\import.py')){
                $command = escapeshellcmd('python c:\\xampp\\htdocs\\law\\script\\import.py');
                $output = shell_exec($command);
                if ($output){
                    $data_arr = [
                        "รูปแบบการแจ้งเตือน : นำเข้าข้อมูล",
                        "เวลา/วันที่ : ".$this->datenow,
                        "รายละเอียด: ".$output
                    ];
                    $this->findToken($data_arr);
                    return $output;
                }
            }else{
                return NULL;
            }
        }
    }
}
