<?php
$title="ข้อมูลของพนักงาน";
require_once "layout/header.php";
require_once "db/connect.php";
require_once "layout/checkadmin.php";

$result = $controller->getEmployees();

$employees = [];
while($row=$result->fetch()){
  $employees[]=$row;
}
$total_employees = 0;
foreach($employees as $emp) {
  if($emp['status'] === 'active'){
    $total_employees++;
  }
}


$dept_counts = array_count_values(array_column($employees, 'department_name'));


?>
<body>
        <div class ="container mt-4">
        <h1 class ="text-center"><?php echo e($title);?></h1>
        <div class="mb-3">
          <h5 class="text-dark">พนักงานทั้งหมดในระบบ : <span class="badge bg-primary"><?php echo $total_employees; ?></span> คน</h5>
        </div>
        <div class="text-end mb-2">
          <a href="addForm.php" class="btn btn-success">+ เพิ่มข้อมูลพนักงาน</a>
        </div>
    <table class="table table-hover">
  <thead>
    <tr>
      <th scope="col">ลำดับ</th>
      <th scope="col">ชื่อพนักงาน</th>
      <th scope="col">นามสกุล</th>
      <th scope="col">อายุ</th>
      <th scope="col">เงินเดือน</th>
      <th scope="col">แผนก</th>
      <th scope="col">ตำแหน่ง</th>
      <th scope="col">วันเริ่มงาน</th>
      <th scope="col">วันออกงาน</th>
      <th scope="col">สถานะ</th>
      <th scope="col">ดำเนินการ</th>
    </tr>
  </thead>
  <tbody>
    <?php  $number = 1;
    $current_dept="";

    foreach($employees as $key =>$row) {

      if($current_dept != "" && $current_dept != $row["department_name"]) { ?>
    <tr style="border-bottom: 4px solid #333 !important; background-color: #f8f9fa;">
    <td colspan="6" class="text-start">
      <strong>รวมพนักงานในแผนก <?php echo e($current_dept); ?> : <?php echo isset($dept_counts[$current_dept]) ? $dept_counts[$current_dept] : 0; ?> คน</strong>
    </td> 
    </tr>
    <?php
      
      $number = 1;
    }
      $current_dept = $row["department_name"];
      ?>
      <tr>
      <td><?php echo $number; ?></td>
      <td><?php echo e($row["fname"]); ?></td>
      <td><?php echo e($row["lname"]); ?></td>
      <td><?php echo e($row["age"]); ?></td> 
      <td><?php echo e(number_format($row["salary"])); ?></td> 
      <td><?php echo e($row["department_name"]); ?></td> 
      <td><?php echo e($row["role_name"]); ?></td> 
      <td><?php echo e($row["start_date"]); ?></td> 
      <td><?php echo e($row["end_date"]); ?></td> 
      <td><?php echo e($row["status"]); ?></td> 
      <td>
        <form class ="d-inline" method="POST" action="delete.php"
        onsubmit="return confirm('คุณต้องการลบข้อมูลหรือไม่ ?')">
        <input type="hidden" name="id" value="<?php echo e($row["emp_id"]);?>">
        <button type="submit" class="btn btn-danger">ลบข้อมูล</button>
        </form>
        <a href ="editForm.php?id=<?php echo e($row["emp_id"]);?>" class="btn btn-warning">แก้ไขข้อมูล</a>    
      </td>
    </tr>
    <?php 
      $number++;
      if ($key === array_key_last($employees)) {
      ?>
         <tr style="border-bottom: 4px solid #333 !important; color: #212529; background-color: #f8f9fa;">
          <td colspan="6" class="text-start">
          <strong>รวมพนักงานในแผนก <?php echo e($current_dept); ?> : <?php echo isset($dept_counts[$current_dept]) ? $dept_counts[$current_dept] : 0; ?> คน</strong>
           </td>
           </tr>
          <?php
                }
              }
              ?>
  </tbody>
</table>
</div>
</body>
</html>