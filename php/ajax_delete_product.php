<?php

$statusCode = 404;


if ($_SERVER['REQUEST_METHOD'] != "POST") {
    echo "Error! You aren't authorised to be here!";
}

if (isset($_POST['id'])) {

    $id = $_POST['id'];

    include "connection.php";
    $upitDeleteImage = $conn->prepare("DELETE FROM images WHERE product_id = :idi");
    $upitDeleteImage->bindParam(":idi",$id);

    $upitDeleteWarehouse = $conn->prepare("DELETE FROM warehouse WHERE product_id = :idw");
    $upitDeleteWarehouse->bindParam(":idw",$id);

    $upitDeleteProduct = $conn ->prepare("DELETE FROM electroproducts WHERE id = :idp");
    $upitDeleteProduct->bindParam(":idp",$id);

    $upitDeleteVezivna = $conn->prepare("DELETE FROM user_product WHERE prod_id = :idup");
    $upitDeleteVezivna->bindParam(":idup",$id);

    $upitProveraVezivna = $conn->prepare("SELECT * FROM user_product WHERE prod_id = :idupp ");
    $upitProveraVezivna->bindParam(":idupp",$id);

    $upitProveraCart = $conn->prepare("SELECT * FROM cart WHERE usr_prod_id = (SELECT id FROM user_product WHERE prod_id = :iducp)");
    $upitProveraCart->bindParam(":iducp",$id);

    $upitDeleteCart = $conn->prepare("DELETE FROM cart WHERE usr_prod_id=(SELECT id FROM user_product WHERE prod_id = :iddc)");
    $upitDeleteCart->bindParam(":iddc",$id);

    $upitProveraBuyout = $conn->prepare("SELECT * FROM buyout WHERE cart_id = (SELECT id FROM cart WHERE usr_prod_id = (SELECT id FROM user_product WHERE prod_id = :idubp))");
    $upitProveraBuyout->bindParam(":idubp",$id);

    $upitDeleteBuyout = $conn->prepare("DELETE FROM buyout WHERE WHERE cart_id = (SELECT id FROM cart WHERE usr_prod_id = (SELECT id FROM user_product WHERE prod_id = :iddb))");
    $upitDeleteBuyout->bindParam(":iddb",$id);

    try {
        $rezQ = $upitDeleteWarehouse->execute();
        $rezI = $upitDeleteImage->execute();
        $rezPV = $upitProveraVezivna->execute();
        $brRedVezivna = $upitProveraVezivna->rowCount();
        if($brRedVezivna>0){
           // Ako POSTOJI VEZIVNA
            $rezPC = $upitProveraCart->execute();
            if($rezPC){
                $rezPB = $upitProveraBuyout->execute();
                if($rezPB){
                    $rezDB = $upitDeleteBuyout->execute();
                    $rezDC = $upitDeleteCart->execute();
                    $rezP1 = $upitDeleteProduct->execute();
                    if($rezDB && $rezDC && $rezP1){
                        $statusCode = 204;
                    }
                    else
                        {
                        $statusCode=500;
                    }
                }
            }else{
                $statusCode=500;
            }
        }else{
            //AKO ne postoji Vezivna!
            $rezP = $upitDeleteProduct->execute();
            $statusCode= 204;
        }

    } catch (PDOException $e) {
        $statusCode = 500;
    }



}

// Vracanje statusnog koda ka klijentu (JS)
http_response_code($statusCode);

