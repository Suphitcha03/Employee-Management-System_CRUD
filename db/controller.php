<?php
class Controller {
    private $db;

    function __construct( $con){
        $this->db=$con;
    }


    function getDepartments(){
        try{
            $sql ="SELECT department_id, department_name 
                   FROM departments
                   ORDER BY department_name ASC";
            $stmt = $this->db->query($sql);
            return $stmt;
        }catch(PDOException $e){
        return false;
        }
    }

    function getEmployees() {
        try{
            $sql ="SELECT e.*,d.department_name as department_name,r.role_name as role_name ,
            er.status as status ,er.start_date as start_date , er.end_date as end_date
            FROM employees e
            INNER JOIN departments d ON e.department_id = d.department_id
            LEFT JOIN employment_records er on er.emp_id = e.emp_id
            INNER JOIN roles r ON r.role_id = er.role_id
            ORDER BY d.department_name ASC ,e.salary ASC"; 
            $stmt = $this->db->query($sql);
            return $stmt;
        }catch(PDOException $e){
        return false;
        }
    }
    function insert(string $img, string $fname, string $lname,string $gender, 
    int $age, int $department_id, INT $role_id,float $salary,string 
    $status,string $start_date,?string $end_date = null): bool { 
        try{
        $sql1 = "INSERT INTO employees(img,fname,lname,gender,age,department_id,salary)
                VALUES(:img,:fname,:lname,:gender,:age,:department_id,:salary)
                ";
                $stmt1=$this->db->prepare($sql1);
                $stmt1->bindParam(":img",$img,PDO::PARAM_STR);
                $stmt1->bindParam(":fname",$fname,PDO::PARAM_STR);
                $stmt1->bindParam(":lname",$lname,PDO::PARAM_STR);
                $stmt1->bindParam(":gender",$gender,PDO::PARAM_STR);
                $stmt1->bindParam(":salary",$salary);
                $stmt1->bindParam(":age",$age,PDO::PARAM_INT);
                $stmt1->bindParam(":department_id",$department_id,PDO::PARAM_INT); 
                $stmt1->execute();

                $emp_id = $this->db->lastInsertId();

        $sql2 = "INSERT INTO employment_records(emp_id,role_id,status,start_date,end_date)
                VALUES(:emp_id,:role_id,:status,:start_date,:end_date)";
                $stmt2 = $this->db->prepare($sql2);    
                $stmt2->bindParam(":emp_id",$emp_id,PDO::PARAM_INT); 
                $stmt2->bindParam(":role_id",$role_id,PDO::PARAM_INT);      
                $stmt2->bindParam(":status",$status,PDO::PARAM_STR);      
                $stmt2->bindParam(":start_date",$start_date,PDO::PARAM_STR);      
                $stmt2->bindParam(":end_date",$end_date,$end_date === null ? PDO::PARAM_NULL:PDO::PARAM_STR);      
                $stmt2->execute();
                return true;

        }catch(PDOException $e){
        echo $e->getMessage();
        return false;
        }
    } 
        function delete(int $id) : bool{
            try{
            $sql1="DELETE FROM employment_records
                WHERE emp_id=:id"; //เอารหัสพนงมาเป็นตัวอ้างอิง โดยรหัสพนงที่ส่งมาจะให้parametor :id เป็นคนรับค่าที่ส่งมา
                $stmt1=$this->db->prepare($sql1); //this-> attribute เรียกใช้ method prepare เพื่อทำการผูกค่า พารามิเตอร์ลงไปในคำสั่ง sql ส่งค่ากลับไปstmt 
                $stmt1->bindParam(":id",$id,PDO::PARAM_INT);
                $stmt1->execute();
            $sql2="DELETE FROM employees
                WHERE emp_id=:id"; //เอารหัสพนงมาเป็นตัวอ้างอิง โดยรหัสพนงที่ส่งมาจะให้parametor :id เป็นคนรับค่าที่ส่งมา
                $stmt2=$this->db->prepare($sql2); //this-> attribute เรียกใช้ method prepare เพื่อทำการผูกค่า พารามิเตอร์ลงไปในคำสั่ง sql ส่งค่ากลับไปstmt 
                $stmt2->bindParam(":id",$id,PDO::PARAM_INT);
                $stmt2->execute();
                return true;

            }catch(PDOException $e){
                // echo $e->getMessage();
                return false;
            }
        }
        function getEmployeeDetail(int $id) {
            try{
                $sql="SELECT e.* ,d.department_name,
                       er.role_id as role_id, er.status as status, er.start_date as start_date, er.end_date as end_date
                    FROM employees e 
                    INNER JOIN departments d on d.department_id = e.department_id
                    LEFT JOIN employment_records er ON er.emp_id = e.emp_id
                    WHERE e.emp_id = :id
                    LIMIT 1";
                $stmt=$this->db->prepare($sql);
                $stmt->bindParam(":id",$id,PDO::PARAM_INT);
                $stmt->execute();
                $result = $stmt->fetch();
                return $result;

            }catch(PDOException $e){
                return false;
            }
        }
        function update(string $img, string $fname, string $lname,string $gender, 
        int $age, int $department_id, string $role_id,float $salary,string $status,
        string $start_date,int $emp_id,?string $end_date = null): bool{ 
            try{
                $sql1="UPDATE employees
                        SET img = :img ,fname=:fname , lname =:lname , gender=:gender , age=:age ,
                        department_id = :department_id,salary=:salary
                        WHERE emp_id = :emp_id";
                $stmt1 = $this->db->prepare($sql1);
                $stmt1->bindParam(":img",$img,PDO::PARAM_STR);
                $stmt1->bindParam(":fname",$fname,PDO::PARAM_STR);
                $stmt1->bindParam(":lname",$lname,PDO::PARAM_STR);
                $stmt1->bindParam(":gender",$gender,PDO::PARAM_STR);
                $stmt1->bindParam(":salary",$salary);
                $stmt1->bindParam(":age",$age,PDO::PARAM_INT);
                $stmt1->bindParam(":department_id",$department_id,PDO::PARAM_INT); 
                $stmt1->bindParam(":emp_id",$emp_id,PDO::PARAM_INT); 
                $stmt1->execute();

                $sql2="UPDATE employment_records
                        SET role_id=:role_id, status =:status , start_date=:start_date, end_date=:end_date
                        WHERE emp_id = :emp_id";
                $stmt2=$this->db->prepare($sql2);

                $stmt2->bindParam(":emp_id",$emp_id,PDO::PARAM_INT);
                $stmt2->bindParam(":role_id",$role_id,PDO::PARAM_INT);      
                $stmt2->bindParam(":status",$status,PDO::PARAM_STR);      
                $stmt2->bindParam(":start_date",$start_date,PDO::PARAM_STR);      
                $stmt2->bindValue(":end_date",$end_date,$end_date=== null ? PDO::PARAM_NULL : PDO::PARAM_STR); 
                $stmt2->execute();
                return true;

            }catch(PDOException $e){
                return false;
            }
        }
        function getImgEmployee(){
            try{
                $sql = "SELECT e.img, e.fname,e.lname,r.role_name,d.department_name,er.status
                        FROM employees e
                        INNER JOIN departments d on d.department_id = e.department_id
                        INNER JOIN employment_records er on er.emp_id = e.emp_id
                        INNER JOIN roles r on r.role_id = er.role_id
                        ORDER BY d.department_name ,r.role_name ASC";
                $stmt=$this->db->query($sql);
                return $stmt;
            }
            catch(PDOException $e){
                echo $e->getMessage();
                return false;
            }
        }

    }


?>