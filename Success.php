<?php
if(!isset($_GET['message']) || !isset($_GET['returnlink'])){
    exit("缺少参数");
}

?>

<!DOCTYPE html>
<html lang="zh-CN">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>嘿嘿</title>
    <link rel="stylesheet" href="./pkg/bootstrap.min.css">
    <script src="./pkg/jquery-3.7.0.min.js"></script>
    <style>
        .card {
            margin: 20vh auto;
            box-shadow: 2px 2px 12px 2px #ccc;
            border-radius: 7px;
        }
    </style>
</head>

<body>

    <div class="container">
        <div class="card" style="width: 18rem;">
            <div class="card-body">
                <h1>Oh yee~</h1>
                <?php
                echo $_GET['message'];
                $returnlink = $_GET['returnlink'];
                echo "<br>";
                echo "<a href='$returnlink' class='btn btn-success'>继续</a>";
                ?>
            </div>
        </div>
    </div>


    <script src="./pkg/popper.min.js"></script>
    <script src="./pkg/bootstrap.min.js"></script>
</body>

</html>