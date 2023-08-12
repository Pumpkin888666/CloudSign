<?php
session_start();
if(!isset($_SESSION['username'])){
    exit("
        <script>
        window.location.href='./Login.html';
        </script>"); 
}
$username = $_SESSION['username'];
include_once('../models/core_mysql.php')
?>


<!DOCTYPE html>
<html lang="zh-CN">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>云签到</title>
    <link rel="stylesheet" href="../pkg/bootstrap.min.css">
    <script src="../pkg/jquery-3.7.0.min.js"></script>
    <style>
        .a {
            margin: 10vh auto;
            box-shadow: 2px 2px 12px 2px #ccc;
            border-radius: 7px;
            background-color: rgba(69, 146, 223, 0.7);
            height: 80vh;
        }
        .card{
            box-shadow: 2px 2px 12px 2px #0c33b3;
            border-radius: 7px;
            background-color: rgb(69, 146, 225);
        }
    </style>
</head>

<body>

    <div class="container a">
        <?php
        $time = date('H');
        if($time > 0 && $time <= 7){
            echo"<h1>$username,午夜了~</h1>";
        }elseif($time > 7 && $time <= 12){
            echo"<h1>$username,早上好~</h1>";
        }elseif($time > 12 && $time <= 18){
            echo"<h1>$username,下午好~</h1>";
        }elseif($time > 18 && $time <= 24){
            echo"<h1>$username,晚上好~</h1>";
        }
        ?>

        <div class="row">

            <div class="col-md-4">
                <div class="card" style="width: 18rem;">
                    <div class="card-body">
                        <?php
                        $time = date("Y/m/d");
                        $sql = "SELECT code FROM SignCode WHERE time = ?";
                        $stmt = $mysqli->prepare($sql);
                        $stmt->bind_param("s",$time);
                        if($stmt->execute()){
                            $stmt->bind_result($code);
                            while($stmt->fetch()){
                               echo'<h5>今日已设置签到码！</h5>';
                                echo("<h3 style='text-align:center;'>".$code."<h3>");
                                echo "<a href='./SignCodeAdd.html' class='btn btn-success'>签到码设置页面</a>";
                            }
                        }
                        if(!$code){
                            echo'<h5>今日还未设置签到码！</h5>';
                            echo "<h3 style='text-align:center;'>NULL</h3>";
                            echo "<a href='./SignCodeAdd.html' class='btn btn-success'>去设置</a>";
                        }
                        
                        $stmt->free_result();
                        $stmt->close();
                        ?>

                        
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card" style="width: 18rem;">
                    <div class="card-body">
                        <?php
                        $sql = "SELECT * FROM Sign";
                        $result = $mysqli->query($sql);
                        $time = date("Y/m/d");
                        $num = 0;
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                if ($row['time'] == $time) {
                                    $num++;
                                }; 
                            }
                        }
                        echo'<h5>今日签到人数:</h5>';
                        echo("<h3 style='text-align:center;'>".$num."</h3>");
                        ?>

                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#SignList">
                        <img src="../static/svg/person-fill.svg">
                        今日签到名单
                        </button>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card" style="width: 18rem;">
                    <div class="card-body">
                        <h5>管理员:</h5>
                        <?php
                        echo "<h3 style='text-align:center;'>$username</h3>"
                        ?>
                        <a href="./ChangePassword.html" class="btn btn-success">
                            <img src="../static/svg/shield-check.svg">
                            修改密码
                        </a>
                    </div>
                </div>
            </div>

        </div>
        <div class="container">
            <h1>服务器信息</h1>
            <ul>
                <li>
                    <b>PHP 版本：</b><?php echo phpversion() ?>
                    <?php if(ini_get('safe_mode')) { echo '线程安全'; } else { echo '非线程安全'; } ?>
                </li>
                <li>
                    <b>MySQL 版本：</b><?php echo mysqli_get_server_info($mysqli) ?>
                </li>
                <li>
                    <b>WEB软件：</b><?php echo $_SERVER['SERVER_SOFTWARE'] ?>
                </li>
                
                <li>
                    <b>服务器时间：</b><?php echo date("Y/m/d H:i:s") ?>
                </li>
            </ul>
        </div>
    </div>
    </div>
                    
    



    <!-- Modal -->
    <div class="modal fade" id="SignList" tabindex="-1"        aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">今日签到名单</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <ol>
                   <?php
                    $time = date("Y/m/d");
                    $sql = "SELECT name FROM Sign WHERE time = ?";
                    $stmt = $mysqli->prepare($sql);
                    $stmt->bind_param("s",$time);
                    if($stmt->execute()){
                        $stmt->bind_result($name);
                        while($stmt->fetch()){
                           echo'<li><p>'.$name.'</p></li>';
                        }
                    }
                    
                    ?>    
                        <li><p>没有更多了...</p></li> 
            </ol>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">关闭</button>
          </div>
        </div>
      </div>
    </div>
    <script src="../pkg/popper.min.js"></script>
    <script src="../pkg/bootstrap.min.js"></script>
</body>

</html>