<?php
    $title = "เเบบฟอร์มลงชื่อเข้าใช้";
    require_once "layout/header.php";
    require_once "db/connect.php";

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $username = $_POST["username"];
        $password = $_POST["password"];

        
        $result = $user->getUser($username,$password);
        // เพิ่มบรรทัดนี้ชั่วคราว
        //      var_dump($username);
        // var_dump($password);
    
        // $row = $user->getUser($username, $password);
        // var_dump($row);
        // die();
        if(!$result){
            echo '<div class= "alert alert-danger">ชื่อผู้ใช้หรือรหัสผ่านไม่ถูกต้อง</div>';

        }else{
            $_SESSION["username"] = $username;
            $_SESSION["userid"] = $result["id"];
            header("Location:index.php");
            exit();
        }
    }
?>

            <h1 class="text-center"><?php echo "เเบบฟอร์มลงชื่อเข้าใช้" ; ?></h1>
            <form method="POST" action="<?php echo e($_SERVER['PHP_SELF']) ?>">
                <div class ="form-group">
                    <label for="fname">Username</label>
                    <input type="text"
                    name="username"
                    class="form-control"
                    value="<?php if($_SERVER["REQUEST_METHOD"] =="POST") echo e($_POST["username"]);  ?>">
                </div>
                <div class="form-group">
                    <label for="lname">Password</label>
                    <input type="password" name="password" class="form-control">
                </div>
                <input type="submit" name="submit" value="เข้าสู่ระบบ" class ="btn btn-primary my-3">
            </form>
</body>
</html>