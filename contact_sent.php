<?php
$name=$_POST['name']; 
$email=$_POST['email'];  
$phone=$_POST['phone'];
$message=$_POST['message'];  
date_default_timezone_set("Asia/Kuala_Lumpur");
$datetime = date("Y-m-d H:i:s");

//////////DB  CONNECTION////////////

$conn = new mysqli('localhost', 'root', '', 'recipebook');
if($conn->connect_error){
    die('Connection failed : ' .$conn->connect_error);
}else{
    $stmt = $conn->prepare("insert into contact(name, email, phone_no, message, sent_at )
    values(?, ?, ?, ?, ?)");//////ikut variable php
    
    $stmt->bind_param("sssss", $name, $email, $phone, $message, $datetime);
    $stmt->execute();
    $stmt->close();
    $conn->close();
    
    ///////////////////try error message/////////////

    echo'<script>alert("Submit Success.Thank You For Your Feedback.")</script>';
    echo '<script>window.location="contactus.php"</script>';

}
?>
