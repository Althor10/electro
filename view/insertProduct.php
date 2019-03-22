
<div class="main">
    <div class="shop_top">
        <div class="container">
            <div class="row shop_box-top">
                <?php if(isset($_SESSION['korisnik']) && $_SESSION['korisnik']->role=='admin'): ?>
                <h3 >Insert a new Product.</h3></br>
            <form action="php/insertProduct.php" method="post" enctype="multipart/form-data">
                <table>
                    <tr>
                    <td><label>Product Label: </label><input type="text" name="prodName" class="input"> </td>
                        <td><label>Price: </label><input type="text" name="prodPrice" class="input"></td>
                        <td><label>Description: </label><textarea type="text" name="prodDesc" style="width:420px" ></textarea>
                        </td>
                        <td> <label>Specifications: </br> </label><textarea type="text"  style="width:420px" name="prodSpec" ></textarea>
                        </td>
                    </tr>
                    <tr>
                        <td> <label >Product Color: </label>
                            <?php $queryColor="SELECT * FROM color";
                            $execColor=executeQuery($queryColor);
                            ?>
                            <select name="slColor">
                                <option value="-1"></option>
                                <?php foreach ($execColor as $color): ?>
                                    <option value="<?= $color->id?>"><?= $color->name?></option>
                                <?php endforeach; ?>
                            </select>
                        </td>
                        <td>
                            <?php $queryCategory="SELECT * FROM subcategory";
                            $execCat = executeQuery($queryCategory);
                            ?>
                            <label>Category: </label>
                            <select name="slCategory">
                                <option value="-1"></option>
                                <?php foreach ($execCat as $cat): ?>
                                    <option value="<?= $cat->id ?>"><?= $cat->name ?></option>
                                <?php endforeach; ?>
                            </select>
                        </td>
                        <td>
                            <label>Product Image: </label>
                            <input type="file" name="filImage" id="image" />
                        </td>
                        <td> <label>Quantity :</label>
                            <input type="text" name="prodQuantity" class="input" required/>
                        </td>
                    </tr>
                </table>
                </br>
                <input type="submit" class="btn btn-danger center-block" name="btnSubbmit" value="Insert">
                <div class="alert">
                    <?php if(isset($_SESSION['error'])):
                       $err = $_SESSION['error'];?>
                       <ul>
                        <?php foreach($err as $e): ?>
                           <li><?=$e?></li>
                        <?php endforeach;?>
                       </ul>

                    <?php endif; ?>
                    <p>For Specification <b>before</b> every specification <b>(except first)</b> and <b>after</b> <b>(except last)</b> add a dlimiter "<b>/</b>" (without " ").</p>
                </div>
            </form>
                <?php else: ?>
                    <h1>NOT AUTHORISED FOR THIS PAGE!</h1>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

