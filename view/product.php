<?php
    $product_id = "";
    if(isset($_GET['product'])){
        $product_id = $_GET['product'];
    }
    $queryInfo = "SELECT *,ep.id as epid,ep.name as epname, cl.name as clname, c.name as cname, s.name as sname FROM electroproducts ep INNER JOIN images i ON ep.id=i.product_id  INNER JOIN  subcategory s ON ep.subcat_id=s.id INNER JOIN category c ON s.cat_id=c.id INNER JOIN warehouse w ON ep.id = w.product_id INNER JOIN color cl ON ep.color_id = cl.id WHERE ep.id=".$product_id;
     $execInfo = executeQuery($queryInfo);
    foreach ($execInfo as $one):
?>
<!-- BREADCRUMB -->
<div id="breadcrumb" class="section">
    <!-- container -->
    <div class="container">
        <!-- row -->
        <div class="row">
            <?php
            if(isset($_SESSION['korisnik'])){
                $usrId = $_SESSION['korisnik']->uid;
            }

            ?>
            <div class="col-md-12">
                <ul class="breadcrumb-tree">
                    <li><a href="<?=$_SERVER['PHP_SELF']?>">Home</a></li>
                    <li><a href="<?= $_SERVER['PHP_SELF']."?page=store"?>" >All Categories</a></li>
                    <li><a href="#"><?= $one->cname ?></a></li>
                    <li><a href="#"><?= $one->sname ?></a></li>
                    <li class="active"><?= $one->epname ?></li>
                </ul>
            </div>
        </div>
        <!-- /row -->
    </div>
    <!-- /container -->
</div>
<!-- /BREADCRUMB -->

<!-- SECTION -->
<div class="section">
    <!-- container -->
    <div class="container">
        <!-- row -->
        <div class="row">
            <!-- Product main img -->
            <div class="col-md-5 col-md-push-2">
                <div id="product-main-img">
                    <div class="product-preview">
                        <img src="<?=$one->img_path ?>" alt=""> <!-- Sta ako imam vise slika ?-->
                    </div>

                    <div class="product-preview">
                        <img src="<?= $one->img_path ?>" alt="">
                    </div>

                    <div class="product-preview">
                        <img src="<?= $one->img_path ?>" alt="">
                    </div>

                    <div class="product-preview">
                        <img src="<?= $one->img_path ?>" alt="">
                </div>
                </div>
            </div>
            <!-- /Product main img -->

            <!-- Product thumb imgs -->
            <div class="col-md-2  col-md-pull-5">
                <div id="product-imgs">
                    <div class="product-preview">
                        <img src="<?= $one->img_path ?>" alt="">
                    </div>

                    <div class="product-preview">
                        <img src="<?= $one->img_path ?>" alt="">
                    </div>

                    <div class="product-preview">
                        <img src="<?= $one->img_path ?>" alt="">
                    </div>

                    <div class="product-preview">
                        <img src="<?= $one->img_path ?>" alt="">
                    </div>
                </div>
            </div>
            <!-- /Product thumb imgs -->

            <!-- Product details -->
            <div class="col-md-5">
                <div class="product-details">
                    <h2 class="product-name"><?= $one->epname ?></h2>
                    <div>
                        <div class="product-rating">
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star-o"></i>
                        </div>

                    </div>
                    <div> <!----------------- -->
                        <h3 class="product-price">$<?=$one->price ?>.00
                            <?php if($one->lastprice): ?>
                            <del class="product-old-price">$<?= $one->lastprice ?>.00</del></h3>
                            <?php endif; ?>
                        <?php if($one->quantity > 0):?>
                        <span class="product-available">In Stock</span>
                        <?php else: ?>
                        <span class="product-available">Sold out</span>
                        <?php endif; ?>
                    </div>
                    <p><?= $one->description ?></p>
                    <div class="product-options">
