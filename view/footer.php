		
		<!-- FOOTER -->
		<footer id="footer">
			<!-- top footer -->
			<div class="section">
				<!-- container -->
				<div class="container">
					<!-- row -->
					<div class="row">
						<div class="col-md-3 col-xs-6">
							<div class="footer">
								<h3 class="footer-title">About Author</h3>
                                <p>Danilo Zdravkovic. Second PHP website.</p>
								<ul class="footer-links">
									<li><a href="https://www.ict.edu.rs/"><i class="fa fa-map-marker"></i>Student of ICT COLLEGE OF APPLIED STUDIES</a></li>
									<li><i class="fa fa-phone"></i>227/16</li>
									<li><a href="<?= $_SERVER['PHP_SELF']."?page=contact"; ?>"><i class="fa fa-envelope-o"></i>danilo.zdravkovic.227.16@ict.edu.rs</a></li>
								</ul>
							</div>
						</div>
						<div class="col-md-3 col-xs-6">
							<div class="footer">

								<h3 class="footer-title">Categories</h3>
								<ul class="footer-links">
                                    <?php
                                    $queryCat = "SELECT * FROM navigation";
                                    $exeQueryCat = executeQuery($queryCat);
                                    foreach ($exeQueryCat as $footNav1):
                                    ?>
									<li><a href="<?=$footNav1->path ?>"><?= $footNav1->name ?></a></li>
                                    <?php endforeach; ?>
								</ul>
							</div>
						</div>

						<div class="clearfix visible-xs"></div>

						<div class="col-md-3 col-xs-6">
							<div class="footer">
								<h3 class="footer-title">Information</h3>
								<ul class="footer-links">
                                    <?php
                                    $queryCat2 = "SELECT * FROM footer_navigation_subnav WHERE id_footnav = (SELECT id FROM footer_navigation WHERE title= 'Information')";
                                    $exeQueryCat2 = executeQuery($queryCat2);
                                    foreach ($exeQueryCat2 as $footNav2):
                                    ?>
									<li><a href="<?= $footNav2->path?>"><?= $footNav2->subnav ?></a></li>
                                    <?php endforeach; ?>
								</ul>
							</div>
						</div>
                        <?php if(isset($_SESSION['korisnik'])): ?>
						<div class="col-md-3 col-xs-6">
							<div class="footer">
								<h3 class="footer-title">Service</h3>
								<ul class="footer-links">
                                    <?php
                                    $queryCat3 = "SELECT * FROM footer_navigation_subnav WHERE id_footnav = (SELECT id FROM footer_navigation WHERE title= 'Service')";
                                    $exeQueryCat3 = executeQuery($queryCat3);
                                    foreach ($exeQueryCat3 as $footNav3):
                                    ?>
									<li><a href="<?= $footNav3->path ?>"><?= $footNav3->subnav ?></a></li>
									<?php endforeach; ?>
								</ul>
							</div>
						</div>
                        <?php else: ?>
                            <div class="col-md-3 col-xs-6">
                                <div class="footer">
                                    <h3 class="footer-title">Service</h3>
                                    <ul class="footer-links">
                                        <li><a href="index.php?page=register">Register</a></li>
                                        <li><a href="index.php?page=login">Login</a></li>
                                    </ul>
                                </div>
                            </div>
                        <?php endif; ?>

					</div>
					<!-- /row -->
				</div>
				<!-- /container -->
			</div>
			<!-- /top footer -->

			<!-- bottom footer -->
			<div id="bottom-footer" class="section">
				<div class="container">
					<!-- row -->
					<div class="row">
						<div class="col-md-12 text-center">
							<ul class="footer-payments">
								<li><a href="#"><i class="fa fa-cc-visa"></i></a></li>
								<li><a href="#"><i class="fa fa-credit-card"></i></a></li>
								<li><a href="#"><i class="fa fa-cc-paypal"></i></a></li>
								<li><a href="#"><i class="fa fa-cc-mastercard"></i></a></li>
								<li><a href="#"><i class="fa fa-cc-discover"></i></a></li>
								<li><a href="#"><i class="fa fa-cc-amex"></i></a></li>
							</ul>
							<span class="copyright">
								<!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
								Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved | This template is made with <i class="fa fa-heart-o" aria-hidden="true"></i> by <a href="https://colorlib.com" target="_blank">Colorlib</a>
							<!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
							</span>
						</div>
					</div>
						<!-- /row -->
				</div>
				<!-- /container -->
			</div>
			<!-- /bottom footer -->
		</footer>
		<!-- /FOOTER -->

		<!-- jQuery Plugins -->
        <script src="js/jquery-3.3.1.min.js"></script>
		<script src="js/jquery.min.js"></script>
		<script src="js/bootstrap.min.js"></script>
		<script src="js/slick.min.js"></script>
		<script src="js/nouislider.min.js"></script>
		<script src="js/jquery.zoom.min.js"></script>
		<script src="js/main.js"></script>

	</body>
</html>
