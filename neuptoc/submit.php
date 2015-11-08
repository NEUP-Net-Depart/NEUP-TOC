<?php error_reporting(E_ALL); ?>
<?php session_start(); ?>
<?php
    //Validate the user
    if(!isset($_SESSION['name']))
    {
        header("Location:login.php");
    }
?>
<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
    <head>
		<!-- BASICS -->
        <meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title>代码编辑</title>
        <meta name="description" content="">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<!--<link rel="stylesheet" type="text/css" href="css/isotope.css" media="screen" />	-->
		<!--<link rel="stylesheet" href="js/fancybox/jquery.fancybox.css" type="text/css" media="screen" />-->
		<link rel="stylesheet" href="css/bootstrap.css">
		<link rel="stylesheet" href="css/bootstrap-theme.css">
        <link rel="stylesheet" href="css/style.css">
		<!-- skin -->
		<link rel="stylesheet" href="skin/default.css">
    </head>
	 
    <body>
		<!-- contact -->
		<section id="section-contact" class="section appear clearfix">
			<div class="container">
				
				<div class="row mar-bot40">
					<div class="col-md-offset-3 col-md-6">
						<div class="section-header">
                        <h2 class="section-heading animated" data-animation="bounceInUp">Hi <?php echo $_SESSION['name'];?> </h2>
							<!--<p>Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet consectetur, adipisci velit, sed quia non numquam.</p>-->
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-8 col-md-offset-2">
						<div class="cform" id="contact-form">
							<div id="sendmessage">
								 Your message has been sent. Thank you!
							</div>
							<form action="submit.php" method="post" role="form" class="contactForm">
							  <div class="form-group">
								<label for="code">Paste Your Code Here!</label>
                                <textarea class="form-control" name="text" rows="15" data-rule="required" data-msg="Please write your code.">
<?php
    if($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['text'])) echo $_POST['text'];
?>
</textarea>
								<div class="validation"></div>
							  </div>
							  <div class="form-group">
								<label for="input">Your input here please~</label>
                                <textarea class="form-control" name="input" rows="4" data-rule="required" >
<?php
    if($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['input'])) echo $_POST['input'];
