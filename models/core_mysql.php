<?php

$host = "localhost";
$user = "username"; //用户名
$password = "password"; //密码
$dbname = "dbname"; //数据库名

$mysqli = new mysqli($host,$user,$password,$dbname);

if($mysqli->connect_errno){
    die($mysqli->connect_error);
}