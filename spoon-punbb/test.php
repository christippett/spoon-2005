<!DOCTYPEhtmlPUBLIC"-//W3C//DTDXHTML1.0Transitional//EN""http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<htmlxmlns="http://www.w3.org/1999/xhtml">
<head>
<metahttp-equiv="Content-Type"content="text/html;charset=iso-8859-1"/>
<title>UntitledDocument</title>
</head>

<body>
<?php
if($_GET['stage']==2){
$filter=array('!','@','#','$','%','^','&','*','(',')','-','_','.','+','=');
	$text=str_replace($filter,"",$_POST['text']);
	echo$text;
	echo"</body>";
	echo"\n</html>";
	exit();
}
?>
<formid="form1"name="form1"method="post"action="<?=$PHP_SELF?>?stage=2">
<label>
<inputname="text"type="text"id="text"/>
</label>
<label>
<inputtype="submit"name="Submit"value="Submit"/>
</label>
</form>
</body>
</html>