?>
</textarea>
								<div class="validation"></div>
							  </div>

							<div class="form-group" >
								<label for="section">Select your code language</label>
								<br/>
								<form action="submit.php" method="post">
									<div style="float: left">
								<select name="ITlanguage">
								<option value="C">C</option>
								<option value="C++">C++</option>
								<option value="C#">C#</option>
								<option value="JAVA">JAVA</option>
								<option value="PHP">PHP</option>
								<option value="Python">Python</option>
								<option value="Ruby">Ruby</option>
								<option value="OC">Objective-C</option>
								<option value="VB">VisualBasic</option>
								</select>

							</div>
									<div style="float: left;margin: 0px 10px;">
										<button type="submit" class="btn btn-theme pull-left">确认</button>
									</div>
									<div style="float: left;margin: 0px 10px;">
										<button type="reset" class="btn btn-theme pull-left">reset</button>
									</div>
									<div style="float: left;margin: 0px 10px;">
										<button type="submit" class="btn btn-theme pull-left">提交</button>
									</div>
									<br>
									</form>
								<?php
        $choose = "";
		if(isset($_POST['ITlanguage'])){
			$choose=$_POST['ITlanguage'];
		}
	?>
								<?php
        $userfilename = "";
		if(isset($_POST['input'])){
			$usertextinput=$_POST['input'];
			$userfileinput=fopen("sandbox/".md5($_POST['text']).".cpp".".in","w") or die("Unable to open file!");
			fwrite($userfileinput, $usertextinput);
			fclose($userfileinput);
			}
		if(isset($_POST['text'])){
			$usertext=$_POST['text'];
			$userfilename=md5($_POST['text']).".cpp";
			$userfile=fopen("sandbox/".$userfilename,"w") or die("Unable to open file!");
			fwrite($userfile, $usertext);
			fclose($userfile);
			}
            var_dump($_SESSION);
            var_dump($_POST);
        if($_SERVER['REQUEST_METHOD'] == "POST" && !isset($_SESSION['output']))     //if server hasn't send result back to client
        {
            $_SESSION['output'] = "";
            $_SESSION['re'] = true;
            $_SESSION['ce'] = true;
            $_SESSION['retResult'] = true;
            $ip = 'localhost';
            $port = 2333;

            $resSocket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);

            if(checkOK($resSocket,'Sock Create') == -1) exit(-1);
            $resClientConn = socket_connect($resSocket, $ip, $port);

            if(checkOK($resClientConn, 'Sock Conn') == -1) exit(-1);
            //echo "Starting Client\n";

            //$msgFromServer = socket_read($resSocket, 2345);
            $msgToServer = "$userfilename#$choose#20151111#whatthefuckismd5sum";
            //echo "Sending compiling request to server ...\n";
            socket_write($resSocket, $msgToServer, strlen($msgToServer) + 1);
            $msgFromServer = socket_read($resSocket,5);         //Listening for signal
            //echo "DEBUG: Recvd##" . $msgFromServer . "\n";
            if($msgFromServer == "FATAL")
            {
                die("Server is down now 233\n");
            }
            else if($msgFromServer == "###OK")
            {
                //echo "Compiling ok ... Program running\n";
                $_SESSION['ce'] = false;
                $msgFromServer = socket_read($resSocket,5);     //Listening for signal
                //echo "DEBUG: Recvd" . $msgFromServer . "\n";
                if($msgFromServer == "###OK")
                {
                    $_SESSION['re'] = false;
                    //echo "Running ok ... Generate output\n";
                    $msgFromServer  = socket_read($resSocket, 99999);
                    //echo "DEBUG: Recvd" . $msgFromServer . "\n";
                    //echo $msgFromServer . "\n";
                }
                //echo "DEBUG: Recvd" . $msgFromServer . "\n";
            }
            else if($msgFromServer == "##ERR")
            {
                //echo "DEBUG: Recvd" . $msgFromServer . "\n";
                //echo "Compile Failed , errMsg is below\n";
                $msgFromServer = socket_read($resSocket, 99999);
                //echo "DEBUG: Recvd" . $msgFromServer . "\n";
                echo $msgFromServer;
            }
            $_SESSION['output'] = $msgFromServer;
            socket_close($resSocket);
            
        }

?>
                                <div class="validation"></div>
                              </div>
                              <div class="form-group">
                                <label for="output">Your Code Output Here~</label>
                                <textarea class="form-control" name="output" rows="5" data-rule="required" data-msg="Here's your output">

<?php
        echo $_SESSION['output'];
        unset($_SESSION['output']);
?>
</textarea>
                                <div class="validation"></div>
                              </div>
                            </form>
                        </div>
                    </div>
                    <!-- ./span12 -->
                </div>

            </div>
        </section>
        <!-- map -->
        <section id="section-map" class="clearfix">
            <div id="map"></div>
        </section>


    <a href="#header" class="scrollup"><i class="fa fa-chevron-up"></i></a>	

    <!--<script src="js/modernizr-2.6.2-respond-1.1.0.min.js"></script>-->
    <script src="js/jquery.js"></script>
    <!--<script src="js/jquery.easing.1.3.js"></script>-->
    <script src="js/bootstrap.min.js"></script>
    <!--<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyASm3CwaK9qtcZEWYa-iQwHaGi3gcosAJc&sensor=false"></script>-->
    <!--<script src="js/jquery.isotope.min.js"></script>-->
    <!--<script src="js/jquery.nicescroll.min.js"></script>-->
    <!--<script src="js/fancybox/jquery.fancybox.pack.js"></script>-->
    <!--<script src="js/skrollr.min.js"></script>		-->
    <!--<script src="js/jquery.scrollTo-1.4.3.1-min.js"></script>-->
    <!--<script src="js/jquery.localscroll-1.2.7-min.js"></script>-->
    <!--<script src="js/stellar.js"></script>-->
    <!--<script src="js/jquery.appear.js"></script>-->
    <!--<script src="js/validate.js"></script>-->
    <!--<script src="js/main.js"></script>-->
    </body>
</html>
<?php
function checkOK ($varr, $errType)
{
    if ($varr == FALSE)
    {
        echo $errType . " Failed\n";
        return -1;
    }
    else {
        //echo $errType . " Success\n";  /* Success makes no output */
        return 0;
    }
}
?>
