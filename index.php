<?php
include "php/connection.php";
session_start();
$page = "";

if(isset($_GET['page'])){
    $page = $_GET['page'];
}

include "view/head.php";

include "view/header.php";
include "view/nav.php";

switch($page){
    case 'pocetna':
        include "view/section1Big.php";
        include "view/section2newProducts.php";
        include "view/section3hot.php";
        include "view/section4Top.php";
        include "view/section5TopSlider.php";
        break;
    case 'product':
        include 'view/product.php';
        break;
    case 'prodedit':
        include "view/product_update.php";
        break;
    case 'login':
        include 'view/loginAcc.php';
        break;
    case 'register':
        include 'view/register.php';
        break;
    case 'adminPanel':
        include 'view/admin.php';
        break;
    case 'prodinsert':
        include 'view/insertProduct.php';
        break;
    case 'newad':
        include "view/insertAd.php";
        break;
    case 'hotedit':
        include 'view/ad_update.php';
        break;
    case 'checkout':
        include 'view/checkout.php';
        break;
    case 'store':
        include 'view/store.php';
        break;
    case 'contact':
        include 'view/author.php';
        break;
    case 'survey':
        include 'view/survey.php';
        break;
    case 'contactAdmin':
        include 'view/contactAdmin.php';
        break;
    default:
        include "view/section1Big.php";
        include "view/section2newProducts.php";
        include "view/section3hot.php";
        include "view/section4Top.php";
        include "view/section5TopSlider.php";
        break;
}


include "view/newsletter.php";
include "view/footer.php";
?>