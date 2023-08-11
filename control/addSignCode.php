<?php
include_once("../models/core_mysql.php");
session_start();
if(!isset($_SESSION['username'])){
    exit("
        <script>
        window.location.href='./Login.html';
        </script>"); 
}
function addCode($mysqli,$SignCode){
    $time = date("Y/m/d");

    $sql = "SELECT * FROM SignCode";
    $result = $mysqli->query($sql);
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            if($row['time'] == $time){
                exit( "
                <script>
                    window.location.href='../Error.php?message=今日你已经添加过了。&returnlink=./admin/SignCodeAdd.html';
                </script>");
            } //验证今日是否添加过code
        }
    }

    //预处理语句
    $sql = "INSERT INTO SignCode(time,code) VALUES(?,?)";
    $addCode = $mysqli->prepare($sql);
    
    $addCode->bind_param("si",$time,$SignCode);
    //使用
    if($addCode->execute()){
        exit( "
                <script>
                    window.location.href='../Success.php?message=成功添加签到码&returnlink=./admin/index.php';
                </script>");
    }else{
        exit("
                <script>
                    window.location.href='../Error.php?message=好像数据库出了点小问题...&returnlink=./admin/SignCodeAdd.html';
                </script>");
    }
};

if(!isset($_POST['SignCode']) || $_POST['SignCode'] == ''){
    exit( "
                <script>
                    window.location.href='../Error.php?message=请你填写完整表单在提交。&returnlink=./admin/SignCodeAdd.html';
                </script>");
};

addCode($mysqli,$_POST['SignCode']);

$mysqli->close();
?>