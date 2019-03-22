<?php
//echo "RAdim";

    if (isset($_POST['btnSubbmit'])) {

        unset($_SESSION['error']);

        $email = $_POST['email'];

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = "Email is not valid";
        }

        if (count($errors) > 0) {
            $_SESSION['error'] = $errors;
            var_dump($errors);
            header("Location: ../index.php?page=newad");
        } else {
            try {
                require_once 'connection.php';
                $queryInsertNews = $conn->prepare("INSERT INTO newsletter (DEFAULT,:mail,CURRENT_TIMESTAMP)");
                $queryInsertNews->bindParam(':mail', $email);
                $rez = $queryInsertNews->execute();
                if ($rez) {

                    header("Location: ../index.php?page=store");
                } else {
                    $_SESSION['error'][] = "Error!!";
                    header("Location: ../index.php?page=pocetna");
                }
            } catch (PDOException $e) {
            }
        }
    }