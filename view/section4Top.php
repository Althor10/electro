		<!-- SECTION -->
		<div class="section">
			<!-- container -->
			<div class="container">
				<!-- row -->
				<div class="row">

					<!-- section title -->
					<div class="col-md-12">
						<div class="section-title">
							<h3 class="title">Top selling</h3>
						</div>
					</div>
					<!-- /section title -->

					<!-- Products tab & slick -->
                    <?php
                    $queryProdTop = "SELECT *, e.id as eId, e.name as prodName, s.name as subName FROM electroproducts e INNER JOIN images i ON e.id = i.product_id INNER JOIN subcategory s ON e.subcat_id = s.id INNER JOIN warehouse w ON e.id=w.product_id WHERE sold>0 ORDER BY sold DESC LIMIT 4";
                    $rezTop = executeQuery($queryProdTop);
                    ?>
					<div class="col-md-12">
						<div class="row">
							<div class="products-tabs">
								<!-- tab -->
								<div id="tab2" class="tab-pane fade in active">
									<div class="products-slick" data-nav="#slick-nav-2">
										<!-- product -->
                                        <?php foreach($rezTop as $proizvod): ?>
										<div class="product">
											<div class="product-img">
												<img src="<?=$proizvod->img_path ?>" alt="<?=$proizvod->alt ?>">
												<div class="product-label">
                                                    <?php if($proizvod->sale): ?>
													<span class="sale">-<?=$proizvod->sale ?>%</span>
                                                    <?php endif; ?>
                                                    <?php if($proizvod->new):?>
													<span class="new">NEW</span>
                                                    <?php endif; ?>
												</div>
											</div>
											<div class="product-body">
												<p class="product-category"><?=$proizvod->subName ?></p>
												<h3 class="product-name"><a href="<?= $_SERVER['PHP_SELF'].'?page=product&product='.$proizvod->eId ?>"><?=$proizvod->prodName ?></a></h3>
												<h4 class="product-price">$<?=$proizvod->price ?>.00
                                                    <?php if($proizvod->lastprice): ?>
                                                    <del class="product-old-price">$<?=$proizvod->lastprice ?>.00</del>
                                                <?php endif;?>
                                                </h4>
												<div class="product-rating">
													<i class="fa fa-star"></i>
													<i class="fa fa-star"></i>
													<i class="fa fa-star"></i>
													<i class="fa fa-star"></i>
													<i class="fa fa-star"></i>
												</div>
												<div class="product-btns">
													<button class="quick-view"><i class="fa fa-eye"></i><span class="tooltipp">quick view</span></button>
												</div>
											</div>
											<div class="add-to-cart">
												<button class="add-to-cart-btn" data-id="<?= $proizvod->eId ?>" ><i class="fa fa-shopping-cart"></i> add to cart</button>
											</div>
										</div>
                                        <?php endforeach; ?>

									</div>
									<div id="slick-nav-2" class="products-slick-nav"></div>
								</div>
								<!-- /tab -->
							</div>
						</div>
					</div>
					<!-- /Products tab & slick -->
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
