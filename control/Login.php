<?php
include_once("../models/core_mysql.php");

session_start();
if(isset($_SESSION['username'])){
     exit("
                        <script>
                        window.location.href='../Error.php?message=您已登录&returnlink=./admin/index.html';
                        </script>"); 
}



$username = $_POST['username'];
$password = md5($_POST['password']);

function Login($mysqli, $username, $password){
      $sql = "SELECT * FROM admin";
      $result = $mysqli->query($sql);
      if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                  if ($row['username'] == $username && $row['password'] == $password) {
                        $_SESSION['username'] = $username;
                        exit("
                        <script>
                        window.location.href='../Success.php?message=登录成功!&returnlink=./admin/index.php';
                        </script>");
                  }
            }
      }
      
      exit("
                        <script>
                        window.location.href='../Error.php?message=登录失败，用户名或密码错误&returnlink=./admin/Login.html';
                        </script>");
};

if(!$username && !$password){
      exit("
                <script>
                    window.location.href='../Error.php?message=请你填写完整表单再提。&returnlink=./index.html';
                </script>");
}

Login($mysqli,$username,$password);

$mysqli->close();
?>