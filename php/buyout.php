<?php
session_start();
$statusCode= 404;
if(isset($_SESSION['korisnik'])){
    if( $_SERVER['REQUEST_METHOD'] != "POST") {
        echo '<h1> Not authorised to enter this page </h1>';
    }else{
        if(isset($_POST['send'])){
            include 'connection.php';
            $userId = $_POST['usrId'];
            $prodSum= $_POST['orderSum'];
            $prodIdArray = $_POST['arr'];
            $quantity = (int)$_POST['sumQuan'];


            for($i=0;$i<count($prodIdArray);$i++){


                $querySelectProduct = $conn->prepare("SELECT id FROM electroproducts WHERE id = :prodId");
                $querySelectProduct->bindParam(":prodId",$prodIdArray[$i]);
                $querySelectProduct->execute();

                $id_p = $querySelectProduct->fetch();

                $querySelectUP = $conn->prepare("SELECT id FROM user_product WHERE user_id = :userId AND prod_id = :prodId");
                $querySelectUP->bindParam(':userId',$userId);
                $querySelectUP->bindParam(':prodId',$id_p->id);
                $querySelectUP->execute();
                $id_up = $querySelectUP->fetch();

                $querySelectC = $conn->prepare("SELECT id FROM cart WHERE usr_prod_id = (SELECT id FROM user_product WHERE user_id = :userId AND prod_id = :prodId ) ");
                $querySelectC->bindParam(':userId',$userId);
                $querySelectC->bindParam(':prodId',$id_p->id);
                $querySelectC->execute();

                $id_cart = $querySelectC->fetch();

                $queryUpdateBuyout = $conn->prepare("UPDATE cart SET buyout = 1 WHERE usr_prod_id = :idup");
                $queryUpdateBuyout->bindParam(':idup',$id_up->id);





                $queryInsertBuyout = $conn->prepare("INSERT INTO buyout VALUES (DEFAULT ,:sumPrice,CURRENT_TIMESTAMP ,:idusr)");
                $queryInsertBuyout->bindParam(':sumPrice',$prodSum);
                $queryInsertBuyout->bindParam(':idcart',$id_up->id);

                $queryDeleteCart = $conn->prepare("DELETE FROM cart WHERE usr_prod_id = :idup");
                $queryDeleteCart->bindParam(":idup",$id_up->id);


                    $querySelectSold = $conn->prepare("SELECT sold FROM warehouse WHERE product_id = :prodId");
                    $querySelectSold->bindParam(':prodId',$id_p->id);
                    $querySelectSold->execute();
                    $soldOld = $querySelectSold->fetch();

                    $soldNew = $soldOld+$quantity;

                    $querySold = $conn->prepare("UPDATE warehouse SET sold = :quan WHERE prod_id = (SELECT id FROM electroproducts WHERE id = :prodId) ");
                    $querySold->bindParam(":quan",$soldNew);
                    $querySold->bindParam(":prodId",$id_p->id);





                try{
                    $rezultatIB = $queryInsertBuyout->execute();
                    if($rezultatIB){
                        $rezultatUB = $queryUpdateBuyout->execute();
                        if($rezultatUB){
                            $rezultatUQ = $querySold->execute();
                            if($rezultatUQ){
                                $rezultatDC = $queryDeleteCart->execute();

                                if($rezultatDC){
                                    $statusCode = 204;
                                    http_response_code($statusCode);
                                }
                                else{

                                    $statusCode = 500;
                                    http_response_code($statusCode);
                                }
                            }else
                                {
                                    $statusCode = 500;
                                http_response_code($statusCode);
                                }


                        }else{
                            $statusCode= 500;

                            http_response_code($statusCode);
                        }


                        }
                        else {
                            $statusCode= 500;

                            http_response_code($statusCode);
                        }

                    }catch (PDOException $e){
                    $e->getMessage();
                }
            }

        }else{
            header('Location: ../index.php?page=login');
        }
    }
}else{

    header("Location: ../index.php?page=login");
}


