<?php if(isset($_SESSION['korisnik'])): ?>
    <?php
        $id = $_SESSION['korisnik']->uid;


    ?>
    <div class="main">
        <div class="shop_top">
            <div class="container">
                <div class="row shop_box-top">
                    <ul class="nav nav-tabs">
                        <li class="active"><a data-toggle="tab" href="#products">Contact Admin</a></li>
                    </ul>
                    <form action="php/sendMail.php" method="post" />
                    <div       id="products" class="tab-pane fade in active">
                        <h3>Admin Contact</h3>
                        <p>Managing products.</p>
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Full Name</th>
                                <th scope="col">Email</th>
                                <th scope="col">Subject</th>
                                <th scope="col">Message</th>
                                <th scope="col">Date</th>
                            </tr>
                            </thead>
                            <?php $query= "SELECT * FROM electrousers WHERE id=$id";
                                $execQuery = executeQuery($query);
                                foreach($execQuery as $person):
                            ?>
                            <tbody>
                                    <th scope="row">#</th>
                                    <td><?= $person->firstname ?> <?= $person->lastname ?> <input type="hidden" name="fullName" id="fullName" value="<?= $person->firstname ?> <?= $person->lastname ?>"/></td>
                                    <td><?= $person->email ?><input type="hidden" name="email" id="email" value="<?= $person->email ?>"/></td>
                                    <td><input type="text" name="subject" id="subject"></td>
                                    <td><input type="text" name="message" id="message"></td>
                                    <?php $date=date('Y-m-d H:i:s',time()); ?>
                                    <td><?= $date ?></td>
                                    <?php endforeach; ?>
                            </tbody>
                        </table>
                        <input type="submit" class="btn btn-danger" name="btnSubbmit" value="Send">

                        </form>
                        <div class="alert"> Send a message to the website <b>admin</b>.</div>
                        <div class="alert-danger">
                            <?php if(isset($_SESSION['error'])){
                                var_dump($_SESSION['error']);}?>

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
