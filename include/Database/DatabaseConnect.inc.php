<?php
/*
------------------------------------------------------------
    Trait DatabaseConnect ใช้ในการเชื่อมต่อฐานข้อมูล MySQL
        - Connect -> ไว้เรียกใช้เวลาต้องการ เพิ่ม ลบ แก้ไข ข้อมูลต่างๆ
------------------------------------------------------------
*/
namespace Database;
use mysqli;

trait DatabaseConnect{
    protected $params = array(
        "HOST" => "localhost",
        "USER" => "root",
        "PASS" => "root",
        "DBNAME" => "db_law",
    );
    public function Connect(){
        $conn = new mysqli(
            $this->params['HOST'],
            $this->params['USER'],
            $this->params['PASS'],
            $this->params['DBNAME']
        );
        $conn->set_charset("utf8");
        return $conn;
        if ($conn -> connect_errno) {
            echo "Failed to connect to MySQL: " . $conn -> connect_error;
            exit();
        }
    }
}
