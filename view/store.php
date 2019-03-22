<?php $actual_link = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF']; ?>
<!-- BREADCRUMB -->
<div id="breadcrumb" class="section">
    <!-- container -->
    <div class="container">
        <!-- row -->
        <div class="row">
            <div class="col-md-12">
                <ul class="breadcrumb-tree">
                    <?php
                    if(isset($_SESSION['korisnik'])){
                        $usrId = $_SESSION['korisnik']->uid;
                    }

                    ?>
                    <input type="hidden" id="order_user_id" value="<?= $usrId ?>">
                    <?php if($_GET['page']=='store' && !isset($_GET['parameter'])): ?>
                    <li><a href="#">Home</a></li>
                    <li><a href="#">All Categories</a></li>
                    <?php else: ?>
                        <li><a href="#">Home</a></li>
                        <li><a href="#">All Categories</a></li>
                    <li><a href="#" class="active"><?= $_GET['parameter']; ?></a></li>
<!--                    <li class="active">Headphones (227,490 Results)</li>-->
                    <?php endif; ?>
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
            <!-- ASIDE -->
            <div id="aside" class="col-md-3">
                <!-- aside Widget -->
                <div class="aside">
                    <h3 class="aside-title">Categories</h3>
                    <div class="checkbox-filter">
                        <?php
                            $querySelectCat = "SELECT * FROM subcategory";
                            $rezSel = executeQuery($querySelectCat);
                            foreach ($rezSel as $cat):
                        ?>
                        <div class="input-checkbox">
                            <a href="<?= $_SERVER['PHP_SELF']."?page=store&parameter=".$cat->name?>">
                            <label for="category-1">
                                <span></span>
                                <?= $cat->name ?>
                                <?php $queryQuantity = $conn->prepare("SELECT * FROM electroproducts WHERE subcat_id = :subid ");
                                    $queryQuantity->bindParam(":subid",$cat->id);
                                    $queryQuantity->execute();
                                    $numProd = $queryQuantity->rowCount();
                                ?>
                                <small>(<?= $numProd ?>)</small>
                            </label></a>
                        </div>
                    <?php endforeach; ?>
                    </div>
                </div>
                <!-- /aside Widget -->

                <!-- aside Widget -->
