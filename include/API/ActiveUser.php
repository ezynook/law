<?php
require_once 'staticDB.php';
$id = $_GET['sid'];
$find = "SELECT `status` FROM tbl_user WHERE id={$id}";
$find_q = $conn->query($find);
$founder = $find_q->fetch_assoc();
if ($founder['status'] == 0){
    $sql = "UPDATE tbl_user SET `status` = 1 WHERE id={$id}";
}else{
    $sql = "UPDATE tbl_user SET `status` = 0 WHERE id={$id}";
}
$query = $conn->query($sql);
if ($query){
    echo "<script>window.location.href='../../index?menu=user-mgt'</script>";
}