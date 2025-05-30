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
        <h1>Resort Data of <?= $_SESSION['resort_name'] ?></h1>
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
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $sql = "SELECT g.id, g.firstname, g.lastname, DATE_FORMAT(g.arrival_date_time, '%M %d, %Y %h:%i %p') AS formatted_arrival_time, d.destination, g.email, g.phone, r.name, g.guest_code
                                FROM guests g 
                                JOIN guest_destinations d ON d.guest_code = g.guest_code
                                JOIN resorts r ON d.destination = r.name
                                WHERE r.id = ?";

                                $stmt = $conn->prepare($sql);
                                $stmt->bind_param('i', $_SESSION['resort_id']);
                                $stmt->execute();
                                $result = $stmt->get_result();

                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        echo "<tr>";
                                        echo "<td>" . $row['id'] . "</td>";
                                        echo "<td>" . $row['firstname'] . " " . $row['lastname'] . "</td>";
                                        echo "<td>" . $row['formatted_arrival_time'] . "</td>";
                                        echo "<td>" . $row['email'] . "</td>";
                                        echo "<td>" . $row['phone'] . "</td>";
                                        echo "<td>
                                            <button type='button' class='btn btn-primary btn-sm fetch-tourists' 
                                                data-guest-code='" . $row['guest_code'] . "'>
                                                <i class='bi bi-download'></i> Fetch Tourists
                                            </button>
                                        </td>";
                                        echo "</tr>";
                                    }
                                }
                                ?>
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
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tourist Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <h6>Main Guest Information</h6>
                        <div id="mainGuestInfo"></div>
                    </div>
                    <div class="col-md-6">
                        <h6>Destinations</h6>
                        <div id="destinationsInfo"></div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <h6>Tourist List</h6>
                        <div id="touristList"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    // Initialize DataTable
    $('#resortTable').DataTable();

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