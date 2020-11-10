<?php
require 'DB.php';
class Manager extends DB
{
    private $mg_db;
public function __construct($user, $pass)
{
    parent::__construct($user, $pass);
    $this->mg_db=$this->db;
}

public function createProject($project_name,$email,$desc,$date_line,$status,$cline){
$date=date("Y-m-d");
$sql=$this->mg_db->prepare("INSERT INTO project (project_name,user_email,descrip,date_line,create_date,status,Client)VALUES (?,?,?,?,?,?,?)");
if($sql->execute(array($project_name,$email,$desc,$date_line,$date,$status,$cline))){
   header("location:index.php?msg=Done");
}
}

public function getProject($email){
    $sql=$this->mg_db->prepare("SELECT * FROM project WHERE user_email=?" );
    $sql->execute(array($email));
    return $sql;
}

public function addTask($project_id,$name,$descr,$status,$email,$date_line){
    $date=date("Y-m-d");
    $sql=$this->mg_db->prepare("INSERT INTO task (project_id,task_name,descrip_task,status,employee_email,date_line,date_create)VALUES (?,?,?,?,?,?,?)");
    if($sql->execute(array($project_id,$name,$descr,$status,$email,$date_line,$date))){
        header("location:tasks.php?id=".$project_id."&msg=Done");
    }

}

public function getEmploye(){
    $sql=$this->mg_db->prepare("SELECT * FROM user LEFT JOIN info ON user.email=info.email WHERE user.role=?");
    $sql->execute(array('3'));
    return $sql;
}

public function getTasks($id_pro){
    $sql=$this->mg_db->prepare("SELECT * FROM task WHERE project_id=?");
    $sql->execute(array($id_pro));
    return $sql;
}

public function employeeNmae($email){
    $sql=$this->mg_db->prepare("SELECT * FROM info WHERE email=?");
    $sql->execute(array($email));
    foreach ($sql as $s){
        return $s['name'];
    }
}

public function projectProg($id){
    $sql_task=$this->mg_db->prepare("SELECT * FROM task WHERE project_id=?");
    $sql_task->execute(array($id));
    $rows=$sql_task->rowCount();
    $sql_task_done=$this->mg_db->prepare("SELECT * FROM task WHERE project_id=? AND status=?");
    $sql_task_done->execute(array($id,"Success"));
    $rowsDone=$sql_task_done->rowCount();
    if($rows==0){
        return 0;
    }
    else{
        $result=($rowsDone/$rows)*100;
        return $result;
    }

}

public function deleteTask($id){
    $sql=$this->mg_db->prepare("DELETE FROM task WHERE id_=?");
    if($sql->execute(array($id))){
        $poj=$_SESSION['project_id'];
        header("location:tasks.php?id=".$poj."&imsg=Done");
    }
}


public function getAllEmp(){
    $sql=$this->mg_db->prepare("SELECT * FROM user LEFT JOIN info ON user.email=info.email ");
    $sql->execute();
    return $sql;
}

public function deleteProject($id){
    $sql=$this->mg_db->prepare("DELETE FROM project WHERE id=?");
    if($sql->execute(array($id))){
        $sql_tasks=$this->mg_db->prepare("DELETE FROM task WHERE project_id=?");
        if($sql_tasks->execute(array($id))){
            header("location:index.php?msg2=Done");
        }
    }
}

}