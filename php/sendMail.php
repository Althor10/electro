<?php
//echo "RAdim";
session_start();
if (isset($_POST['btnSubbmit'])) {

    unset($_SESSION['error']);

    $subject = $_POST['subject'];
    $message = $_POST['message'];
    $fullname = $_POST['fullName'];
    $email = $_POST['email'];

    $errors = [];
    if($subject == ""){
        $errors[] = "Must have a subject!";
    }

    if($message == ""){
        $errors[] = "Can't send an empty message!";
    }



    if (count($errors) > 0) {
        $_SESSION['error'] = $errors;
        var_dump($errors);
        header("Location: ../index.php?page=contactAdmin");
    } else {
        try {
            require_once 'connection.php';
            $queryInsertMail = $conn->prepare("INSERT INTO adminmessage(id,fullname,email,subject,message,date) VALUES (DEFAULT,:fullname,:email,:subject,:mess,CURRENT_TIMESTAMP)");
            $queryInsertMail->bindParam(':fullname',$fullname);
            $queryInsertMail->bindParam(':email', $email);
            $queryInsertMail->bindParam(':subject', $subject);
            $queryInsertMail->bindParam(':mess', $message);
            $rez = $queryInsertMail->execute();
            if ($rez) {
                header("Location: ../index.php?page=pocetna");
            } else {
                $_SESSION['error'][] = "Error!!";
                header("Location: ../index.php?page=contactAdmin");
            }
        } catch (PDOException $e) {
            $e->getMessage();
        }
    }
}