<?php
include './server/koneksi.php';

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$query = "SELECT * FROM campaign";
$result = $conn->query($query);

if ($result->num_rows > 0) {
  echo '<div class="card-container">';
  while($row = $result->fetch_assoc()) {
      echo '<div class="card">
              <img src="'. $row["banner"].'">
              <div class="card-content">                                    
                  <h3>' . $row["title"] . '</h3>
                  <p>' . $row["description"] . '</p>
                  <div class="card-footer">
                      <span class="date">' . date("d F Y", strtotime($row["campaignDate"])) . '</span>
                      <span class="location">' . $row["location"] . '</span>
                  </div>
                  <button class="buy-now">BUY NOW</button>
              </div>
            </div>';
  }
  echo '</div>';
} else {
  echo "No results found";
}
$conn->close();
?>