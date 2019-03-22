<?php
session_start();
$statusCode= 404;
if(isset($_SESSION['korisnik'])){
if( $_SERVER['REQUEST_METHOD'] != "POST") {
    echo '<h1> Not authorised to enter this page </h1>';
}else{
    if(isset($_POST['send'])){
        include 'connection.php';
        $prodId= $_POST['id'];
        $usrId = $_POST['usrId'];

        if(isset($_POST['quan'])){
            $quantity1 = $_POST['quan'];
        }

        $queryUpit = $conn->prepare("SELECT * FROM user_product WHERE user_id = :usrId AND prod_id = :prod AND quantity = 1");
        $queryUpit->bindParam(":usrId",$usrId);
        $queryUpit->bindParam(":prod",$prodId);
        $queryUpit->execute();

        $userProdData = $queryUpit->fetch();




        if($queryUpit->rowCount()<1) {

            $queryBind = $conn->prepare("INSERT INTO user_product(user_id,prod_id,quantity) VALUES (:usr,:prod,1)");
            $queryBind->bindParam(':usr', $usrId);
            $queryBind->bindParam(':prod', $prodId);

            try {
                $rezB = $queryBind->execute();

                if ($rezB) {

                    $queryCart = $conn->prepare("INSERT INTO cart(usr_prod_id,quantity,buyout) VALUES ((SELECT id FROM user_product WHERE user_id = :usr AND prod_id = :prod AND quantity = 1),1,0)");
                    $queryCart->bindParam(':usr',$usrId);
                    $queryCart->bindParam(':prod',$prodId);

                    $rezC = $queryCart->execute();
                    if ($rezC) {
                        $statusCode = 204;
                        http_response_code($statusCode);
                    } else {
                        $statusCode = 500;

                        http_response_code($statusCode);
                    }
                } else{
                    $statusCode = 500;

                    http_response_code($statusCode);
                }
            }catch (PDOException $e){
                $e->getMessage();
            }


        }else{
            $queryUpdate = $conn->prepare("UPDATE user_product SET quantity = :quan WHERE id = :idUP ");
            $quantity = $userProdData->quantity + 1;
            $queryUpdate->bindParam(":quan",$quantity);
            $queryUpdate->bindParam(":idUP",$userProdData->id);

            try {
                $rezU = $queryUpdate->execute();

                if ($rezU) {

                    $querySelCart= $conn->prepare("SELECT * FROM cart WHERE usr_prod_id = :idup");
                    $querySelCart->bindParam(":idup",$userProdData->id);
                    $querySelCart->execute();

                    if($querySelCart->rowCount()<1){

                        $queryCart2 = $conn->prepare("INSERT INTO cart(usr_prod_id,quantity,buyout) VALUES (:idup,:quan,0)");
                        $queryCart2->bindParam(':idup',$userProdData->id);
                        $queryCart2->bindParam(":quan",$quantity);

                        $rezC2 = $queryCart2->execute();
                        if ($rezC2) {
                            $statusCode = 204;
                            http_response_code($statusCode);
                        } else {
                            $statusCode = 500;

                            http_response_code($statusCode);
                        }

                    }else{
                        $queryCart3 = $conn->prepare("UPDATE cart SET quantity = :quan WHERE usr_prod_id = :idup");
                        $queryCart3->bindParam(":quan",$quantity);
                        $queryCart3->bindParam(':idup',$userProdData->id);

                        $rezC3 = $queryCart3->execute();
                        if ($rezC3) {
                            $statusCode = 204;
                            http_response_code($statusCode);
                        } else {
                            $statusCode = 500;

                            http_response_code($statusCode);
                        }
                    }


                } else{
                    $statusCode = 500;

                    http_response_code($statusCode);
                }
            }catch (PDOException $e){
                $e->getMessage();
            }

        }


    }
    else
        { $statusCode= 500;

        http_response_code($statusCode);}
}
}else{

    header("Location: ../index.php?page=login");
    $statusCode = 403;
    http_response_code($statusCode);
}


