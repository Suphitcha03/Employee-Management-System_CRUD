<?php

require_once "db/connect.php";
//ถ้ามีการส่งข้อมูลมาในรูปแบบPOSTเมธอด ค่าที่ส่งมาเกิดจากกดปุ่ม submit จะให้ทำการรับค่าจากฟร์อมแก้ไข fname,lname,salary,department
if(isset($_POST["submit"])){
    //ส่งข้อมูลให้กับพนง เลขไอดีอะไร มาจาก รหัสพนงที่อยากอัพเดท
    $emp_id = $_POST["emp_id"];
//คำสั่งรับค่าที่ส่งมาจากแบบฟอร์มเเก้ไข
    $old_img=$_POST["old_img"] ?? "";
    $fname=$_POST["fname"];
    $lname=$_POST["lname"];
    $gender=$_POST["gender"];
    $age=$_POST["age"];
    $department_id=$_POST["department_id"];
    $role_id=$_POST["role_id"];
    $salary=$_POST["salary"];
    $status=$_POST["status"];
    $start_date=$_POST["start_date"];
    $end_date=$_POST["end_date"];
    $img = $old_img;
    // 2. 📸 เพิ่มลอจิกตรวจสอบว่าผู้ใช้เลือกรูปภาพใหม่เข้ามาไหม
    if(!empty($_FILES["img"]["name"])){
        // ตั้งชื่อไฟล์ใหม่ด้วยระบบเวลาเพื่อป้องกันชื่อซ้ำ
        $img       = time() . '_' . $_FILES["img"]["name"];
        $uploadDir = "imgs/"; 
        
        if(!file_exists($uploadDir)) mkdir($uploadDir, 0777, true);
        
        // ย้ายไฟล์รูปภาพใหม่เข้าโฟลเดอร์จริง
        move_uploaded_file($_FILES["img"]["tmp_name"], $uploadDir . $img);
    }

   $result = $controller->update($img,$fname,$lname,$gender,$age,$department_id,$role_id,$salary,$status,$start_date,$emp_id,$end_date !== "" ? $end_date:null); 
    if($result){
        header("Location:index.php");
        exit();
    }

    
}


?>