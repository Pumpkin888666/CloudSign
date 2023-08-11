<?php
include_once('../models/core_mysql.php');
$name = $_POST['name'];
$SignCode = $_POST['SignCode'];

function Sign($mysqli, $name, $SignCode){
      $time = date("Y/m/d");

      $sql = "SELECT * FROM Sign";
      $result = $mysqli->query($sql);
      if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                  if ($row['name'] == $name && $row['time'] == $time) {
                        exit("
                              <script>
                              window.location.href='../Error.php?message=请勿重复签到!&returnlink=./index.html';
                              </script>");
                  }; //判断今天是否签到过
            }
      }
      $sql = "SELECT * FROM SignCode";
      $result = $mysqli->query($sql);
      if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                  if ($row['time'] == $time && $row['code'] == $SignCode) {
                        //预处理语句
                        $sql = "INSERT INTO Sign(name,time) VALUES(?,?)";
                        $addCode = $mysqli->prepare($sql);
                        $addCode->bind_param("ss", $name, $time);
                        //使用
                        if ($addCode->execute()) {
                              exit("
                        <script>
                        window.location.href='../Success.php?message=签到成功,祝你有美好的一天!&returnlink=./index.html';
                        </script>");
                        } else {
                              exit("
                        <script>
                        window.location.href='../Error.php?message=好像数据库出了点小问题...&returnlink=./index.html';
                        </script>");
                        }
                  } //判断签到码
            }
      }
      
      exit("
                        <script>
                        window.location.href='../Error.php?message=添加失败，可能有以下原因:1.你的签到码有误2.管理员还没有添加今天的签到码3.程序出错&returnlink=./index.html';
                        </script>");
};

if (!$name || !$SignCode) {
      exit("
                <script>
                    window.location.href='../Error.php?message=请你填写完整表单再提。&returnlink=./index.html';
                </script>");
}

Sign($mysqli, $name, $SignCode);

$mysqli->close();

?>