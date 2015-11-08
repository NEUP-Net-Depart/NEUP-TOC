<!DOCTYPE html>
<html>
<head>
<?php
    session_start();
	//include('XXX.php');
	//$username="DMK";
    $username = $_SESSION['name'];
	echo '<p style="text-align:center">'."您好，".$username."。这是您编辑代码的地方！".'</p>';
?>

 
 
<hr/>
</head>
<form action="submit.php" method="post">
<div style="width:1000px;height:500px;float:left" >
	<h3>在以下方块中编辑您的代码：</h3>
	<textarea name="text" rows="50" cols="100" maxlength="1000" background:transparent></textarea>
	<br/>
	<br/>
	<input type="button" value="重置" style="width:500px;height:50px;float:left" id="text2" onclick="ResetText()" >
	<script type="text/javascript">
		function ResetText(){
			document.getElementById('id').Value = '';
		}
    </script>
</div>

<div style="width:300px;height:500px;float:left">
	<h3>在以下地方选择您要编辑的语言：</h3>
	<br/>
	<br/>
	<form action="submit.php" method="post">
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
		<input type="submit" value="确认" name="submit" />
	</form>
	<?php
		if(isset($_POST['ITlanguage'])){
			$choose=$_POST['ITlanguage'];
		}
	?>
	<br/>
	<br/>
	<h3>在以下地方输入您的输入语句：</h3>
	<textarea name="input" rows="15" cols="100" maxlength="500" id="input2"></textarea>
	<br/>
	<br/>
	<input type="button" value="重置" style="width:500px;height:50px" onclick="ResetText()" >
	<script type="text/javascript">
		function ResetText(){
			document.getElementById('id').Value = '';
		}
    </script>
	</script>
	<input type="submit" value="提交" style="width:500px;height:50px">
	<?php
		if(isset($_POST['input'])){
			$usertextinput=$_POST['input'];
			$userfileinputname=md5($_POST['input']);
			$userfileinput=fopen($userfileinputname."input.txt","w") or die("Unable to open file!");
			fwrite($userfileinput, $usertextinput);
			fclose($userfileinput);
			}
		if(isset($_POST['text'])){
			$usertext=$_POST['text'];
			$userfilename=md5($_POST['text']);
			$userfile=fopen($username."@".$userfilename.".txt","w") or die("Unable to open file!");
			fwrite($userfile, $usertext);
			fclose($userfile);
			}
	?>
	<br/>
	<br/>
	<h3>在以下地方输出您的结果：</h3>
	<form action="submit.php" method="post">
		<textarea name="text" rows="15" cols="100" maxlength="5000">
		<?php
			
		?></textarea>
		<br/>
		<br/>
	</form>
</form>
</div>
</html>
