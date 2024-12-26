<?php include 'setting/system.php'; ?>
<?php include 'theme/head.php'; ?>
<?php include 'theme/sidebar.php'; ?>
<?php include 'session.php'; ?>

<?php
if (!$_GET['id'] or empty($_GET['id']) or $_GET['id'] == '') {
	header('location: manage-pig.php');
} else {

	$pigno = $bname = $b_id = $cname = $c_id = $fname = $f_id = $vname = $v_id = $health = "";
	$id = (int)$_GET['id'];
	$query = $db->query("SELECT * FROM pigs WHERE id = '$id' ");
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

?>
<!-- !PAGE CONTENT! -->
<div class="w3-main" style="margin-left:300px;margin-top:43px;">

	<!-- Header -->
	<header class="w3-container" style="padding-top:22px">
		<h5><b><i class="fa fa-dashboard"></i> Pig Management</b></h5>
	</header>

	<?php #include 'inc/data.php'; 
	?>


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
							<th>Date sold</th>
							<th>Reason</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
						<?php

						$get = $db->query("SELECT p.pigno,s.date_sold,s.reason,s.buyer,s.price,p.id,s.money FROM sold s LEFT JOIN pigs p ON s.pig_id = p.id");
						$res = $get->fetchAll(PDO::FETCH_OBJ);
						foreach ($res as $n) { ?>
							<tr>
								<td> <?php echo $n->pigno; ?> </td>
								<td> <?php echo $n->buyer; ?> </td>
								<td> <?php echo $n->price; ?> </td>
								<td> <?php echo $n->money; ?> </td>
								<td> <?php echo $n->date_sold; ?> </td>
								<td> <?php echo $n->reason; ?> </td>
								<td>
									<a href="receipt.php?id=<?= $n->id ?>" class="btn btn-primary">
										<i class="fa fa-print"> Receipt</i>
									</a>
								</td>
							</tr>
						<?php }

						?>
					</tbody>
				</table>
			</div>

			<div class="col-md-6">

				<?php
				if (isset($_POST['submit'])) {
					$id = $_POST['id'];
					$buyer = $_POST['buyer'];
					$price = $_POST['price'];
					$money = $_POST['money'];
					$n_remark = $_POST['reason'];
					$now = date('Y-m-d');
					$status = 3;


					$n_id = $_GET['id'];

					if ($price > $money) {
				?>
						<script>
							const Toast = Swal.mixin({
								toast: true,
								position: "top-end",
								showConfirmButton: false,
								timer: 3000,
								timerProgressBar: true,
								didOpen: (toast) => {
									toast.onmouseenter = Swal.stopTimer;
									toast.onmouseleave = Swal.resumeTimer;
								}
							});

							Toast.fire({
								icon: "error",
								title: "Error, Cash must not be less than the price"
							});
						</script>
					<?php
					} else {
						$insert_query = $db->query("INSERT INTO sold(pig_id, date_sold, reason, buyer, price, money)VALUES('$id','$now', '$n_remark', '$buyer', '$price', '$money') ");

						$update_pig = $db->query("UPDATE pigs SET status = '$status' WHERE id = '$id'");

						// AMO INI GI PULI 
						// GI KUHA ANG LATEST NA SOLD BALI ANG ATON GI ADD NGA BAG O SA SOLD
						if ($update_pig) {
							$get_sold = $db->query("SELECT * FROM sold ORDER BY id DESC");
							$fetch_sold = $get_sold->fetch(PDO::FETCH_OBJ);

							$new_sold = $fetch_sold->id;
						}

						if ($insert_query) {
							?>
								<script>
									const Toast = Swal.mixin({
										toast: true,
										position: "top-end",
										showConfirmButton: false,
										timer: 1500,
										timerProgressBar: true,
										didOpen: (toast) => {
											toast.onmouseenter = Swal.stopTimer;
											toast.onmouseleave = Swal.resumeTimer;
										}
									});
		
									Toast.fire({
										icon: "success",
										title: "Pig successfully sold"
									}).then(() => {
										window.location.href = "receipt.php?id=<?= $new_sold ?>"
									});
								</script>
							<?php
		
							} else { ?>
		
								<script>
									const Toast = Swal.mixin({
										toast: true,
										position: "top-end",
										showConfirmButton: false,
										timer: 3000,
										timerProgressBar: true,
										didOpen: (toast) => {
											toast.onmouseenter = Swal.stopTimer;
											toast.onmouseleave = Swal.resumeTimer;
										}
									});
		
									Toast.fire({
										icon: "error",
										title: "Error inserting pig data. Please try again"
									});
								</script>
						<?php
							}

					}

				}

				?>


				<form role='form' method="post">

					<input type="hidden" name="id" readonly="on" class="form-control" value="<?php echo $pid; ?>">
					<div class="form-group">
						<label class="control-label">Pig No</label>
						<input type="text" name="pigno" readonly="on" class="form-control" value="<?php echo $pigno; ?>">
					</div>

					<div class="form-group">
						<label class="control-label">Buyer Name</label>
						<input type="text" name="buyer" class="form-control" required>
					</div>

					<div class="form-group">
						<label class="control-label">Price</label>
						<input type="text" name="price" class="form-control" onkeyup="this.value=this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1')" value="<?= $p_price ?>" readonly required>
					</div>

					<div class="form-group">
						<label class="control-label">Cash</label>
						<input type="text" name="money" class="form-control" onkeyup="this.value=this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1')" required>
					</div>

					<div class="form-group">
						<label class="control-label">Reason</label>
						<textarea name="reason" placeholder="Enter reason for sold" class="form-control" value=""></textarea>
					</div>

					<button name="submit" type="submit" class="btn btn-sm  btn-default">Add to list</button>
				</form>
			</div>
		</div>
	</div>

</div>


<?php include 'theme/foot.php'; ?>