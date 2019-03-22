<?php
session_start();
require_once "connection.php";
if ($_SERVER['REQUEST_METHOD'] != "POST") {
    echo "Error! You are not authorised to be here!!!";
}
if (isset($_POST['btnSubmit'])){
    unset($_SESSION['error']);

    $contactName = $_POST['tbIme'];
    $products = $_POST['products'];
    $answer = $_POST['yesNo'];
    $errors = [];

    $reName = "/\b([A-Z]{1}[a-z]{1,30}[- ]{0,1}|[A-Z]{1}[- \']{1}[A-Z]{0,1}  
    [a-z]{1,30}[- ]{0,1}|[a-z]{1,2}[ -\']{1}[A-Z]{1}[a-z]{1,30}){2,5}/";


    if (!preg_match($reName, $contactName)) {
        $errors[] = "Wrong type for name.";
    }
    if($products == "" || $products == null){
        $errors[] = "Must choose an answer";
    }
    if( $answer == null){
        $errors[] = "Must choose an answer";
    }

    if (count($errors) > 0) {


        $_SESSION['error'] = $errors;
        header("Location: ../index.php?page=survey");
    } else {

        require_once "connection.php";

        $upit_unos = $conn->prepare("INSERT INTO survey (name,product,answer) VALUES ( :name,:product,:answer)");

        // Zamena "placeholdera" iz upita sa vrednostima

        $upit_unos->bindParam(':name', $contactName);
        $upit_unos->bindParam(':product', $products);
        if($answer == 1){
            $yes ="yes";
            $upit_unos->bindParam(':answer', $yes);
        }
        else{
            $no='no';
            $upit_unos->bindParam(':answer', $no);
        }
        try {


            $rezultat = $upit_unos->execute();
            if ($rezultat) {
                $_SESSION['success']= "You have sent a message!";
                header("Location: ../index.php?page=pocetna");
            } else {
                $_SESSION['error'][]= "Error while sending message";
                header("Location: ../index.php?page=survey");
            }

        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }}