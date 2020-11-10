<?php
require "DB.php";
class login extends DB{
 private $login;
 public function __construct($user, $pass)
 {
     parent::__construct($user, $pass);
     $this->login=$this->db;
 }

 public function newUser($email,$pass,$name,$phone,$depart,$role){
     $sql=$this->login->prepare("INSERT INTO user (email,pass,role) VALUES (?,?,?)");
     if($sql->execute(array($email,$pass,$role))){
         $sql_info=$this->login->prepare("INSERT INTO info (email,name,phone,rank,depart_id) VALUES(?,?,?,?,?)");
         if($sql_info->execute(array($email,$name,$phone,"",$depart))){
             return "";
         }
     }

 }

 public function getUser(){
     $sql=$this->login->prepare("SELECT * FROM user LEFT JOIN info ON user.email=info.email  where user.role!=?");
     $sql->execute(array('1'));
     return $sql;
 }

 public function deleteUser($email){
     $sql=$this->login->prepare("DELETE FROM user WHERE email=?");
     if($sql->execute(array($email))){
         $sql_info=$this->login->prepare("DELETE FROM info WHERE email=?");
         if($sql_info->execute(array($email))){
             header("location:index.php");
         }
     }
 }

    public function newDepart($depart){
        $sql=$this->login->prepare("INSERT INTO department (depart_name) VALUES (?)");
        if($sql->execute(array($depart))){
            return "";
        }



    }

    public function getDepa(){
     $sql=$this->login->prepare("SELECT * FROM department");
     $sql->execute();
     return $sql;
    }

    public function getrole(){
        $sql=$this->login->prepare("SELECT * FROM role");
        $sql->execute();
        return $sql;
    }

    public function login($email,$pass){
     $sql=$this->login->prepare("SELECT * FROM user WHERE email=? AND pass=? ");
     $sql->execute(array($email,$pass));
     if($sql->rowCount()==1){

         foreach ($sql as $s){
             if($s['role']==1){
                 $_SESSION['email']=$email;
                 $_SESSION['pass']=$pass;
                 header("location:Admin/index.php");
             }
             else if($s['role']==2){
                 $_SESSION['email']=$email;
                 $_SESSION['pass']=$pass;
                 header("location:Manager/index.php");

             }
             else if($s['role']==3){
                 $_SESSION['email']=$email;
                 $_SESSION['pass']=$pass;
                 header("location:User/index.php");
             }
             else{

             }
         }
     }
     else{
         header("location:login.php?msg=error");
     }
    }


    public function checkEmail($email){
     $sql=$this->login->prepare("SELECT * FROM user WHERE email=?");
     $resu=$sql->execute(array($email));
     $couns=$sql->rowCount();
     if($couns==1){
         $_SESSION['email_res']=$email;
         return true;
     }
     return false;
    }

    public function restPassword($email,$pass){
     $pas=sha1($pass);
     $sql=$this->login->prepare("UPDATE user SET pass=? WHERE email=?");
     if($sql->execute(array($pas,$email))){
         header("location:login.php");
     }
    }


}

