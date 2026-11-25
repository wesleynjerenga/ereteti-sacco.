<?php
require_once 'includes/db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: deliveries.php');
    exit;
}

$member = strtoupper(trim($_POST['member_no'] ?? ''));
$date = $_POST['delivery_date'] ?? '';
$session = $_POST['session'] ?? '';
$litres = $_POST['litres'] ?? '';
$errors = [];

if (!preg_match('/^ER-[0-9]{4}$/', $member)) {
    $errors[] = 'The member number must be ER- and four digits, such as ER-0001.';
}
if (!preg_match('/^[0-9]{4}-[0-9]{2}-[0-9]{2}$/', $date)) {
    $errors[] = 'Choose the date of the delivery.';
}
if ($session !== 'MORNING' && $session !== 'EVENING') {
    $errors[] = 'Choose the morning or the evening session.';
}
if (!is_numeric($litres) || $litres <= 0 || $litres > 60) {
    $errors[] = 'Litres must be more than 0 and at most 60.';
}

if (count($errors) === 0) {
    $stmt = mysqli_prepare($conn, 'SELECT farmer_id FROM farmer WHERE member_no = ?');
    mysqli_stmt_bind_param($stmt, 's', $member);
    mysqli_stmt_execute($stmt);
    $farmer = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));
    if ($farmer === null) {
        $errors[] = 'No farmer has the member number ' . $member . '.';
    }
}

if (count($errors) === 0) {
    $stmt = mysqli_prepare($conn,
        'INSERT INTO milk_delivery (farmer_id, delivery_date, session, litres)
         VALUES (?, ?, ?, ?)');
    mysqli_stmt_bind_param($stmt, 'issd', $farmer['farmer_id'], $date, $session, $litres);
    try {
        mysqli_stmt_execute($stmt);
        header('Location: deliveries.php?date=' . urlencode($date) . '&saved=1');
        exit;
    } catch (mysqli_sql_exception $e) {
        if ($e->getCode() === 1062) {
            $errors[] = $member . ' has already delivered in the '
                . strtolower($session) . ' session on ' . $date . '.';
        } else {
            throw $e;
        }
    }
}

$page_title = 'Delivery not recorded';
include 'includes/header.php';
?>
<main>
<h2>The delivery was not recorded</h2>
<ul>
<?php foreach ($errors as $error) {
    echo '<li>' . htmlspecialchars($error) . '</li>';
} ?>
</ul>
<p><a href="deliveries.php">Back to the deliveries</a></p>
</main>
<?php include 'includes/footer.php'; ?>
