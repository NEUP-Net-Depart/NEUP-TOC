<?php error_reporting(0);?>
<?php
  session_start();
  check_login();
   ?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1.0" />
    <title>在线编译</title>

    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css" />
    <link rel="stylesheet" type="text/css" href="css/bootstrap-theme.min.css" />

    <style type="text/css">
        html,body {
            height: 100%;
        }
        body {background-image: url(DMKSB.jpg);
            background-repeat:no-repeat;
        }
        .box {
            filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#6699FF', endColorstr='#6699FF'); /*  IE */

            /*background-image:linear-gradient(bottom, #6699FF 0%, #6699FF 100%);
            background-image:-o-linear-gradient(bottom, #6699FF 0%, #6699FF 100%);
            background-image:-moz-linear-gradient(bottom, #6699FF 0%, #6699FF 100%);
            background-image:-webkit-linear-gradient(bottom, #6699FF 0%, #6699FF 100%);
            background-image:-ms-linear-gradient(bottom, #6699FF 0%, #6699FF 100%);*/

            margin: 0 auto;
            position: relative;
            width: 100%;
            height: 100%;
        }
        .login-box {
            width: 100%;
            max-width:500px;
            height: 400px;
            position: absolute;
            top: 50%;

            margin-top: -200px;
            /*设置负值，为要定位子盒子的一半高度*/

        }
        @media screen and (min-width:500px){
            .login-box {
                left: 50%;
                /*设置负值，为要定位子盒子的一半宽度*/
                margin-left: -250px;
            }
        }

        .form {
            width: 100%;
            max-width:500px;
            height: 275px;
            margin: 0 auto;
            padding-top: 25px;
        }
        .login-content {
            height: 300px;
            width: 100%;
            max-width:500px;
            background-color: rgba(255, 250, 2550, .6);
            float: left;
        }


        .input-group {
            margin: 0px 0px 30px 0px !important;
        }
        .form-control,
        .input-group {
            height: 40px;
        }

        .form-group {
            margin-bottom: 0px !important;
        }
        .login-title {
            padding: 20px 10px;
            background-color: rgba(0, 0, 0, .6);
        }
        .login-title h1 {
            margin-top: 10px !important;
        }
        .login-title small {
            color: #fff;
        }

        .link p {
            line-height: 20px;
            margin-top: 30px;
        }
        .btn-sm {
            padding: 8px 24px !important;
            font-size: 16px !important;
        }
    </style>

</head>

<body>
<?php
    function check_login()
    {
      echo $_SESSION['name'];
        if(isset($_SESSION['name']))
        {
            header("Location:submit.php");
        }
        else
        {

        }
        return ;
    }
    if($_SERVER['REQUEST_METHOD']!='POST')
    {
    	?>

<div class="box">
    <div class="login-box">

        <div class="login-title text-center">

            <h1><small>登录界面</small></h1>
        </div>
        <div class="login-content ">

            <div class="form">
                <?php
    if($_SESSION['err'] == true)
      {
      	?>
                <div align="center" >
                    <font color="#FF0000">用户名或密码错误</font>
                </div>
                <?php
      }
      ?>
                <form action="#" method="post">
                    <div class="form-group">
                        <div class="col-xs-12  ">
                            <div class="input-group">
                                <span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
                                <input type="text" id="name" name="name" class="form-control" placeholder="用户名">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-12  ">
                            <div class="input-group">
                                <span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></span>
                                <input type="password" id="pwd" name="pwd" class="form-control" placeholder="密码">
                            </div>
                        </div>
                    </div>


                    <div class="form-group form-actions">
                        <div class="col-xs-4 col-xs-offset-4 ">
                            <button type="submit" class="btn btn-sm btn-info"><span class="glyphicon glyphicon-off"></span> 登录</button>
                        </div>
                    </div>
                </form>
                <?php
    }
    else
    {
        $user = $_POST['name'] ;
        $password = $_POST['pwd'];
        if($user=='root' && $password=='root')
        {
            $_SESSION['name'] = "root";
            ?>
                <script language='javascript'>document.location = 'submit.php'</script>
                <?php
        }
        else
        {
          $_SESSION['err'] = true;
            ?>
                <script language='javascript'>document.location = 'login.php'</script>
                <?php
         }
  }
    ?>
            </div>
        </div>
    </div>
</div>

<div style="text-align:center;">
</div>


</body>

</html>