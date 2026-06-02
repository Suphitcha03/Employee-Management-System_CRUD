<?php
    $title = "แบบฟอร์มบันทึกข้อมูลพนักงาน";
require_once "layout/header.php";
require_once "db/connect.php";
require_once "layout/checkadmin.php";


$result = $controller->getDepartments();
$rolesByDept = [
    'IT'          => [1=>'Junior Developer', 2=>'Mid-level Developer', 3=>'Senior Developer', 4=>'IT Support'],
    'Marketing'   => [5=>'Marketing Trainee', 6=>'Marketing Specialist', 7=>'Marketing Assistant'],
    'Accounting'  => [8=>'Junior Accountant', 9=>'Senior Accountant'],
    'HR'          => [10=>'HR Officer'],
    'Sales'       => [11=>'Sales Executive'],
    'Operation'   => [12=>'Operation Staff', 13=>'Operation Helper']
];

//เช็คมีกดปุ่มsubmit ยัง ค่าที่ส่งมาชื่อ name = submit
if (isset($_POST["submit"])){
    $fname         = $_POST["fname"];
    $lname         = $_POST["lname"];
    $gender        = $_POST["gender"];
    $age           = (int)$_POST["age"];
    $salary        = (float)$_POST["salary"];
    $department_id = (int)$_POST["department_id"];
    $role_id       = $_POST["role_id"];
    $status        = $_POST["status"];
    $start_date    = $_POST["start_date"];
    $end_date      = !empty($_POST["end_date"]) ? $_POST["end_date"] : null;
    
    $status        = $_POST["status"];
    $start_date    = $_POST["start_date"];
    $end_date      = !empty($_POST["end_date"]) ? $_POST["end_date"] : null;

    if($status === 'active'){
    $end_date = null;
}
    // จัดการรูป
    $img = '';
    if(!empty($_FILES["img"]["name"])){
        $img       = time() . '_' . $_FILES["img"]["name"];
        $uploadDir = "imgs/";
        if(!file_exists($uploadDir)) mkdir($uploadDir, 0777, true);
        move_uploaded_file($_FILES["img"]["tmp_name"], $uploadDir . $img);
    }

    $status_result = $controller->insert($img, $fname, $lname, $gender, $age,
                                          $department_id, $role_id, $salary,
                                          $status, $start_date, $end_date);
    if($status_result) {
         header("Location: " . $_SERVER['PHP_SELF'] . "?status=success");
        exit();
    }else{
         header("Location: " . $_SERVER['PHP_SELF'] . "?status=error");
        exit();
    }
}
    //      echo '<pre>';
    // var_dump($_POST);
    // var_dump($_FILES);
    // echo '</pre>';
    
if (isset($_GET['status'])) {
    if ($_GET['status'] === 'success') {
        require_once "layout/success_message.php";
    } elseif ($_GET['status'] === 'error') {
        require_once "layout/error_message.php";
    }
}
    
    //echo $department_id;
    //echo "กดปุ่มบันทึก";

?>
    <div class="container mt-4" style="max-width:600px">
    <form method="POST" enctype="multipart/form-data" action="<?php echo $_SERVER['PHP_SELF'] ?>">
         <!-- รูปพนักงาน -->
    <div class="mb-3">
        <label class="form-label">รูปพนักงาน</label>
        <input type="file" name="img" class="form-control" accept="image/*">
        <small class="text-muted">ถ้าไม่เลือกรูปจะใช้รูป default</small>
    </div>

    <!-- ชื่อ -->
    <div class="mb-3">
        <label class="form-label">ชื่อ</label>
        <input type="text" name="fname" class="form-control" required>
    </div>

    <!-- นามสกุล -->
    <div class="mb-3">
        <label class="form-label">นามสกุล</label>
        <input type="text" name="lname" class="form-control" required>
    </div>

    <!-- เพศ -->
    <div class="mb-3">
        <label class="form-label">เพศ</label>
        <select name="gender" class="form-select">
            <option value="male">Male</option>
            <option value="female">Female</option>
            <option value="unspecified">Unspecified</option>
        </select>
    </div>

    <!-- อายุ -->
    <div class="mb-3">
        <label class="form-label">อายุ</label>
        <input type="number" name="age" class="form-control" required min="18" max="65">
    </div>

    <!-- เงินเดือน -->
    <div class="mb-3">
        <label class="form-label">เงินเดือน</label>
        <input type="number" name="salary" class="form-control" required>
    </div>

    <!-- แผนก -->
    <div class="mb-3">
        <label class="form-label">แผนก</label>
        <select name="department_id" id="department_id" class="form-select" onchange="filterRoles()">
            <?php 
            $depts=[];
            while($row = $result->fetch()) { 
                $depts[]=$row;
                ?>
            <option value="<?php echo e($row['department_id']); ?>"
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
            <?php foreach($roles as $id=> $name) : ?>
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
        <select name="status" id="status" class="form-select">
            <option value="active">Active</option>
            <option value="resigned">Resigned</option>
            <option value="terminated">Terminated</option>
        </select>
    </div>

    <!-- วันเริ่มงาน -->
    <div class="mb-3">
        <label class="form-label">วันเริ่มงาน</label>
        <input type="date" name="start_date" 
               class="form-control" required>
    </div>

    <!-- วันออก -->
    <div class="mb-3">
        <label class="form-label">วันออกจากงาน</label>
        <input type="date" name="end_date" id="end_date" class="form-control">
        <small class="text-muted">ถ้ายังทำงานอยู่ไม่ต้องกรอก</small>
    </div>
    <button type="submit" name="submit" class="btn btn-primary w-100 mb-4">
        บันทึก
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

const status = document.getElementById('status');
const endDate = document.getElementById('end_date');

function toggleEndDate(){
    if(status.value === 'active'){
        endDate.value = '';
        endDate.disabled = true;
    }else{
        endDate.disabled = false;
    }
}

status.addEventListener('change', toggleEndDate);
toggleEndDate();
</script>
</body>
</html>