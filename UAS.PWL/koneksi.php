<?php
date_default_timezone_set('Asia/Jakarta');

$servername = "localhost";
$username = "id21748630_admin";
$password = "Sandik4!"; //isi password masing"
$db = "id21748630_webdailyjournal";

//create connection
$conn = new mysqli($servername,$username,$password,$db);

//check connection
if($conn->connect_error){
    die("Connection Failed : ".$conn->connect_error);
}

echo "Connected successfully<hr>";
?>