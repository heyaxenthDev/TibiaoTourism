<?php 
include "authentication.php";
checkLogin();

include "includes/conn.php";

include "includes/header.php";
include "includes/sidebar.php";
include "includes/alert.php";
?>
<main id="main" class="main">
    <div class="pagetitle d-flex justify-content-between">
        <h1>Resort Data</h1>
        <div class="d-grid gap-2 d-md-flex">
            <button class="btn btn-primary" data-bs-target="#NewResortData" data-bs-toggle="modal">
                <i class="bi bi-clipboard-plus" data-bs-toggle="tooltip" data-bs-title="Add New Resort Data"></i> New
                Resort Account
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
                        <div class="form-floating mb-3 position-relative">
                            <input type="password" class="form-control" id="password" name="password"
                                placeholder="Resort Password" required>
                            <label for="password">Resort Password</label>
                            <button type="button"
                                class="btn btn-outline-secondary position-absolute top-50 end-0 translate-middle-y me-2"
                                onclick="togglePasswordVisibility()" tabindex="-1">
                                <i class="bi bi-eye" id="toggleIcon"></i>
                            </button>
                        </div>

                        <script>
                        function togglePasswordVisibility() {
                            const passwordInput = document.getElementById("password");
                            const toggleIcon = document.getElementById("toggleIcon");

                            if (passwordInput.type === "password") {
                                passwordInput.type = "text";
                                toggleIcon.classList.remove("bi-eye");
                                toggleIcon.classList.add("bi-eye-slash");
                            } else {
                                passwordInput.type = "password";
                                toggleIcon.classList.remove("bi-eye-slash");
                                toggleIcon.classList.add("bi-eye");
                            }
                        }
                        </script>


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
                        <h5 class="card-title" id="card-title">Resort Accounts</h5>

                        <table id="accountTable" class="table datatable">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Resort Name</th>
                                    <th>Resort Address</th>
                                    <th>Resort Password</th>
                                    <th>Action</th>
                                </tr>
                            </thead>

                            <tbody>

                                <?php 
                                // Fetch appointments from database
                                $sql = "SELECT * FROM resorts";
                                $result = mysqli_query($conn, $sql);
                                $count = 1;
                                while ($row = mysqli_fetch_assoc($result)) {
                                
                            ?>
                                <tr>
                                    <td><?= $count++ ?></td>
                                    <td><?=$row['name']?></td>
                                    <td><?=$row['address']?></td>
                                    <td><?= substr($row['password'], 0, 10) . '...' ?></td>
                                    <td>
                                        <button data-edit-id="<?= $row['id']?>" class="btn btn-sm btn-primary"><i
                                                class="bi bi-pencil-square"></i></button>
                                        <button data-delete-id="<?= $row['id']?>" class="btn btn-sm btn-danger"><i
                                                class="bi bi-trash"></i></button>
                                    </td>
                                </tr>
                                <?php }
                             ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Edit Modal -->
        <div class="modal fade" id="EditResortData" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
            aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="staticBackdropLabel">Edit Resort Data</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="code.php" method="POST">
                        <div class="modal-body p-3">
                            <input type="hidden" name="edit_id" id="edit_id">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="editResortName" name="resort_name"
                                    placeholder="Resort Name" required>
                                <label for="editResortName">Resort Name</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="editResortAddress" name="resort_address"
                                    placeholder="Resort Address" required>
                                <label for="editResortAddress">Resort Address</label>
                            </div>
                            <div class="form-floating mb-3 position-relative">
                                <input type="password" class="form-control" id="editResortPassword" name="password"
                                    placeholder="Resort Password" required>
                                <label for="editResortPassword">Resort Password</label>
                                <button type="button"
                                    class="btn btn-outline-secondary position-absolute top-50 end-0 translate-middle-y me-2"
                                    onclick="toggleEditPasswordVisibility()" tabindex="-1">
                                    <i class="bi bi-eye" id="editToggleIcon"></i>
                                </button>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary" name="EditResort"><i class="bi bi-save"></i>
                                Save
                                Changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div><!-- End Edit Modal -->

        <script>
        $(document).ready(function() {
            $('#accountTable').DataTable();
            // Edit button click handler
            $(document).on('click', '[data-edit-id]', function() {
                var id = $(this).data('edit-id');
                $('#edit_id').val(id);

                // Fetch resort data
                $.ajax({
                    url: 'code.php',
                    type: 'POST',
                    data: {
                        get_resort: true,
                        id: id
                    },
                    success: function(response) {
                        try {
                            var data = JSON.parse(response);
                            $('#editResortName').val(data.name);
                            $('#editResortAddress').val(data.address);
                            $('#editResortPassword').val(data.password);
                            $('#EditResortData').modal('show');
                        } catch (e) {
                            Swal.fire({
                                title: 'Error!',
                                text: 'Error loading resort data.',
                                icon: 'error',
                                confirmButtonText: 'OK'
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        Swal.fire({
                            title: 'Error!',
                            text: 'Error loading resort data.',
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    }
                });
            });

            // Edit form submission
            $('#EditResortData form').on('submit', function(e) {
                e.preventDefault();

                // Get form data
                var formData = {
                    EditResort: true,
                    edit_id: $('#edit_id').val(),
                    resort_name: $('#editResortName').val(),
                    resort_address: $('#editResortAddress').val(),
                    password: $('#editResortPassword').val()
                };

                $.ajax({
                    url: 'code.php',
                    type: 'POST',
                    data: formData,
                    success: function(response) {
                        $('#EditResortData').modal('hide');
                        Swal.fire({
                            title: 'Success!',
                            text: 'Resort data has been updated successfully.',
                            icon: 'success',
                            confirmButtonText: 'OK'
                        }).then((result) => {
                            location.reload();
                        });
                    },
                    error: function(xhr, status, error) {
                        Swal.fire({
                            title: 'Error!',
                            text: 'An error occurred while updating the resort data.',
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    }
                });
            });

            // Delete button click handler
            $(document).on('click', '[data-delete-id]', function() {
                var id = $(this).data('delete-id');

                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: 'code.php',
                            type: 'POST',
                            data: {
                                DeleteResort: true,
                                delete_id: id
                            },
                            success: function(response) {
                                Swal.fire({
                                    title: 'Deleted!',
                                    text: 'Resort data has been deleted successfully.',
                                    icon: 'success',
                                    confirmButtonText: 'OK'
                                }).then((result) => {
                                    location.reload();
                                });
                            },
                            error: function(xhr, status, error) {
                                Swal.fire({
                                    title: 'Error!',
                                    text: 'An error occurred while deleting the resort data.',
                                    icon: 'error',
                                    confirmButtonText: 'OK'
                                });
                            }
                        });
                    }
                });
            });
        });

        function toggleEditPasswordVisibility() {
            const passwordInput = document.getElementById("editResortPassword");
            const toggleIcon = document.getElementById("editToggleIcon");

            if (passwordInput.type === "password") {
                passwordInput.type = "text";
                toggleIcon.classList.remove("bi-eye");
                toggleIcon.classList.add("bi-eye-slash");
            } else {
                passwordInput.type = "password";
                toggleIcon.classList.remove("bi-eye-slash");
                toggleIcon.classList.add("bi-eye");
            }
        }
        </script>
    </section>

</main><!-- End #main -->

<?php 
include "includes/footer.php";
?>