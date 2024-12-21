<?php
include "config.php";

if (!isset($_SESSION['role'])) {
    header("Location: login.php");
    exit();
}

$role = $_SESSION['role'];
?>

<?php
// Koneksi ke database
include 'config.php';

// Tambahkan data anggota baru
if (isset($_POST['add_member'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $registered = $_POST['registered'];

    $sql = "INSERT INTO member (id, name, phone, email, registered) VALUES ('$id', '$name', '$phone', '$email', '$registered')";
    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Member added successfully');</script>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Ambil data anggota
$sql = "SELECT * FROM member";
$result = $conn->query($sql);


// Update data anggota
if (isset($_POST['edit_member'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $registered = $_POST['registered'];

    $sql = "UPDATE member SET name = '$name', phone = '$phone', email = '$email', registered = '$registered' WHERE id = '$id'";
    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Member updated successfully');</script>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}


?>



<div id="content">
    <main class="ms-sm-auto px-md-4">
            <div class="row mb-3">
                <div class="card py-3 text-center">
                    <h3 class="fw-bold mb-0" style="color: #0d6efd;">Member Management</h3>
                </div>
            </div>

        <!-- Form Add Member -->
        <div class="card mb-4">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Add Member</h5>
            </div>
            <div class="card-body">
                <form method="POST" enctype="multipart/form-data">
                    <div class="row g-3">
                        <div class="col-md-2">
                            <label for="id" class="form-label">ID</label>
                            <input type="text" class="form-control" id="id" name="id" placeholder="Enter ID member" required>
                        </div>
                        <div class="col-md-3">
                            <label for="name" class="form-label">Name Member</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="Enter name member" required>
                        </div>
                        <div class="col-md-2">
                            <label for="phone" class="form-label">Phone</label>
                            <input type="number" class="form-control" id="phone" name="phone" placeholder="Enter phone number" required>
                        </div>
                        <div class="col-md-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="Enter Email Address" required>
                        </div>
                        <div class="col-md-2">
                            <label for="registered" class="form-label">Registered</label>
                            <input type="date" class="form-control" id="registered" name="registered" required>
                        </div>
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-primary" name="add_member">Add Member</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

<!-- Table to display members -->
<div class="card mb-2">
    <div class="card-header bg-primary text-white">
        <h5 class="mb-0">Member List</h5>
    </div>
    <div class="table-responsive p-3">
        <table id="memberTable" class="table table-striped table-bordered align-middle">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Phone</th>
                    <th>Email</th>
                    <th>Registered</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result->num_rows > 0): ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?= $row['id']; ?></td>
                            <td><?= htmlspecialchars($row['name']); ?></td>
                            <td><?= $row['phone']; ?></td>
                            <td><?= $row['email']; ?></td>
                            <td><?= $row['registered']; ?></td>
                            <td>
                                <button class="btn btn-warning btn-sm editMemberBtn" 
                                    data-id="<?= $row['id']; ?>" 
                                    data-name="<?= htmlspecialchars($row['name']); ?>" 
                                    data-phone="<?= $row['phone']; ?>" 
                                    data-email="<?= $row['email']; ?>" 
                                    data-registered="<?= $row['registered']; ?>" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#editMemberModal">
                                    Edit
                                </button>
                                <a href="delete_member.php?id=<?= $row['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this member?')">Delete</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" class="text-center">No members found</td>
                    </tr>
                <?php endif; ?>
            </tbody>

        </table>
    </div>
</div>
<!-- Modal Edit Member -->
<div class="modal fade" id="editMemberModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Member</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="editMemberId" name="id">
                    <div class="mb-3">
                        <label for="editMemberName" class="form-label">Name</label>
                        <input type="text" class="form-control" id="editMemberName" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="editMemberPhone" class="form-label">Phone</label>
                        <input type="text" class="form-control" id="editMemberPhone" name="phone" required>
                    </div>
                    <div class="mb-3">
                        <label for="editMemberEmail" class="form-label">Email</label>
                        <input type="email" class="form-control" id="editMemberEmail" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="editMemberRegistered" class="form-label">Registered</label>
                        <input type="date" class="form-control" id="editMemberRegistered" name="registered" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" name="edit_member">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

    </main>
</div>

<script>
    $(document).ready(function () {
        $('.table').DataTable({
            "paging": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "language": {
                "paginate": {
                    "previous": "&laquo;",
                    "next": "&raquo;"
                },
                "search": "Search:",
                "lengthMenu": "Display _MENU_ members per page"
            }
        });
    });
</script>

<script>
    // Isi data ke modal edit
    $(document).on('click', '.editMemberBtn', function () {
        const id = $(this).data('id');
        const name = $(this).data('name');
        const phone = $(this).data('phone');
        const email = $(this).data('email');
        const registered = $(this).data('registered');

        $('#editMemberId').val(id);
        $('#editMemberName').val(name);
        $('#editMemberPhone').val(phone);
        $('#editMemberEmail').val(email);
        $('#editMemberRegistered').val(registered);
    });
</script>


<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
