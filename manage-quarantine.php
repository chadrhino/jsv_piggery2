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
 
 <?php #include 'inc/data.php'; ?>

 
 <div class="w3-container" style="padding-top:22px">
	 <div class="w3-row">
	 	<h2>Quarantine List</h2>
	 	<div class="col-md-12">
	 		<a title="Check to delete from list" data-toggle="modal" data-target="#_remove" id="delete"  class="btn btn-danger"><i class="fa fa-trash"></i>
			</a>
	 		<form method="post" action="remove_quarantine.php" class="table-responsive">
	 		<table class="table table-hover" id="table">
	 			<thead>
	 				<tr>
	 					<th></th>
	 					<th>Pig No</th>
	 					<th>Date Start</th>
						 <th>Date End</th>
	 					<th>Breed</th>
						 <th>Classification</th>
						 <th>Feed</th>
						 <th>Vitamins</th>
	 					<th>Reason</th>
	 				</tr>
	 			</thead>
	 			<tbody>
	 				<?php

	 				$get = $db->query("SELECT
						q.id, 
						q.date_q,
						q.date_start,
						q.date_end,
						q.reason,
						b.name AS breed,
						p.pigno,
						c.name AS classification,
						f.name AS feed,
						v.name AS vitamins
					FROM 
						quarantine q 
					LEFT JOIN 
						pigs p ON q.pig_no = p.id 
					LEFT JOIN 
						classification c ON p.classification_id = c.id 
					LEFT JOIN 
						feed f ON p.feed_id = f.id 
					LEFT JOIN 
						vitamins v ON p.vitamins_id = v.id 
					LEFT JOIN 
						breed b ON p.breed_id = b.id 
					WHERE 
						p.status = 2
					");
	 				$res = $get->fetchAll(PDO::FETCH_OBJ);
					$today_date = date('Y-m-d');
	 				foreach($res as $n){ 
						if ($n->date_end == $today_date) {
							$update = $db->query("UPDATE pigs SET status = 1 WHERE id = '$n->pigno'");
							if ($update) {
								$delete = $db->query("DELETE FROM quarantine WHERE id = $n->id");
							}
						}
						
						?>
                         <tr>
                         	<td>
                         		<input type="checkbox" name="selector[]" value="<?php echo $n->id ?>">
                         	</td>
                         	<td> <?php echo $n->pigno; ?> </td>
                         	<td>  <?php echo $n->date_start; ?> </td>
							 <td>  <?php echo $n->date_end; ?> </td>
                         	<td><?php echo $n->breed; ?> </td>
							 <td><?php echo $n->classification; ?> </td>
							 <td><?php echo $n->feed; ?> </td>
							 <td><?php echo $n->vitamins ; ?> </td>
                         	<td> <?php echo $n->reason; ?> </td>
                         </tr> 
	 				<?php }

	 				?>
	 			</tbody>
	 		</table>

	 		<?php include('inc/modal-delete.php'); ?>
	 	</form>
	 	</div>
	 	 </div>
</div>

</div>

<?php include 'theme/foot.php'; ?>