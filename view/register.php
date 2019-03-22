<!-- BREADCRUMB -->
<div id="breadcrumb" class="section">
    <!-- container -->
    <div class="container">
        <!-- row -->
        <div class="row">
            <div class="col-md-12">
                <h3 class="breadcrumb-header">Register</h3>
                <ul class="breadcrumb-tree">
                    <li><a href="#">Home</a></li>
                    <li class="active">Register</li>
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
                        <h3 class="title">Registration Form</h3>
                    </div>
                    <form action="php/register.php" method="post">
                    <div class="form-group">
                        <input class="input" type="text" name="first-name" placeholder="First Name">
                    </div>
                    <div class="form-group">
                        <input class="input" type="text" name="last-name" placeholder="Last Name">
                    </div>
                    <div class="form-group">
                        <input class="input" type="email" name="email" placeholder="Email">
                    </div>
                    <div class="form-group">
                        <input class="input" type="text" name="adress" placeholder="Address">
                    </div>
                    <div class="form-group">
                       <label>City</label>
                        <select name="city" >

                            <option value="-1"></option>
                            <?php $queryCity = "SELECT * FROM city";
                                    $execCity = executeQuery($queryCity);

                                    foreach ($execCity as $city):
                            ?>
                            <option value="<?= $city->id?>"><?= $city->name ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                        <div class="form-group">
                            <input class="input" type="text" name="username" placeholder="Username">
                        </div>
                        <div class="form-group">
                            <input class="input" type="password" name="password" placeholder="Password">
                        </div>
                        <input type="submit" name='btnSubmit' class="primary-btn order-submit" value="Register">
                </div>
                </form>
                <!-- /Billing Details -->

            </div>

            <!-- Order Details -->
            <div class="col-md-5 order-details">
                <div class="section-title text-center">
                    <h3 class="title">Welcome!</h3>
                </div>
                <div class="order-summary">
                    <div class="order-row">
                        <div>We're glad that you have chosen to join our little tech family!
                            Here you will be able to get our new products and get in touch with latest tech.
                            Our top-end laptops and desktop computers will be to your liking!
                            So, relax, grab your phone or computer and start ordering now!
                        </div>

                    </div>

                </div>
            </div>
            <!-- /Order Details -->
        </div>
        <!-- /row -->
    </div>
    <!-- /container -->
</div>
<!-- /SECTION -->