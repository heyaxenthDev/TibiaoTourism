<?php 
// include "includes/conn.php";

include "authentication.php";
checkLogin();

include "includes/header.php";
include "includes/sidebar.php";
include "includes/alert.php";
?>
<main id="main" class="main">
    <div class="pagetitle d-flex justify-content-between">
        <h1>Resort Data</h1>
        <div class="d-grid gap-2 d-md-flex">
            <select name="resort" id="resort" class="form-select" aria-label="Default select example">
                <option selected value="">Select Resort Data</option>
                <?php
                    // Query to fetch resort data
                    $sql = "SELECT id, name FROM resorts";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        // Output data of each row
                        while ($row = $result->fetch_assoc()) {
                            echo '<option value="' . htmlspecialchars($row['id']) . '">' . htmlspecialchars($row['name']) . '</option>';
                        }
                    } else {
                        echo '<option value="">No resorts available</option>';
                    }
                ?>
            </select>

            <button class="btn btn-primary" data-bs-target="#NewResortData" data-bs-toggle="modal">
                <i class="bi bi-clipboard-plus" data-bs-toggle="tooltip" data-bs-title="Add New Resort Data"></i>
            </button>
        </div>
    </div><!-- End Page Title -->

    <!-- Modal -->
    <div class="modal fade" id="NewResortData" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Add New Resort Data</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="code.php" method="POST">
                    <div class="modal-body p-3">
                        <img src="assets/img/undraw_destination_re_sr74.svg" class="img-fluid mb-3" alt="">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="floatingResortName" name="resort_name"
                                placeholder="Resort Name" required>
                            <label for="floatingResortName">Resort Name</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="floatingResortAddress" name="resort_address"
                                placeholder="Resort Address" required>
                            <label for="floatingResortAddress">Resort Address</label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" name="NewResort">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title" id="card-title">Resort Name</h5>

                        <table id="resortTable" class="table datatable">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Arrival Date</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Location</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </section>
</main><!-- End #main -->

<script>
$(document).ready(function() {
    // Initialize DataTables
    $('#resortTable').DataTable();

    // Load data into DataTables on resort change
    $('#resort').change(function() {
        var resortId = $(this).val();
        if (resortId !== '') {
            $.ajax({
                url: 'get_resort_data.php',
                type: 'POST',
                data: {
                    resort_id: resortId
                },
                success: function(response) {
                    var data = JSON.parse(response);
                    console.log(data); // Log the returned data
                    var table = $('#resortTable').DataTable();
                    table.clear(); // Clear existing data

                    if (data.length > 0) {
                        $.each(data, function(index, item) {
                            table.row.add([
                                index + 1,
                                item.firstname + " " + item.lastname || '',
                                item.arrival_date_time || 'N/A',
                                item.email || 'No email',
                                item.phone || '',
                                item.destination || '',
                            ]).draw(false);
                        });
                    } else {
                        table.row.add([
                            '', 'No data available', '', '', '', '', ''
                        ]).draw(false);
                    }
                },
                error: function() {
                    alert('Error fetching data');
                }
            });
        }
    });
});
</script>

<?php 
include "includes/footer.php";
?>