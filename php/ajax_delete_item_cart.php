<?php
$statusCode = 404;


if ($_SERVER['REQUEST_METHOD'] != "POST") {
    echo "Error! You aren't authorised to be here!";
}

if (isset($_POST['id'])) {

    $id = $_POST['id'];
    $idu = $_POST['idu'];

    include "connection.php";
    $upitDeleteCart = $conn->prepare("DELETE FROM cart WHERE usr_prod_id = (SELECT id FROM user_product WHERE prod_id = :idc AND user_id = :idu) ");
    $upitDeleteCart->bindParam(":idc",$id);
    $upitDeleteCart->bindParam(":idu",$idu);

    $upitDeleteUP = $conn->prepare("DELETE FROM user_product WHERE prod_id = :idp AND user_id = :idu ");
    $upitDeleteUP->bindParam(":ida",$id);
    $upitDeleteUP->bindParam(":idu",$idu);

    try {

        $rezDC = $upitDeleteCart->execute();

        if($rezDC){
            $rezDUP = $upitDeleteUP->execute();
            if($rezDUP){
                $statusCode = 204;
            }else{
                $statusCode = 500;
            }

        }else{
            $statusCode = 500;
        }

    } catch (PDOException $e) {
        $statusCode = 500;
    }



}

// Vracanje statusnog koda ka klijentu (JS)
http_response_code($statusCode);

