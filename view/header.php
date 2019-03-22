<!-- HEADER -->
<header>
			<!-- TOP HEADER -->
			<div id="top-header">
				<div class="container">
					<ul class="header-links pull-left">
						<li><a href="#"><i class="fa fa-phone"></i> +021-95-51-84</a></li>
						<li><a href="#"><i class="fa fa-envelope-o"></i> electro@gmail.com</a></li>
						<li><a href="#"><i class="fa fa-map-marker"></i> 1734 Stonecoal Road</a></li>
					</ul>
					<ul class="header-links pull-right">
<!--						<li><a href="#"><i class="fa fa-dollar"></i> USD</a></li>-->
                        <?php if(!isset($_SESSION['korisnik'])): ?>
						<li><a href="<?= $_SERVER['PHP_SELF']."?page=login"?>"><i class="fa fa-user-o"></i> My Account</a></li>
                        <?php endif; ?>
                        <?php if(isset($_SESSION['korisnik']) && $_SESSION['korisnik']->role == "admin"): ?>
                            <li><a href="<?= $_SERVER['PHP_SELF']."?page=adminPanel" ?>"><i class="fa fa-user-o"></i> Admin Panel</a></li>
                        <?php endif; ?>
                        <?php if(isset($_SESSION['korisnik'])): ?>
                            <li><a href="php/logout.php"><i class="fa fa-user-o"></i> Logout</a></li>
                        <?php endif; ?>

					</ul>
				</div>
			</div>
			<!-- /TOP HEADER -->

			<!-- MAIN HEADER -->
			<div id="header">
				<!-- container -->
				<div class="container">
					<!-- row -->
					<div class="row">
						<!-- LOGO -->
						<div class="col-md-3">
							<div class="header-logo">
								<a href="<?= $_SERVER['PHP_SELF']."?page=pocetna"?>" class="logo">
									<img src="./img/logo.png" alt="">
								</a>
							</div>
						</div>
						<!-- /LOGO -->

						<!-- SEARCH BAR -->
						<div class="col-md-6">
							<div class="header-search">
								<form>
									<select class="input-select" name="category">
                                        <?php
                                        $queryCat = "Select * FROM subcategory";
                                        $rezCat = executeQuery($queryCat);

                                        ?>
										<option value="0">All Categories</option>
                                        <?php
                                        foreach ($rezCat as $item):
                                        ?>
                                        <option value="<?= $item->id?>"> <?= $item->name ?></option>
                                        <?php endforeach; ?>

									</select>
									<input class="input"  name='find' placeholder="Search here">
                                    <input type="hidden" name="page" value="store">
									<button class="search-btn" name="strana" value="1">Search</button>
								</form>
							</div>
						</div>
						<!-- /SEARCH BAR -->

						<!-- ACCOUNT -->
						<div class="col-md-3 clearfix">
							<div class="header-ctn">

                                <?php
                                if(isset($_SESSION['korisnik'])):
                                $usrId = $_SESSION['korisnik']->uid;
                                $queryCart= $conn->prepare("SELECT * FROM cart c INNER JOIN user_product up ON c.usr_prod_id = up.id WHERE up.user_id=:usid AND buyout=0");
                                $queryCart->bindParam(':usid',$usrId);
                                $rezCart = $queryCart->execute();
                                    $querySumRow = $conn->prepare("SELECT *,ep.id as pid FROM cart c INNER JOIN user_product up ON c.usr_prod_id = up.id INNER JOIN electroproducts ep ON up.user_id = ep.id INNER JOIN images i ON ep.id = i.product_id WHERE up.user_id=:usrId AND buyout=0 ");
                                    $querySumRow->bindParam("usrId",$usrId);
                                    $rezSumRow = $querySumRow->execute();
                                    $brojPredmeta = $querySumRow->fetch();
                                $queryCartObj = "SELECT *,ep.id as pid FROM cart c INNER JOIN user_product up ON c.usr_prod_id = up.id INNER JOIN electroproducts ep ON up.prod_id = ep.id INNER JOIN images i ON ep.id = i.product_id WHERE up.user_id=$usrId  AND buyout=0 ";
                                $rezCartObj = executeQuery($queryCartObj);
                                ?>
								<div class="dropdown">
									<a class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
										<i class="fa fa-shopping-cart"></i>
										<span>Your Cart</span>
                                        <?php if($querySumRow->rowCount()>0): ?>
										<div class="qty"><?= $brojPredmeta->quantity; ?></div>
                                        <?php else: ?>

                                            <div class="qty">0</div>
                                        <?php endif;?>


									</a>
									<div class="cart-dropdown">
										<div class="cart-list">
                                            <?php foreach ($rezCartObj as $obj): ?>

											<div class="product-widget">
												<div class="product-img">
													<img src="<?= $obj->img_path ?>" alt="<?= $obj->alt ?>">
												</div>
												<div class="product-body">
													<h3 class="product-name"><a href="#"><?= $obj->name ?></a></h3>
                                                <?php if($querySumRow->rowCount()>0): ?>
													<h4 class="product-price"><span class="qty"><?= $brojPredmeta->quantity; ?>x</span>$<?= $obj->price ?>.00</h4>

                                                <?php endif;?>
                                                </div>
												<button class="delete delete-product-cart" data-id="<?= $obj->pid ?>"><i class="fa fa-close"></i></button>
											    <input type="hidden" name="userIdDel" id="usrIdDel" value="<?= $_SESSION['korisnik']->uid?>">
                                            </div>
                                            <?php endforeach; ?>

										</div>
                                        <?php
                                            $querySum = "SELECT *,ep.id as pid FROM cart c INNER JOIN user_product up ON c.usr_prod_id = up.id INNER JOIN electroproducts ep ON up.prod_id = ep.id WHERE up.user_id=$usrId AND buyout=0";
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
										<div class="cart-summary">
                                            <?php if($querySumRow->rowCount()>0): ?>
											<small><?= $brojPredmeta->quantity ?> Item(s) selected</small>
                                            <?php else: ?>
                                                <small>0 Item(s) selected</small>
                                            <?php endif;?>
											<h5 name="totalSum">SUBTOTAL: $<?= $suma ?>.00</h5>
										</div>
										<div class="cart-btns">
											<a href="#">Buy -></a>
											<a href="<?= $_SERVER['PHP_SELF']."?page=checkout"?>">Checkout  <i class="fa fa-arrow-circle-right"></i></a>
										</div>
									</div>
								</div>
                                <?php endif; ?>
								<!-- /Cart -->

								<!-- Menu Toogle -->
								<div class="menu-toggle">
									<a href="#">
										<i class="fa fa-bars"></i>
										<span>Menu</span>
									</a>
								</div>
								<!-- /Menu Toogle -->
							</div>
						</div>
						<!-- /ACCOUNT -->
					</div>
					<!-- row -->
				</div>
				<!-- container -->
			</div>
			<!-- /MAIN HEADER -->
    <script src="js/jquery-3.3.1.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            $('.delete-product-cart').click(function () {
                var id = $(this).data('id');
                var idu = $('#usrIdDel').val();
                //alert(id);

                $.ajax({
                    method: 'POST',
                    url: "php/ajax_delete_item_cart.php",
                    dataType: 'json',
                    data: {
                        id: id,
                        idu:idu
                    },
                    success: function (podaci) {
                        alert("Product is removed.");
                        location.reload();
                    },
                    error: function (xhr, statusTxt, error) {
                        var status = xhr.status;
                        switch (status) {
                            case 500:
                                alert("Server ERROR! Curently it is not possible to remove the product.");
                                location.reload();
                                break;
                            case 404:
                                alert("Page not Found!");
                                location.reload();
                                break;
                            default:
                                alert("Error: " + status + " - " + statusTxt);
                                location.reload();
                                break;
                        }
                    }
                });
            });
        });
    </script>
		</header>
		<!-- /HEADER -->
