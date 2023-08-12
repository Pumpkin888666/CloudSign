<?php
include_once("../models/core_mysql.php");
session_start();
if(!isset($_SESSION['username'])){
    exit("
        <script>
        window.location.href='../admin/Login.html';
        </script>"); 
};

function ChangePassword($mysqli,$username,$oldpassword,$newpassword){
    $sql = "SELECT username,id FROM admin WHERE username = ? and password = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("ss",$username,$oldpassword);
    if($stmt->execute()){
        $stmt->bind_result($username,$id);
        while($stmt->fetch()){
            $sql = "UPDATE admin SET password = '$newpassword' WHERE id=$id";
            $stmt->free_result();
            if($mysqli->query($sql)){
                echo("
                <script>
                window.location.href='../Success.php?message=修改成功!请重新登录&returnlink=./admin/Login.html';
                </script>");
                session_destroy();
                exit();
            }else{
                echo $mysqli->error;
                exit();
                // exit( "
                //     <script>
                //     window.location.href='../Error.php?message=数据库出了点小问题...&returnlink=./admin/ChangePassword.html';
                // </script>");
            }
        }
    }
    exit( "
        <script>
        window.location.href='../Error.php?message=修改失败，请检查参数。&returnlink=./admin/ChangePassword.html';
        </script>");
    
    $stmt->close();
}




if(!isset($_POST['oldpassword']) || !isset($_POST['newpassword']) || $_POST['newpassword'] == '' || $_POST['oldpassword'] == '' || $_POST['username'] == ''){
    exit( "
        <script>
            window.location.href='../Error.php?message=请你填写完整表单在提交。&returnlink=./admin/ChangePassword.html';
    </script>");
};

ChangePassword($mysqli,$_POST['username'],md5($_POST['oldpassword']),md5($_POST['newpassword']));

$mysqli->close();
?>