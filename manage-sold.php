<?php include 'setting/system.php'; ?>
<?php include 'theme/head.php'; ?>
<?php include 'theme/sidebar.php'; ?>
<?php include 'session.php'; ?>



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
			<div class="col-md-12">
				<a title="Check to delete from list" data-toggle="modal" data-target="#_removesold" id="delete" class="btn btn-danger"><i class="fa fa-trash"></i>
				</a>
				<form method="post" action="remove_sold.php" class="table-responsive">
					<table class="table table-hover" id="table">
						<thead>
							<tr>
								<th></th>
								<th>Pig No</th>
								<th>Date sold</th>
								<th>Breed</th>
								<th>Classification</th>
								<th>Feed</th>
								<th>Vitamins</th>
								<th>Reason</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
							<?php

							$get = $db->query("SELECT
						s.id,
						s.date_sold,
						s.reason,
						b.name AS breed,
						p.pigno,
						p.id AS pig_id,
						c.name AS classification,
						f.name AS feed,
						v.name AS vitamins
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
					");
							$res = $get->fetchAll(PDO::FETCH_OBJ);
							foreach ($res as $n) { ?>
								<tr>
									<td>
										<input type="checkbox" name="selector[]" value="<?php echo $n->id ?>">
									</td>
									<td> <?php echo $n->pigno; ?> </td>
									<td> <?php echo $n->date_sold; ?> </td>
									<td><?php echo $n->breed; ?> </td>
									<td><?php echo $n->classification; ?> </td>
									<td><?php echo $n->feed; ?> </td>
									<td><?php echo $n->vitamins; ?> </td>
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

					<div id="_removesold" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
						<div class="modal-dialog">

							<div class="modal-content">

								<div class="modal-content">
									<div class="modal-header">
										<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
										<h3 class="modal-title">Remove From Sold List ?</h3>
									</div>

									<div class="modal-body">
										<div class="alert alert-danger">
											<p>Are you sure you want to remove pig from sold list?.</p>
										</div>
									</div>
									<div class="modal-footer">
										<button class="btn" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i> Close</button>
										<button name="remove" class="btn btn-danger"><i class="fa fa-check"></i> Yes</button>
									</div>
								</div>
							</div>
						</div>
				</form>
			</div>
		</div>
	</div>

</div>

<?php include 'theme/foot.php'; ?>