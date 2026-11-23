<?php
require_once 'includes/db.php';          
$page_title = 'Deliveries';
include 'includes/header.php';

// 2 · QUERY — every delivery on one day, with the farmer's number and name
$sql = "SELECT f.member_no, f.first_name, f.last_name, d.session, d.litres, d.accepted
FROM milk_delivery d
JOIN farmer f ON f.farmer_id = d.farmer_id
WHERE d.delivery_date = '2026-10-12'
ORDER BY f.member_no, d.session";
$result = mysqli_query($conn, $sql);
$count = mysqli_num_rows($result);
?>

$count = mysqli_num_rows($result);  ?>

  <main>
 <p><?php echo $count; ?> deliveries on this day.</p>   
   <p><?php echo $count; ?> deliveries on this day.</p> 
    <p>Milk received at the Olepolos centre on the Kiserian route,
    Monday 12 October 2026. Both sessions are listed: the morning
    collection from 6.30am and the evening collection from 4.00pm.</p>

    <!-- Week 8: the clerk's form -->
    <h2>Record a delivery</h2>

    <form id="delivery-form" action="#" method="post">
      <label for="member">Member number</label>
      <input type="text" id="member" name="member_no"
             placeholder="ER-0000" required>
      <p id="member-message" class="message"
         aria-live="polite"></p>

      <label for="session">Session</label>
      <select id="session" name="session" required>
        <option value="">Choose a session</option>
        <option value="MORNING">Morning</option>
        <option value="EVENING">Evening</option>
      </select>

      <label for="litres">Litres</label>
      <input type="number" id="litres" name="litres"
             step="0.01" required>
      <p id="litres-message" class="message"
         aria-live="polite"></p>

      <button type="submit">Record delivery</button>
      <p id="form-message" aria-live="polite"></p>
    </form>

    <div class="table-scroll">
      <table>
        <caption>Milk received, Monday 12 October 2026</caption>

        <thead>
          <tr>
            <th scope="col">Member</th>
            <th scope="col">Farmer</th>
            <th scope="col">Session</th>
            <th scope="col">Litres</th>
            <th scope="col">Accepted</th>
          </tr>
        </thead>

        <tbody>
   <?php
if ($count === 0) {                                                            
// NEW
echo '<tr><td colspan="5">No deliveries recorded on this day.</td></tr>';  // NEW
} else {                                                                       
// 3 · FETCH each row, and 4 · SHOW it as a table row
while ($row = mysqli_fetch_assoc($result)) {
if ($row['accepted'] == 1) {
$accepted = 'Yes';
} else {
$accepted = 'No';
}
echo '<tr>';
echo '<td>' . $row['member_no'] . '</td>';
echo '<td>' . $row['first_name'] . ' ' . $row['last_name'] . '</td>';
echo '<td>' . ucfirst(strtolower($row['session'])) . '</td>';
echo '<td>' . $row['litres'] . '</td>';
echo '<td>' . $accepted . '</td>';
echo '</tr>';
 }
}
?>
        </tbody>

        <tfoot>
          <tr>
            <th colspan="4" scope="row">Accepted today</th>
            <td id="accepted-total"></td>
          </tr>
        </tfoot>
      </table>
    </div>

    <p>Joseph Kamau's morning load failed the alcohol test and was
    rejected, so it is not counted in the day's total. It is still
    listed: a rejected load is recorded, never deleted, because the
    farmer has a right to see what happened to their milk.</p>
  </main>
  
<?php include 'includes/footer.php'; ?>