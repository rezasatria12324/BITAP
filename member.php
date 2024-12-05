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
?>
<!-- Main Content -->
<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <h2 class="mt-4">Member</h2>

    <!-- Form Add Product -->
    <form class="mb-4" method="POST" enctype="multipart/form-data">
        <div class="row">
            <div class="col-md-2 mb-3">
                <label for="id" class="form-label">ID</label>
                <input type="text" class="form-control" id="id" name="id" placeholder="Enter ID member" required>
            </div>
            <div class="col-md-3 mb-3">
                <label for="name" class="form-label">Name Member</label>
                <input type="text" class="form-control" id="name" name="name" placeholder="Enter name member" required>
            </div>
            <div class="col-md-2 mb-3">
                <label for="phone" class="form-label">Phone</label>
                <input type="number" class="form-control" id="phone" name="phone" placeholder="Enter phone number" required>
            </div>
           
            <div class="col-md-2 mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="Enter Email Address" required>
            </div>
            <div class="col-md-2 mb-3">
                <label for="registered" class="form-label">registered</label>
                <input type="date" class="form-control" id="registered" name="registered" placeholder="Enter register date" required>
            </div>

            <div class="col-md-12">
                <button type="submit" class="btn btn-primary" name="add_member">Add Member</button>
            </div>
        </div>
    </form>

    <div class="card">
        <div class="container pt-2">
        <table  class="table table-bordered">
            <thead>
                <tr>
                    <th>Id member</th>
                    <th>Name</th>
                    <th>Phone</th>
                    <th>Email</th>
                    <th>Registered</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>{$row['id']}</td>
                                <td>{$row['name']}</td>
                                <td>{$row['phone']}</td>
                                <td>{$row['email']}</td>
                                <td>{$row['registered']}</td>
                                <td>
                                    <a href='editmember.php?id={$row['id']}' class='btn btn-warning btn-sm'><i class='fas fa-edit'></i> Edit</a>
                                    <a href='deletemember.php?id={$row['id']}' class='btn btn-danger btn-sm' onclick='return confirm(\"Are you sure you want to delete this item?\")'><i class='fas fa-trash'></i> Delete</a>
                                </td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='6'>No members found</td></tr>";
                }
                ?>
            </tbody>
        </table>
        </div>
    </div>
</main>
