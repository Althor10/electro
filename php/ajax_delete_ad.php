<?php

$statusCode = 404;


if ($_SERVER['REQUEST_METHOD'] != "POST") {
    echo "Error! You aren't authorised to be here!";
}

if (isset($_POST['id'])) {

    $id = $_POST['id'];

    include "connection.php";
    $upitDeleteImage = $conn->prepare("DELETE FROM hotad_image WHERE hotad_id = :idh");
    $upitDeleteImage->bindParam(":idh",$id);

    $upitDeleteAd = $conn->prepare("DELETE FROM hotad WHERE id = :ida");
    $upitDeleteAd->bindParam(":ida",$id);

    try {
        $rezDI = $upitDeleteImage->execute();
        $rezDA = $upitDeleteAd->execute();
        if($rezDI && $rezDA){
            $statusCode = 204;
        }else{
            $statusCode = 500;
        }

    } catch (PDOException $e) {
        $statusCode = 500;
    }



}

// Vracanje statusnog koda ka klijentu (JS)
http_response_code($statusCode);