<!--                <div class="aside">-->
<!--                    <h3 class="aside-title">Price</h3>-->
<!--                    <div class="price-filter">-->
<!--                        <div id="price-slider"></div>-->
<!--                        <div class="input-number price-min">-->
<!--                            <input id="price-min" type="number">-->
<!--                            <span class="qty-up">+</span>-->
<!--                            <span class="qty-down">-</span>-->
<!--                        </div>-->
<!--                        <span>-</span>-->
<!--                        <div class="input-number price-max">-->
<!--                            <input id="price-max" type="number">-->
<!--                            <span class="qty-up">+</span>-->
<!--                            <span class="qty-down">-</span>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </div>-->

                <div class="aside">
                    <h3 class="aside-title">Top selling</h3>
                    <?php
                    $queryTop3 = "SELECT *,ep.id as epid,s.name as sname, ep.name as prodname  FROM electroproducts ep INNER JOIN warehouse w ON ep.id = w.product_id INNER JOIN images i ON ep.id = i.product_id INNER JOIN subcategory s ON ep.subcat_id = s.id WHERE sold>10 ORDER BY price DESC LIMIT 3 ";
                    $exexQuery3 = executeQuery($queryTop3);
                    foreach($exexQuery3 as $top3):
                    ?>
                    <div class="product-widget">
                        <div class="product-img">
                            <img src="<?= $top3->img_path ?>" alt="<?= $top3->alt ?>">
                        </div>
                        <div class="product-body">
                            <p class="product-category"><?= $top3->sname ?></p>
                            <h3 class="product-name"><a href="index.php?page=product&product=<?=$top3->epid?>"><?= $top3->prodname ?></a></h3>
                            <h4 class="product-price">$<?= $top3->price ?>.00
                                <?php if( $top3->lastprice ): ?>
                                <del class="product-old-price">$<?= $top3->lastprice ?>.00</del></h4>
                            <?php endif; ?>
                        </div>
                    </div>
                    <?php endforeach; ?>

                </div>
                <!-- /aside Widget -->
            </div>
            <!-- /ASIDE -->

            <!-- STORE -->
            <div id="store" class="col-md-9">
                <!-- store top filter -->
                <div class="store-filter clearfix">
                    <div class="store-sort">
                        <label>
                            Sort By:
                            <select class="input-select">
                                <option value="0">Popular</option>
                                <option value="1">Position</option>
                            </select>
                        </label>

                        <label>
                            Show:
                            <select class="input-select">
                                <option value="0">6</option>
                            </select>
                        </label>
                    </div>

                </div>
                <!-- /store top filter -->


                <?php
                    $queryProds = "SELECT *,ep.id as epid,ep.name as epname, cl.name as clname, c.name as cname, s.name as sname FROM electroproducts ep INNER JOIN images i ON ep.id=i.product_id  INNER JOIN  subcategory s ON ep.subcat_id=s.id INNER JOIN category c ON s.cat_id=c.id INNER JOIN warehouse w ON ep.id = w.product_id INNER JOIN color cl ON ep.color_id = cl.id";
                    $queryExec = executeQuery($queryProds);
                    if(isset($_GET['parameter'])):
                        $parametar = $_GET['parameter'];
                    if($parametar!='Hot'):
                        $queryProds1 = "SELECT *,ep.id as epid,ep.name as epname, cl.name as clname, c.name as cname, s.name as sname FROM electroproducts ep INNER JOIN images i ON ep.id=i.product_id  INNER JOIN  subcategory s ON ep.subcat_id=s.id INNER JOIN category c ON s.cat_id=c.id INNER JOIN warehouse w ON ep.id = w.product_id INNER JOIN color cl ON ep.color_id = cl.id WHERE s.name='".$parametar."'";
                        $queryExec1 = executeQuery($queryProds1);

                ?>
                <!-- store products -->
                <div class="row">
                    <!-- product -->

                    <?php   foreach($queryExec1 as $proizvod1): ?>
                    <div class="col-md-4 col-xs-6">
                        <div class="product">
                            <div class="product-img">

                                <img src="<?= $proizvod1->img_path ?>" alt="<?= $proizvod1->alt ?>">
                                <div class="product-label">
                                    <?php if ($proizvod1->sale): ?>
                                    <span class="sale">-<?= $proizvod1->sale ?>%</span>
                                    <?php endif; ?>
                                    <?php if ($proizvod1->new): ?>
                                    <span class="new">NEW</span>
                                    <?php endif;?>
                                </div>
                            </div>
                            <div class="product-body">
                                <p class="product-category"><?= $proizvod1->sname ?></p>
                                <h3 class="product-name"><a href="<?= $_SERVER['PHP_SELF'].'?page=product&product='.$proizvod1->epid ?>"><?= $proizvod1->epname ?></a></h3>
                                <h4 class="product-price">$<?= $proizvod1->price ?>.00
                                    <?php if($proizvod1->lastprice): ?>
                                    <del class="product-old-price">$<?= $proizvod1->lastprice ?>.00  </del></h4>
                                    <?php endif; ?>
                                <div class="product-rating">
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                </div>
                                <div class="product-btns">
                                    <button class="add-to-wishlist"><i class="fa fa-heart-o"></i><span class="tooltipp">add to wishlist</span></button>
                                    <button class="add-to-compare"><i class="fa fa-exchange"></i><span class="tooltipp">add to compare</span></button>
                                    <button class="quick-view"><i class="fa fa-eye"></i><span class="tooltipp">quick view</span></button>
                                </div>
                            </div>
                            <div class="add-to-cart">
                                <button class="add-to-cart-btn" data-id="<?= $proizvod1->epid ?>"><i class="fa fa-shopping-cart"></i> add to cart</button>


                            </div>
                        </div>

                    </div>

                    <?php endforeach; ?>
                    <?php else: ?>
                    <!-- store products -->
                    <div class="row">
                        <!-- product -->

                        <?php
                            $queryProds2 = "SELECT *,ep.id as epid,ep.name as epname, cl.name as clname, c.name as cname, s.name as sname FROM electroproducts ep INNER JOIN images i ON ep.id=i.product_id  INNER JOIN  subcategory s ON ep.subcat_id=s.id INNER JOIN category c ON s.cat_id=c.id INNER JOIN warehouse w ON ep.id = w.product_id INNER JOIN color cl ON ep.color_id = cl.id WHERE hot=1";
                            $queryExec2 = executeQuery($queryProds2);
                            foreach($queryExec2 as $proizvod2): ?>
                        <div class="col-md-4 col-xs-6">
                            <div class="product">
                                <div class="product-img">

                                    <img src="<?= $proizvod2->img_path ?>" alt="<?= $proizvod2->alt ?>">
                                    <div class="product-label">
                                        <?php if ($proizvod2->sale): ?>
                                            <span class="sale">-<?= $proizvod2->sale ?>%</span>
                                        <?php endif; ?>
                                        <?php if ($proizvod2->new): ?>
                                            <span class="new">NEW</span>
                                        <?php endif;?>
                                    </div>
                                </div>
                                <div class="product-body">
                                    <p class="product-category"><?= $proizvod2->sname ?></p>
                                    <h3 class="product-name"><a href="<?= $_SERVER['PHP_SELF'].'?page=product&product='.$proizvod2->epid ?>"><?= $proizvod2->epname ?></a></h3>
                                    <h4 class="product-price">$<?= $proizvod2->price ?>.00
                                        <?php if($proizvod2->lastprice): ?>
                                        <del class="product-old-price">$<?= $proizvod2->lastprice ?>.00</del></h4>
                                    <?php endif; ?>
                                    <div class="product-rating">
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                    </div>
                                    <div class="product-btns">
                                        <button class="add-to-wishlist"><i class="fa fa-heart-o"></i><span class="tooltipp">add to wishlist</span></button>
                                        <button class="add-to-compare"><i class="fa fa-exchange"></i><span class="tooltipp">add to compare</span></button>
                                        <button class="quick-view"><i class="fa fa-eye"></i><span class="tooltipp">quick view</span></button>
                                    </div>
                                </div>
                                <div class="add-to-cart">
                                    <button class="add-to-cart-btn" data-id="<?= $proizvod2->epid ?>"><i class="fa fa-shopping-cart"></i> add to cart</button>
                                </div>
                            </div>

                        </div>
                            <?php endforeach; ?>
                    <?php endif; ?>

                </div>
                <!-- /store products -->
                    <?php elseif(isset($_GET['strana']) && !isset($_GET['category']) && !isset($_GET['find'])): ?>
                        <?php

                        if (isset($_GET['strana'])) {
                            $strana = $_GET['strana'];
                        } else
                            $strana = 1;


                        $perPage = 6;
                        $limit = $strana * $perPage;
                        $offSet = ($strana * $perPage) - $perPage;

                        $tupi = "SELECT *,ep.id as epid,ep.name as epname, cl.name as clname, c.name as cname, s.name as sname FROM electroproducts ep INNER JOIN images i ON ep.id=i.product_id  INNER JOIN  subcategory s ON ep.subcat_id=s.id INNER JOIN category c ON s.cat_id=c.id INNER JOIN warehouse w ON ep.id = w.product_id INNER JOIN color cl ON ep.color_id = cl.id LIMIT $limit OFFSET $offSet";

                        $pagina = executeQuery($tupi);
                        $count = count($pagina);

                        ?>
                        <?php foreach($pagina as $proizvod2): ?>
                            <div class="col-md-4 col-xs-6">
                                <div class="product">
                                    <div class="product-img">
                                        <img src="<?= $proizvod2->img_path ?>" alt="<?= $proizvod2->alt ?>">
                                        <div class="product-label">
                                            <?php if ($proizvod2->sale): ?>
                                                <span class="sale">-<?= $proizvod2->sale ?>%</span>
                                            <?php endif; ?>
                                            <?php if ($proizvod2->new): ?>
                                                <span class="new">NEW</span>
                                            <?php endif;?>
                                        </div>
                                    </div>
                                    <div class="product-body">
                                        <p class="product-category"><?= $proizvod2->sname ?></p>
                                        <h3 class="product-name"><a href="<?= $_SERVER['PHP_SELF'].'?page=product&product='.$proizvod2->epid ?>"><?= $proizvod2->epname ?></a></h3>
                                        <h4 class="product-price">$<?= $proizvod2->price ?>.00
                                            <?php if($proizvod2->lastprice): ?>
                                            <del class="product-old-price">$<?= $proizvod2->lastprice ?>.00</del></h4>
                                        <?php endif; ?>
                                        <div class="product-rating">
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                        </div>
                                        <div class="product-btns">
                                            <button class="add-to-wishlist"><i class="fa fa-heart-o"></i><span class="tooltipp">add to wishlist</span></button>
                                            <button class="add-to-compare"><i class="fa fa-exchange"></i><span class="tooltipp">add to compare</span></button>
                                            <button class="quick-view"><i class="fa fa-eye"></i><span class="tooltipp">quick view</span></button>
                                        </div>
                                    </div>
                                    <div class="add-to-cart">
                                        <button class="add-to-cart-btn" data-id="<?= $proizvod2->epid ?>"><i class="fa fa-shopping-cart"></i> add to cart</button>

                                    </div>
                                </div>

                            </div>
                        <?php endforeach; ?>

                    <?php elseif(isset($_GET['strana']) && isset($_GET['category']) && isset($_GET['find'])): ?>
                    <?php
                        $category = $_GET['category'];
                        $find = $_GET['find'];

                        if (isset($_GET['strana'])) {
                            $strana = $_GET['strana'];
                        } else
                            $strana = 1;


                        $perPage = 6;
                        $limit = $strana * $perPage;
                        $offSet = ($strana * $perPage) - $perPage;

                       // echo $find;
                        if($category==0){
                            $queryProds4 = "SELECT *,ep.id as epid,ep.name as epname, cl.name as clname, c.name as cname, s.name as sname FROM electroproducts ep INNER JOIN images i ON ep.id=i.product_id  INNER JOIN  subcategory s ON ep.subcat_id=s.id INNER JOIN category c ON s.cat_id=c.id INNER JOIN warehouse w ON ep.id = w.product_id INNER JOIN color cl ON ep.color_id = cl.id WHERE ep.name = '".$find."'";
                           // echo $queryProds4;
                        }else {
                            $queryProds4 = "SELECT *,ep.id as epid,ep.name as epname, cl.name as clname, c.name as cname, s.name as sname FROM electroproducts ep INNER JOIN images i ON ep.id=i.product_id  INNER JOIN  subcategory s ON ep.subcat_id=s.id INNER JOIN category c ON s.cat_id=c.id INNER JOIN warehouse w ON ep.id = w.product_id INNER JOIN color cl ON ep.color_id = cl.id WHERE ep.subcat_id = $category AND ep.name ='".$find."'";
                          //  echo $queryProds4;
                        }$rezProdsSearch = executeQuery($queryProds4);
                        $count = count($rezProdsSearch);

                        ?>
                        <?php foreach($rezProdsSearch as $prodSrch): ?>
                            <div class="col-md-4 col-xs-6">
                                <div class="product">
                                    <div class="product-img">
                                        <img src="<?= $prodSrch->img_path ?>" alt="<?= $prodSrch->alt ?>">
                                        <div class="product-label">
                                            <?php if ($prodSrch->sale): ?>
                                                <span class="sale">-<?= $prodSrch->sale ?>%</span>
                                            <?php endif; ?>
                                            <?php if ($prodSrch->new): ?>
                                                <span class="new">NEW</span>
                                            <?php endif;?>
                                        </div>
                                    </div>
                                    <div class="product-body">
                                        <p class="product-category"><?= $prodSrch->sname ?></p>
                                        <h3 class="product-name"><a href="<?= $_SERVER['PHP_SELF'].'?page=product&product='.$prodSrch->epid ?>"><?= $prodSrch->epname ?></a></h3>
                                        <h4 class="product-price">$<?= $prodSrch->price ?>.00
                                            <?php if($prodSrch->lastprice): ?>
                                            <del class="product-old-price">$<?= $prodSrch->lastprice ?>.00</del></h4>
                                        <?php endif; ?>
                                        <div class="product-rating">
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                        </div>
                                        <div class="product-btns">
                                            <button class="add-to-wishlist"><i class="fa fa-heart-o"></i><span class="tooltipp">add to wishlist</span></button>
                                            <button class="add-to-compare"><i class="fa fa-exchange"></i><span class="tooltipp">add to compare</span></button>
                                            <button class="quick-view"><i class="fa fa-eye"></i><span class="tooltipp">quick view</span></button>
                                        </div>
                                    </div>
                                    <div class="add-to-cart">
                                        <button class="add-to-cart-btn" data-id="<?= $prodSrch->epid ?>"><i class="fa fa-shopping-cart"></i> add to cart</button>

                                    </div>
                                </div>

                            </div>
                        <?php endforeach; ?>

                    <?php else:?>
                <!-- store products -->
                <div class="row">
                    <!-- product -->

                    <?php foreach($queryExec as $proizvod): ?>
                    <div class="col-md-4 col-xs-6">
                        <div class="product">
                            <div class="product-img">
                                <img src="<?= $proizvod->img_path ?>" alt="<?= $proizvod->alt ?>">
                                <div class="product-label">
                                    <?php if ($proizvod->sale): ?>
                                        <span class="sale">-<?= $proizvod->sale ?>%</span>
                                    <?php endif; ?>
                                    <?php if ($proizvod->new): ?>
                                        <span class="new">NEW</span>
                                    <?php endif;?>
                                </div>
                            </div>
                            <div class="product-body">
                                <p class="product-category"><?= $proizvod->sname ?></p>
                                <h3 class="product-name"><a href="<?= $_SERVER['PHP_SELF'].'?page=product&product='.$proizvod->epid ?>"><?= $proizvod->epname ?></a></h3>
                                <h4 class="product-price">$<?= $proizvod->price ?>.00
                                    <?php if($proizvod->lastprice): ?>
                                    <del class="product-old-price">$<?= $proizvod->lastprice ?>.00</del></h4>
                                <?php endif; ?>
                                <div class="product-rating">
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                </div>
                                <div class="product-btns">
                                    <button class="add-to-wishlist"><i class="fa fa-heart-o"></i><span class="tooltipp">add to wishlist</span></button>
                                    <button class="add-to-compare"><i class="fa fa-exchange"></i><span class="tooltipp">add to compare</span></button>
                                    <button class="quick-view"><i class="fa fa-eye"></i><span class="tooltipp">quick view</span></button>
                                </div>
                            </div>
                            <div class="add-to-cart">
                                <button class="add-to-cart-btn" data-id="<?= $proizvod->epid ?>"><i class="fa fa-shopping-cart"></i> add to cart</button>

                            </div>
                        </div>

                    </div>
                    <?php endforeach; ?>

                    <?php endif;?>
                </div>
                <!-- /store products -->


                <!-- store bottom filter -->
                    <?php if(isset($_GET['strana'])): ?>
                    <div class="row div-pagination" style="float: right;">
                        <div class="col-4 col-offset-6" id="paginacija">
                            <ul class="pagination">
                                <?php if ($strana - 2 > 0): ?>
                                    <li>
                                        <a href="<?= $actual_link ?>?page=store&strana=<?= $strana - 2 ?>"><?= $strana - 2; ?></a>
                                    </li>
                                <?php endif; ?>
                                <?php if ($strana - 1 > 0): ?>
                                    <li>
                                        <a href="<?= $actual_link ?>?page=store&strana=<?= $strana - 1 ?>"><?= $strana - 1; ?></a>
                                    </li>
                                <?php endif; ?>
                                <li class="active"><a href="#"><?= $strana ?></a></li>
                                <?php if ($strana + 1 <= $count/$perPage+1): ?>
                                    <li>
                                        <a href="<?= $actual_link ?>?page=store&strana=<?= $strana + 1 ?>"><?= $strana + 1; ?></a>
                                    </li>
                                <?php endif; ?>
                                <?php if ($strana + 2 < $count/$perPage+1): ?>
                                    <li>
                                        <a href="<?= $actual_link ?>?page=store&strana=<?= $strana + 2 ?>"><?= $strana + 2; ?></a>
                                    </li>
                                <?php endif; ?>
                            </ul>
                        </div>
                    </div>
                    <?php else:?>
                        <div class="row div-pagination" style="float: right;">
                            <div class="col-4 col-offset-6" id="paginacija">
                                <ul class="pagination">
                                        <li class="active">
                                            <a href="#">1</a>
                                        </li>
                                </ul>
                            </div>
                        </div>
                    <?php endif; ?>
                <!-- /store bottom filter -->
            </div>
            <!-- /STORE -->
        </div>
        <!-- /row -->
    </div>
    <!-- /container -->
</div>
<!-- /SECTION -->
    <!-- JS -->

    <script src="js/jquery-3.3.1.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            $('.add-to-cart-btn').click(function () {
                var id = $(this).data('id');
                var usrId = $('#order_user_id').val();
                // alert(usrId);
                // alert(id);


                $.ajax({
                    method: 'POST',
                    url: "php/add_to_cart.php",
                    dataType: 'json',
                    data: {
                        send:'sent',
                        id: id,
                        usrId:usrId
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
