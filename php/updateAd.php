<?php
session_start();
if (isset($_SESSION['korisnik']) && $_SESSION['korisnik']->role === "admin") {
    if (isset($_POST['btnSubbmit']))
        unset($_SESSION['error']);

    $adId = (int)$_POST['adId'];
    $adIId = $_POST['adIId'];
    $adTitle = $_POST['title'];
    $adText = $_POST['text'];
    $adDate = $_POST['dateTill'];
    $adDateStart = $_POST['dateStart'];
    $image = $_FILES['adImage'];
    $priority = (int)$_POST['priority'];

    $time = strtotime($adDate);

    $newformat = date('Y-m-d H:i:s',$time);

    $time2 = strtotime($adDateStart);

    $newformat2 = date('Y-m-d H:i:s',$time2);

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
        header("Location: ../index.php?page=hotedit&id=".$adId);
    }
    else {
        try {
            echo $adId;
            var_dump($adId);
            require_once 'connection.php';
            $upit_unos = $conn->prepare("UPDATE hotad SET title = :title, advert = :ad , date_start = :ds, date_end = :de, priority = :priority WHERE id = :id ");
            $upit_unos->bindParam(':title', $adTitle);
            $upit_unos->bindParam(':ad', $adText);
            $upit_unos->bindParam(':ds', $newformat2);
            $upit_unos->bindParam(':de', $newformat);
            $upit_unos->bindParam(':priority', $priority);
            $upit_unos->bindParam(':id', $adId);

            try {
                $rezUH = $upit_unos->execute();
              //  echo 'URADIO';
                if ($rezUH) {

                    $naziv_fajla = time() . $ime_fajla;
                    $nova_putanja = "../img/upload/" . $naziv_fajla;
                    $putanja_fajla = "img/upload/" . $naziv_fajla;

                    $moveFile = move_uploaded_file($tmp_putanja, $nova_putanja);
                    if($moveFile){
                        echo 'True';
                    $upit_unos2 = $conn->prepare("UPDATE hotad_image SET img_path = :img WHERE hotad_id = :idh");
                    $upit_unos2->bindParam(':img', $nova_putanja);
                    $upit_unos2->bindParam(':idh', $adId);

                    $rezUHI = $upit_unos2->execute();
                    if ($rezUHI) {

                      //  $_SESSION['success'][] = "Update finished!";
                       // header("Location: ../index.php?page=adminPanel");

                        echo $priority;
                    } else {
                        $_SESSION['error'][] = "Update error!";
                        header("Location: ../index.php?page=hotedit&id=" . $adId);
                    }
                    }else {
                        $_SESSION['error'][] = "Move Failed!";
                        header("Location: ../index.php?page=hotedit&id=" . $adId);
                    }
                } else {

                    $_SESSION['error'][] = "Update error!";
                    header("Location: ../index.php?page=hotedit&id=" . $adId);
                }

            } catch (PDOException $e) {
               echo $e->getMessage();
                $_SESSION['error'][] = "Update error!";
                header("Location: ../index.php?page=hotedit&id=".$adId);

//                echo 'OVDE';
                echo '</br> '.$adId.' '.$nova_putanja;
                var_dump($rezUHI);

            }
        } catch (PDOException $e) {
           echo $e->getMessage();
            $_SESSION['error'][] = "Update error!";
            header("Location: ../index.php?page=hotedit&id=".$adId);

        }
    }
}else{

    echo "<h1>NOT AUTHORISED FOR THIS PAGE. LEAVE!</h1>";
}