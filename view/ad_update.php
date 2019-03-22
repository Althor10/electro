<?php if(isset($_SESSION['korisnik']) && $_SESSION['korisnik']->role=='admin'): ?>
  <?php  if(isset($_GET['id'])): ?>
    <!-- BREADCRUMB -->
    <div id="breadcrumb" class="section">
        <!-- container -->
        <div class="container">

            <!-- row -->
            <div class="row">
                <div class="col-md-12">
                    <h3 class="breadcrumb-header">Update Ad</h3>
                    <ul class="breadcrumb-tree">
                        <li><a href="<?= $_SERVER['PHP_SELF']."?page=adminPanel"?>">Admin Panel</a></li>
                        <li class="active">Insert</li>
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

                <div class="col-md-7">
                    <!-- Billing Details -->
                    <div class="billing-details">
                        <div class="section-title">
                            <h3 class="title">Insert AD Form</h3>
                        </div>
                        <?php

                        $prodId = (int)$_GET['id'];
                        if($prodId):
                        $queryGet = "SELECT *,h.id as hid,hi.id as hiid FROM hotad h INNER JOIN hotad_image hi ON h.id=hi.hotad_id WHERE h.id = $prodId";
                        $execGet = executeQuery($queryGet);
                        foreach ($execGet as $get):
                        ?>
                        <form action="php/updateAd.php" method="post" enctype="multipart/form-data">
                            <div class="form-group">
                                <input class="input" type="text" name="title" placeholder="Title" required value="<?=$get->title ?>">
                            </div>
                            <div class="form-group">
                                <input class="input" type="text" name="text" placeholder="Text" value="<?=$get->advert ?>" required>
                            </div>
                            <div class="form-group">
                                <label>Start Date</label>
                                <input class="input" type="date" name="dateStart"  >
                            </div>
                            <div class="form-group">
                                <label>End Date</label>
                                <input class="input" type="date" name="dateTill" value="" >
                            </div>
                            <div class="form-group">
                                <input class="input" type="file" name="adImage" value="<?=$get->img_path ?>" >
                            </div>
                            <div class="form-group">
                                <label>PRIORITY: </label>
                                <select name="priority" required>
                                <?php if($get->priority == 1): ?>
                                    <option value="1">TOP</option>
                                    <option value="-1"></option>
                                    <option value="0">NOT</option>
                                 <?php else: ?>
                                 <option value="0">NOT</option>
                                    <option value="-1"></option>
                                    <option value="1">TOP</option>
                                    <?php endif; ?>
                                </select>
                            </div>
                            <input type="hidden" name="adId" value="<?=$get->hid ?>">
                            <input type="hidden" name="adIId" value="<?=$get->hiid ?>">
                            <input type="submit" name='btnSubmit' class="primary-btn order-submit" value="Update">
                    </div>
                    </form>
                    <?php endforeach; ?>
                        <?php else: ?>
                        <h1>YOU HAVE IT WRONG MATE!</h1>
                        <h2>Not authorised to be on this page</h2>
                        <?php endif; ?>
                </div>
                <div class="col-md-5 order-details">
                    <div class="section-title text-center">
                        <h3 class="title">Ad instructions!</h3>
                    </div>
                    <div class="order-summary">
                        <div class="order-row">
                            <div><p>Keep in mind of the image size and width and height (1782 x 465), the date must not be expired (past date),
                                    </br>Look to it that the title and text be catchy and to attract attention!
                                    </br> If you want the ad to appear set priority TOP!</p>
                                <div><?php
                                    if(isset($_SESSION['error'])){
                                        $sesija = $_SESSION['error'];
                                        foreach ($sesija as $error) {
                                            echo "<b>$error</b> ";
                                        }
                                    }
                                    ?></div>
                            </div>

                        </div>

                    </div>
                </div>

            </div>
            <!-- /row -->
        </div>
        <!-- /container -->
    </div>
    <!-- /SECTION -->
  <?php endif; ?>
<?php else: ?>
    <h1>GET OUT FROM HERE! You are not authorised to be on this page</h1>
<?php endif; ?>
