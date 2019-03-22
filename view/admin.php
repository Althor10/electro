<div class="main">
    <div class="shop_top">
        <div class="container">
            <div class="row shop_box-top">
                <?php if (isset($_SESSION['korisnik']) && $_SESSION['korisnik']->role === 'admin'): ?>
                <ul class="nav nav-tabs">
                    <li class="active"><a data-toggle="tab" href="#users">Users</a></li>
                    <li><a data-toggle="tab" href="#products">Products</a></li>
                    <li><a data-toggle="tab" href="#hotdeals">Hot Deals</a></li>
                    <li><a data-toggle="tab" href="#messages">Messages</a></li>
                    <li><a data-toggle="tab" href="#newsletter">Newsletter</a></li>
                </ul>

                <div class="tab-content">
                    <div id="users" class="tab-pane fade in active">
                        <h3>Users</h3>
                        <p>Managing users.</p>
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Username</th>
                                <th scope="col">Email</th>
                                <th scope="col">Date(Made)</th>
                                <th scope="col">Role</th>
                                <th scope="col">Edit</th>
                                <th scope="col">Delete</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $upitcinaZaBazu = "SELECT *,eu.id as euid FROM electrousers eu INNER JOIN role r ON eu.role_id= r.id WHERE role!='admin'";
                            $aloo = executeQuery($upitcinaZaBazu);

                            foreach ($aloo as $user):
                                ?>
                                <tr>
                                    <th scope="row"><?= $user->euid-1 ?></th>
                                    <td><?= $user->username ?></td>
                                    <td><?= $user->email ?></td>
                                    <td><?= $user->date_made ?></td>
                                    <td><?= $user->role ?></td>

                                    <td><a href="index.php?page=edit&id=<?= $user->bid ?>">Edit</a></td>
                                    <td>
                                        <button type="button" class="btn btn-danger delete-user"
                                                data-id="<?= $user->euid ?>">Delete
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    <div id="products" class="tab-pane fade">
                        <h3>Products</h3>
                        <p>Managing products.</p>
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Name</th>
                                <th scope="col">Price</th>
                                <th scope="col">Desc</th>
                                <th scope="col">Sale</th>
                                <th scope="col">New</th>
                                <th scope="col">Hot</th>
                                <th scope="col">Quantity</th>
                                <th scope="col">Sold</th>
                                <th scope="col">Category</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                    $queryProd1 = "SELECT *,e.id as eId, e.name as prodName, s.name as subName FROM electroproducts e INNER JOIN images i ON e.id = i.product_id INNER JOIN subcategory s ON e.subcat_id = s.id INNER JOIN warehouse w ON e.id = w.product_id ORDER BY eId";
                    $rez = executeQuery($queryProd1);
                    ?>

                           <?php foreach ($rez as $prod):
                                ?>
                                <tr>
                                    <th scope="row"><?= $prod->eId ?></th>
                                    <td><?= $prod->prodName ?></td>
                                    <td>$<?= $prod->price ?></td>
                                    <td><?= $prod->description ?></td>
                                    <?php if($prod->sale): ?>
                                    <td>-<?= $prod->sale ?>%</td>
                                    <?php else: ?>
                                    <td>NOT</td>
                                    <?php endif; ?>
                                    <?php if($prod->new==1):?>
                                    <td>YES</td>
                                    <?php else: ?>
                                    <td>NO</td>
                                    <?php  endif; ?>
                                    <?php if($prod->hot==1):?>
                                        <td>YES</td>
                                    <?php else: ?>
                                        <td>NO</td>
                                    <?php  endif; ?>
                                    <td><?= $prod->quantity ?></td>
                                    <td><?= $prod->sold ?></td>
                                    <td><?= $prod->subName ?></td>
                                    <td><a href="index.php?page=prodedit&id=<?= $prod->eId ?>">Edit</a></td>
                                    <td>
                                        <button type="button" class="btn btn-danger delete-product"
                                                data-id="<?= $prod->eId ?>">Delete
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                        <a href="index.php?page=prodinsert"><input type="button" class="btn btn-danger" value="INSERT"> </a>
                    </div>
                    <div id="hotdeals" class="tab-pane fade">
                        <h3>Hot Deals</h3>
                        <p>Editing and Deleting the "Hot Deals" ad.</p>
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Title</th>
                                <th scope="col">Text</th>
                                <th scope="col">Date Set</th>
                                <th scope="col">Date end</th>
                                 <th scope="col">Priority</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $queryAd = "SELECT *,h.id as hid FROM hotad h INNER JOIN hotad_image hi ON h.id=hotad_id ";
                            $getAD = executeQuery($queryAd);

                            foreach ($getAD as $ad):
                                ?>
                                <tr>
                                    <th scope="row"><?= $ad->hid ?></th>
                                    <td><?= $ad->title ?></td>
                                    <td>$<?= $ad->advert ?></td>
                                    <td><?= $ad->date_start ?></td>
                                    <td><?= $ad->date_end ?></td>
                                    <?php if($ad->priority==1):?>
                                    <td>TOP</td>
                                    <?php else: ?>
                                    <td>NOT</td>
                                    <?php endif; ?>
                                    <td><a href="index.php?page=hotedit&id=<?= $ad->hid ?>">Edit</a></td>
                                    <td>
                                        <button type="button" class="btn btn-danger delete-ad"
                                                data-id="<?= $ad->hid ?>">Delete
                                        </button>
                                    </td>
                                </tr>
                        <?php endforeach; ?>
                            </tbody>
                        </table>
                        <a href="index.php?page=newad"><input type="button" class="btn btn-danger"  value="INSERT"/></a>
                    </div>

                    <div id="messages" class="tab-pane fade">
                        <h3>Messages</h3>
                        <p>Sent Messages from users and buyers</p>
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Who</th>
                                <th scope="col">Email</th>
                                <th scope="col">Subject</th>
                                <th scope="col">Text</th>
                                <th scope="col">Date</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $queryContact = "SELECT *,c.id as cid FROM adminmessage c";
                            $getContacts = executeQuery($queryContact);

                            foreach ($getContacts as $contact):
                                ?>
                                <tr>
                                    <th scope="row"><?= $contact->cid ?></th>
                                    <td><?= $contact->fullname ?></td>
                                    <td><?= $contact->email ?></td>
                                    <td><?= $contact->subject ?></td>
                                    <td><?= $contact->message ?></td>
                                    <td><?= $contact->date ?></td>
                                    <td><a href="index.php?page=response&id=<?= $contact->cid ?>">Respond</a></td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                            <div id="newsletter" class="tab-pane fade">
                                <h3>Newsletter</h3>
                                <p>Sending news to clients.</p>
                                <table class="table table-striped">
                                    <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Client</th>
                                        <th scope="col">Subject</th>
                                        <th scope="col">News</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                                                $queryNews = "SELECT * FROM newsletter";
                                                                $getNews = executeQuery($queryNews);

                                                                foreach ($getNews as $news):
                                    ?>
                                    <tr>
                                        <th scope="row"><?= $news->id ?></th>
                                        <td><?= $news->email ?></td>
                                        <td><input type="text" name="subject" class="input"></td>
                                        <td><input type="text" name="news" class="input"></td>
                                        <td><a href="mailto:<?= $news->email ?>?subject=NewsLetterElelectro&body=Welcome" target="_top">Send</a></td>
                                    </tr>
                                    <?php endforeach; ?>
                                    </tbody>
                                </table>
                             </div>
                        </table>

                    </div>
                </div>

            </div>
    </div>
