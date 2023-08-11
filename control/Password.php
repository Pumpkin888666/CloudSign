<?php
include_once("../models/core_mysql.php");
session_start();
if(!isset($_SESSION['username'])){
    exit("
        <script>
        window.location.href='../admin/Login.html';
        </script>"); 
};

function ChangePassword($mysqli,$oldpassword,$newpassword){
    $sql = "SELECT * FROM admin";
    $result = $mysqli->query($sql);
    if ($result->num_rows > 0) {
          while ($row = $result->fetch_assoc()) {
                if ($row['password'] == md5($oldpassword)) {
                    $password = md5($newpassword);
                    $sql = "UPDATE admin SET password = '$password' WHERE id=".$row['id'];
                    
                    if(mysqli_query($mysqli,$sql)){
                        session_destroy();
                        exit("
                        <script>
                        window.location.href='../Success.php?message=修改成功!请牢记&returnlink=./admin/Login.html';
                        </script>");
                    }else{
                        exit( "
                            <script>
                            window.location.href='../Error.php?message=数据库出了点小问题...&returnlink=./admin/ChangePassword.html';
                        </script>");
                    }
                    
                }
          }
    }
    
    exit( "
        <script>
            window.location.href='../Error.php?message=旧密码错误。&returnlink=./admin/ChangePassword.html';
    </script>");
}




if(!isset($_POST['oldpassword']) || !isset($_POST['newpassword']) || $_POST['newpassword'] == '' || $_POST['oldpassword'] == ''){
    exit( "
        <script>
            window.location.href='../Error.php?message=请你填写完整表单在提交。&returnlink=./admin/ChangePassword.html';
    </script>");
};

ChangePassword($mysqli,$_POST['oldpassword'],$_POST['newpassword']);

$mysqli->close();
?>