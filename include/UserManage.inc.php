<?php
date_default_timezone_set('Asia/Bangkok');
require_once 'Database/DatabaseConnect.inc.php';

class UserManage{
    use Database\DatabaseConnect;

    function showUser(){
        $sql = "
            SELECT
                *
            FROM
                tbl_user
            ORDER BY
                username ASC
        ";
        $query = $this->Connect()->query($sql);
        if ($query->num_rows > 0){
            return $query;
        }else{
            return false;
        }
    }

    function deleteUser($id){
        $sql = "DELETE FROM tbl_user WHERE id={$id}";
        $query = $this->Connect()->query($sql);
        if ($query){
            return 'success';
        }else{
            return 'fail';
        }
    }

    function ChangePassword($username, $password){
        $sql = "UPDATE tbl_user SET password='{$password}' WHERE username='{$username}'";
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
