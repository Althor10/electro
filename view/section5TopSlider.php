<!-- SECTION -->
<div class="section">
			<!-- container -->
			<div class="container">
				<!-- row -->
				<div class="row">
					<div class="col-md-4 col-xs-6">
						<div class="section-title">
							<h4 class="title">Top selling</h4>
							<div class="section-nav">
								<div id="slick-nav-3" class="products-slick-nav"></div>
							</div>
						</div>

						<div class="products-widget-slick" data-nav="#slick-nav-3">
							<div>
                                <?php $queryTop3 = "SELECT *,ep.id as epid,s.name as sname, ep.name as prodname  FROM electroproducts ep INNER JOIN warehouse w ON ep.id = w.product_id INNER JOIN images i ON ep.id = i.product_id INNER JOIN subcategory s ON ep.subcat_id = s.id WHERE sold>10 LIMIT 3";
                                        $exexQuery3 = executeQuery($queryTop3);
                                        foreach($exexQuery3 as $top3):
                                ?>
								<!-- product widget -->
								<div class="product-widget">
									<div class="product-img">
										<img src="<?= $top3->img_path ?>" alt="<?= $top3->alt ?>">
									</div>
									<div class="product-body">
										<p class="product-category"><?= $top3->sname ?></p>
										<h3 class="product-name"><a href="index.php?page=product&product=<?=$top3->epid?>"><?= $top3->prodname ?></a></h3>
										<h4 class="product-price">$<?= $top3->price ?>.00 <?php if($top3->lastprice): ?><del class="product-old-price">$<?= $top3->lastprice ?>.00</del> <?php endif; ?></h4>
									</div>
								</div>
                                <?php endforeach;?>
								<!-- /product widget -->
							</div>

							<div>
                                <?php $queryTop32 = "SELECT *,ep.id as epid,s.name as sname, ep.name as prodname  FROM electroproducts ep INNER JOIN warehouse w ON ep.id = w.product_id INNER JOIN images i ON ep.id = i.product_id INNER JOIN subcategory s ON ep.subcat_id = s.id WHERE sold>1 ORDER BY price ASC LIMIT 3 ";
                                $exexQuery32 = executeQuery($queryTop32);
                                foreach($exexQuery32 as $top32):
                                    ?>
                                    <!-- product widget -->
                                    <div class="product-widget">
                                        <div class="product-img">
                                            <img src="<?= $top32->img_path ?>" alt="<?= $top32->alt ?>">
                                        </div>
                                        <div class="product-body">
                                            <p class="product-category"><?= $top32->sname ?></p>
                                            <h3 class="product-name"><a href="index.php?page=product&product=<?=$top32->epid?>"><?= $top32->prodname ?></a></h3>
                                            <h4 class="product-price">$<?= $top32->price ?>.00 <?php if($top32->lastprice): ?><del class="product-old-price">$<?= $top32->lastprice ?>.00</del> <?php endif; ?></h4>
                                        </div>
                                    </div>
                                <?php endforeach;?>
                                <!-- /product widget -->
							</div>
						</div>
					</div>

					<div class="col-md-4 col-xs-6">
						<div class="section-title">
							<h4 class="title">Top selling</h4>
							<div class="section-nav">
								<div id="slick-nav-4" class="products-slick-nav"></div>
							</div>
						</div>

						<div class="products-widget-slick" data-nav="#slick-nav-4">
							<div>
                                <?php $queryTop33 = "SELECT *,ep.id as epid,s.name as sname, ep.name as prodname  FROM electroproducts ep INNER JOIN warehouse w ON ep.id = w.product_id INNER JOIN images i ON ep.id = i.product_id INNER JOIN subcategory s ON ep.subcat_id = s.id WHERE sold>1 AND s.name = 'Laptops' ORDER BY price ASC LIMIT 3 ";
                                $exexQuery33 = executeQuery($queryTop33);
                                foreach($exexQuery33 as $top33):
                                    ?>
                                    <!-- product widget -->
                                    <div class="product-widget">
                                        <div class="product-img">
                                            <img src="<?= $top33->img_path ?>" alt="<?= $top33->alt ?>">
                                        </div>
                                        <div class="product-body">
                                            <p class="product-category"><?= $top33->sname ?></p>
                                            <h3 class="product-name"><a href="index.php?page=product&product=<?=$top33->epid?>"><?= $top33->prodname ?></a></h3>
                                            <h4 class="product-price">$<?= $top33->price ?>.00 <?php if($top33->lastprice): ?><del class="product-old-price">$<?= $top33->lastprice ?>.00</del> <?php endif; ?></h4>
                                        </div>
                                    </div>
                                <?php endforeach;?>
							</div>

							<div>
                                <?php $queryTop34 = "SELECT *,ep.id as epid,s.name as sname, ep.name as prodname  FROM electroproducts ep INNER JOIN warehouse w ON ep.id = w.product_id INNER JOIN images i ON ep.id = i.product_id INNER JOIN subcategory s ON ep.subcat_id = s.id WHERE sold>1 AND s.name = 'Desktop' ORDER BY price ASC LIMIT 3 ";
                                $exexQuery34 = executeQuery($queryTop34);
                                foreach($exexQuery34 as $top34):
                                    ?>
                                    <!-- product widget -->
                                    <div class="product-widget">
                                        <div class="product-img">
                                            <img src="<?= $top34->img_path ?>" alt="<?= $top34->alt ?>">
                                        </div>
                                        <div class="product-body">
                                            <p class="product-category"><?= $top34->sname ?></p>
                                            <h3 class="product-name"><a href="index.php?page=product&product=<?=$top34->epid?>"><?= $top34->prodname ?></a></h3>
                                            <h4 class="product-price">$<?= $top34->price ?>.00 <?php if($top34->lastprice): ?><del class="product-old-price">$<?= $top34->lastprice ?>.00</del> <?php endif; ?></h4>
                                        </div>
                                    </div>
                                <?php endforeach;?>
							</div>
						</div>
					</div>

					<div class="clearfix visible-sm visible-xs"></div>

					<div class="col-md-4 col-xs-6">
						<div class="section-title">
							<h4 class="title">Top selling</h4>
							<div class="section-nav">
								<div id="slick-nav-5" class="products-slick-nav"></div>
							</div>
						</div>

						<div class="products-widget-slick" data-nav="#slick-nav-5">
							<div>
                                <?php $queryTop35 = "SELECT *,ep.id as epid,s.name as sname, ep.name as prodname  FROM electroproducts ep INNER JOIN warehouse w ON ep.id = w.product_id INNER JOIN images i ON ep.id = i.product_id INNER JOIN subcategory s ON ep.subcat_id = s.id WHERE sold>1 ORDER BY price ASC LIMIT 3 ";
                                $exexQuery35 = executeQuery($queryTop35);
                                foreach($exexQuery35 as $top35):
                                    ?>
                                    <!-- product widget -->
                                    <div class="product-widget">
                                        <div class="product-img">
                                            <img src="<?= $top35->img_path ?>" alt="<?= $top35->alt ?>">
                                        </div>
                                        <div class="product-body">
                                            <p class="product-category"><?= $top35->sname ?></p>
                                            <h3 class="product-name"><a href="index.php?page=product&product=<?=$top35->epid?>"><?= $top35->prodname ?></a></h3>
                                            <h4 class="product-price">$<?= $top35->price ?>.00 <?php if($top35->lastprice): ?><del class="product-old-price">$<?= $top35->lastprice ?>.00</del> <?php endif; ?></h4>
                                        </div>
                                    </div>
                                <?php endforeach;?>
							</div>

							<div>
                                <?php $queryTop36 = "SELECT *,ep.id as epid,s.name as sname, ep.name as prodname  FROM electroproducts ep INNER JOIN warehouse w ON ep.id = w.product_id INNER JOIN images i ON ep.id = i.product_id INNER JOIN subcategory s ON ep.subcat_id = s.id WHERE sold>1 ORDER BY price DESC LIMIT 3 ";
                                $exexQuery36 = executeQuery($queryTop36);
                                foreach($exexQuery36 as $top36):
                                    ?>
                                    <!-- product widget -->
                                    <div class="product-widget">
                                        <div class="product-img">
                                            <img src="<?= $top36->img_path ?>" alt="<?= $top36->alt ?>">
                                        </div>
                                        <div class="product-body">
                                            <p class="product-category"><?= $top36->sname ?></p>
                                            <h3 class="product-name"><a href="index.php?page=product&product=<?=$top36->epid?>"><?= $top36->prodname ?></a></h3>
                                            <h4 class="product-price">$<?= $top36->price ?>.00 <?php if($top36->lastprice): ?><del class="product-old-price">$<?= $top36->lastprice ?>.00</del> <?php endif; ?></h4>
                                        </div>
                                    </div>
                                <?php endforeach;?>
							</div>
						</div>
					</div>

				</div>
				<!-- /row -->
			</div>
			<!-- /container -->
		</div>
		<!-- /SECTION -->
