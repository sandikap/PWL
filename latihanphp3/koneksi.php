<?php
date_default_timezone_set('Asia/Jakarta');

$servername = "localhost";
$username = "root";
$password = "";
$db = "webdailyjournal";

//create connection
$conn = new mysqli($servername,$username,$password,$db);

//check connection
if($conn->connect_error){
    die("Connection Failed : ".$conn->connect_error);
}

echo "Connected successfully<hr>";
?>