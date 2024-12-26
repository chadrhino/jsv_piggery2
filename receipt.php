<?php 
include 'setting/system.php';
include 'theme/head.php';
include 'theme/sidebar.php';
include 'session.php';

if (!$_GET['id'] || empty($_GET['id']) || $_GET['id'] == '') {
    header('location: manage-pig.php');
    exit;
} else {
    $id = (int)$_GET['id'];

    // Fetch sold pig details with the correct column names
    $get = $db->query("
        SELECT p.weight, p.pigno, s.date_sold, s.reason, s.buyer, s.price, s.money, s.cashier_name, s.contact, p.month 
        FROM sold s
        LEFT JOIN pigs p ON s.pig_id = p.id
        WHERE s.id = '$id'
    ");
    $res = $get->fetch(PDO::FETCH_OBJ);

    if (!$res) {
        header('location: manage-pig.php');
        exit;
    }

    // Generate Invoice Number
    $invoiceNumber = 'INV-' . str_pad($id, 6, '0', STR_PAD_LEFT); // Format as INV-000001

    // Capture cashier_name and contact from form submission
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (isset($_POST['cashier_name']) && isset($_POST['contact'])) {
            $cashier_name = htmlspecialchars($_POST['cashier_name']);
            $contact = htmlspecialchars($_POST['contact']);

            // Server-side validation: ensure contact is 11 digits
            if (!preg_match('/^\d{11}$/', $contact)) {
                echo "<script>alert('Contact number must be exactly 11 digits.');</script>";
            } else {
                // Update the database
                $db->query("UPDATE sold SET cashier_name = '$cashier_name', contact = '$contact' WHERE id = '$id'");
                $res->cashier_name = $cashier_name; // Update locally for immediate display
                $res->contact = $contact; 
                echo "<script>alert('Details updated successfully!');</script>";
            }
        }
    }
}
?>

<!-- Page Content -->
<div class="w3-main" style="margin-left:300px;margin-top:43px;">
    <header class="w3-container dont-print" style="padding-top:22px">
        <h5><b><i class="fa fa-dashboard"></i> Pig Management</b></h5>
    </header>

    <div class="w3-container" style="padding-top:22px">
        <div class="w3-padding text-center" style="border: 1px #000 dashed; position: relative;">
            <img src="img/pig14.jpg" class="w3-circle w3-margin-right" style="width: 120px; position: absolute; top: 0; left: 0; margin: 20px;">
            
            <!-- Receipt and Invoice Header -->
            <h4 style="font-weight: bolder;">JSV Piggery</h4>
            <h5 style="font-weight: bolder;">Kangwayan, Madridejos, Cebu</h5>
            <p><strong>Invoice Number:</strong> <?= $invoiceNumber ?></p>
            <p>Date: <?= date('m-d-Y', strtotime($res->date_sold)) ?></p>
            <p>Buyer: <?= htmlspecialchars($res->buyer) ?></p>
            <p>Cashier/Staff: <?= htmlspecialchars($res->cashier_name ?? 'Not Specified') ?></p>
            <p>Contact: <?= htmlspecialchars($res->contact ?? 'Not Specified') ?></p>

            <!-- Receipt Table -->
            <table class="w3-table w3-border w3-border-black w3-margin-top">
                <tr>
                    <th>PIG NO.</th>
                    <th>MONTH</th>
                    <th>WEIGHT</th>
                    <th>PRICE PER KILO</th>
                    <th>PRICE</th>
                </tr>
                <tr>
                    <td><?= htmlspecialchars($res->pigno) ?></td>
                    <td><?= htmlspecialchars($res->month ?? 0) ?></td>
                    <td><?= htmlspecialchars($res->weight) ?> KG</td>
                    <td>200</td>
                    <td><?= number_format($res->price, 2) ?></td>
                </tr>
            </table>

            <!-- Total Summary -->
            <div style="text-align: right; width: 100%; margin-top: 20px;">
                <h4>Total: <?= number_format($res->price, 2) ?></h4>
                <h4>Cash: <?= number_format($res->money, 2) ?></h4>
                <h3>CHANGE: <?= number_format($res->money - $res->price, 2) ?></h3>
            </div>

            <!-- Signature Section -->
            <div style="text-align: left; margin-top: 50px; border-top: 1px solid #000; width: 30%; padding-top: 10px;">
                <p>Signature:</p>
                <br>
                <!-- <p>_________________________</p> -->
                <!-- <p style="font-size: 12px;">(Buyer or Authorized Representative)</p> -->
            </div>
        </div>

        <!-- Form to Update Cashier and Contact -->
        <form method="post" class="dont-print" style="margin-top: 20px;">
            <label for="cashier_name">Cashier/Staff Name:</label>
            <input type="text" id="cashier_name" name="cashier_name" class="form-control" 
                value="<?= htmlspecialchars($res->cashier_name ?? '') ?>" required>

            <label for="contact" style="margin-top: 10px;">Contact (Phone):</label>
            <input type="text" id="contact" name="contact" class="form-control" 
                value="<?= htmlspecialchars($res->contact ?? '') ?>" 
                pattern="\d{11}" title="Contact number must be exactly 11 digits" required>

            <button type="submit" class="btn btn-primary w3-margin-top">Update Receipt</button>
        </form>

        <!-- Print Button -->
        <button type="button" onclick="window.print()" class="btn btn-primary dont-print w3-margin-top" style="float: right;">
            <i class="fa fa-print"></i> Print
        </button>
    </div>
</div>

<?php include 'theme/foot.php'; ?>
