<?php
session_start();
require "../../../../backend/Manager.php";
$mang=new Manager('root','');
$mang->deleteTask($_GET['id']);
