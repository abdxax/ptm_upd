<?php
session_start();
require "../../../../backend/Manager.php";
$mang=new Manager('root','');
$id=$_GET['id'];
$mang->deleteProject($id);

