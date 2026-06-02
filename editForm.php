<?php
$title ="แบบฟอร์มแก้ไขข้อมูล";
require_once "db/connect.php";
require_once "layout/header.php";
require_once "layout/checkadmin.php";


//ถ้าไม่มีการส่งไอดีมาให้วิ่งกลับไปหน้าเเรก อัตโนมัติ
if(!isset($_GET["id"])){
    header("Location:index.php");
    exit();
}else{
    $id=$_GET["id"];
    $emp=$controller->getEmployeeDetail($id);
    
}
$result=$controller->getDepartments();

$roles = [
    1  => 'Junior Developer',
    2  => 'Mid-level Developer',
    3  => 'Senior Developer',
    4  => 'IT Support',
    5  => 'Marketing Trainee',
    6  => 'Marketing Specialist',
    7  => 'Marketing Assistant',
    8  => 'Junior Accountant',
    9  => 'Senior Accountant',
    10 => 'HR Officer',
    11 => 'Sales Executive',
    12 => 'Operation Staff',
    13 => 'Operation Helper'
];
?>
<div class="container mt-4" style="max-width:600px">
<h1 class ="text-center"><?php echo "แบบฟอร์มแก้ไขข้อมูลของพนักงาน";?></h1>  
        <form method="POST" action="updateEmployee.php" enctype="multipart/form-data">
            <input type="hidden" name="emp_id" value="<?php echo $emp["emp_id"] ?>">
            <!-- รูปปัจจุบัน -->
    <div class="mb-3 text-center">
        <?php if(!empty($emp['img'])) { ?>
            <img src="imgs/<?php echo $emp['img']; ?>"
                 class="rounded-circle mb-2"
                 style="width:100px;height:100px;object-fit:cover">
        <?php } else { ?>
             <div class="text-muted mb-2">ยังไม่มีรูป</div>
        <?php } ?>
            <input type="hidden" name="old_img" value="<?php echo $emp['img']; ?>">
            </div>
             <!-- อัปโหลดรูปใหม่ -->
            <div class="mb-3">
             <label class="form-label">รูปพนักงาน</label>
             <input type="file" name="img" class="form-control" accept="image/*">
             <small class="text-muted">ถ้าไม่เลือกรูปใหม่จะใช้รูปเดิม</small>
            </div>
            <div class = "form-group">
                <label for="fname">ชื่อ</label>
                <input type="text" name="fname" class="form-control" required value="<?php echo $emp["fname"] ?>">
            </div> 
            <div class = "form-group">   
                <label for="lname">นามสกุล</label>
                <input type="text" name="lname" class="form-control" required value="<?php echo $emp["lname"] ?>">
            </div>
            <!-- เพศ -->
            <div class="mb-3">
                <label class="form-label">เพศ</label>
                <select name="gender" class="form-select">
                    <option value="male"        <?php if($emp['gender']=='male')        echo 'selected'; ?>>Male</option>
                    <option value="female"      <?php if($emp['gender']=='female')      echo 'selected'; ?>>Female</option>
                    <option value="unspecified" <?php if($emp['gender']=='unspecified') echo 'selected'; ?>>Unspecified</option>
                </select>
            </div>
            <!-- อายุ -->
            <div class="mb-3">
                <label class="form-label">อายุ</label>
                <input type="number" name="age" class="form-control" 
               min="18" max="65"
               value="<?php echo $emp['age']; ?>">
            </div>
            <div class = "form-group">   
                <label for="salary">เงินเดือน</label>
                <input type="number" name="salary" class="form-control" required value="<?php echo $emp["salary"] ?>">
            </div>
            <div class = "form-group">   
                <label for="department">แผนก</label>
                <select name ="department_id" id="department_id" class="form-control" onchange="filterRoles()">
                    <?php 
                    $depts=[];
                    while($row=$result->fetch()){
                        $depts[]=$row;
                        ?>
                    <option  value="<?php echo e($row['department_id']); ?>"
                    data-name="<?php echo e($row['department_name']); ?>">
                   <?php echo e($row['department_name']); ?>
                    </option>
            <?php } ?>
        </select>
    </div>
        <!-- Role -->
            <div class="mb-3">
                <label class="form-label">ตำแหน่ง</label>
                    <select name="role_id" id ="role_id" class="form-select">
                     <?php foreach($rolesByDept as $dept => $roles) : ?>
                     <?php foreach($roles as $id => $name) :?>
                        <option value="<?php echo $id; ?>" data-dept="<?php echo $dept; ?>">
                    <?php echo e($name); ?>
                        </option>
                    <?php endforeach; ?>
                    <?php endforeach; ?>
                    </select>
             </div>
            <!-- สถานะ -->
            <div class="mb-3">
                 <label class="form-label">สถานะ</label>
                    <select name="status" class="form-select">
                        <option value="active"     <?php if($emp['status']=='active')     echo 'selected'; ?>>Active</option>
                        <option value="resigned"   <?php if($emp['status']=='resigned')   echo 'selected'; ?>>Resigned</option>
                        <option value="terminated" <?php if($emp['status']=='terminated') echo 'selected'; ?>>Terminated</option>
                    </select>
                    </div>
            <!-- วันเริ่มงาน -->
            <div class="mb-3">
            <label class="form-label">วันเริ่มงาน</label>
                <input type="date" name="start_date" class="form-control" required
               value="<?php echo $emp['start_date']; ?>">
            </div>

    <!-- วันออก -->
            <div class="mb-3">
                <label class="form-label">วันออกจากงาน</label>
                <input type="date" name="end_date" class="form-control"
               value="<?php echo $emp['end_date'] ?? ''; ?>">
                <small class="text-muted">ถ้ายังทำงานอยู่ไม่ต้องกรอก</small>
    </div>
            
            <button type="submit" name="submit" class="btn btn-primary w-100 mb-4">
        อัพเดต
    </button>    
        </form>
</div>
<script>
function filterRoles() {
    const deptSelect = document.getElementById('department_id');
    const selectedName = deptSelect.options[deptSelect.selectedIndex].dataset.name;
    const roleSelect= document.getElementById('role_id');

    roleSelect.querySelectorAll('option').forEach(opt=>{
        opt.style.display = opt.dataset.dept === selectedName ? '' : 'none';
    });

    const first = [...roleSelect.options].find(o =>o.style.display !== 'none');
    if (first) roleSelect.value = first.value;
}
filterRoles();
</script>
</body>
</html>