<?php
session_start();

if (isset($_SESSION['korisnik']) && $_SESSION['korisnik']->role === "admin") {

    if (isset($_POST['btnSubbmit']))
        //unset($_SESSION['error']);

    $prodId = $_POST['prodId'];
    $prodName = $_POST['productName'];
    $prodDesc = trim($_POST['textDesc']);
    $prodSpec = trim($_POST['textSpec']);
    $lastPrice = $_POST['lastPrice'];
    $sale = $_POST['sale'];
    $price =  $_POST['lastPrice']-($_POST['lastPrice']*$sale/100);
    $new = $_POST['new'];
    $hot = $_POST['hot'];
    $prodQuantity = $_POST['prodQuantity'];
    $prodSold = $_POST['prodSold'];

    $regProductName = "/^[.@&]?[a-zA-Z0-9 ]+[ !.@&()]?[ a-zA-Z0-9!()]+/";
    $regPrice = "/^[0-9]{0,4}$/";
    $errors = [];

    if (!preg_match($regProductName, $prodName)) {
        $errors[] = "Product name is not valid.";
    }

    if (strlen($prodDesc)>500) {
        $errors[] = "Exceeded maximum character count for the description.";
    }

    if (strlen($prodSpec)>700) {
        $errors[] = "Exceeded maximum character count for the specification.";
    }
//    if(!preg_match($regPrice,$price)){
//        $errors[] = "Price format is wrong.";
//    }
    if(!preg_match($regPrice,$prodQuantity)){
        $errors[] = "Quantity is wrong";
    }


    if (count($errors) > 0) {


        $_SESSION['error'] = $errors;
        var_dump($errors);
        echo $sale;
        header("Location: ../index.php?page=prodedit&id=$prodId");
    } else {


        require_once "connection.php";
        $upit_unos = $conn->prepare("UPDATE warehouse SET quantity = :quant , sold = :sold WHERE product_id = (SELECT id FROM electroproducts WHERE id = :prodid) ");

        $upit_unos->bindParam(':quant', $prodQuantity);
        $upit_unos->bindParam(':sold',$prodSold);
        $upit_unos->bindParam(':prodid', $prodId);


        try {

            $rezultat = $upit_unos->execute();
            //header("Location: ../index.php?page=adminPanel");

            if ($rezultat) {
                if($lastPrice<>$price && $sale <> -1 && $sale == 0){
                $upit_unos2 = $conn->prepare("UPDATE electroproducts SET name = :name, description = :desc, specifications = :specs, price = :price,lastprice = :lastprice, sale=:sale, new= :new, hot= :hot  WHERE id = :prodid ");

                    $upit_unos2->bindParam(':name',$prodName);
                    $upit_unos2->bindParam(':desc',$prodDesc);
                    $upit_unos2->bindParam(':specs',$prodSpec);
                    $upit_unos2->bindParam(':price',$price);
                    $upit_unos2->bindParam(':lastprice',$lastPrice);
                    $upit_unos2->bindParam(':sale',$sale);
                    $upit_unos2->bindParam(':new',$new);
                    $upit_unos2->bindParam(':hot',$hot);
                    $upit_unos2->bindParam(':prodid',$prodId);
                }else{
                    $upit_unos2 = $conn->prepare("UPDATE electroproducts SET name = :name, description = :desc, price=:price,lastprice = null, specifications = :specs, sale=null, new= :new, hot= :hot  WHERE id = :prodid ");

                    $upit_unos2->bindParam(':name',$prodName);
                    $upit_unos2->bindParam(':desc',$prodDesc);
                    $upit_unos2->bindParam(':specs',$prodSpec);
                    $querySel="SELECT lastprice FROM electroproducts WHERE id=".$prodId;
                    $execQ = executeQuery($querySel);
                    foreach($execQ as $item){
                    $upit_unos2->bindParam(':price',$item->lastprice);
                        }
                    $upit_unos2->bindParam(':new',$new);
                    $upit_unos2->bindParam(':hot',$hot);
                    $upit_unos2->bindParam(':prodid',$prodId);
                }
            }

                        try{
                            $rez2 = $upit_unos2->execute();
                            if ($rez2) {
                                $_SESSION['success'] = "Update was made!";
                                header("Location: ../index.php?page=adminPanel");
                            } else {
                                $_SESSION['error'][] = "Update error!";

                                header("Location: ../index.php?page=prodedit&id=$prodId");
                            }
                        }
                        catch (PDOException $e){
                            echo $e->getMessage();


                        }
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
}
} else {

    echo "<h1>NOT AUTHORISED FOR THIS PAGE. LEAVE!</h1>";
}
