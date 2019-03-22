<?php

$statusCode = 404;


if ($_SERVER['REQUEST_METHOD'] != "POST") {
    echo "Error! You aren't authorised to be here!";
}

if (isset($_POST['id'])) {

    $id = $_POST['id'];

    include "connection.php";
    $upitDeleteAdr = $conn->prepare("DELETE FROM  address WHERE user_id = :ida");
    $upitDeleteAdr->bindParam(":ida",$id);

    $upitProveraBuy = $conn->prepare("SELECT * FROM buyout WHERE cart_id = (SELECT id FROM cart WHERE usr_prod_id = (SELECT id FROM user_product WHERE user_id = :idpb ))");
    $upitProveraBuy->bindParam(":idpb",$id);

    $upitDeleteBuy = $conn->prepare("DELETE FROM  buyout WHERE cart_id = (SELECT id FROM cart WHERE usr_prod_id = (SELECT id FROM user_product WHERE user_id = :idb ))");
    $upitDeleteBuy->bindParam(":idb",$id);

    $upitProveraCart = $conn->prepare("SELECT * FROM cart WHERE usr_prod_id = (SELECT id FROM user_product WHERE user_id = :idpc )");
    $upitProveraCart->bindParam(":idpc",$id);

    $upitDeleteCart = $conn->prepare("DELETE FROM  cart WHERE usr_prod_id = (SELECT id FROM user_product WHERE user_id = :idc )");
    $upitDeleteCart->bindParam(":idc",$id);

    $upitProveraUsPr = $conn->prepare("SELECT * FROM user_product where user_id = :idpup");
    $upitProveraUsPr->bindParam(":idpup",$id);

    $upitDeleteUsPr = $conn->prepare("DELETE FROM  user_product WHERE user_id = :idup)");
    $upitDeleteUsPr->bindParam(":idup",$id);

    $upitDeleteUsr = $conn->prepare("DELETE FROM electrousers WHERE id = :idu");
    $upitDeleteUsr->bindParam(':idu',$id);

    try {

        $rezDA = $upitDeleteAdr->execute();
        if($rezDA){
         $brKolPB = $upitProveraBuy->rowCount();

            if($brKolPB>0){
                $rezDB = $upitDeleteBuy->execute();
                if($rezDB){
                    $brKolPC = $upitProveraCart->rowCount();

                    if($brKolPC>0){
                        $rezDC = $upitDeleteCart->execute();
                        if($rezDC){
                            $brKolPUP = $upitProveraUsPr->rowCount();
                            if($brKolPUP>0){
                                $rezPUP = $upitDeleteUsPr->execute();
                                if($rezPUP){
                                    $rezDU = $upitDeleteUsr->execute();
                                    if($rezDU){
                                        $statusCode = 204;
                                    }else{
                                        $statusCode = 500;
                                    }

                                }else{
                                    $statusCode = 500;
                                }
                            }else {

                                $rezDU = $upitDeleteUsr->execute();
                                if($rezDU){
                                    $statusCode = 204;
                                }else{
                                    $statusCode = 500;
                                }
                            }
                        }else{
                            $statusCode = 500;
                        }
                    }else{
                        $rezDU = $upitDeleteUsr->execute();
                        if($rezDU){
                            $statusCode = 204;
                        }else{
                            $statusCode = 500;
                        }
                    }
                }else{
                    $statusCode = 500;
                }
            }
            else
                {
                $rezDU = $upitDeleteUsr->execute();
                    if($rezDU){
                        $statusCode = 204;
                    }else{
                        $statusCode = 500;
                    }
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

