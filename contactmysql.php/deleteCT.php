<?php
$servername= "localhost";
$username="root";
$password="";
$database="contactform";
$conn = mysqli_connect($servername,$username,$password,$database);  
if(!$conn){
    die("connection failed: ". mysqli_connect_error() );
}
$sql ="";
$result = mysqli_query($conn,$sql);
echo "Data Deleted";
mysqli_close($conn);


?>