<!--                        <label>-->
<!--                            Size-->
<!--                            <select class="input-select">-->
<!--                                <option value="0">X</option>-->
<!--                            </select>-->
<!--                        </label>-->
                        <label>
                            Color
                            <select class="input-select">
                                <option value="0"><?= $one->clname ?></option>
                            </select>
                        </label>
                    </div>

                    <div class="add-to-cart">
                        <div class="qty-label">
                            Qty
                            <div class="input-number">
                                <input type="number" id="quan" >
                                <span class="qty-up">+</span>
                                <span class="qty-down">-</span>
                            </div>
                            <input type="hidden"  value="<?= $one->price ?>">
                        </div>
                        <button class="add-to-cart-btn" data-id="<?= $one->epid ?>"><i class="fa fa-shopping-cart"></i> add to cart</button>
                        <input type="hidden" id="order_user_id" value="<?= $usrId ?>">
                    </div>

                    <ul class="product-btns">
                        <li><a href="#"><i class="fa fa-heart-o"></i> add to wishlist</a></li>
                        <li><a href="#"><i class="fa fa-exchange"></i> add to compare</a></li>
                    </ul>

                    <ul class="product-links">
                        <li>Category:</li>
                        <li><a href="#"><?= $one->cname ?></a></li>
                        <li><a href="#"><?= $one->sname ?></a></li>
                    </ul>

                    <ul class="product-links">
                        <li>Share:</li>
                        <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                        <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                        <li><a href="#"><i class="fa fa-google-plus"></i></a></li>
                        <li><a href="#"><i class="fa fa-envelope"></i></a></li>
                    </ul>

                </div>
            </div>
            <!-- /Product details -->

            <!-- Product tab -->
            <div class="col-md-12">
                <div id="product-tab">
                    <!-- product tab nav -->
                    <ul class="tab-nav">
                        <li class="active"><a data-toggle="tab" href="#tab1">Description</a></li>
                        <li><a data-toggle="tab" href="#tab2">Details</a></li>
                    </ul>
                    <!-- /product tab nav -->

                    <!-- product tab content -->
                    <div class="tab-content">
                        <!-- tab1  -->
                        <div id="tab1" class="tab-pane fade in active">
                            <div class="row">
                                <div class="col-md-12">
                                    <p><?= $one->description ?></p> </div>
                            </div>
                        </div>
                        <!-- /tab1  -->

                        <!-- tab2  -->
                        <div id="tab2" class="tab-pane fade in">
                            <div class="row">
                                <div class="col-md-12">
                                    <p><?php
                                        $specs = explode('/',$one->specifications);
                                     //  echo "<b>".$specs[0]."</b> ".$specs[1];
                                        $broj=0;
                                          //  var_dump($specs);
                                            for($i=0;$i<count($specs)-$broj;$i++){


                                        echo "<b>".$specs[$i+$broj]."</b> ".$specs[$i+$broj+1]."</br>";
                                                   $broj++;



                                            }
                                        ?></p>
                                </div>
                            </div>
                        </div>
                        <!-- /tab2  -->
                        <?php endforeach; ?>

                    </div>
                    <!-- /product tab content  -->
                </div>
            </div>
            <!-- /product tab -->
        </div>
        <!-- /row -->
    </div>
    <!-- /container -->
</div>
<!-- /SECTION -->
<script src="js/jquery-3.3.1.min.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $('.add-to-cart-btn').click(function () {
            var id = $(this).data('id');
            var usrId = $('#order_user_id').val();
            var quan = $('#quan').val();

            // alert(usrId);
            // alert(id);


            $.ajax({
                method: 'POST',
                url: "php/add_to_cart.php",
                dataType: 'json',
                data: {
                    send:'sent',
                    id: id,
                    usrId:usrId,
                    quan:quan
                },
                success: function (podaci) {
                    alert("The item has been added to cart!");
                    alert(quan);
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
                        case 403:
                            alert("You need to be logged in first!");
                            break;
                        default:
                            alert("Error: " + status + " - " + statusTxt);
                            break;
                    }
                }
            });
        });
    });
</script>