<?php
session_start();
if (isset($_POST['submit'])) {
    unset($_SESSION['error']);

    $email = $_POST['email'];
    $lozinka = $_POST['password'];

    $errors = [];
    $reLozinka = "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[#$^+=!*()@%&_-]).{8,}$/";

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Email is in wrong format!";
    }

    if (!preg_match($reLozinka, $lozinka)) {
        $errors[] = "Password or e-mail is wrong.";
    }

    if (count($errors) > 0) {
        $_SESSION['error'] = $errors;
        header("Location: ../index.php?page=login");
    } else {

            require_once "connection.php";
            $lozinka = md5($lozinka);

            $query = "SELECT u.id as uid, email,password,role_id,role,username FROM electrousers u INNER JOIN role r ON u.role_id=r.id WHERE active=1 
                  AND u.email = :email AND u.password = :password;";


            $stmt = $conn->prepare($query);
            $stmt->bindParam(":email", $email);
            $stmt->bindParam(":password", $lozinka);

            $stmt->execute();
            $user = $stmt->fetch(); // Dohvatanje samo jednog korisnika

        if ($user) {
            $_SESSION['korisnik'] =  $user; //Pravljenje sesije koja kao sadrzaj ima rezultat rada baze podataka
            header("Location: ../index.php?page=pocetna");

        } else {
            $errors[] = "Wrong e-mail or password";
            $_SESSION['error'] = $errors;
            header("Location: ../index.php?page=login");
        }
    }
}