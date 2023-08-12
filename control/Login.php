<?php
include_once("../models/core_mysql.php");

session_start();
if (isset($_SESSION['username'])) {
      exit("
                        <script>
                        window.location.href='../Error.php?message=您已登录&returnlink=./admin/index.html';
                        </script>");
}



$username = $_POST['username'];
$password = md5($_POST['password']);

function Login($mysqli, $username, $password)
{
      $sql = "SELECT username FROM admin WHERE username = ? and password = ?";
      $stmt = $mysqli->prepare($sql);
      $stmt->bind_param("ss",$username,$password);
      if($stmt->execute()){
            $stmt->bind_result($username);
            while($stmt->fetch()){
                  $_SESSION['username'] = $username;
                 echo "<script>
                    window.location.href='../Success.php?message=登录成功&returnlink=./admin/index.php';
                </script>" ;
            }
            exit("
                <script>
                    window.location.href='../Error.php?message=登录失败。&returnlink=./admin/Login.html';
                </script>");
      }
      $stmt->free_result();
      $stmt->close();
};

if ($username =='' || $password =='') {
      exit("
                <script>
                    window.location.href='../Error.php?message=请你填写完整表单再提。&returnlink=./admin/Login.html';
                </script>");
}

Login($mysqli, $username, $password);

$mysqli->close();
?>