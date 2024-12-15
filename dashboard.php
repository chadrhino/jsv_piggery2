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

  <?php 
    // Fetch monthly sales data
    function getSold($month, $conn){
        $year = date('Y');
        $stmt = $conn->query("SELECT SUM(price) AS TOTAL FROM sold WHERE MONTH(date_sold) = '$month' AND YEAR(date_sold) = '$year'");
        if ($stmt->rowCount() > 0) {
            $fetch = $stmt->fetch(PDO::FETCH_OBJ);
            return $fetch->TOTAL ?? 0;
        } else {
            return 0;
        }
    }

    $sales = [
        getSold("01", $db), getSold("02", $db), getSold("03", $db),
        getSold("04", $db), getSold("05", $db), getSold("06", $db),
        getSold("07", $db), getSold("08", $db), getSold("09", $db),
        getSold("10", $db), getSold("11", $db), getSold("12", $db)
    ];
    $total_sales = array_sum($sales);
  ?>

  <div class="w3-container dont-print" style="padding-top:22px">
    <canvas id="myChart" style="width:100%;"></canvas>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script>
    var xValues = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
    var yValues = [<?= implode(',', $sales) ?>]; // Monthly sales data

    // Generate a dataset for each month with distinct styles
    var datasets = xValues.map((month, index) => {
      return {
        label: month,
        fill: false,
        borderColor: getRandomColor(), // Generate a random color for each line
        backgroundColor: getRandomColor(),
        data: yValues.map((val, i) => (i === index ? val : null)), // Only one data point for the corresponding month
        tension: 0.4, // Smooth curve for the "wave" effect
        pointRadius: 5, // Larger points for emphasis
        pointHoverRadius: 8
      };
    });

    new Chart("myChart", {
      type: "line", // Line chart type
      data: {
        labels: xValues, // Months as labels
        datasets: datasets // All datasets for the chart
      },
      options: {
        responsive: true,
        plugins: {
          title: {
            display: true,
            text: "Monthly Sales Wave (<?= number_format($total_sales) ?>)"
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
            beginAtZero: true
          }
        }
      }
    });

    // Function to generate random colors
    function getRandomColor() {
      return `rgba(${Math.floor(Math.random() * 256)}, ${Math.floor(Math.random() * 256)}, ${Math.floor(Math.random() * 256)}, 1)`;
    }
  </script>

</div>

<?php include 'theme/foot.php'; ?>
