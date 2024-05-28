<?php
ini_set('display_errors', true);
error_reporting(E_ALL);

include './server/koneksi.php';

// Setting untuk pagination
$limit = 8; // jumlah hasil per halaman
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

$search = isset($_GET['search']) ? $_GET['search'] : '';

// Query untuk menghitung total hasil
$countQuery = "SELECT COUNT(*) as total 
               FROM campaign 
               INNER JOIN organizer ON campaign.organizerId = organizer.organizerId";
if (!empty($search)) {
    $countQuery .= " WHERE campaign.title LIKE '%" . $conn->real_escape_string($search) . "%' 
                    OR organizer.organizerName LIKE '%" . $conn->real_escape_string($search) . "%' 
                    OR campaign.location LIKE '%" . $conn->real_escape_string($search) . "%'";
}
$countResult = $conn->query($countQuery);
$totalResults = $countResult->fetch_assoc()['total'];
$totalPages = ceil($totalResults / $limit);

// Query utama dengan limit dan offset
$query = "SELECT campaign.*, organizer.organizerName 
          FROM campaign 
          INNER JOIN organizer ON campaign.organizerId = organizer.organizerId";
if (!empty($search)) {
    $query .= " WHERE campaign.title LIKE '%" . $conn->real_escape_string($search) . "%' 
                OR organizer.organizerName LIKE '%" . $conn->real_escape_string($search) . "%' 
                OR campaign.location LIKE '%" . $conn->real_escape_string($search) . "%'";
}
$query .= " LIMIT $limit OFFSET $offset";

$result = $conn->query($query);

if ($result->num_rows > 0) {
  echo '<div class="card-container">';
  while($row = $result->fetch_assoc()) {
      $imagePath = 'assets/images/campaign/' . $row["banner"];
      echo '<div class="card card-aksi">
              <img src="' . $imagePath . '" alt="' . $row["title"] . '">
              <div class="card-content">                                    
                  <h3>' . $row["title"] . '</h3>
                  <h8>' . $row["organizerName"] . '</h8>                  
                  <div class="card-footer">
                      <div class="loc-date">
                          <img class="campaigns-location-icon" src="../assets/images/pin.png" alt="Location Icon">
                          <p class="campaigns-location">' . $row["location"] . '</p>
                      </div>
                      <div class="loc-date">
                          <img class="campaigns-date-icon" src="../assets/images/calendar.png" alt="Calendar Icon">
                          <p class="campaigns-date">';
                          $day = date("d", strtotime($row['campaignDate']));
                          $month = date("n", strtotime($row['campaignDate']));
                          $year = date("Y", strtotime($row['campaignDate']));
                          $month = convertMonth(1, $month);
                          echo $day . " " . $month . " " . $year;
      echo           '</p>
                      </div>
                  </div>
                  <a href="aksiRelawan.php?campaignId=' . $row["campaignId"] . '" class="buy-now">Daftar</a>
              </div>
            </div>';
  }
  echo '</div>';
  
  // Generate pagination links
  echo '<div class="pagination">';
  for ($i = 1; $i <= $totalPages; $i++) {
      $activeClass = ($i == $page) ? 'active' : '';
      echo '<a class="' . $activeClass . '" href="?page=' . $i . '&search=' . htmlspecialchars($search) . '">' . $i . '</a>';
  }
  echo '</div>';
} else {
  echo '<div class="searchErr"><h2>Tidak ada hasil ditemukan untuk pencarian "' . htmlspecialchars($search) . '"</h2></div>';
}

$conn->close();

function convertMonth($type, $month) {
  $months = [
      1 => "January", 2 => "February", 3 => "March",
      4 => "April", 5 => "May", 6 => "June",
      7 => "July", 8 => "August", 9 => "September",
      10 => "October", 11 => "November", 12 => "December"
  ];
  return $months[$month];
}
?>