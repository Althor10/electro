<!-- BREADCRUMB -->
<div id="breadcrumb" class="section">
    <!-- container -->
    <div class="container">
        <!-- row -->
        <div class="row">
            <div class="col-md-12">
                <h3 class="breadcrumb-header">Login</h3>
                <ul class="breadcrumb-tree">
                    <li><a href="<?= $_SERVER['PHP_SELF']."?page=pocetna" ?>">Home</a></li>
                    <li class="active">My Account</li>
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
            <div class="main">
                <div class="shop_top">
                    <div class="container">
                        <div class="col-md-6">
                            <div class="login-page">
                                <h4 class="title">New User</h4>
                                <p>Don't have an account? You can create one in just one step! You will be given a option to enter your address. Don't be
                                    alarmed it is so that we know where to ship the products. Hope you enjoy our collection.</p>
                                <div class="button1">
                                    <a href="index.php?page=register"><input
                                                style="
                                                        height: 30px;
                                                        width: 100%;
                                                        background: #D10024;
                                                        color: #FFF;
                                                        font-weight: 700;
                                                        border: none;
                                                        border-radius: 40px 40px 40px 40px;"
                                                type="submit" name="Submit" value="Create an Account"></a>
                                </div>
                                <div class="clear"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="login-title">
                                <h4 class="title">Registered Customers</h4>
                                <?php if (isset($_SESSION['error'])) {
                                    $sesija = $_SESSION['error'];
                                    foreach ($sesija as $error) {
                                        echo "<b>$error</b> ";
                                    }
                                }?>
                                <div id="loginbox" class="loginbox">

                                    <form action="php/login.php" method="post" name="login" id="login-form">
                                        <table>
                                            <form action="php/login.php" method="post" name="login" id="login-form">

                                                <tr>
                                                    <td> <p id="login-form-username">
                                                            <label for="modlgn_username">Email </label></td>
                                                    <td>  <input id="modlgn_username" type="text" name="email" class="input" size="18"
                                                                 autocomplete="off"></td>
                                                    </p>
                                                </tr>
                                                <tr>
                                                    <td><p id="login-form-password">
                                                            <label for="modlgn_passwd">Password</label> </td>
                                                    <td> <input id="modlgn_passwd" type="password" name="password" class="input" size="18"
                                                                autocomplete="off"> </td>
                                                    </p>
                                                </tr>
                                                <tr>
                                                    <div class="remember">

                                                        <td> <input type="submit" name="submit" class="sbmt-button"
                                                                    style="
                                                        height: 30px;
                                                        width: 100px;
                                                        background: #D10024;
                                                        color: #FFF;
                                                        font-weight: 700;
                                                        border: none;
                                                        border-radius: 40px 40px 40px 40px;"
                                                                    value="Login"> </td>
                                                        <div class="clear"></div>
                                                    </div>
                                                </tr>

                                            </form>
                                        </table>
                                </div>
                            </div>
                            <div class="clear"></div>
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
