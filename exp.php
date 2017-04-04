<?php
echo <<<_END
<html>
<head>
<title>
MULTI TOOLKIT
</title>
</head>
<link rel='stylesheet' type='text/css' href='style.css'>
_END;
echo '<body background = "./ico/bg.jpg">';
echo '<br><table border width = "100%"><tr><td>';
$df = "ifconfig | grep -Eo 'inet (addr:)?([0-9]*\.){3}[0-9]*' | grep -Eo '([0-9]*\.){3}[0-9]*' | grep -v '127.0.0.1'
";
$ip = shell_exec($df);
echo "to connect to this using a device connected to common network type </br>";
echo "<h3>".$ip."/exp.php"."</h3>";
echo "<td>";
$df = "upower -i $(upower -e | grep 'BAT') | grep -E".' "state|to\ full|percentage"';
$ip = shell_exec($df);
echo "THIS IS THE POWER DETAIL OF YOUR SERVER</br>";
echo "<h3>".$ip."/exp.php"."</h3>";
echo "</table><br>";

$fs = fopen("ext.txt", 'r');
$dir = fread($fs,filesize("ext.txt"));
fclose($fs);
if(isset($_POST['fldr']))
echo $_POST['fldr'];
if(isset($_POST['filename']) and !empty($_POST['ta']))
{
	$filename = $_POST['filename'];
	$flnm = $dir.$filename;
$fh = fopen("$flnm", 'w');
$text = $_POST['ta'];
fwrite($fh, $text);
fclose($fh);
}

if (isset($_POST['open'])) 
{
	$filename = $_POST['filename'];
	$flnm = $dir.$filename;
	$m = 1;
	$fh = fopen("$flnm", 'r') or
die("File does not exist or you lack permission to open it");
	$line = fread($fh, filesize($flnm));
	fclose($fh); 
	
	
}
if(isset($_POST['reset']))
{
	$dir = "./";
	$fs = fopen("ext.txt",'w');
	fwrite($fs , $dir);
	fclose($fs);
}
if(isset($_POST['back']))
{	$n = filesize("ext.txt")-2;
	for($k = $n;$k>0;$k--)
	{
		if($dir[$k] == "/")
			{$pos = $k+1;
			 break;
			}
	}
	
	$dir = substr($dir, 0 ,$pos);
	$fs = fopen("ext.txt",'w');
	fwrite($fs , $dir);
	fclose($fs);

}
echo <<<_END
<table>
<tr>
<td>
<form method = "post" action = "exp.php">
<input type = "hidden" name = "reset">
<button type="submit"> <img src = "./ico/reset.png"> </button>
</form>
<td>
<form method = "post" action = "exp.php">
<input type = "hidden" name = "back">
<button type="submit"><img src = "./ico/prev.png"></button>
</form>
</table>


_END;

echo <<<_END
<table>
<tr>
<td valign = "top">
<h3> CREATE FILE </h1>
<form method='post' action="exp.php" name="sa"><pre>
<input type="text" name="filename">the file name</input>
<textarea name="ta" cols="80" rows="30" class="l">$line</textarea>
<input type="submit" value="submit file">
</form>
</pre>
<td valign = "top">
<h3> OPEN EXISTING FILE </h3> 
<form method='post' action="exp.php" name="sa"><pre>
<input type="text" name="filename">the file name</input>
<input type="hidden" name="open">
<input type="submit" value="open file">
</form>
</pre>

_END;

echo <<<_END
<td valign = "top">
<h3>EXECUTE SHELL COMMANDS </h3>
<form method = "post" action = "exp.php">
<input type = "text" name = "cmd">input command here</input>
<input type = "submit" value = "submit" name = "pressed">
</form>

_END;
if(isset($_POST['pressed']))
{
	$cmd = $_POST['cmd'];
	exec(escapeshellcmd($cmd), $output, $status);
	if ($status) echo "Exec command failed";
	else
	{
		echo "<pre>";
		foreach($output as $line) echo htmlspecialchars("$line\n");
		echo "</pre>";
	}
	
}


if(isset($_POST['fldr']))
	{$dir = $dir . $_POST['fldr'] . "/";
	 $fs = fopen("ext.txt", 'w');
	 fwrite($fs, $dir);
	 fclose($fs);
	}
;

$ab = scandir($dir);
echo '<tr><td style="border:6px solid black;background:yellow"><h3> BROWSER WINDOW </h3>';
for ($i=2;$i < count($ab);$i++)
{	$ext = strrpos($ab[$i], '.')==""?"":substr($ab[$i], strrpos($ab[$i], '.') + 1);
	echo "<hr>";
    if($ext == "png" or $ext == "jpg" or $ext == "jpeg" or $ext == "gif")
	echo 'filename : - <a href="'.$dir.$ab[$i].'"><img src="./ico/img1.png">'.$ab[$i].'</a><br>';
    elseif($ext == "mp3")
	echo 'filename : - <a href="'.$dir.$ab[$i].'"><img src="./ico/mp31.png">'.$ab[$i].'</a><br>';
    elseif($ext == "pdf")
	echo 'filename : - <a href="'.$dir.$ab[$i].'"><img src="./ico/pdf1.png">'.$ab[$i].'</a><br>';
    elseif($ext == "mp4" || $ext == "wmv" || $ext == "mkv" || $ext == "avi")
	echo 'filename : - <a href="'.$dir.$ab[$i].'"><img src="./ico/vid1.png">'.$ab[$i].'</a><br>';
    elseif($ext == "txt")
	echo 'filename : - <a href="'.$dir.$ab[$i].'"><img src="./ico/file.png">'.$ab[$i].'</a><br>';
    elseif($ext == "")
	echo '<img src = "./ico/fldr2.png">'.$ab[$i].'<form method = "post" action = "exp.php"><input type = "hidden" name = "fldr" value = "'.$ab[$i].'"><input type = "submit" value = "visit"></form></br>';
    elseif($ext == "html")
	echo 'filename : - <a href="'.$dir.$ab[$i].'"><img src="./ico/html1.png">'.$ab[$i].'</a><br>';
    elseif($ext == "php")
	echo 'filename : - <a href="'.$dir.$ab[$i].'"><img src="./ico/php1.png">'.$ab[$i].'</a><br>';
    elseif($ext == "zip" or $ext == "tar")
	echo 'filename : - <a href="'.$dir.$ab[$i].'"><img src="./ico/zip1.png">'.$ab[$i].'</a><br>';
	else
	echo 'filename : - <a href="'.$dir.$ab[$i].'">'.$ab[$i].'</a><br>';
	
}
// upload.php
echo <<<_END
<td valign="top">
<h3>UPLOAD FILES TO SERVER</h3>
<form method="post" enctype="multipart/form-data">
    <input type="file" name="files[]" id="files" multiple="" />
    <input type="submit" value="Upload" />
</form>
_END;
if(isset($_FILES['files'])){
    $errors= array();
	foreach($_FILES['files']['tmp_name'] as $key => $tmp_name ){
		$file_name = $key.$_FILES['files']['name'][$key];
		$file_size =$_FILES['files']['size'][$key];
		$file_tmp =$_FILES['files']['tmp_name'][$key];
		$file_type=$_FILES['files']['type'][$key];	
		$desired_dir="user_data";
        if(empty($errors)==true){
            if(is_dir($desired_dir)==false){
                mkdir("$desired_dir", 0700);		// Create directory if it does not exist
            }
            if(is_dir("$desired_dir/".$file_name)==false){
                move_uploaded_file($file_tmp,"user_data/".$file_name);
            }}
}}
echo "</body>"




?>
