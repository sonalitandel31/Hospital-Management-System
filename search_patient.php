<?php
    include("doctor_header.php");
    include('database.php');
    $searchQuery = '';
    if (isset($_POST['search'])) {
        $searchQuery = mysqli_real_escape_string($conn, $_POST['search_query']);
    }
    $query = "SELECT * FROM patient_detail WHERE p_name LIKE '%$searchQuery%' OR p_email LIKE '%$searchQuery%'";
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
    form {
        margin-bottom: 20px;
    }
    form input[type="text"] {
        padding: 8px;
        font-size: 16px;
        width: 300px;
        margin-right: 10px;
        border: 1px solid #ddd;
        border-radius: 4px;
    }
    form input[type="submit"] {
        padding: 8px 16px;
        background-color: #3498db;
        color: white;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-size: 16px;
    }
    form input[type="submit"]:hover {
        background-color: #2980b9;
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
<h3>Doctor | Search Patient</h3><br>
<form method="POST" action="">
    <input type="text" name="search_query" placeholder="Search by name or email" value="<?php echo $searchQuery; ?>" required>
    <input type="submit" name="search" value="Search">
</form>
<br>
<?php if (isset($_POST['search'])): ?>
    <table border="1">
        <thead>
            <tr>
                <th>Patient ID</th>
                <th>Full Name</th>
                <th>Address</th>
                <th>Gender</th>
                <th>Email</th>
                <th>Creation Date</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>
                            <td>{$row['p_detail_id']}</td>
                            <td>{$row['p_name']}</td>
                            <td>{$row['p_add']}</td>
                            <td>{$row['p_gender']}</td>
                            <td>{$row['p_email']}</td>
                            <td>{$row['created_at']}</td>
                            <td>
                                <a href='view_patient.php?p_detail_id={$row['p_detail_id']}' style='background-color: #3498db; color: white; padding: 6px 12px; text-decoration: none; border-radius: 4px; margin-left: 8px;'>View</a>
                            </td>
                        </tr>";
                }
            } else {
                echo "<tr><td colspan='8'>No patients found.</td></tr>";
            }
            ?>
        </tbody>
    </table>
<?php endif; ?>
</section>
</body>
</html>
