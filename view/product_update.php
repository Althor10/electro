<?php if(isset($_SESSION['korisnik']) && $_SESSION['korisnik']->role=='admin'): ?>
<?php if(isset($_GET['id'])){
    $id = $_GET['id'];
    }

    ?>
<div class="main">
    <div class="shop_top">
        <div class="container">
            <div class="row shop_box-top">
                <ul class="nav nav-tabs">
                    <li class="active"><a data-toggle="tab" href="#products">Product</a></li>
                </ul>
                <form action="php/updateProduct.php" method="post" />
                <div       id="products" class="tab-pane fade in active">
                    <h3>Product</h3>
                    <p>Managing products.</p>
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Name</th>
                            <th scope="col">Price</th>
                            <th scope="col">Desc</th>
                            <th scope="col">Specs</th>
                            <th scope="col">Sale</th>
                            <th scope="col">New</th>
                            <th scope="col">Hot</th>
                            <th scope="col">Quantity</th>
                            <th scope="col">Sold</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $queryProd1 = "SELECT *,e.id as eId, e.name as prodName, s.name as subName FROM electroproducts e INNER JOIN images i ON e.id = i.product_id INNER JOIN subcategory s ON e.subcat_id = s.id INNER JOIN warehouse w ON e.id = w.product_id WHERE e.id=".$id." ORDER BY eId";
                        $rez = executeQuery($queryProd1);
                        ?>

                        <?php foreach ($rez as $prod):
                            ?>
                            <tr>
                                <th scope="row"><?= $prod->eId ?></th>
                                <td><input type="text" name="productName" id="prodName" value="<?= $prod->prodName ?>"/></td>
                                <td><?= $prod->price ?> <input type="hidden" value="<?= $prod->price ?>" name="lastPrice" id="lP"></td>
                                <td><textarea name="textDesc" style="margin: 0px; height: 350px; width: 180px;" ><?= $prod->description ?></textarea></td>
                                <td><textarea name="textSpec" style="margin: 0px; height: 350px; width: 180px;" ><?= $prod->specifications ?></textarea></td>
                                <td>
                                    <select name="sale">
                                        <option value="<?= $prod->sale ?>"><?= $prod->sale ?></option>
                                        <option value="-1">Full Price</option>
                                        <option value="0">0</option>
                                        <option value="10">10</option>
                                        <option value="20">20</option>
                                        <option value="30">30</option>
                                        <option value="40">40</option>
                                        <option value="50">50</option>
                                        <option value="60">60</option>
                                        <option value="70">70</option>
                                        <option value="80">80</option>
                                    </select>
                                </td>
                                    <td>
                                        <select name="new">
                                            <?php if($prod->new): ?>
                                            <option value="1">YES</option>
                                            <option value="0">NO</option>
                                            <?php else: ?>
                                                <option value="0">NO</option>
                                                <option value="1">YES</option>
                                            <?php endif; ?>
                                        </select>
                                    </td>
                                    <td>
                                        <select name="hot">
                                            <?php if($prod->hot): ?>
                                                <option value="1">YES</option>
                                                <option value="0">NO</option>
                                            <?php else: ?>
                                                <option value="0">NO</option>
                                                <option value="1">YES</option>
                                            <?php endif; ?>
                                        </select>
                                    </td>
                                <td><input type="text" name="prodQuantity" size="2px" id="prodQuantity" value="<?= $prod->quantity ?>"></td>
                                <td><input type="text" name="prodSold" size="2px" id="prodSold" value="<?= $prod->sold ?>"></td>
                                <input type="hidden" name="prodId" value="<?= $prod->eId ?>">
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                    <input type="submit" class="btn btn-danger" name="btnSubbmit" value="Update">

                    </form>
                    <div class="alert"> Price will be defined by the <b>Sold</b> row. Price will be lowered by the chosen <b>percentage</b>.</div>
                    <div class="alert-danger">
                        <?php if(isset($_SESSION['error'])){
                            var_dump($_SESSION['errora']);}?>

                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
<?php else: ?>
    <h3> YOU ARE NOT AUTHORISED TO ENTER THIS PAGE! PLEASE RETURN </h3>
    <script> alert("DONT DO THIS MATE!");</script>
<?php endif; ?>
