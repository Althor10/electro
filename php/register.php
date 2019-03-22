<?php
session_start();
if (isset($_POST['btnSubmit']))
    unset($_SESSION['error']);


$ime = trim($_POST['first-name']);
$prezime = trim($_POST['last-name']);
$email = trim($_POST['email']);
$lozinka = trim($_POST['password']);
$username = $_POST['username'];
$city = $_POST['city'];
$adresa = $_POST['adress'];

# Validacija podataka

$reImePrezime = "/^[A-Z][a-z]{2,50}$/";
$reLozinka = "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[#$^+=!*()@%&_-]).{8,}$/";
$reAdress = "/^([A-Z][a-z]+\s)+(\d)+$/";
$errors = [];

if (!preg_match($reImePrezime, $ime)) {
    $errors[] = "Wrong type for name.";
}

if (!preg_match($reImePrezime, $prezime)) {
    $errors[] = "Last name wont go.";
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = "Email is not valid";
}

if (!preg_match($reLozinka, $lozinka)) {
    $errors[] = "Password must be at least 5 letters long.";
}
if (!preg_match($reAdress, $adresa)) {
    $errors[] = "Adress is not valid.";
}
if($city==-1){
    $errors[] = "You must choose a city!";
}

if (count($errors) > 0) {


    $_SESSION['error']= $errors;
    var_dump($_SESSION['error']);
   // header("Location: ../index.php?page=register");
} else {

    # Generisanje korisnickog imena od email adrese korisnika

    $lozinka = md5($lozinka);
    require_once "connection.php";

    $upit_unos = $conn->prepare("INSERT INTO electrousers VALUES ('', :first, :last, :email,  :lozinka, :username, :datum,(SELECT id FROM role r WHERE r.role='user'),0)");


    $upit_unos->bindParam(':first', $ime);
    $upit_unos->bindParam(':last', $prezime);
    $upit_unos->bindParam(':email', $email);
    $upit_unos->bindParam(':lozinka', $lozinka);
    $upit_unos->bindParam(':username', $username);

    $datum = date("Y-m-d H:i:s");

    $upit_unos->bindParam(':datum', $datum);

    try {
        // izvrsavanje upita

        $rezultat = $upit_unos->execute();

        if ($rezultat) {
            $upit_unos2 = $conn->prepare("INSERT INTO address VALUES('',:adress,(SELECT id FROM city WHERE id= :city),(SELECT id FROM electrousers WHERE email=:email))");
            $upit_unos2->bindParam(':adress',$adresa);
            $upit_unos2->bindParam(':city',$city);
            $upit_unos2->bindParam(':email',$email);

            try{
                $rezultat2 = $upit_unos2->execute();
                if($rezultat2){
                        $success = $_SESSION['success'];
                        array_push($success,'DONE!');
                    header("Location: ../index.php?page=login");
                }else{
                    $_SESSION['error'][]= "Error!!";
                    header("Location: ../index.php?page=register");
                }
            }catch (PDOException $e){
                echo $e->getMessage();
            }
        } else {
            $_SESSION['error'][]= "Error!!";
            header("Location: ../index.php?page=register");
        }
    } catch (PDOException $e) {
        echo $e->getMessage();
    }

}