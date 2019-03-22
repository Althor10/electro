<?php
//echo "RAdim";
session_start();

if (isset($_SESSION['korisnik']) && $_SESSION['korisnik']->role === "admin") {
    if (isset($_POST['btnSubbmit']))

        unset($_SESSION['error']);

    $adTitle = $_POST['title'];
    $adText = $_POST['text'];
    $adDate = $_POST['dateTill'];
    $image = $_FILES['adImage'];
    $priority = (int)$_POST['priority'];

    $time = strtotime($adDate);

    $newformat = date('Y-m-d H:i:s',$time);

    $regTitle = "/^[A-z\s]+$/";
    $regText = "/^.{4,55}$/";
    $errors = [];

    if (!preg_match($regTitle, $adTitle)) {
        $errors[] = "Title is not valid.";
    }
    if(!preg_match ($regText,$adText)){
        $errors[] = "Text is not valid.";
    }
    if($priority == -1){
        $errors[]  = "Must choose priority!";
    }


    $ime_fajla = $image['name'];
    $tip_fajla = $image['type'];
    $velicina_fajla = $image['size'];
    $tmp_putanja = $image['tmp_name'];

    $dozvoljeni_formati = array("image/jpg", "image/jpeg", "image/png", "image/gif");

    if(!in_array($tip_fajla, $dozvoljeni_formati)){
        $errors[] = "Wrong Type of file.";
    }

    if($velicina_fajla > 3000000){
        $errors[] = "File must be less than 3MB.";
    }
    $adDateTime = strtotime($adDate);
    $currentTime = time();
    $currentDate = date("Y-m-d H:i:s");

    if(!($adDateTime-$currentTime)>0){
        $errors[]= "Time must be set in the future!";
    }

    if (count($errors) > 0) {
//        echo $priority;
        $_SESSION['error'] = $errors;
       // echo $adDateTime - $currentTime."</br>";
        var_dump($errors);
//        var_dump($adDate);
//        var_dump($adDateTime);
        header("Location: ../index.php?page=newad");
    }
    else{
        try{
            require_once "connection.php";
            $upit_unos = $conn->prepare("INSERT INTO hotad VALUES ('',:title,:ad,:currTime,:endDate,:priority)");
            $upit_unos->bindParam(':title',$adTitle);
            $upit_unos->bindParam(':ad',$adText);
            $upit_unos->bindParam(":currTime",$currentDate);
            $upit_unos->bindParam(':endDate',$newformat);
            $upit_unos->bindParam(":priority",$priority);

            try {
                $rez1 = $upit_unos->execute();
            if($rez1){

                $naziv_fajla = time().$ime_fajla;
                $nova_putanja = "../img/upload/".$naziv_fajla;
                $putanja_fajla ="img/upload/".$naziv_fajla;

                $moveFile = move_uploaded_file($tmp_putanja, $nova_putanja);

                $upit_unos2 = $conn->prepare("INSERT INTO hotad_image VALUES ('',(SELECT id FROM hotad WHERE title=:title AND date_start = :currime),:path)");
                $upit_unos2->bindParam(":title",$adTitle);
                $upit_unos2->bindParam(":currime",$currentDate);
                $upit_unos2->bindParam(":path",$nova_putanja);
                $rez2 = $upit_unos2->execute();
                if($rez2){
                    $_SESSION['success'] = "Insert was done successfully!";
                    header("Location: ../index.php?page=adminPanel");
                }else{
                    $_SESSION['error'][] = "Update error!";
                    header("Location: ../index.php?page=newad");
                }
            } else {
                $_SESSION['error'][] = "Update error!";
                header("Location: ../index.php?page=newad");
            }
            }catch(PDOException $e){
                $e->getMessage();
            }
        }catch (PDOException $e){
            $e->getMessage();
        }
    }
}else{

    echo "<h1>NOT AUTHORISED FOR THIS PAGE. LEAVE!</h1>";
}