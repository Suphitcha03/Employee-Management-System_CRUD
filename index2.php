<?php
$title = "บอร์ดข้อมูลพนักงาน";
require_once "layout/header.php";
require_once "db/connect.php";
require_once "layout/checkadmin.php";

$result = $controller->getImgEmployee();
$employees = $result->fetchAll();

$departments = [];
foreach($employees as $emp) {
    $dept = $emp['department_name'];
    $departments[$dept][] = $emp;
}
?>

<div class="container mt-4">
    <h1 class="text-center mb-4"><?php echo e($title); ?></h1>

    <?php foreach($departments as $deptName => $emps) { ?>
    
    <div class="mb-2">
        <h5 class="fw-bold text-secondary">
            🏢 <?php echo $deptName; ?>
            <span class="badge bg-secondary"><?php echo count($emps); ?> คน</span>
        </h5>
    </div>

    <div class="row mb-3">
        <?php foreach($emps as $idx => $row) { 
            // ✅ ข้ามคนที่ resigned/terminated ไม่แสดงบนบอร์ด
            if($row['status'] === 'resigned' || $row['status'] === 'terminated') continue;
            $modalId = 'modal_' . $idx . '_' . preg_replace('/\s+/', '', $deptName);
            switch($row['role_name']) {
                case 'Senior':   $badgeColor = 'success';   break;
                case 'Mid':      $badgeColor = 'warning';    break;
                case 'Junior':   $badgeColor = 'primary';    break;
                case 'Contract': $badgeColor = 'secondary';  break;
                default:         $badgeColor = 'dark';
            }
        ?>
        <div class="col-6 col-md-2 text-center mb-4">
            <!-- กดแล้ว popup -->
            <div data-bs-toggle="modal" data-bs-target="#<?php echo $modalId; ?>"
                 style="cursor:pointer">
                <!-- รูป -->
                <?php if(!empty($row['img'])) { ?>
                    <img src="imgs/<?php echo $row['img']; ?>"
                         class="rounded-circle border mb-3"
                         style="width:200px;height:200px;object-fit:cover">
                <?php } else { ?>
                    <div class="rounded-3 bg-light border d-flex align-items-center
                                justify-content-center mx-auto mb-2 text-secondary"
                         style="width:200px;height:200px;font-size:72px">
                        👤
                    </div>
                <?php } ?>
                <div class="fw-bold" style="font-size:13px">
                    <?php echo e($row['fname']) . ' ' . e($row['lname']); ?>
                </div>
                <span class="badge bg-<?php echo $badgeColor; ?> mt-1">
                    <?php echo e($row['role_name']); ?>
                </span>
            </div>

            <!-- Modal -->
            <div class="modal fade" id="<?php echo $modalId; ?>" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title fw-bold">ข้อมูลพนักงาน</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center py-4">
                
                <?php if(!empty($row['img'])) { ?>
                    <img src="imgs/<?php echo $row['img']; ?>"
                         class="rounded-3 border mb-4 shadow-sm"
                         style="width:350px; height:350px; object-fit:cover;">
                <?php } else { ?>
                    <div class="rounded-3 bg-light border d-flex align-items-center justify-content-center mx-auto mb-4 text-secondary"
                         style="width:350px; height:350px; font-size:96px">
                        👤
                    </div>
                <?php } ?>

                <h2 class="fw-bold mb-2 text-dark"><?php echo e($row['fname']) . ' ' . e($row['lname']); ?></h2>
                
                <p class="text-muted fs-4 mb-3">
                    แผนก: <span class="text-secondary fw-semibold"><?php echo e($deptName); ?></span>
                </p>
                
                <span class="badge bg-<?php echo $badgeColor; ?> fs-4 px-4 py-2 shadow-sm">
                    <?php echo e($row['role_name']); ?>
                </span>
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-lg" data-bs-dismiss="modal">ปิด</button>
            </div>
        </div>
    </div>
</div>

        </div>
        <?php } ?>
    </div>

    <hr class="border border-2 mb-4">
    <?php } ?>
</div>
</body>
</html>