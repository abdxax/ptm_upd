<?php
require "DB.php";
class User extends DB {
    private $user_db;
    public function __construct($user, $pass)
    {
        parent::__construct($user, $pass);
        $this->user_db=$this->db;
    }

    public function getTask($email){
        $sql=$this->user_db->prepare("SELECT * FROM task LEFT JOIN project ON task.project_id=project.id WHERE task.employee_email=?");
        $sql->execute(array($email));
        return $sql;
    }

    public function getTaskId($id){
        $sql=$this->user_db->prepare("SELECT * FROM task LEFT JOIN project ON task.project_id=project.id WHERE task.id_=?");
        $sql->execute(array($id));
        return $sql;
    }

    public function getTaskStatus($id){
        $sql=$this->user_db->prepare("SELECT * FROM task WHERE id_=?");
        $sql->execute(array($id));
        foreach ($sql as $s){
            return $s['status'];
        }
    }

    public function update($id,$status){
        $sql=$this->user_db->prepare("UPDATE task SET status=? WHERE id_=?");
        if($sql->execute(array($status,$id))){
           header('location:index.php?msg=Done');
        }
    }
}