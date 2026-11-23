<?php
require_once 'includes/db.php';          // 1 · CONNECT — loads $conn
$page_title = 'Our routes';
include 'includes/header.php';
// 2 · QUERY — ask the database for every route, in order
$sql = "SELECT route_name, collection_centre FROM route ORDER BY route_id";
$result = mysqli_query($conn, $sql);
?>
  <main>
    <label for="route-search">Find a route or a centre</label>
    <input type="search" id="route-search" placeholder="e.g. Ngong">
    <p id="route-count" aria-live="polite"></p>
<?php
// 3 · FETCH the next row, and 4 · SHOW it — once for every row
while ($row = mysqli_fetch_assoc($result)) {
    echo '<section>';
    echo '<h2>' . $row['route_name'] . ' route</h2>';
    echo '<p>Milk is cooled at ' . $row['collection_centre'] . '.</p>';
    echo '</section>';
}
?>
  </main>
<?php include 'includes/footer.php'; ?>