</div>

        </div>
<script src="js/jquery-3.3.1.min.js"></script>
        <script type="text/javascript">
            $(document).ready(function () {
                $('.delete-user').click(function () {
                    var id = $(this).data('id');
                    //alert(id);

                    $.ajax({
                        method: 'POST',
                        url: "php/ajax_delete_user.php",
                        dataType: 'json',
                        data: {
                            id: id
                        },
                        success: function (podaci) {
                            alert("User is deleted.");
                            location.reload();
                        },
                        error: function (xhr, statusTxt, error) {
                            var status = xhr.status;
                            switch (status) {
                                case 500:
                                    alert("Server ERROR! Curently it is not possible to delete the user.");
                                    break;
                                case 404:
                                    alert("Page not Found!");
                                    break;
                                default:
                                    alert("Error: " + status + " - " + statusTxt);
                                    break;
                            }
                        }
                    });
                });
            });
        </script>
        <script type="text/javascript">
            $(document).ready(function () {
                $('.delete-product').click(function () {
                    var id = $(this).data('id');
                    // alert(id);

                    $.ajax({
                        method: 'POST',
                        url: "php/ajax_delete_product.php",
                        dataType: 'json',
                        data: {
                            id: id
                        },
                        success: function (podaci) {
                            alert("The item has been deleted!");
                            location.reload();
                        },
                        error: function (xhr, statusTxt, error) {
                            var status = xhr.status;
                            switch (status) {
                                case 500:
                                    alert("Server ERROR! Curently it is not possible to delete the product.");
                                    location.reload();
                                    break;
                                case 404:
                                    alert("Page not Found!");
                                    location.reload();
                                    break;
                                default:
                                    alert("Error: " + status + " - " + statusTxt);
                                    location.reload();
                                    break;
                            }
                        }
                    });
                });
            });
        </script>
        <script type="text/javascript">
            $(document).ready(function () {
                $('.delete-ad').click(function () {
                    var id = $(this).data('id');
                    // alert(id);

                    $.ajax({
                        method: 'POST',
                        url: "php/ajax_delete_ad.php",
                        dataType: 'json',
                        data: {
                            id: id
                        },
                        success: function (podaci) {
                            alert("The ad has been removed!");
                           // alert(podaci);
                            location.reload();
                        },
                        error: function (xhr, statusTxt, error) {
                            var status = xhr.status;
                            switch (status) {
                                case 500:
                                    alert("Server ERROR! Curently it is not possible to delete the ad.");
                                    break;
                                case 404:
                                    alert("Page not Found!");
                                    break;
                                default:
                                    alert("Error: " + status + " - " + statusTxt);
                                    location.reload();
                                    break;
                            }
                        }
                    });
                });
            });
        </script>
        <?php else: ?>
            <h4> YOU ARE NOT AUTHORISED TO ENTER THIS PAGE! PLEASE RETURN </h4>
            <script> alert("DONT DO THIS MATE!");</script>
        <?php endif; ?>

