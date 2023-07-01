<?php
session_start();
require 'connection.php';

$POST = filter_var_array($_POST, FILTER_SANITIZE_STRING);
$POSTI = filter_var_array($_POST, FILTER_SANITIZE_NUMBER_INT);


if(isset($POST['starRate'])) {

    $starRate = mysqli_real_escape_string($conn, $POST['starRate'] ?? "");
    $rateMsg = mysqli_real_escape_string($conn, $POST['rateMsg'] ?? "");
    $date = mysqli_real_escape_string($conn, $POST['date'] ?? "");
    $userName = mysqli_real_escape_string($conn, $POST['name'] ?? "");
    $id = mysqli_real_escape_string($conn, $POST['id'] ?? "");

    $sql = $conn->prepare("SELECT * from review WHERE userName=? AND recipe_id =?");
    $sql->bind_param("ss", $userName,  $id);
    $sql->execute();
    $res = $sql->get_result();
    $rst = $res->fetch_assoc();
    $pCode = $rst['userName'];
    if(!$pCode) {
        $stmt = $conn->prepare("INSERT INTO review (userName, userReview, userMessage, dateReviewed, recipe_id ) VALUES ( ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $userName, $starRate, $rateMsg, $date, $id);
    }
    else {
        $stmt = $conn->prepare("UPDATE review SET userName=?, userReview=?, userMessage=?, dateReviewed=? WHERE userName=? AND recipe_id =?");
        $stmt->bind_param("ssssss",  $userName, $starRate, $rateMsg, $date, $userName, $id);
    }

   $stmt->execute();
}