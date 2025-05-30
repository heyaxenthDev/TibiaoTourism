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
                                    <th>Phone</th>
                                    <th>Location</th>
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
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tourist Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <h6>Main Guest Information</h6>
                        <div id="mainGuestInfo" class="border rounded p-3"></div>
                    </div>
                    <div class="col-md-6">
                        <h6>Destinations</h6>
                        <div id="destinationsInfo" class="border rounded p-3"></div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <h6>Tourist List</h6>
                        <div id="touristList" class="border rounded p-3"></div>
                    </div>
                </div>
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
                    console.log(data); // Log the returned data
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
                                item.phone || '',
                                item.destination || '',
                                `<button type='button' class='btn btn-primary btn-sm fetch-tourists' 
                                    data-guest-code='${item.guest_code}'>
                                    <i class='bi bi-download'></i> Fetch Tourists
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
        const button = $(this);

        // Disable button and show loading state
        button.prop('disabled', true).html('<i class="bi bi-arrow-repeat spin"></i> Fetching...');

        // Clear previous data
        $('#mainGuestInfo').html('');
        $('#destinationsInfo').html('');
        $('#touristList').html('');

        // Fetch tourist details
        $.ajax({
            url: 'get_tourist_details.php',
            type: 'POST',
            data: {
                guest_code: guestCode
            },
            success: function(response) {
                try {
                    const data = JSON.parse(response);

                    if (data.status === 'error') {
                        alert(data.message);
                        return;
                    }

                    const guestData = data.data;

                    // Update main guest info
                    let mainGuestHtml = `
                        <p><strong>Name:</strong> ${guestData.main_guest.firstname} ${guestData.main_guest.lastname}</p>
                        <p><strong>Email:</strong> ${guestData.main_guest.email || 'N/A'}</p>
                        <p><strong>Phone:</strong> ${guestData.main_guest.phone || 'N/A'}</p>
                        <p><strong>Arrival:</strong> ${guestData.main_guest.formatted_arrival_time || 'N/A'}</p>
                        <p><strong>Type of Stay:</strong> ${guestData.main_guest.type_of_stay || 'N/A'}</p>
                    `;
                    $('#mainGuestInfo').html(mainGuestHtml);

                    // Update destinations info
                    let destinationsHtml = '<ul class="list-unstyled">';
                    if (guestData.destinations.length > 0) {
                        guestData.destinations.forEach(dest => {
                            destinationsHtml +=
                                `<li><i class="bi bi-geo-alt"></i> ${dest.resort_name || dest.destination}</li>`;
                        });
                    } else {
                        destinationsHtml += '<li>No destinations found</li>';
                    }
                    destinationsHtml += '</ul>';
                    $('#destinationsInfo').html(destinationsHtml);

                    // Update tourist list
                    let touristHtml = '<table class="table table-bordered">';
                    touristHtml += `
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Age</th>
                                <th>Gender</th>
                                <th>Nationality</th>
                            </tr>
                        </thead>
                        <tbody>
                    `;
                    if (guestData.tourists.length > 0) {
                        guestData.tourists.forEach(tourist => {
                            touristHtml += `
                                <tr>
                                    <td>${tourist.firstname} ${tourist.lastname}</td>
                                    <td>${tourist.age || 'N/A'}</td>
                                    <td>${tourist.gender || 'N/A'}</td>
                                    <td>${tourist.nationality || 'N/A'}</td>
                                </tr>
                            `;
                        });
                    } else {
                        touristHtml +=
                            '<tr><td colspan="4" class="text-center">No tourists found</td></tr>';
                    }
                    touristHtml += '</tbody></table>';
                    $('#touristList').html(touristHtml);

                    // Show the modal
                    $('#viewTouristsModal').modal('show');

                } catch (error) {
                    console.error('Error parsing response:', error);
                    alert('Error loading tourist details. Please try again.');
                }
            },
            error: function(xhr, status, error) {
                console.error('Error fetching tourist details:', error);
                alert('Error loading tourist details. Please try again.');
            },
            complete: function() {
                // Re-enable button and restore original state
                button.prop('disabled', false).html(
                    '<i class="bi bi-download"></i> Fetch Tourists');
            }
        });
    });
});
</script>

<?php 
include "includes/footer.php";
?>