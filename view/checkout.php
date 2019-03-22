<!-- BREADCRUMB -->
<div id="breadcrumb" class="section">
    <!-- container -->
    <div class="container">
        <!-- row -->
        <div class="row">
            <div class="col-md-12">
                <h3 class="breadcrumb-header">Checkout</h3>
                <ul class="breadcrumb-tree">
                    <li><a href="#">Home</a></li>
                    <li class="active">Checkout</li>
                </ul>
            </div>
        </div>
        <!-- /row -->
    </div>
    <!-- /container -->
</div>
<!-- /BREADCRUMB -->
<?php
if(isset($_SESSION['korisnik'])): ?>
<!-- SECTION -->
<div class="section">
    <!-- container -->
    <div class="container">
        <!-- row -->
        <div class="row">

            <div class="col-md-7">
                <!-- Billing Details -->
                <div class="billing-details">
                    <div class="section-title">
                        <h3 class="title">Billing address</h3>
                    </div>
                    <?php
                    $queryGetUsr = "SELECT *,co.name as coname,ci.name as ciname FROM electrousers u INNER JOIN address a ON u.id = a.user_id INNER JOIN city ci ON a.city_id = ci.id INNER JOIN country co ON ci.country_id = co.id WHERE u.id = ".$_SESSION['korisnik']->uid;
                    $rezGetUsr = executeQuery($queryGetUsr);
                    foreach ($rezGetUsr as $usr):
                     ?>
                    <div class="form-group">
                        <input class="input" type="text" name="first-name" value="<?= $usr->firstname ?>" readonly>
                    </div>
                    <div class="form-group">
                        <input class="input" type="text" name="last-name" value="<?= $usr->lastname ?>" readonly>
                    </div>
                    <div class="form-group">
                        <input class="input" type="email" name="email" value="<?= $usr->email ?>" readonly>
                    </div>
                    <div class="form-group">
                        <input class="input" type="text" name="address" value="<?= $usr->adress ?>" readonly>
                    </div>
                    <div class="form-group">
                        <input class="input" type="text" name="city" value="<?= $usr->ciname ?>" readonly>
                    </div>
                    <div class="form-group">
                        <input class="input" type="text" name="country" value="<?= $usr->coname ?>" readonly>
                    </div>
                    <div class="form-group">
                        <div class="input-checkbox">
                            <input type="checkbox" id="create-account">

                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
                <!-- /Billing Details -->


                <!-- Order notes -->
                <div class="order-notes">
                    <textarea class="input" placeholder="Order Notes"></textarea>
                </div>
                <!-- /Order notes -->
            </div>
            <?php
            $usrId = $_SESSION['korisnik']->uid;
            $queryCart= $conn->prepare("SELECT * FROM cart c INNER JOIN user_product up ON c.usr_prod_id = up.id WHERE up.user_id=:usid");
            $queryCart->bindParam(':usid',$usrId);
            $rezCart = $queryCart->execute();
            $queryCartObj = "SELECT *,ep.id as pid FROM cart c INNER JOIN user_product up ON c.usr_prod_id = up.id INNER JOIN electroproducts ep ON up.prod_id = ep.id INNER JOIN images i ON ep.id = i.product_id WHERE up.user_id=$usrId AND buyout = 0 LIMIT 1";
            $rezCartObj = executeQuery($queryCartObj);

            ?>
            <!-- Order Details -->
            <div class="col-md-5 order-details">
                <div class="section-title text-center">
                    <h3 class="title">Your Order</h3>
                </div>
                <div class="order-summary">
                    <div class="order-col">
                        <div><strong>PRODUCT</strong></div>
                        <div><strong>TOTAL</strong></div>
                    </div>

                    <div class="order-products">
                        <?php foreach ($rezCartObj as $obj):?>
                        <div class="order-col">
                            <div><?= $obj->quantity ?>x <?= $obj->name ?></div>
                            <input type="hidden" class="quantity" value="<?=$obj->quantity ?>">
                            <input type="hidden" class="bought-product" value="<?= $obj->pid ?>" >
                            <div>$<?= $obj->price ?>.00</div>
                        </div>

                        <?php endforeach; ?>
                    </div>



                    <div class="order-col">
                        <div>Shiping</div>
                        <div><strong>FREE</strong></div>
                    </div>
                    <div class="order-col">
                        <div><strong>TOTAL</strong></div>
                        <?php
                        $querySum = "SELECT *,ep.id as pid FROM cart c INNER JOIN user_product up ON c.usr_prod_id = up.id INNER JOIN electroproducts ep ON up.prod_id = ep.id WHERE up.user_id=$usrId AND buyout = 0 LIMIT 1 ";
                        $execSumObj = executeQuery($querySum);
                        $suma = 0;
                        foreach($execSumObj as $sum)
                        {
                            if($obj->quantity>1){
                                $suma += $sum->price*$sum->quantity;
                            }
                            else
                                {
                                $suma += $sum->price;
                                }
                        }
                        ?>
                        <div><strong class="order-total" >$<?= $suma ?>.00</strong></div>
                        <input type="hidden" id="orderSum" value="<?=$suma ?>">
                        <input type="hidden" id="quantitySum" value=""?>
                    </div>
                </div>
                <div class="input-checkbox">
                    <input type="checkbox" id="terms">
                    <label for="terms">
                        <span></span>
                        I've read and accept the <a href="https://docs.google.com/document/d/1GPy-UEZdkJW4TCBlvmyRPUeyWuOctnTbE04MCGo2mHI/edit">terms & conditions</a>
                    </label>
                </div>
                <button  class="primary-btn order-submit center-block" >Place order</button>
                <input type="hidden" id="usrId" value="<?= $_SESSION['korisnik']->uid ?>">
            </div>
            <!-- /Order Details -->
        </div>
        <!-- /row -->
    </div>
    <!-- /container -->
</div>
    <script src="js/jquery-3.3.1.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            $('.order-submit').click(function () {
                var orderSum = $('#orderSum').val();
                var usrId = $('#usrId').val();
                var prodId = document.getElementsByClassName('bought-product');
                var arr = [];
                var quantity = document.getElementsByClassName('quantity');

                var sumQuan = 0;
                for(var j = 0;j<quantity.length;j++){
                    sumQuan += quantity[j].value;
                }

                for(var i= 0;i<prodId.length;i++){
                    arr.push(prodId[i].value);
                }
                //alert (arr);
                // alert(usrId);
                // alert(id);


                $.ajax({
                    method: 'POST',
                    url: "php/buyout.php",
                    dataType: 'json',
                    data: {
                        send:'sent',
                        orderSum: orderSum,
                        usrId:usrId,
                        arr:arr,
                        sumQuan:sumQuan
                    },
                    success: function (podaci) {
                        alert("The item has been added to cart!");
                        location.reload();
                    },
                    error: function (xhr, statusTxt, error) {
                        var status = xhr.status;
                        switch (status) {

                            case 500:
                                alert("Server ERROR! Store is currently offline!");
                                break;
                            case 404:
                                alert("Page not Found!");
                                break;
                            default:
                                alert(sumQuan);
                                alert("Error: " + status+" - " + statusTxt);
                                break;
                        }
                    }
                });
            });
        });
    </script>
<!-- /SECTION -->
<?php else: header("Location: ../index.php?page=login"); ?>
<?php endif;?>