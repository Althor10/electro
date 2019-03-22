<?php
session_start();

if (isset($_SESSION['korisnik']) && $_SESSION['korisnik']->role === "admin") {

    if (isset($_POST['btnSubbmit']))
        unset($_SESSION['error']);

    $prodName = $_POST['prodName'];
    $prodDesc = trim($_POST['prodDesc']);
    $prodSpec = trim($_POST['prodSpec']);
    $price =  $_POST['prodPrice'];
    $color = $_POST['slColor'];
    $category = $_POST['slCategory'];
    $prodQuantity = $_POST['prodQuantity'];
    $image = $_FILES['filImage'];

    $regProductName = "/^[.@&]?[a-zA-Z0-9 ]+[ !.@&()]?[ a-zA-Z0-9!()]+/";
    $regPrice = "/^[0-9]{0,4}$/";
    $errors = [];

    if (!preg_match($regProductName, $prodName)) {
        $errors[] = "Product name is not valid.";
    }

    if (strlen($prodDesc)>500) {
        $errors[] = "Exceeded maximum character count for the description.";
    }
    if (!$prodQuantity>0) {
        $errors[] = "You must enter the quantity of products.";
    }

    if (strlen($prodSpec)>700) {
        $errors[] = "Exceeded maximum character count for the specification.";
    }
    if(!preg_match($regPrice,$price)){
        $errors[] = "Price format is wrong.";
    }
    if(!preg_match($regPrice,$prodQuantity)){
        $errors[] = "Quantity is wrong";
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

    if (count($errors) > 0) {


        $_SESSION['error'] = $errors;
        var_dump($errors);
        header("Location: ../index.php?page=prodinsert");
    } else {


        require_once "connection.php";
        $upit_unos = $conn->prepare("INSERT INTO electroproducts (id,name,description,price,specifications,lastprice,new,sale,hot,color_id,subcat_id) VALUES ('',:name,:desc,:price,:spec,null,1,0,0,(SELECT id from color WHERE id=:colId),(SELECT id from subcategory WHERE id= :subId))");

        $upit_unos->bindParam(':name', $prodName);
        $upit_unos->bindParam(':desc',$prodDesc);
        $upit_unos->bindParam(':price', $price);
        $upit_unos->bindParam(':spec', $prodSpec);
        $upit_unos->bindParam(':colId', $color);
        $upit_unos->bindParam(':subId', $category);


        try {

            $rezultat = $upit_unos->execute();
            //header("Location: ../index.php?page=adminPanel");

            if ($rezultat) {

                    $upit_unos2 = $conn->prepare("INSERT INTO warehouse (id,product_id,quantity,sold) VALUES ('',(SELECT id FROM electroproducts WHERE name = :name AND specifications = :specs),:quant,0)");

                    $upit_unos2->bindParam(':name',$prodName);
                    $upit_unos2->bindParam(':specs',$prodSpec);
                    $upit_unos2->bindParam(':quant',$prodQuantity);
                $rez2 = $upit_unos2->execute();
                if($rez2){


                    $naziv_fajla = time().$ime_fajla;
                    $nova_putanja = "../img/upload/".$naziv_fajla;
                    $putanja_fajla ="img/upload/".$naziv_fajla;

                    $moveFile = move_uploaded_file($tmp_putanja, $nova_putanja);

                    if($moveFile) {
                        $upit_unos3 = $conn->prepare("INSERT INTO images (id,product_id,img_path,alt) VALUES ('',(SELECT id FROM electroproducts WHERE name = :name AND specifications = :specs),:path,:alt)");
                        $upit_unos3->bindParam(":name",$prodName);
                        $upit_unos3->bindParam(':specs',$prodSpec);
                        $upit_unos3->bindParam(':path',substr($nova_putanja,1));
                        $upit_unos3->bindParam(':alt',$prodName);
                        $rez3 = $upit_unos3->execute();
                        if($rez3){
                            try{
                                if ($rez3) {
                                    $_SESSION['success'] = "Insert was done successfully!";
                                    header("Location: ../index.php?page=adminPanel");
                                } else {
                                    $_SESSION['error'][] = "Update error!";
                                    header("Location: ../index.php?page=prodinsert");
                                }
                            }
                            catch (PDOException $e){
                                echo $e->getMessage();

                            }
                        }
                    }

                }else {
                    header("Location: ../index.php?page=prodinsert");
                    $_SESSION['error'] [] = "Query error";
                }

                }else {
                header("Location: ../index.php?page=prodinsert");
                $_SESSION['error'] [] = "Query error";
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
} else {

    echo "<h1>NOT AUTHORISED FOR THIS PAGE. LEAVE!</h1>";
}
