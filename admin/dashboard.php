<?php 
include "includes/conn.php";

include "authentication.php";
checkLogin();


include "includes/header.php";
include "includes/sidebar.php";
?>

<script src="assets/js/sweetalert2.all.min.js"></script>
<?php
if (isset($_SESSION['logged'])) {
?>
<script type="text/javascript">
const Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
    didOpen: (toast) => {
        toast.addEventListener('mouseenter', Swal.stopTimer)
        toast.addEventListener('mouseleave', Swal.resumeTimer)
    }
});

Toast.fire({
    background: '#53a653',
    color: '#fff',
    icon: '<?php echo $_SESSION['logged_icon']; ?>',
    title: '<?php echo $_SESSION['logged']; ?>'
});
</script>
<?php
    unset($_SESSION['logged']);
}
?>
<main id="main" class="main">

    <div class="pagetitle">
        <h1>Dashboard</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                <li class="breadcrumb-item active">Dashboard</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section dashboard">
        <div class="row">

            <!-- Left side columns -->
            <div class="col-lg-8">
                <div class="row">

                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Reports</h5>
                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                                <?php 
                                $sql = "SELECT id, name FROM resorts";
                                $result = $conn->query($sql);

                                if ($result->num_rows > 0) {
                                    $active = 'active'; // To set the first tab as active
                                    while($row = $result->fetch_assoc()){
                                ?>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link <?= $active; ?>" id="<?= $row['name'];?>-tab"
                                        data-bs-toggle="tab" data-bs-target="#<?= $row['name'];?>" type="button"
                                        role="tab" aria-controls="<?= $row['name'];?>"
                                        aria-selected="true"><?= $row['name'];?></button>
                                </li>
                                <?php
                                        $active = ''; // Reset active for subsequent tabs
                                    }
                                } else {
                                    echo "No Resort Listed";
                                }
                                ?>
                            </ul>

                            <!-- Container for the line chart -->
                            <div id="chartContainer">
                                <?php 
                                $result->data_seek(0); // Reset result set pointer
                                while($row = $result->fetch_assoc()){
                                ?>
                                <div class="tab-pane fade" id="<?= $row['name'];?>" role="tabpanel"
                                    aria-labelledby="<?= $row['name'];?>-tab">
                                    <div id="reportsChart-<?= $row['name']; ?>"></div>
                                </div>
                                <?php
                                }
                                ?>
                            </div>
                        </div>
                    </div>

                    <script>
                    document.addEventListener("DOMContentLoaded", () => {
                        new ApexCharts(document.querySelector("#reportsChart"), {
                            series: [{
                                name: 'Sales',
                                data: [31, 40, 28, 51, 42, 82, 56],
                            }, {
                                name: 'Revenue',
                                data: [11, 32, 45, 32, 34, 52, 41]
                            }, {
                                name: 'Customers',
                                data: [15, 11, 32, 18, 9, 24, 11]
                            }],
                            chart: {
                                height: 350,
                                type: 'area',
                                toolbar: {
                                    show: false
                                },
                            },
                            markers: {
                                size: 4
                            },
                            colors: ['#4154f1', '#2eca6a', '#ff771d'],
                            fill: {
                                type: "gradient",
                                gradient: {
                                    shadeIntensity: 1,
                                    opacityFrom: 0.3,
                                    opacityTo: 0.4,
                                    stops: [0, 90, 100]
                                }
                            },
                            dataLabels: {
                                enabled: false
                            },
                            stroke: {
                                curve: 'smooth',
                                width: 2
                            },
                            xaxis: {
                                type: 'datetime',
                                categories: ["2018-09-19T00:00:00.000Z", "2018-09-19T01:30:00.000Z",
                                    "2018-09-19T02:30:00.000Z", "2018-09-19T03:30:00.000Z",
                                    "2018-09-19T04:30:00.000Z", "2018-09-19T05:30:00.000Z",
                                    "2018-09-19T06:30:00.000Z"
                                ]
                            },
                            tooltip: {
                                x: {
                                    format: 'dd/MM/yy HH:mm'
                                },
                            }
                        }).render();
                    });
                    </script>




                    <!-- Recent Check-ins -->
                    <div class="col-12">
                        <div class="card recent-sales overflow-auto">

                            <div class="filter">
                                <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                    <li class="dropdown-header text-start">
                                        <h6>Filter</h6>
                                    </li>

                                    <li><a class="dropdown-item" href="#">Today</a></li>
                                    <li><a class="dropdown-item" href="#">This Month</a></li>
                                    <li><a class="dropdown-item" href="#">This Year</a></li>
                                </ul>
                            </div>

                            <div class="card-body">
                                <h5 class="card-title">Recent Check-ins <span>| Today</span></h5>


                                <table class="table table-borderless datatable">
                                    <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Guest Name</th>
                                            <th scope="col">Destination</th>
                                            <th scope="col">Type of Stay</th>
                                            <th scope="col">Arrival Date & Time</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        // Get today's date
                                        $current_date = date('Y-m-d');

                                        // Fetch recent check-ins
                                        $sql = "SELECT * FROM `guests` WHERE DATE(`date_created`) = DATE(NOW()) AND `arrival_date_time` IS NOT NULL";
                                        $result = $conn->query($sql);

                                        if ($result->num_rows > 0) {
                                            // Initialize counter
                                            $counter = 1;

                                            // Output data of each row
                                            while ($row = $result->fetch_assoc()) {
                                                echo "<tr>
                                                        <th scope='row'>" . $counter++ . "</th>
                                                        <td>" . htmlspecialchars($row['firstname']) . " " . htmlspecialchars($row['lastname']) . "</td>
                                                        <td>" . htmlspecialchars($row['destination']) . "</td>"
                                                        . ($row['type_of_stay'] == "Over Night Stay" ? "<td><span class='badge bg-success'>" . htmlspecialchars($row['type_of_stay']) . "</span></td>" : "<td><span class='badge bg-warning'>" . htmlspecialchars($row['type_of_stay']) . "</span></td>")
                                                        . "<td>" . htmlspecialchars($row['arrival_date_time']) . "</td>
                                                    </tr>";
                                            }
                                        } else {
                                            echo "<tr><td colspan='6'>No recent check-ins</td></tr>";
                                        }
                                        ?>
                                    </tbody>

                                </table>

                            </div>

                        </div>
                    </div><!-- End Recent Check-ins -->

                </div>
            </div><!-- End Left side columns -->

            <!-- Right side columns -->
            <div class="col-lg-4">

                <!-- Guest Count Chart -->
                <div class="card">
                    <div class="filter">
                        <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                        <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                            <li class="dropdown-header text-start">
                                <h6>Filter</h6>
                            </li>
                            <li><a class="dropdown-item" href="#">Today</a></li>
                            <li><a class="dropdown-item" href="#">This Month</a></li>
                            <li><a class="dropdown-item" href="#">This Year</a></li>
                        </ul>
                    </div>

                    <div class="card-body pb-0">
                        <h5 class="card-title">Guest Count Chart <span>| Today</span></h5>

                        <div id="trafficChart" style="min-height: 400px;" class="echart"></div>

                        <script>
                        document.addEventListener("DOMContentLoaded", () => {
                            // Fetch data from PHP
                            fetch('fetch_guest_data.php')
                                .then(response => response.json())
                                .then(data => {
                                    // Prepare data for chart
                                    const chartData = data.map(item => ({
                                        value: item.guest_count,
                                        name: item.destination
                                    }));

                                    // Initialize ECharts instance
                                    const chart = echarts.init(document.querySelector("#trafficChart"));

                                    // Set options for pie chart
                                    const options = {
                                        tooltip: {
                                            trigger: 'item'
                                        },
                                        legend: {
                                            top: '5%',
                                            left: 'center'
                                        },
                                        series: [{
                                            name: 'Access From',
                                            type: 'pie',
                                            radius: ['40%', '70%'],
                                            avoidLabelOverlap: false,
                                            label: {
                                                show: false,
                                                position: 'center'
                                            },
                                            emphasis: {
                                                label: {
                                                    show: true,
                                                    fontSize: '18',
                                                    fontWeight: 'bold'
                                                }
                                            },
                                            labelLine: {
                                                show: false
                                            },
                                            data: chartData
                                        }]
                                    };

                                    // Set options and render chart
                                    chart.setOption(options);
                                })
                                .catch(error => {
                                    console.error('Error fetching data:', error);
                                });
                        });
                        </script>

                    </div>
                </div><!-- End Guest Count Chart -->



            </div><!-- End Right side columns -->

        </div>
    </section>

</main><!-- End #main -->

<?php 
include "includes/footer.php";
?>