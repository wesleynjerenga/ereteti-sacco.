<?php
$page_title = 'Deliveries';
include 'includes/header.php';
?>
  <main>
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
      <p id="form-message" class="message" aria-live="polite"></p>
    </form>

    <div class="table-scroll">
      <table id="delivery-table">
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
          <tr>
            <td>ER-0001</td>
            <td>Peter Mwangi</td>
            <td>Morning</td>
            <td>5.38</td>
            <td>Yes</td>
          </tr>
          <tr>
            <td>ER-0001</td>
            <td>Peter Mwangi</td>
            <td>Evening</td>
            <td>4.29</td>
            <td>Yes</td>
          </tr>
          <tr>
            <td>ER-0002</td>
            <td>Grace Wanjiku</td>
            <td>Morning</td>
            <td>4.39</td>
            <td>Yes</td>
          </tr>
          <tr>
            <td>ER-0002</td>
            <td>Grace Wanjiku</td>
            <td>Evening</td>
            <td>3.02</td>
            <td>Yes</td>
          </tr>
          <tr>
            <td>ER-0003</td>
            <td>Joseph Kamau</td>
            <td>Morning</td>
            <td>7.73</td>
            <td>No</td>
          </tr>
          <tr>
            <td>ER-0003</td>
            <td>Joseph Kamau</td>
            <td>Evening</td>
            <td>6.75</td>
            <td>Yes</td>
          </tr>
        </tbody>

        <tfoot>
          <tr>
            <th colspan="4" scope="row">Accepted today</th>
            <td id="accepted-total">23.83</td>
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
