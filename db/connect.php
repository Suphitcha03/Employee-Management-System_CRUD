<?php

$host="localhost";
$username = getenv('DB_USER') ?: "root"; 
$password = getenv("DB_PASS") ?: ""; 
$db="employeesdb"; 
$dsn="mysql:host=$host;dbname=$db;charset=utf8mb4"; // charset=utf8 คือยากให้ฐานข้อมูลรองรับการใช้ภาษาไทยด้วย

try{
    $pdo = new PDO($dsn,$username,$password,[
    PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION, //throw Exception when It has error
    PDO::ATTR_DEFAULT_FETCH_MODE=>PDO::FETCH_ASSOC, //fetch like as array write column name
    PDO::ATTR_EMULATE_PREPARES=>false]); // use native prepared statements
    //echo "เชื่อมสำเร็จ";
}catch(PDOException $e){
    //echo $e->getMessage();
    exit('Database connection failed.');
}
require_once __DIR__."/controller.php";
require_once __DIR__. "/user.php";

$controller = new Controller($pdo); //จัดการข้อมูลพนักงาน
$user = new User($pdo); // จัดการผู้ใช้ระบบ

function e($value){
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}
//$user->insertUser('admin','12345');


?>