<?php
require_once "db/connect.php";
//ถ้าไม่มีการส่งไอดีมาให้วิ่งกลับไปหน้าเเรก อัตโนมัติ
if(!isset($_POST["id"])){
    header("Location:index.php");
    exit();
}else{
    $id=$_POST["id"];
    $result = $controller->delete($id);

    if($result){
        header("Location:index.php");
        exit();
    }
}

?>