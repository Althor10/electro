<div class="main">
    <div class="shop_top">
        <div class="container">
            <?php
            if (isset($_SESSION['error'])) {
                foreach ($_SESSION['error'] as $error) {
                    echo "<p>$error</p>";
                    unset($_SESSION['error']);
                }
            }
            ?>
            <form action="php/survey.php" method="post">
                <div class="register-top-grid">
                    <h2>SURVEY</h2>
                    <div>
                        <span>Name</span>
                        <input type="text" name="tbIme">
                    </div>
                    <div class="clear"></div>

                </div>
                <div class="clear"></div>
                <div class="register-bottom-grid">
                    <h3>QUESTION</h3>
                    <div>
                        <span>What do you use the most?<label>*</label></span>
                        <select name="products">
                            <option  value="0">Choose category...</option>
                            <option  value="Smartphone">Smartphone</option>
                            <option value="Laptop">Laptop</option>
                            <option value="Desktop">Desktop</option>
                            <option value="Camera">Camera</option>
                            <option value="Headphones">Headphones</option>
                            <option value="Tablet">Tablet</option>
                        </select>
                    </div>
                    <div>
                        <span>Do you like the look of the website?</span>
                        <select name="yesNo">
                            <option value="0">No</option>
                            <option value="1">Yes</option>
                        </select>
                    </div>
                    <div class="clear"></div>
                </div>
                <div class="clear"></div>
                <input type="submit" value="Answer" name="btnSubmit">
            </form>
        </div>
    </div>
</div>