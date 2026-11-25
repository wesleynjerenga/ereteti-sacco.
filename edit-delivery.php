<?php
require_once 'includes/db.php';

$id = (int) ($_POST['delivery_id'] ?? $_GET['id'] ?? 0);
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $litres = $_POST['litres'] ?? '';
    $accepted = isset($_POST['accepted']) ? 1 : 0;
    $date = $_POST['date'] ?? '';

    if (!is_numeric($litres) || $litres <= 0 || $litres > 60) {
        $errors[] = 'Litres must be more than 0 and at most 60.';
    }
    if (count($errors) === 0) {
        $stmt = mysqli_prepare($conn,
            'UPDATE milk_delivery SET litres = ?, accepted = ? WHERE delivery_id = ?');
        mysqli_stmt_bind_param($stmt, 'dii', $litres, $accepted, $id);
        mysqli_stmt_execute($stmt);
        header('Location: deliveries.php?date=' . urlencode($date) . '&updated=1');
        exit;
    }
}

$stmt = mysqli_prepare($conn,
'SELECT d.delivery_id, f.member_no, f.first_name, f.last_name,
d.delivery_date, d.session, d.litres, d.accepted
FROM milk_delivery d
JOIN farmer f ON f.farmer_id = d.farmer_id
WHERE d.delivery_id = ?');
mysqli_stmt_bind_param($stmt, 'i', $id);
mysqli_stmt_execute($stmt);
$delivery = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));

$page_title = 'Edit a delivery';
include 'includes/header.php';
?>
<main>
<?php if ($delivery === null) { ?>
<p>There is no delivery number <?php echo $id; ?>.</p>
<?php } else { ?>
<p><?php echo htmlspecialchars($delivery['member_no'] . ' · ' . $delivery['first_name'] . ' ' . $delivery['last_name']
. ' · ' . $delivery['delivery_date'] . ' · ' . ucfirst(strtolower($delivery['session']))); ?></p>
<?php foreach ($errors as $error) {
    echo '<p class="message">' . htmlspecialchars($error) . '</p>';
} ?>
<form action="edit-delivery.php" method="post">
<input type="hidden" name="delivery_id" value="<?php echo $delivery['delivery_id']; ?>">
<input type="hidden" name="date" value="<?php echo htmlspecialchars($delivery['delivery_date']); ?>">
<label for="litres">Litres</label>
<input type="number" id="litres" name="litres" step="0.01"
value="<?php echo htmlspecialchars($delivery['litres']); ?>" required>
<p id="litres-message" class="message" aria-live="polite"></p>
<label>
<input type="checkbox" name="accepted" value="1"<?php if ($delivery['accepted'] == 1) { echo ' checked'; } ?>>
Accepted
</label>
<button type="submit">Save the change</button>
</form>
<p><a href="deliveries.php?date=<?php echo urlencode($delivery['delivery_date']); ?>">Cancel</a></p>
<?php } ?>
</main>
<?php include 'includes/footer.php'; ?>
