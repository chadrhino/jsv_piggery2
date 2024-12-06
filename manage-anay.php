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
      <h2>Manage Sow Pigs</h2>
      <!-- <a href="add-pig.php" class="btn btn-sm btn-primary pull-right"><i class="fa fa-plus"></i> Add New Pig</a><br><br> -->
      <div class="table-responsive">
        <table class="table table-hover table-striped" id="table">
          <thead>
            <tr>
              <th>S/N</th>
              <th>Photo</th>
              <th>Pig No.</th>
              <th>Breed</th>
              <th>Classification</th>
              <th>Feed</th>
              <th>Vitamins</th>
              <th>Weight</th>
              <!-- <th>Price</th> -->
              <th>Month</th>
              <!-- <th>Gender</th> -->
              <th>Health Status</th>
              <th>Arrived</th>
              <!-- <th>Remark</th> -->
              <!-- <th>Desc.</th> -->
              <th></th>
            </tr>
          </thead>
          <tbody>
            <?php
            $all_pig = $db->query("SELECT 
			p.*,b.name AS breed_name,
			c.name AS class_name, 
			v.name AS vita_name, 
			f.name AS feed_name,
			a.date_created  
			FROM 
				pigs p 
			INNER JOIN 
				anay a ON p.id = a.pig_id
			LEFT JOIN
			 	breed b ON p.breed_id = b.id 
			LEFT JOIN
			 	vitamins v ON p.vitamins_id = v.id 
			LEFT JOIN 
				classification c ON p.classification_id = c.id 
			LEFT JOIN 
				feed f ON p.feed_id = f.id 
			WHERE p.type = 'sow' AND p.status = 1 ORDER BY p.id DESC ");
            $fetch = $all_pig->fetchAll(PDO::FETCH_OBJ);
            foreach ($fetch as $data) {
             
            ?>
                <tr>
                  <td><?php echo $data->id ?></td>
                  <td>
                    <img width="70" height="70" src="<?php echo $data->img; ?>" class="img img-responsive thumbnail">
                  </td>
                  <td><?php echo $data->pigno ?></td>
                  <td><?php echo $data->breed_name ?></td>
                  <td><?php echo $data->class_name ?></td>
                  <td><?php echo $data->feed_name ?></td>
                  <td><?php echo $data->vita_name ?></td>
                  <td><?php echo $data->weight ?></td>
                  <!-- <td>₱ <?php echo number_format((int)$data->weight * 200) ?></td> -->
                  <td><?= $data->month ?></td>
                  <!-- <td><?php echo $data->gender ?></td> -->
                  <td><?php echo $data->health_status ?></td>
                  <td><?php echo $data->arrived ?></td>
                  <!-- <td><?php echo wordwrap($data->remark, 300, '<br>'); ?></td> -->
                  <!-- <td><?php echo $data->description ?></td> -->
                  <td>
                    <div class="dropdown">
                      <button class="btn btn-sm btn-default dropdown-toggle" type="button" data-toggle="dropdown"><i class="fa fa-cog"></i> Option
                        <span class="caret"></span></button>
                      <ul class="dropdown-menu dropdown-menu-right">
                        <li><a href="edit-anay.php?id=<?php echo $data->id ?>"><i class="fa fa-edit"></i> Edit</a></li>
                        <li><a onclick="return showDelete(<?= $data->id ?>)"><i class="fa fa-trash"></i> Delete</a></li>
                        <li><a onclick="return showQuarantine(<?= $data->id ?>)" style="cursor: pointer;"><i class="fa fa-paper-plane"></i> Quarantine Pig</a></li>
                      </ul>
                    </div>
                  </td>
                </tr>
            <?php
              }
            // }
            ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>


</div>

<script>

  function showDelete(x) {
    Swal.fire({
      title: "Do you want to delete this to pig?",
      showDenyButton: true,
      confirmButtonText: "Yes",
      denyButtonText: `No`
    }).then((result) => {
      /* Read more about isConfirmed, isDenied below */
      if (result.isConfirmed) {
        window.location.href = "delete-anay.php?id=" + x
      }
    });
  }

  function showQuarantine(x) {
    Swal.fire({
      title: "Do you want to add this to quarantine?",
      showDenyButton: true,
      confirmButtonText: "Yes",
      denyButtonText: `No`
    }).then((result) => {
      /* Read more about isConfirmed, isDenied below */
      if (result.isConfirmed) {
        window.location.href = "quarantine.php?id=" + x
      }
    });
  }
</script>


<?php 
if (isset($_GET['pregnant'])) {
  $status = 4;
  $id = $_GET['id'];

  $stmt = $db->query("UPDATE pigs SET status = $status WHERE id = '$id'");
  if ($stmt) {
    $insert = $db->query("INSERT INTO pregnant SET pig_id = '$id'");
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
								title: "Pig added to anay table"
							}).then(function(){
								window.location.href = "manage-pig.php"
							});
    </script>
    <?php 
  }

}

include 'theme/foot.php'; ?>