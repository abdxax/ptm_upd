<?php
session_start();
require "../../../../backend/login.php";
$mang=new login('root','');
$id=$_GET['id'];
$mang->deleteUser($id);
