<?php
class DB{
    protected $db;
    public function __construct($user,$pass)
    {
        $this->db=new PDO("mysql:host=localhost;dbname=ptm",$user,$pass);
    }


}
