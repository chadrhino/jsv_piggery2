<?php include 'setting/system.php'; ?>
<?php include 'theme/head.php'; ?>
<?php include 'theme/sidebar.php'; ?>
<?php include 'session.php'; ?>

<!-- !PAGE CONTENT! -->
<div class="w3-main" style="margin-left:300px;margin-top:43px;">

  <!-- Header -->
  <header class="w3-container dont-print" style="padding-top:22px">
    <h5><b><i class="fa fa-dashboard"></i> My Dashboard</b></h5>
  </header>

  <?php include 'inc/data.php'; ?>
  <div class="w3-container dont-print" style="padding-top:22px">
    <canvas id="myChart" style="width:100%;"></canvas>
  </div>

  <div class="w3-container" style="padding-top:22px" id="history">
    <h3 class="dont-print"><b>Pig In & Out History</b></h3>

    <form method="post" class="w3-margin-bottom dont-print" >
      <label>Select Month</label>
      <input type="month" class="form-control" name="month" min="<?= date('Y-m') ?>" value="<?= isset($_POST['month']) ? $_POST['month'] : '' ?>">

      <div class="w3-margin-top">
        <label>Select to Show</label>
        <div style="display: flex; gap: 20px;">
          <div>
            <input type="radio" name="type" value="1" <?php 
              if (isset($_POST['month'])) {
                if ($_POST['type'] == 1) {
                  echo 'checked';
                }
              }else{
                echo 'checked';
              }
            ?> >
            In
          </div>
          <div>
            <input type="radio" name="type" value="2" <?php 
              if (isset($_POST['month'])) {
                if ($_POST['type'] == 2) {
                  echo 'checked';
                }
              }
            ?> >
            Out
          </div>
        </div>
      </div>

      <div style="text-align: right;">
        <button type="submit" class="btn btn-primary w3-margin-top">Show</button>
      </div>
    </form>

    <hr class="dont-print">

    <?php
    if (isset($_POST['month'])) {
      $month = date('m', strtotime($_POST['month']));
      $year = date('Y', strtotime($_POST['month']));
      $type = $_POST['type'];
      ?>
      <script>
        window.location.href = "#history"
      </script>
      <?php 
      if ($type == 1) {
        ?>
       <h3 class="w3-margin-bottom"><b>Pig In History</b></h3>
        <table class="table table-hover table-bordered">
          <thead>
            <th>#</th>
            <th>Pig No.</th>
            <th>Breed</th>
            <th>Weight</th>
            <th>Gender</th>
            <th>Date Arrived</th>
          </thead>
          <tbody>
            <?php
            $i = 1;
            $get_history_enter = $db->query("SELECT p.*, b.name AS breed FROM pigs p LEFT JOIN breed b ON p.breed_id = b.id WHERE MONTH(p.arrived) = '$month'");
            if ($get_history_enter->rowCount() > 0) {
            foreach ($get_history_enter as $entered) {
            ?>
              <tr>
                <td><?= $i++ ?></td>
                <td><?= $entered['pigno'] ?></td>
                <td><?= $entered['breed'] ?></td>
                <td><?= $entered['weight'] ?></td>
                <td><?= $entered['gender'] ?></td>
                <td><?= $entered['arrived'] ?></td>
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
      <?php
      }else{
        ?>
        <h3 class="w3-margin-bottom"><b>Pig Out History</b></h3>
         <table class="table table-hover table-bordered" >
      <thead>
        <th>#</th>
        <th>Pig No.</th>
        <th>Breed</th>
        <th>Weight</th>
        <th>Buyer</th>
        <th>Price</th>
        <th>Cash</th>
        <th>Date Sold</th>
      </thead>
      <tbody>
        <?php
        $i = 1;
        $get_history_out = $db->query("SELECT p.*, b.name AS breed, s.buyer, s.price AS price_sold, s.money, s.date_sold, s.money FROM pigs p INNER JOIN sold s ON p.id = s.pig_id LEFT JOIN breed b ON p.breed_id = b.id WHERE MONTH(s.date_sold) = '$month' ");
        if ($get_history_out->rowCount() > 0) {
        foreach ($get_history_out as $out) {
        ?>
          <tr>
            <td><?= $i++ ?></td>
            <td><?= $out['pigno'] ?></td>
            <td><?= $out['breed'] ?></td>
            <td><?= $out['weight'] ?></td>
            <td><?= $out['buyer'] ?></td>
            <td><?= number_format($out['price_sold']) ?></td>
            <td><?= number_format($out['money']) ?></td>
            <td><?= $out['date_sold'] ?></td>
          </tr>
        <?php
        }
      }else{
        ?>
        <tr>
          <td style="text-align: center;" colspan="8">
            No record found
          </td>
        </tr>
        <?php 
      }
        ?>
      </tbody>
    </table>
				
        <?php
      }

    } else {
    ?>
    <h3 class="w3-margin-bottom"><b>Pig In History</b></h3>
      <table class="table table-hover table-bordered">
        <thead>
          <th>#</th>
          <th>Pig No.</th>
          <th>Breed</th>
          <th>Weight</th>
          <th>Gender</th>
          <th>Date Arrived</th>
        </thead>
        <tbody>
          <?php
          $i = 1;
          $get_history_enter = $db->query("SELECT p.*, b.name AS breed FROM pigs p LEFT JOIN breed b ON p.breed_id = b.id");
          if ($get_history_enter->rowCount() > 0) {
            foreach ($get_history_enter as $entered) {
            ?>
              <tr>
                <td><?= $i++ ?></td>
                <td><?= $entered['pigno'] ?></td>
                <td><?= $entered['breed'] ?></td>
                <td><?= $entered['weight'] ?></td>
                <td><?= $entered['gender'] ?></td>
                <td><?= $entered['arrived'] ?></td>
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
    <?php
    }
    ?>

<button type="button" onclick="print()" class="btn btn-primary dont-print w3-margin-top" style="float: right;"><i class="fa fa-print"></i> Print</button>
  </div>

  <!-- <div class="w3-container" style="padding-top:22px">
    <h3><b>Pig-Out History</b></h3>
    <table id="table" class="table table-hover table-bordered" >
      <thead>
        <th>#</th>
        <th>Pig No.</th>
        <th>Breed</th>
        <th>Weight</th>
        <th>Buyer</th>
        <th>Price</th>
        <th>Cash</th>
        <th>Date Sold</th>
      </thead>
      <tbody>
        <?php
        $i = 1;
        $get_history_out = $db->query("SELECT p.*, b.name AS breed, s.buyer, s.price AS price_sold, s.money, s.date_sold FROM pigs p INNER JOIN sold s ON p.id = s.pig_id LEFT JOIN breed b ON p.breed_id = b.id ");
        foreach ($get_history_out as $out) {
        ?>
          <tr>
            <td><?= $i++ ?></td>
            <td><?= $out['pigno'] ?></td>
            <td><?= $out['breed'] ?></td>
            <td><?= $out['weight'] ?></td>
            <td><?= $out['buyer'] ?></td>
            <td><?= number_format($out['price_sold']) ?></td>
            <td><?= number_format($out['money']) ?></td>
            <td><?= $out['date_sold'] ?></td>
          </tr>
        <?php
        }
        ?>
      </tbody>
    </table>
  </div> -->

  
  <?php 
    function getSold($month, $conn){
      $year = date('Y');

      $stmt = $conn->query("SELECT SUM(price) AS TOTAL FROM sold WHERE MONTH(date_sold) = '$month' AND YEAR(date_sold) = '$year'");
      
      if ($stmt->rowCount() > 0) {
        $fetch = $stmt->fetch(PDO::FETCH_OBJ);
        $result = $fetch->TOTAL;
      }else{
        $result = 0;
      }
      return $result;
    }    

    $jan = getSold("01", $db) ?? 0;
    $feb = getSold("02", $db) ?? 0;
    $mar = getSold("03", $db) ?? 0;
    $apr = getSold("04", $db) ?? 0;
    $may = getSold("05", $db) ?? 0;
    $jun = getSold("06", $db) ?? 0;
    $july = getSold("07", $db) ?? 0;
    $aug = getSold("08", $db) ?? 0;
    $sept = getSold("09", $db) ?? 0;
    $oct = getSold("10", $db) ?? 0;
    $nov = getSold("11", $db) ?? 0;
    $dec = getSold("12", $db) ?? 0;

    $total_sales = $jan + $feb + $mar + $apr + $may + $jun + $july + $aug + $sept + $oct + $nov + $dec;

  ?>


  <script>
    var xValues = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
    var yValues = [<?php echo $jan;  ?>, <?php echo $feb;  ?>, <?php echo $mar;  ?>, <?php echo $apr;  ?>, <?php echo $may;  ?>, <?php echo $jun;  ?>, <?php echo $july;  ?>, <?php echo $aug;  ?>, <?php echo $sept;  ?>, <?php echo $oct;  ?>, <?php echo $nov;  ?>, <?php echo $dec;  ?>];
    // var barColors = ["#478ef2", "#478ef2", "#478ef2", "#478ef2", "#478ef2", "#478ef2", "#478ef2", "#478ef2"];
    

    new Chart("myChart", {
      type: "line",
      data: {
        labels: xValues,
        datasets: [{
          
          borderColor: "#478ef2",
          data: yValues
        }]
      },
      options: {
        legend: {
          display: false
        },
        title: {
          display: true,
          text: "Annual Sales ( <?= number_format($total_sales) ?> )"
        },
        scales: {
      yAxes: [{ticks: {min: 0}}],
    }
      }
    });
  </script>

  <script>
    $(document).ready(function() {
      $("#table").DataTable();
    })
  </script>

</div>


<?php include 'theme/foot.php'; ?>