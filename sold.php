<?php include 'setting/system.php'; ?>
<?php include 'theme/head.php'; ?>
<?php include 'theme/sidebar.php'; ?>
<?php include 'session.php'; ?>

<?php
if (!$_GET['id'] || empty($_GET['id'])) {
    header('location: manage-pig.php');
    exit;
} else {
    $pigno = $bname = $b_id = $cname = $c_id = $fname = $f_id = $vname = $v_id = $health = "";
    $id = (int)$_GET['id'];
    $query = $db->query("SELECT * FROM pigs WHERE id = '$id'");
    $fetchObj = $query->fetchAll(PDO::FETCH_OBJ);

    foreach ($fetchObj as $obj) {
        $pid = $obj->id;
        $pigno = $obj->pigno;
        $b_id = $obj->breed_id;
        $p_price = (float)$obj->weight * 200;
        $c_id = $obj->classification_id;
        $f_id = $obj->feed_id;
        $v_id = $obj->vitamins_id;
        $health = $obj->health_status;

        $k = $db->query("SELECT * FROM breed WHERE id = '$b_id'");
        $ks = $k->fetchAll(PDO::FETCH_OBJ);
        foreach ($ks as $r) {
            $bname = $r->name;
        }
    }
}

if (isset($_POST['submit'])) {
    $id = $_POST['id'];
    $buyer = $_POST['buyer'];
    $price = $_POST['price'];
    $money = $_POST['money'];
    $n_remark = $_POST['reason'];
    $cashier_name = $_POST['cashier_name'];
    $contact = $_POST['contact'];
    $now = date('Y-m-d');
    $status = 3;

    if ($price > $money) {
        echo "<script>
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Cash must not be less than the price!'
            });
        </script>";
    } else {
        $insert_query = $db->query("INSERT INTO sold (pig_id, date_sold, reason, buyer, price, money, cashier_name, contact) 
            VALUES ('$id', '$now', '$n_remark', '$buyer', '$price', '$money', '$cashier_name', '$contact')");

        $update_pig = $db->query("UPDATE pigs SET status = '$status' WHERE id = '$id'");

        if ($insert_query) {
            echo "<script>
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: 'Pig successfully sold!',
                    showConfirmButton: false,
                    timer: 1500
                }).then(() => {
                    window.location.href = 'receipt.php?id={$db->lastInsertId()}';
                });
            </script>";
        } else {
            echo "<script>
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Failed to add sold data. Please try again.'
                });
            </script>";
        }
    }
}
?>

<div class="w3-main" style="margin-left:300px;margin-top:43px;">
    <header class="w3-container" style="padding-top:22px">
        <h5><b><i class="fa fa-dashboard"></i> Pig Management</b></h5>
    </header>

    <div class="w3-container" style="padding-top:22px">
        <div class="w3-row">
            <h2>Sold List</h2>
            <div class="col-md-6 table-responsive">
                <table class="table table-hover" id="table">
                    <thead>
                        <tr>
                            <th>Pig No</th>
                            <th>Buyer</th>
                            <th>Price</th>
                            <th>Money</th>
                            <th>Date Sold</th>
                            <th>Reason</th>
                            <th>Cashier/Staff</th>
                            <th>Contact</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $get = $db->query("SELECT p.pigno, s.date_sold, s.reason, s.buyer, s.price, p.id, s.money, s.cashier_name, s.contact 
                                           FROM sold s 
                                           LEFT JOIN pigs p ON s.pig_id = p.id");
                        $res = $get->fetchAll(PDO::FETCH_OBJ);
                        foreach ($res as $n) { ?>
                            <tr>
                                <td><?php echo $n->pigno; ?></td>
                                <td><?php echo $n->buyer; ?></td>
                                <td><?php echo $n->price; ?></td>
                                <td><?php echo $n->money; ?></td>
                                <td><?php echo $n->date_sold; ?></td>
                                <td><?php echo $n->reason; ?></td>
                                <td><?php echo $n->cashier_name; ?></td>
                                <td><?php echo $n->contact; ?></td>
                                <td>
                                    <a href="receipt.php?id=<?= $n->id ?>" class="btn btn-primary">
                                        <i class="fa fa-print"> Receipt</i>
                                    </a>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>

            <div class="col-md-6">
                <form role='form' method="post">
                    <input type="hidden" name="id" readonly class="form-control" value="<?php echo $pid; ?>">
                    <div class="form-group">
                        <label class="control-label">Pig No</label>
                        <input type="text" name="pigno" readonly class="form-control" value="<?php echo $pigno; ?>">
                    </div>
                    <div class="form-group">
                        <label class="control-label">Buyer Name</label>
                        <input type="text" name="buyer" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label class="control-label">Price</label>
                        <input type="text" name="price" class="form-control" readonly value="<?php echo $p_price; ?>" required>
                    </div>
                    <div class="form-group">
                        <label class="control-label">Cash</label>
                        <input type="text" name="money" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label class="control-label">Cashier/Staff Name</label>
                        <input type="text" name="cashier_name" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label class="control-label">Contact (Email or Phone)</label>
                        <input type="text" name="contact" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label class="control-label">Reason</label>
                        <textarea name="reason" class="form-control"></textarea>
                    </div>
                    <button name="submit" type="submit" class="btn btn-sm btn-default">Add to list</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include 'theme/foot.php'; ?>