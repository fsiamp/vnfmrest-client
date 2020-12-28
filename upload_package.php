<?php
session_start();
?>
<html>
<title>Upload VNF Package | CBAM REST Client</title>
<link rel="shortcut icon" href="https://networks.nokia.com/sites/all/themes/alu_responsive/favicon.ico" type="image/vnd.microsoft.icon">
<link href="layout.css" rel="stylesheet" />
<head>
<meta charset="utf-8">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name="robots" content="noindex, nofollow">

<style>
body{
  margin-left:10px; 
  margin-right:10px;
   font-family: Tahoma;
background-color:#F7F7F7;
overflow-x: hidden;
 }
a:hover {
    background-color: lightgreen;
    text-decoration: underline;
}
</style>
</head>
<body>
<div id="head"><h1>CBAM</h1><a href="index.php"><center><img src="pw6pWh1497554045.png" height='25' width='410' alt="logo" /></center></a></div><br>
<?php
error_reporting(0);
if (isset($_FILES["package_file"]["name"])) {

    $name = $_FILES["package_file"]["name"];
    $tmp_name = $_FILES['package_file']['tmp_name'];
    $error = $_FILES['package_file']['error'];

    if (!empty($name)) {
        $location = 'packages/';

        move_uploaded_file($tmp_name, $location.$name);
        }
}

$CBAM_IP='';
$ACCESS_TOKEN='';
$PACKAGE_NAME='';

if (isset($_SESSION["cbam_ip"])) {
  $CBAM_IP=$_SESSION["cbam_ip"];
}
if (isset($_SESSION["access_token"])) {
  $ACCESS_TOKEN=$_SESSION["access_token"];
}

if(isset($_POST['cbam_ip'])){
   $CBAM_IP=$_POST['cbam_ip'];
}
if(isset($_POST['access_token'])){
   $ACCESS_TOKEN=$_POST['access_token'];
}
if (isset($_FILES["package_file"]["name"])){
   $PACKAGE_NAME=$_FILES["package_file"]["name"];
}

echo "<b style='font-size:20px;'><a href='index.php'>Get CBAM Access Token</a></b>&nbsp;&nbsp;<object style='font-size:20px;'><select style='font-size:20px;' onchange='if (this.value) window.location.href=this.value'><option style='font-size:20px;' value='upload_package.php' selected>Upload VNF Package</option><option style='font-size:20px;' value='create_vnf.php'>Create VNF</option><option style='font-size:20px;' value='modify_extensions.php'>Modify Extensions</option><option style='font-size:20px;' value='instantiate_vnf.php'>Instantiate VNF</option><option style='font-size:20px;' value='scale_vnf.php'>Scale VNF</option><option style='font-size:20px;' value='heal_vnf.php'>Heal VNF</option><option style='font-size:20px;' value='execute_custom.php'>Execute Custom Operation</option><option style='font-size:20px;' value='terminate_vnf.php'>Terminate VNF</option><option style='font-size:20px;' value='cancel_operation.php'>Cancel Operation</option><option style='font-size:20px;' value='delete_vnf.php'>Delete VNF</option><option style='font-size:20px;' value='change_package_version.php'>Change Package Version</option><option style='font-size:20px;' value='delete_package.php'>Delete VNF Package</option><option style='font-size:20px;' value='list_packages.php'>List VNF Packages</option></select><br><br>";
echo "<form action='".htmlspecialchars($_SERVER['PHP_SELF'])."' method='POST' enctype='multipart/form-data'><input type='text' name='cbam_ip' placeholder='CBAM IP' style='display:inline; position:relative; padding:3px; border:1px solid #474747;  font-size:16px; background-color: #FFF; width:536px;' value='".$CBAM_IP."'></input><br><br>";

echo "<object style='font-size:20px;'>Template Package:</object><br><br><input type='file' name='package_file' id='package_file' placeholder='Template Package' style='display:inline; position:relative; padding:3px; border:1px solid #474747; font-size:16px; background-color: #FFF; width:536px;' value='".$PACKAGE_NAME."'></input><br><br>";

echo "<input type='text' name='access_token' placeholder='Access Token' style='display:inline; position:relative; padding:3px; border:1px solid #474747; font-size:16px; background-color: #FFF; width:396px;' value='".$ACCESS_TOKEN."'></input>&nbsp;<input type='submit' style='font-size:16px;' value='Upload Package'></input></form>";

if(!empty($_POST['cbam_ip']) && isset($_FILES["package_file"]["name"]) && !empty($_POST['access_token'])){


$CBAM_IP=$_POST['cbam_ip'];
$ACCESS_TOKEN=$_POST['access_token'];

$result = shell_exec('curl -k -XPOST -i -H "Content-Type: multipart/form-data" -H "Nokia-VNFM-API-Version: 3.3" -H "Authorization: bearer '.$ACCESS_TOKEN.'" -F "content=@packages/'.$PACKAGE_NAME.'" https://'.$CBAM_IP.'/api/catalog/adapter/vnfpackages');

echo "<textarea rows='17' cols='115' style='display:inline; position:relative; padding:3px; border:1px solid #474747; font-size:17px; background-color: #FFF; width:536px;' placeholder='Response (Content)'>$result</textarea><br>";
}

else {

echo "<textarea rows='17' cols='115' style='display:inline; position:relative; padding:3px; border:1px solid #474747; font-size:17px; background-color: #FFF; width:536px;' placeholder='Response (Content)'></textarea><br>";
}
?>
</body>
</html>