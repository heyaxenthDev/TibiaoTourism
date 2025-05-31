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
        </div>
    </div><!-- End Page Title -->

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
                                    <th>Action</th>
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

<!-- View Tourists Modal -->
<div class="modal fade" id="viewTouristsModal" tabindex="-1">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tourist Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <!-- Main Guest Info -->
                <h6 class="text-primary">Main Guest Information</h6>
                <div class="row mb-3">
                    <div class="col-md-6 mb-2">
                        <label>Guest Code</label>
                        <input type="text" id="viewGuestCode" class="form-control" readonly>
                    </div>
                    <div class="col-md-6 mb-2">
                        <label>Name</label>
                        <input type="text" id="viewMainGuest" class="form-control" readonly>
                    </div>
                    <div class="col-md-6 mb-2">
                        <label>Phone</label>
                        <input type="text" id="viewPhone" class="form-control" readonly>
                    </div>
                    <div class="col-md-6 mb-2">
                        <label>Address</label>
                        <input type="text" id="viewTypeOfStay" class="form-control" readonly>
                    </div>
                    <div class="col-md-6 mb-2">
                        <label>Age</label>
                        <input type="text" id="viewAge" class="form-control" readonly>
                    </div>
                    <div class="col-md-6 mb-2">
                        <label>Arrival Date and Time</label>
                        <input type="text" id="viewArrivalDateTime" class="form-control" readonly>
                    </div>
                </div>

                <!-- Destinations -->
                <h6 class="text-primary mt-4">Destinations</h6>
                <div id="viewDestinations" class="border rounded p-3 mb-3">Loading...</div>

                <!-- Tourist List -->
                <h6 class="text-primary">Additional Guests</h6>
                <div id="viewTouristList" class="border rounded p-3">Loading...</div>

            </div>
        </div>
    </div>
</div>


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
                    var table = $('#resortTable').DataTable();
                    table.clear(); // Clear existing data

                    var table_name = $('#card-title');

                    if (data.length > 0) {
                        // Set the card title to the resort name
                        table_name.text(data[0].name);

                        $.each(data, function(index, item) {
                            table.row.add([
                                index + 1,
                                item.firstname + " " + item.lastname || '',
                                item.formatted_arrival_time || 'N/A',
                                item.email || 'No email',
                                `<button type='button' class='btn btn-primary btn-sm fetch-tourists' 
                                    data-guest-code='${item.guest_code}'>
                                    <i class='bi bi-eye'></i> View Details  
                                </button>`
                            ]).draw(false);
                        });
                    } else {
                        table_name.text('No data available');
                        table.row.add([
                            '', 'No data available', '', '', '', '', ''
                        ]).draw(false);
                    }
                },
                error: function(xhr, status, error) {
                    alert('Error fetching data: ' + xhr.responseText);
                }
            });
        }
    });

    // Handle fetch tourists button click
    $(document).on('click', '.fetch-tourists', function() {
        const guestCode = $(this).data('guest-code');

        fetch(`get_tourist_details.php?code=${guestCode}`)
            .then(response => response.json())
            .then(result => {
                if (result.status !== 'success') {
                    alert('Failed to fetch guest details: ' + result.message);
                    return;
                }

                const data = result.data;

                // Fill fields (main_guest)
                $('#viewGuestCode').val(data.main_guest.guest_code || '');
                $('#viewMainGuest').val(data.main_guest.firstname + ' ' + data.main_guest
                    .lastname || '');
                $('#viewPhone').val(data.main_guest.phone || '');
                $('#viewTypeOfStay').val(data.main_guest.type_of_stay || '');
                $('#viewAge').val(data.main_guest.age || '');
                $('#viewArrivalDateTime').val(data.main_guest.formatted_arrival_time || '');

                // Destinations
                let destinationHtml = '';
                data.destinations.forEach(dest => {
                    destinationHtml += `<p>${dest.resort_name}</p>`;
                });
                $('#viewDestinations').html(destinationHtml || '<p>No destinations</p>');

                // Tourists
                let touristHtml = '';
                data.tourists.forEach(tourist => {
                    touristHtml += `<p>${tourist.firstname} ${tourist.lastname}</p>`;
                });
                $('#viewTouristList').html(touristHtml || '<p>No additional guests</p>');

                // Show modal
                const viewModal = new bootstrap.Modal(document.getElementById('viewTouristsModal'));
                viewModal.show();
            })
            .catch(error => {
                console.error("Fetch error:", error);
                alert("An error occurred while fetching guest details.");
            });
    });
});
</script>

<?php 
include "includes/footer.php";
?>