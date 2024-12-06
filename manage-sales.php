<?php include 'setting/system.php'; ?>
<?php include 'theme/head.php'; ?>
<?php include 'theme/sidebar.php'; ?>
<?php include 'session.php'; ?>



<!-- !PAGE CONTENT! -->
<div class="w3-main" style="margin-left:300px;margin-top:43px;">

	<!-- Header -->
	<header class="w3-container dont-print" style="padding-top:22px">
		<h5><b><i class="fa fa-dashboard"></i> Pig Management</b></h5>
	</header>

	<?php #include 'inc/data.php'; 
	?>


	<div class="w3-container" style="padding-top:22px">
		<div class="w3-row">
			<h2 class="dont-print">Sales</h2>
			<hr>
			<div class="col-12 w3-margin-bottom dont-print">
				<form action="" method="post">
					<label>Select Month</label>
					<input type="month" class="form-control" name="month">
					<div style="text-align: right;">
						<button type="submit" class="btn btn-primary w3-margin-top">Show</button>
					</div>
				</form>
			</div>

			<hr>

			<div class="col-md-12">

				<?php if(isset($_POST['month'])): ?>
					<h3>Sales for <?= date('F', strtotime($_POST['month'])) ?></h3>
				<?php endif; ?>

				<table class="table table-hover" >
					<thead>
						<tr>
							<th>Pig No</th>
							<th>Reason</th>
							<th>Buyer</th>
							<th>Price</th>
							<th>Cash</th>
							<th>Feed</th>
							<th>Date sold</th>
						</tr>
					</thead>
					<tbody>
						<?php
						$price_array = [];

						if (isset($_POST['month'])) {

							

							$month = date('m', strtotime($_POST['month']));
							$year = date('Y', strtotime($_POST['month']));
							$get = $db->query("SELECT
						s.id,
						s.date_sold,
						s.reason,
						b.name AS breed,
						p.pigno,
						p.id AS pig_id,
						c.name AS classification,
						f.name AS feed,
						v.name AS vitamins,
						s.price,
						s.buyer,
						s.money
					FROM 
						sold s
					LEFT JOIN 
						pigs p ON s.pig_id = p.id 
					LEFT JOIN 
						classification c ON p.classification_id = c.id 
					LEFT JOIN 
						feed f ON p.feed_id = f.id 
					LEFT JOIN 
						vitamins v ON p.vitamins_id = v.id 
					LEFT JOIN 
						breed b ON p.breed_id = b.id 
					WHERE 
						p.status = 3 
						AND MONTH(s.date_sold) = '$month' 
						AND YEAR(s.date_sold) = '$year' 
					");
							$res = $get->fetchAll(PDO::FETCH_OBJ);
							if (count($res) > 0) {
								foreach ($res as $n) {
									?>
											<tr>
												
												<td> <?php echo $n->pigno; ?> </td>
												<td> <?php echo $n->reason; ?> </td>
												<td> <?php echo $n->buyer; ?> </td>
												<td><?php echo number_format($n->price); ?> </td>
												<td><?php echo number_format($n->money); ?> </td>
												<td><?php echo number_format($n->price - $n->money); ?> </td>
												<td><?php echo $n->date_sold; ?> </td>
												
											</tr>
									<?php
										$price_array[] = $n->price;
										}
							}else{
								?>
								<tr>
									<td style="text-align: center;" colspan="7">
										No record found
									</td>
								</tr>
								<?php 
							}
						}else{
							?>
								<tr>
									<td style="text-align: center;" colspan="7">
										No record found
									</td>
								</tr>
								<?php 
							
						}
						?>
					</tbody>
				</table>

				<h4 style="text-align: right;">Total: <?= number_format(array_sum($price_array), 2) ?></h4>
				<button type="button" onclick="print()" class="btn btn-primary dont-print w3-margin-top" style="float: right;"><i class="fa fa-print"></i> Print</button>
			</div>
			
		</div>
	</div>

</div>

<?php include 'theme/foot.php'; ?>