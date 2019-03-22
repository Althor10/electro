
<?php
    $queryGetDeal = "SELECT *,h.id as hid, hi.id as hiid FROM hotad h INNER JOIN hotad_image hi ON h.id = hi.hotad_id LIMIT 1";
    $execGetDeal = executeQuery($queryGetDeal);
    foreach ($execGetDeal as $hotDeal):
?>
		<!-- HOT DEAL SECTION -->
		<div id="hot-deal" class="section">
			<!-- container -->
			<div class="container">
				<!-- row -->
				<div class="row">
					<div class="col-md-12">
						<div class="hot-deal" style="background-image: url("<?= $hotDeal->img_path ?>")">
							<ul class="hot-deal-countdown">
								<li><?php

                                    $dateLDay = strtotime($hotDeal->date_end);
                                    $remaining = $dateLDay - time();
								    $dateLTime = strtotime($dateLDay);

                                    $days_remaining = floor($remaining / 86400);
                                    $hours_remaining = floor(($remaining % 86400) / 3600);
                                    $minutes_remaining = floor(($remaining % 3600)/60);
                                    $secunds_remaining = floor($remaining % 60);

							?>
									<div>
										<h3><?= $days_remaining; ?></h3>
										<span>Days</span>
									</div>
								</li>
								<li>
									<div>
										<h3><?= $hours_remaining; ?></h3>
										<span>Hours</span>
									</div>
								</li>
								<li>
									<div>
										<h3><?= $minutes_remaining;?></h3>
										<span>Mins</span>
									</div>
								</li>
								<li>
									<div>
										<h3><?= $secunds_remaining;?></h3>
										<span>Secs</span>
									</div>
								</li>
							</ul>
							<h2 class="text-uppercase"><?= $hotDeal->title?></h2>
							<p><?= $hotDeal->advert ?></p>
							<a class="primary-btn cta-btn" href="<?= $_SERVER['PHP_SELF']."?page=store&parameter=Hot"?>">Shop now</a>
						</div>
					</div>
				</div>
				<!-- /row -->
			</div>
			<!-- /container -->
		</div>
<?php endforeach; ?>
		<!-- /HOT DEAL SECTION -->
