<?php
require_once 'includes/db.php';
$page_title = 'Deliveries';
include 'includes/header.php';

$date = $_GET['date'] ?? '2026-10-12';
$stmt = mysqli_prepare($conn,
"SELECT d.delivery_id, f.member_no, f.first_name, f.last_name,
d.session, d.litres, d.accepted
FROM milk_delivery d
JOIN farmer f ON f.farmer_id = d.farmer_id
WHERE d.delivery_date = ?
ORDER BY f.member_no, d.session");
mysqli_stmt_bind_param($stmt, 's', $date);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$count = mysqli_num_rows($result);
?>
<main>
<?php
if (isset($_GET['saved'])) { echo '<p class="success">The delivery was recorded.</p>'; }
if (isset($_GET['updated'])) { echo '<p class="success">The delivery was updated.</p>'; }
if (isset($_GET['deleted'])) { echo '<p class="success">The delivery was deleted.</p>'; }
?>
<form action="deliveries.php" method="get">
<label for="date">Show the deliveries on</label>
<input type="date" id="date" name="date" value="<?php echo htmlspecialchars($date); ?>">
<button type="submit">Show</button>
</form>
<p><?php echo $count; ?> deliveries on this day.</p>
<h2>Record a delivery</h2>
<form id="delivery-form" action="process-delivery.php" method="post">
<label for="member">Member number</label>
<input type="text" id="member" name="member_no" placeholder="ER-0000" required>
<p id="member-message" class="message" aria-live="polite"></p>
<label for="delivery-date">Date</label>
<input type="date" id="delivery-date" name="delivery_date" value="<?php echo htmlspecialchars($date); ?>" required>
<label for="session">Session</label>
<select id="session" name="session" required>
<option value="">Choose a session</option>
<option value="MORNING">Morning</option>
<option value="EVENING">Evening</option>
</select>
<label for="litres">Litres</label>
<input type="number" id="litres" name="litres" step="0.01" required>
<p id="litres-message" class="message" aria-live="polite"></p>
<button type="submit">Record delivery</button>
<p id="form-message" aria-live="polite"></p>
</form>
<div class="table-scroll">
<table id="delivery-table">
<caption>Milk received on <?php echo htmlspecialchars($date); ?></caption>
<thead><tr>
<th scope="col">Member</th><th scope="col">Farmer</th><th scope="col">Session</th>
<th scope="col">Litres</th><th scope="col">Accepted</th><th scope="col">Change</th>
</tr></thead>
<tbody>
<?php
if ($count === 0) {
    echo '<tr><td colspan="6">No deliveries recorded on this day.</td></tr>';
} else {
    while ($row = mysqli_fetch_assoc($result)) {
        $accepted = $row['accepted'] == 1 ? 'Yes' : 'No';
        $id = $row['delivery_id'];
        echo '<tr>';
        echo '<td>' . htmlspecialchars($row['member_no']) . '</td>';
        echo '<td>' . htmlspecialchars($row['first_name'] . ' ' . $row['last_name']) . '</td>';
        echo '<td>' . ucfirst(strtolower($row['session'])) . '</td>';
        echo '<td>' . htmlspecialchars($row['litres']) . '</td>';
        echo '<td>' . $accepted . '</td>';
        echo '<td><a href="edit-delivery.php?id=' . $id . '">Edit</a>';
        echo ' <form action="delete-delivery.php" method="post" class="inline">';
        echo '<input type="hidden" name="delivery_id" value="' . $id . '">';
        echo '<input type="hidden" name="date" value="' . htmlspecialchars($date) . '">';
        echo '<button type="submit">Delete</button></form></td>';
        echo '</tr>';
    }
}
?>
</tbody>
<tfoot><tr><th colspan="4" scope="row">Accepted today</th><td id="accepted-total"></td><td></td></tr></tfoot>
</table>
</div>
<p>A load rejected on quality is recorded, never deleted: edit it to Accepted: No. Delete is for a delivery keyed by mistake.</p>
</main>
<?php include 'includes/footer.php'; ?>
