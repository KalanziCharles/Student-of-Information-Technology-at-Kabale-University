<?php
// Start session to check if the user is logged in
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.html"); // Redirect to login page if not logged in
    exit();
}

// Database connection settings
$servername = "localhost";
$dbname = "cameratdb";  // Database name
$dbusername = "root";                // Database username
$dbpassword = "";                    // Database password

// Create connection
$conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch report data from the database
$sql = "SELECT id, report_name, camera_name, generated_at, report_status, description FROM reports"; // Example query
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Reports - Intelligent Camera Tracking System</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<!-- Navigation Bar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="index.html">Camera Tracking System</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item">
          <a class="nav-link" href="camera.php">Camera</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="alerts.php">Alerts</a>
        </li>
        <li class="nav-item">
          <a class="nav-link active" href="reports.php">Reports</a>
        </li>
      </ul>
    </div>
  </div>
</nav>

<!-- Main Content -->
<div class="container mt-4">
  <h2 class="mb-4">Reports Dashboard</h2>

  <?php if ($result && $result->num_rows > 0): ?>
    <div class="table-responsive">
      <table class="table table-striped">
        <thead>
          <tr>
            <th scope="col">ID</th>
            <th scope="col">Report Name</th>
            <th scope="col">Camera Name</th>
            <th scope="col">Generated At</th>
            <th scope="col">Status</th>
            <th scope="col">Description</th>
          </tr>
        </thead>
        <tbody>
          <?php while($row = $result->fetch_assoc()): ?>
            <tr>
              <td><?php echo htmlspecialchars($row['id']); ?></td>
              <td><?php echo htmlspecialchars($row['report_name']); ?></td>
              <td><?php echo htmlspecialchars($row['camera_name']); ?></td>
              <td><?php echo htmlspecialchars($row['generated_at']); ?></td>
              <td><?php echo htmlspecialchars($row['report_status']); ?></td>
              <td><?php echo htmlspecialchars($row['description']); ?></td>
            </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    </div>
  <?php else: ?>
    <p>No reports available.</p>
  <?php endif; ?>

  <?php
  // Close database connection
  $conn->close();
  ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

