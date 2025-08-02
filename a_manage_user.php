<?php
    include("admin_header.php");
    include('database.php');
    if (isset($_POST['delete']) && isset($_POST['p_id'])) {
        $p_id = $_POST['p_id'];
        $p_id = mysqli_real_escape_string($conn, $p_id);
        $query = "DELETE FROM patient_mast WHERE p_id = '$p_id'";
        $result = mysqli_query($conn, $query);

        if ($result) {
            echo "";
        } else {
            echo "<p>Error deleting patient: " . mysqli_error($conn) . "</p>";
        }
    }
    $query = "SELECT * FROM patient_mast";
    $result = mysqli_query($conn, $query);
?>
<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f4f4f4;
        margin: 0;
        padding: 0;
    }
    section.dashboard {
        margin: 20px;
        padding: 20px;
        background-color: #fff;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }
    h3 {
        color: #2c3e50;
        font-size: 24px;
        margin-bottom: 20px;
    }
    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }
    table, th, td {
        border: 1px solid #ddd;
    }
    th {
        background-color:rgb(121, 187, 230);
        color: white;
        padding: 10px;
        text-align: left;
    }
    td {
        padding: 8px;
        text-align: left;
    }
    td input[type="submit"] {
        background-color: #e74c3c;
        color: white;
        border: none;
        padding: 6px 12px;
        cursor: pointer;
        border-radius: 4px;
        transition: background-color 0.3s ease;
    }
    td input[type="submit"]:hover {
        background-color: #c0392b;
    }
    @media screen and (max-width: 768px) {
        table, th, td {
            font-size: 14px;
        }

        td input[type="submit"] {
            padding: 4px 8px;
        }
    }
</style>
<section class="dashboard">
<h3>Admin | Manage User</h3>
<table border="1">
<thead>
    <tr>
        <th>Patient ID</th>
        <th>Full Name</th>
        <th>Address</th>
        <th>City</th>
        <th>Gender</th>
        <th>Email</th>
        <th>Created At</th>
        <th>Action</th>
    </tr>
</thead>
<tbody>
    <?php
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>
                    <td>{$row['p_id']}</td>            
                    <td>{$row['fullname']}</td>
                    <td>{$row['address']}</td>
                    <td>{$row['city']}</td>
                    <td>{$row['gender']}</td>
                    <td>{$row['email']}</td>
                    <td>{$row['created_at']}</td>
                    <td>
                        <form method='POST' action='' onsubmit='return confirmDelete()' style='display:inline;'>
                            <input type='hidden' name='p_id' value='{$row['p_id']}'>
                            <input type='submit' name='delete' value='Delete'>
                        </form>
                    </td>
                </tr>";
        }
    } else {
        echo "<tr><td colspan='8'>No patients found.</td></tr>";
    }
    ?>
</tbody>
</table>
</section>

<script>
    function confirmDelete() {
        return confirm('Are you sure you want to delete this patient?');
    }
</script>
</body>
</html>
