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

    <!-- Form Section -->
    <form method="post" class="w3-margin-bottom dont-print">
      <label>Select Month</label>
      <input type="month" class="form-control" name="month" min="<?= date('Y-m') ?>" value="<?= isset($_POST['month']) ? $_POST['month'] : '' ?>">

      <div class="w3-margin-top">
        <label>Select to Show</label>
        <div style="display: flex; gap: 20px;">
          <div>
            <input type="radio" name="type" value="1" <?php echo (isset($_POST['type']) && $_POST['type'] == 1) ? 'checked' : 'checked'; ?> > In
          </div>
          <div>
            <input type="radio" name="type" value="2" <?php echo (isset($_POST['type']) && $_POST['type'] == 2) ? 'checked' : ''; ?>> Out
          </div>
        </div>
      </div>

      <div style="text-align: right;">
        <button type="submit" class="btn btn-primary w3-margin-top">Show</button>
      </div>
    </form>

    <hr class="dont-print">

    <!-- PHP: History Table -->
    <?php
    if (isset($_POST['month'])) {
      $month = date('m', strtotime($_POST['month']));
      $year = date('Y', strtotime($_POST['month']));
      $type = $_POST['type'];

      echo "<script>window.location.href = '#history'</script>";

      if ($type == 1) {
        echo "<h3 class='w3-margin-bottom'><b>Pig In History</b></h3>";
        include 'inc/pig_in_history.php';
      } else {
        echo "<h3 class='w3-margin-bottom'><b>Pig Out History</b></h3>";
        include 'inc/pig_out_history.php';
      }
    } else {
      echo "<h3 class='w3-margin-bottom'><b>Pig In History</b></h3>";
      include 'inc/pig_in_history.php';
    }
    ?>

    <button type="button" onclick="print()" class="btn btn-primary dont-print w3-margin-top" style="float: right;">
      <i class="fa fa-print"></i> Print
    </button>
  </div>

  <!-- PHP: Fetch Sales Data -->
  <?php 
    function getSold($month, $conn) {
      $year = date('Y');
      $stmt = $conn->query("SELECT SUM(price) AS TOTAL FROM sold WHERE MONTH(date_sold) = '$month' AND YEAR(date_sold) = '$year'");
      if ($stmt->rowCount() > 0) {
        $fetch = $stmt->fetch(PDO::FETCH_OBJ);
        $result = $fetch->TOTAL;
      } else {
        $result = 0;
      }
      return $result;
    }    

    $sales = [];
    for ($i = 1; $i <= 12; $i++) {
      $sales[] = getSold(str_pad($i, 2, "0", STR_PAD_LEFT), $db) ?? 0;
    }
    $total_sales = array_sum($sales);
  ?>

  <!-- Chart.js Script -->
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script>
    var xValues = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
    var yValues = [<?= implode(',', $sales) ?>];

    new Chart("myChart", {
      type: "line", // Specify the chart type as 'line'
      data: {
        labels: xValues,
        datasets: [{
          label: "Monthly Sales",
          fill: false, // Disable filling the area under the line
          borderColor: "#478ef2", // Line color
          backgroundColor: "#478ef2", // Point color
          data: yValues, // Data points
          tension: 0.4 // Smooth curves between points
        }]
      },
      options: {
        responsive: true,
        plugins: {
          title: {
            display: true,
            text: "Annual Sales (<?= number_format($total_sales) ?>)"
          },
          legend: {
            display: true,
            position: "top"
          }
        },
        scales: {
          x: {
            title: {
              display: true,
              text: "Months"
            }
          },
          y: {
            title: {
              display: true,
              text: "Sales (in units)"
            },
            beginAtZero: true // Ensure the y-axis starts at zero
          }
        }
      }
    });
  </script>

  <!-- DataTable Script -->
  <script>
    $(document).ready(function() {
      $("#table").DataTable();
    });
  </script>
</div>

<?php include 'theme/foot.php'; ?>
