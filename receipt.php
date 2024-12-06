<?php include 'setting/system.php'; ?>
<?php include 'theme/head.php'; ?>
<?php include 'theme/sidebar.php'; ?>
<?php include 'session.php'; ?>

<?php 
 if(!$_GET['id'] OR empty($_GET['id']) OR $_GET['id'] == '')
 {
 	header('location: manage-pig.php');

 }else{
 	
 	$pigno = $bname = $b_id = $cname = $c_id = $fname = $f_id = $vname = $v_id =$health = "";
 	$id = (int)$_GET['id'];

    $sold_query = $db->query("SELECT * FROM sold WHERE id = '$id' ");
    $fetch_sold = $sold_query->fetch(PDO::FETCH_OBJ);
    $pig_id = $fetch_sold->pig_id;

 	$query = $db->query("SELECT * FROM pigs WHERE id = '$pig_id' ");
 	$fetchObj = $query->fetchAll(PDO::FETCH_OBJ);

 	foreach($fetchObj as $obj){
		$pid = $obj->id;
       $pigno = $obj->pigno;
	   $b_id = $obj->breed_id;
	   $c_id = $obj->classification_id;
       $f_id = $obj->feed_id;
       $v_id = $obj->vitamins_id;
	   $health = $obj->health_status;
       $arrived = $obj->arrived;

	     $k = $db->query("SELECT * FROM breed WHERE id = '$b_id' ");
		 $k = $db->query("SELECT * FROM classification WHERE id = '$c_id' ");
         $k = $db->query("SELECT * FROM feed WHERE id = '$f_id' ");
         $k = $db->query("SELECT * FROM vitamins WHERE id = '$v_id' ");
       	 $ks = $k->fetchAll(PDO::FETCH_OBJ);
       	 foreach ($ks as $r) {
       	 	$bname = $r->name;
			$cname = $r->name;
            $fname = $r->name;
            $vname = $r->name;
       	 }
 	}
 }

 function countMonths($startDate, $endDate) {
    // Convert string dates to DateTime objects
    $start = new DateTime($startDate);
    $end = new DateTime($endDate);

    // Include end date in the range
    $end->modify('+1 month');

    // Define interval as 1 month
    $interval = new DateInterval('P1M');

    // Generate a date period
    $dateRange = new DatePeriod($start, $interval, $end);

    // Count the number of months in the period
    $months = iterator_count($dateRange) - 1; // Subtract 1 to exclude end date

    return $months;
}

$get = $db->query("SELECT p.weight,p.pigno,s.date_sold,s.reason,s.buyer,s.price,p.id,s.money,p.month FROM sold s LEFT JOIN pigs p ON s.pig_id = p.id WHERE s.id = '$id'");
$res = $get->fetch(PDO::FETCH_OBJ);

// $startDate = $arrived;
// $endDate = $res->date_sold;

?>
<!-- !PAGE CONTENT! -->
<div class="w3-main" style="margin-left:300px;margin-top:43px;">

  <!-- Header -->
  <header class="w3-container dont-print" style="padding-top:22px">
    <h5><b><i class="fa fa-dashboard"></i> Pig Management</b></h5>
  </header>
 
 <?php #include 'inc/data.php'; ?>

<style>
    table, tr , tr td{
        border: 1px solid #000;
    }
</style>
 <div class="w3-container" style="padding-top:22px">
	<?php 
       
    ?>

    <div class="w3-padding text-center" style="border: 1px #000 dashed; position: relative;">
        <img src="img/pig.png" class="w3-circle w3-margin-right" style="width:46px; position: absolute; top: 0; left: 0; margin: 20px;">
        <h4 style="font-weight: bolder;">JSV Piggery</h4>
        <p>Date: <?= date('m-d-Y', strtotime($res->date_sold)) ?></p>
        <p>Buyer: <?= $res->buyer ?></p>
        <table class="w3-table w3-border w3-border-black w3-margin-top">
            <tr>
                <td>PIG NO.</td>
                <th>MONTH</th>
                <td>WEIGHT</td>
                <td>Price Per Kilo</td>
                <td>PRICE</td>
            </tr>
            <tr>
                <td><?= $res->pigno ?></td>
                <td><?= $res->month ?? 0 ?></td>
                <td><?= $res->weight ?></td>
                <td>200</td>
                <td><?= number_format($res->price, 2) ?></td>
            </tr>
        </table>

        <div style="text-align: right; width: 100%;">
            <h4>Total: <?= number_format($res->price) ?></h4>
            <h4>Cash: <?= number_format($res->money) ?></h4>
            <h3>CHANGE: <?= number_format($res->money - $res->price) ?></h3>
        </div>
    </div>
    
    <button type="button" onclick="print()" class="btn btn-primary dont-print w3-margin-top" style="float: right;"><i class="fa fa-print"></i> Print</button>
</div>

</div>

<?php include 'theme/foot.php'; ?>