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

     <!-- Chart Display -->
  <div class="w3-container dont-print" style="padding-top:22px">
    <canvas id="myChart" style="width: 800px; height: 500px; margin-left: 2px; margin-right: auto"></canvas>
  </div>

  <!-- Pie Chart Display with reduced size -->
  <div class="w3-container dont-print" style="padding-top:25px">
      <h3><b>Farm Overview</b></h3>
      <canvas id="pieChart" style="width: 40%; height: 100px; margin-left: auto; margin-right: auto;"></canvas>
  </div>
  

  <?php
  // Fetch data for the pie chart from the database

  // Fetch number of pigs
  $number_of_pigs = $db->query("SELECT COUNT(*) FROM `pigs`")->fetchColumn();
  $number_of_anay = $db->query("SELECT COUNT(*) FROM `pigs` WHERE `type` = 'Sow'")->fetchColumn();
  $feed_data = $db->query("SELECT COUNT(*) FROM `feed`")->fetchColumn();
  $breed_data = $db->query("SELECT COUNT(*) FROM `breed`")->fetchColumn();
  $number_of_classification = $db->query("SELECT COUNT(*) FROM `classification`")->fetchColumn();
  $vitamins_data = $db->query("SELECT COUNT(*) FROM `vitamins`")->fetchColumn();
  $quarantine_data = $db->query("SELECT COUNT(*) FROM `pigs` WHERE status = 'Quarantine'")->fetchColumn();
  $sold_pigs = $db->query("SELECT COUNT(*) FROM `sold`")->fetchColumn();

  // Fetch number of breeds
  $number_of_breeds_query = $db->query("SELECT COUNT(*) FROM `breed`");
  $number_of_breeds = $number_of_breeds_query ? $number_of_breeds_query->fetchColumn() : 0;

  // Create an array to pass to the JavaScript chart
  $pie_data = json_encode([
      "Pigs" => $number_of_pigs,
      "Sows" => $number_of_anay,
      "Breeds" => $number_of_breeds,
      "Classification" => $number_of_classification,
      "Feed" => $feed_data,
      "Vitamins" => $vitamins_data,
      "Quarantine" => $quarantine_data,
      "Sold Pigs" => $sold_pigs
  ]);
  ?>

  <!-- Pie Chart Script -->
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script>
    var pieData = <?php echo $pie_data; ?>;

    var ctx = document.getElementById("pieChart").getContext("2d");
    var myPieChart = new Chart(ctx, {
        type: 'pie',
        data: {
            labels: Object.keys(pieData), // Labels are the keys of the data
            datasets: [{
                label: 'Farm Data Distribution',
                data: Object.values(pieData), // Data is the values of the data
                backgroundColor: [
                    "#FF5733", // Red
                    "#33FF57", // Green
                    "#3357FF", // Blue
                    "#FFD700", // Gold
                    "#FF6347", // Tomato
                    "#8A2BE2", // Blue Violet
                    "#90EE90", // Light Green
                    "###000000"  // Orange 
                ],
                hoverOffset: 4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            layout: {
                padding: 10
            },
            plugins: {
                title: {
                    display: true,
                    text: "Farm Overview"
                },
                legend: {
                    position: 'right',
                    labels: {
                        boxWidth: 10,
                        font: {
                            size: 15
                        }
                    }
                },
                tooltip: {
                    callbacks: {
                        label: function(tooltipItem) {
                            var label = tooltipItem.label || '';
                            if (label) {
                                label += ': ';
                            }
                            label += tooltipItem.raw + ' units';
                            return label;
                        }
                    }
                }
            }
        }
    });
  </script>
<!--  
<?php
// Fetch monthly pig in and out data
$pig_in_data = [];
$pig_out_data = [];
for ($month = 1; $month <= 12; $month++) {
    $month_formatted = str_pad($month, 2, '0', STR_PAD_LEFT);

    // Get pig in data
    $in_count = $db->query("SELECT COUNT(*) FROM `pigs` WHERE MONTH(`arrived`) = '$month_formatted'")->fetchColumn();
    $pig_in_data[] = $in_count;

    // Get pig out data
    $out_count = $db->query("SELECT COUNT(*) 
                             FROM `sold` 
                             WHERE MONTH(`date_sold`) = '$month_formatted'")->fetchColumn();
    $pig_out_data[] = $out_count;
}

// Encode data for JavaScript
$pig_in_data_json = json_encode($pig_in_data);
$pig_out_data_json = json_encode($pig_out_data);
?>

<script>
  var pigInData = <?php echo $pig_in_data_json; ?>;
  var pigOutData = <?php echo $pig_out_data_json; ?>;
  var months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];

  var ctx = document.getElementById("historyChart").getContext("2d");
  var historyChart = new Chart(ctx, {
    type: "bar",
    data: {
      labels: months, // X-axis labels (months)
      datasets: [
        {
          label: "Pig In",
          data: pigInData,
          backgroundColor: "rgba(75, 192, 192, 0.6)", // Light teal
          borderColor: "rgba(75, 192, 192, 1)",
          borderWidth: 1
        },
        {
          label: "Pig Out",
          data: pigOutData,
          backgroundColor: "rgba(255, 99, 132, 0.6)", // Light red
          borderColor: "rgba(255, 99, 132, 1)",
          borderWidth: 1
        }
      ]
    },
    options: {
      responsive: true,
      plugins: {
        title: {
          display: true,
          text: "Pig In and Out History (Monthly)"
        },
        legend: {
          position: 'top'
        }
      },
      scales: {
        y: {
          beginAtZero: true,
          ticks: {
            stepSize: 5 // Adjust as needed based on your data
          }
        }
      }
    }
  });
</script>


      <!-- History Section -->
      <!-- <div class="w3-container" style="padding-top:22px" id="history">
        <h3 class="dont-print"><b>Pig In & Out History</b></h3>

        <form method="post" class="w3-margin-bottom dont-print">
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
                  } else {
                    echo 'checked';
                  }
                ?>> In
              </div>
              <div>
                <input type="radio" name="type" value="2" <?php 
                  if (isset($_POST['month'])) {
                    if ($_POST['type'] == 2) {
                      echo 'checked';
                    }
                  }
                ?>> Out
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
                } else {
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
          } else {
            ?>
            <h3 class="w3-margin-bottom"><b>Pig Out History</b></h3>
            <table class="table table-hover table-bordered"> -->
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
                $get_history_out = $db->query("SELECT p.*, b.name AS breed, s.buyer, s.price AS price_sold, s.money, s.date_sold, s.money FROM pigs p INNER JOIN sold s ON p.id = s.pig_id LEFT JOIN breed b ON p.breed_id = b.id WHERE MONTH(s.date_sold) = '$month'");
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
                } else {
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
            } else {
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

      <?php 
        function getSold($month, $conn){
          $year = date('Y');

          $stmt = $conn->query("SELECT SUM(price) AS TOTAL FROM sold WHERE MONTH(date_sold) = '$month' AND YEAR(date_sold) = '$year'");

          if ($stmt->rowCount() > 0) {
            $fetch = $stmt->fetch(PDO::FETCH_OBJ);
            return $fetch->TOTAL;
          }
          return 0;
        }

        // Monthly sales data
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

        // Total sales
        $total_sales = $jan + $feb + $mar + $apr + $may + $jun + $july + $aug + $sept + $oct + $nov + $dec;
      ?>

      <!-- Chart.js -->
      <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
      <script>
      var xValues = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
      var yValues1 = [<?php echo $jan; ?>, <?php echo $feb; ?>, <?php echo $mar; ?>, <?php echo $apr; ?>, <?php echo $may; ?>, <?php echo $jun; ?>, <?php echo $july; ?>, <?php echo $aug; ?>, <?php echo $sept; ?>, <?php echo $oct; ?>, <?php echo $nov; ?>, <?php echo $dec; ?>];
      var yValues2 = [/* Enter another set of data for the second stacked area, for example */ 100, 200, 300, 400, 500, 600, 700, 800, 900, 1000, 1100, 1200];

      var ctx = document.getElementById("myChart").getContext("2d");

      var myChart = new Chart(ctx, {
        type: "line", // Use line chart to simulate an area chart
        data: {
          labels: xValues, // X-axis labels
          datasets: [{
              label: "Sales (Primary Dataset)", // The first dataset
              data: yValues1, // The first data series
              fill: true, // Fill the area under the line
              backgroundColor: "rgba(71, 142, 242, 0.3)", // Light blue for the first area
              borderColor: "#478ef2", // Blue line color
              borderWidth: 2, // Line width
              pointBackgroundColor: "#478ef2", // Point color
              pointRadius: 3 // Point size
            },
            {
              label: "Sales (Secondary Dataset)", // The second dataset
              data: yValues2, // The second data series
              fill: true, // Fill the area under the line
              backgroundColor: "rgba(144, 238, 144, 0.5)", // Light green for the second area
              borderColor: "#90EE90", // Green line color
              borderWidth: 2, // Line width
              pointBackgroundColor: "#90EE90", // Point color
              pointRadius: 3 // Point size
            }
          ]
        },
        options: {
          responsive: true,
          plugins: {
            title: {
              display: true,
              text: "Monthly Sales Overview"
            }
          },
          scales: {
            y: {
              stacked: true, // Stack the data on the Y-axis
              beginAtZero: true, // Start Y-axis at 0
              ticks: {
                stepSize: 1000 // Set step size for better visualization
              }
            },
            x: {
              stacked: true // Stack the data on the X-axis if necessary
            }
          },
          elements: {
            line: {
              tension: 0.4 // This creates the smooth curve effect
            }
          }
        }
      });
    </script>
    <!-- Additional Chart for Pig In and Out History -->
<div class="w3-container dont-print" style="padding-top:25px">
  <h3><b>Pig In and Out History Overview</b></h3>
  <canvas id="historyChart" style="width: 60%; height: 300px; margin-left: auto; margin-right: auto;"></canvas>
</div>

<?php
// Fetch monthly pig in and out data
$pig_in_data = [];
$pig_out_data = [];
for ($month = 1; $month <= 12; $month++) {
    $month_formatted = str_pad($month, 2, '0', STR_PAD_LEFT);

    // Get pig in data
    $in_count = $db->query("SELECT COUNT(*) FROM `pigs` WHERE MONTH(`arrived`) = '$month_formatted'")->fetchColumn();
    $pig_in_data[] = $in_count;

    // Get pig out data
    $out_count = $db->query("SELECT COUNT(*) 
                             FROM `sold` 
                             WHERE MONTH(`date_sold`) = '$month_formatted'")->fetchColumn();
    $pig_out_data[] = $out_count;
}

// Encode data for JavaScript
$pig_in_data_json = json_encode($pig_in_data);
$pig_out_data_json = json_encode($pig_out_data);
?>

<script>
  var pigInData = <?php echo $pig_in_data_json; ?>;
  var pigOutData = <?php echo $pig_out_data_json; ?>;
  var months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];

  var ctx = document.getElementById("historyChart").getContext("2d");
  var historyChart = new Chart(ctx, {
    type: "bar",
    data: {
      labels: months, // X-axis labels (months)
      datasets: [
        {
          label: "Pig In",
          data: pigInData,
          backgroundColor: "rgba(75, 192, 192, 0.6)", // Light teal
          borderColor: "rgba(75, 192, 192, 1)",
          borderWidth: 1
        },
        {
          label: "Pig Out",
          data: pigOutData,
          backgroundColor: "rgba(255, 99, 132, 0.6)", // Light red
          borderColor: "rgba(255, 99, 132, 1)",
          borderWidth: 1
        }
      ]
    },
    options: {
      responsive: true,
      plugins: {
        title: {
          display: true,
          text: "Pig In and Out History (Monthly)"
        },
        legend: {
          position: 'top'
        }
      },
      scales: {
        y: {
          beginAtZero: true,
          ticks: {
            stepSize: 5 // Adjust as needed based on your data
          }
        }
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
