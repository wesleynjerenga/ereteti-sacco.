<?php
// post, because it transmits form data securely in the request body rather than exposing it in the URL address bar
$page_title = 'Application received';
include 'includes/header.php';

// the select sends a number; this array turns it back into the route's name
$routes = ['1' => 'Kiserian', '2' => 'Ngong', '3' => 'Rongai'];

echo '<main>';
if (isset($_POST['first_name'])) {
    // the form was sent: read each value by its name
    $first = $_POST['first_name'];
    $last = $_POST['last_name'];
    $phone = $_POST['phone'];
    $route = $routes[$_POST['route']];

    echo '<h2>Thank you, ' . $first . ' ' . $last . '</h2>';
    echo '<p>We have your application to join the ' . $route . ' route.</p>';
    echo '<p>The office will call you on ' . $phone . ' when your member number is ready.</p>';
} else {
    // nothing was sent - the page was opened directly
    echo '<h2>No application</h2>';
    echo '<p>This page answers the membership form. ';
    echo '<a href="register.php">Fill it in first.</a></p>';
}
echo '</main>';

include 'includes/footer.php';
?>
