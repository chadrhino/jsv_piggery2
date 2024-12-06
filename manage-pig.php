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
      <h2>Manage Pigs</h2>
      <!-- <a title="Check to delete from list" onclick="SoldAll()" id="sold" class="btn btn-primary"><i class="fa fa-plus"> Sold All</i> -->
				</a>
      <a href="add-pig.php" class="btn btn-sm btn-primary pull-right"><i class="fa fa-plus"></i> Add New Pig</a><br><br>
      <form method="POST" class="table-responsive">
        <table class="table table-hover table-striped" id="table">
          <thead>
            <tr>
            <!-- <th></th> -->
              <th>S/N</th>
              <th>Photo</th>
              <th>Pig No.</th>
              <th>Breed</th>
              <th>Classification</th>
              <th>Feed</th>
              <th>Vitamins</th>
              <th>Weight</th>
              <th>Price</th>
              <th>Month</th>
              <th>Gender</th>
              <th>Health Status</th>
              <th>Arrived</th>
              <!-- <th>Remark</th> -->
              <th>Desc.</th>
              <th></th>
            </tr>
          </thead>
          <tbody>
            <?php
            $all_pig = $db->query("SELECT p.*,b.name AS breed_name, c.name AS class_name, v.name AS vita_name, f.name AS feed_name  FROM pigs p LEFT JOIN breed b ON p.breed_id = b.id LEFT JOIN vitamins v ON p.vitamins_id = v.id LEFT JOIN classification c ON p.classification_id = c.id LEFT JOIN feed f ON p.feed_id = f.id WHERE p.status = 1 AND p.type IS NULL ORDER BY p.id DESC ");
            $fetch = $all_pig->fetchAll(PDO::FETCH_OBJ);
            foreach ($fetch as $data) {
              // $get_breed = $db->query("SELECT * FROM breed WHERE id = '$data->breed_id'");
              // $breed_result = $get_breed->fetchAll(PDO::FETCH_OBJ);
              // foreach ($breed_result as $breed)
              //   $get_classification = $db->query("SELECT * FROM classification WHERE id = '$data->classification_id'");
              // $classification_result = $get_classification->fetchAll(PDO::FETCH_OBJ);
              // foreach ($classification_result as $classification)
              //   $get_feed = $db->query("SELECT * FROM feed WHERE id = '$data->feed_id'");
              // $feed_result = $get_feed->fetchAll(PDO::FETCH_OBJ);
              // foreach ($feed_result as $feed)
              //   $get_vitamins = $db->query("SELECT * FROM vitamins WHERE id = '$data->vitamins_id'");
              // $vitamins_result = $get_vitamins->fetchAll(PDO::FETCH_OBJ);
              // foreach ($vitamins_result as $vitamins) {
            ?>
                <tr>
                <!-- <td>
										<input type="checkbox" name="selector[]" value="<?php echo $data->id ?>">
									</td> -->
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
                  <td>₱ <?php echo number_format((float)$data->weight * 200) ?></td>
                  <td><?= $data->month ?></td>
                  <td><?php echo $data->gender ?></td>
                  <td><?php echo $data->health_status ?></td>
                  <td><?php echo $data->arrived ?></td>
                  <!-- <td><?php echo wordwrap($data->remark, 300, '<br>'); ?></td> -->
                  <td><?php echo $data->description ?></td>
                  <td>
                    <div class="dropdown">
                      <button class="btn btn-sm btn-default dropdown-toggle" type="button" data-toggle="dropdown"><i class="fa fa-cog"></i> Option
                        <span class="caret"></span></button>
                      <ul class="dropdown-menu dropdown-menu-right">
                        <li><a href="edit-pig.php?id=<?php echo $data->id ?>"><i class="fa fa-edit"></i> Edit</a></li>
                        <li><a onclick="return showDelete(<?= $data->id ?>)"><i class="fa fa-trash"></i> Delete</a></li>
                        <li><a onclick="return showAnay(<?= $data->id ?>, '<?= $data->gender ?>')" style="cursor: pointer;"><i class="fa fa-paper-plane"></i> Sow Pig</a></li>
                        <li><a onclick="return showQuarantine(<?= $data->id ?>)" style="cursor: pointer;"><i class="fa fa-paper-plane"></i> Quarantine Pig</a></li>
                        <li><a onclick="return showSold(<?= $data->id ?>)" style="cursor: pointer;"><i class="fa fa-paper-plane"></i> Sold Pig</a></li>
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
      </form>
    </div>
  </div>


</div>

<script>
  function showSold(x) {
    Swal.fire({
      title: "Do you want to sell this pig?",
      showDenyButton: true,
      confirmButtonText: "Yes",
      denyButtonText: `No`
    }).then((result) => {
      /* Read more about isConfirmed, isDenied below */
      if (result.isConfirmed) {
        window.location.href = "sold.php?id=" + x
      }
    });
  }

  function SoldAll() {
    Swal.fire({
      title: "Do you want to sell all this pig?",
      showDenyButton: true,
      confirmButtonText: "Yes",
      denyButtonText: `No`
    }).then((result) => {
      if (result.isConfirmed) {
        document.forms[0].submit();
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

  function showAnay(x,gender) {
    Swal.fire({
      title: "Is this pig a Sow?",
      showDenyButton: true,
      confirmButtonText: "Yes",
      denyButtonText: `No`
    }).then((result) => {
      /* Read more about isConfirmed, isDenied below */
      if (result.isConfirmed) {
        window.location.href = "manage-pig.php?anay&id=" + x + "&gender=" + gender
      }
    });
  }

  function showDelete(x) {
    Swal.fire({
      title: "Do you want to delete this to pig?",
      showDenyButton: true,
      confirmButtonText: "Yes",
      denyButtonText: `No`
    }).then((result) => {
      /* Read more about isConfirmed, isDenied below */
      if (result.isConfirmed) {
        window.location.href = "delete.php?id=" + x
      }
    });
  }
</script>


<?php 
if (isset($_GET['anay'])) {
  $status = 4;
  $id = $_GET['id'];
  $gender = strtolower($_GET['gender']);
  $type = "sow";

  if ($gender == "female") {
    $stmt = $db->query("UPDATE pigs SET type = '$type' WHERE id = '$id'");
    if ($stmt) {
      $insert = $db->query("INSERT INTO anay SET pig_id = '$id'");
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
  }else{
    ?>
      <script>
          const Toast = Swal.mixin({
                  toast: true,
                  position: "top-end",
                  showConfirmButton: false,
                  timer: 2000,
                  timerProgressBar: true,
                  didOpen: (toast) => {
                    toast.onmouseenter = Swal.stopTimer;
                    toast.onmouseleave = Swal.resumeTimer;
                  }
                });
  
                Toast.fire({
                  icon: "error",
                  title: "Pig must be female"
                }).then(function(){
                  window.location.href = "manage-pig.php"
                });
      </script>
      <?php 
  }

}

include 'theme/foot.php'; ?>