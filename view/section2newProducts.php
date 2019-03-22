	


		<!-- SECTION -->
		<div class="section">
			<!-- container -->
			<div class="container">
				<!-- row -->
				<div class="row">

					<!-- section title -->
					<div class="col-md-12">
						<div class="section-title">
							<h3 class="title">New Products</h3>

							</div>
						</div>
					</div>
					<!-- /section title -->

					<!-- Products tab & slick -->
                    <?php
                    $queryProd = "SELECT *,e.id as eId, e.name as prodName, s.name as subName FROM electroproducts e INNER JOIN images i ON e.id = i.product_id INNER JOIN subcategory s ON e.subcat_id = s.id";
                    $rez = executeQuery($queryProd);
                    ?>


					<div class="col-md-12">

						<div class="row">
							<div class="products-tabs">
								<!-- tab -->

								<div id="tab1" class="tab-pane active">
									<div class="products-slick" data-nav="#slick-nav-1">
										<!-- product -->

                                        <?php foreach ($rez as $product): ?>
                                        <?php if($product->new): ?>
										<div class="product">
											<div class="product-img">
												<img src="<?=$product->img_path?>" alt="<?=$product->alt?>">
												<div class="product-label">

													<span class="new">NEW</span>


												</div>
											</div>
											<div class="product-body">
												<p class="product-category"><?=$product->subName ?></p>
												<h3 class="product-name"><a href="<?= $_SERVER['PHP_SELF'].'?page=product&product='.$product->eId ?>" data-id="<?=$product->eId?>"><?= $product->prodName ?></a></h3>
                                                <h4 class="product-price">$<?= $product->price ?>.00 <?php if($product->lastprice): ?><del class="product-old-price">$<?= $product->lastprice ?>.00</del> <?php endif; ?></h4>
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
												<button class="add-to-cart-btn" data-id="<?= $product->eId ?>"><i class="fa fa-shopping-cart"></i> add to cart</button>
											</div>
										</div>
                                            <?php endif; ?>
                                        <?php endforeach; ?>

										<!-- /product -->


									</div>
									<div id="slick-nav-1" class="products-slick-nav"></div>
								</div>
								<!-- /tab -->
							</div>

						</div>
					</div>

					<!-- Products tab & slick -->
				</div>

				<!-- /row -->
			</div>

			<!-- /container -->
		</div>
		<!-- /SECTION -->
