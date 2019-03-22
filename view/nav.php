	
		<!-- NAVIGATION -->
		<nav id="navigation">
			<!-- container -->
			<div class="container">
				<!-- responsive-nav -->
				<div id="responsive-nav">
					<!-- NAV -->
					<ul class="main-nav nav navbar-nav">
                        <?php
                        $queryNav = "SELECT * FROM navigation";
                        $rezNav = executeQuery($queryNav);
                        ?>
                        <?php foreach ($rezNav as $item):?>
<!--						<li class="active"><a href="#">Home</a></li>-->

						<li><a href="<?= $item->path ?>"> <?= $item->name ?></a></li>
                        <?php endforeach;?>
					</ul>
					<!-- /NAV -->
				</div>
				<!-- /responsive-nav -->
			</div>
			<!-- /container -->
		</nav>
		<!-- /NAVIGATION -->
