const litres = document.querySelector('#litres');
const litresMessage = document.querySelector('#litres-message');
const member = document.querySelector('#member');
const memberMessage = document.querySelector('#member-message');
const form = document.querySelector('#delivery-form');
const formMessage = document.querySelector('#form-message');
const routeSearch = document.querySelector('#route-search');
const routeCards = document.querySelectorAll('.route-card');
const acceptedTotal = document.querySelector('#accepted-total');
const acceptedRows = document.querySelectorAll('#delivery-table tbody tr');
const memberShape = /^ER-[0-9]{4}$/;

function checkLitres() {
  if (!litres || !litresMessage) {
    return;
  }

  const amount = Number(litres.value);

  if (litres.value === '') {
    litresMessage.textContent = '';
    litres.classList.remove('invalid');
  } else if (amount <= 0) {
    litresMessage.textContent = 'Litres must be more than 0.';
    litres.classList.add('invalid');
  } else if (amount > 60) {
    litresMessage.textContent = 'Over 60 litres in one session. Check the reading.';
    litres.classList.add('invalid');
  } else {
    litresMessage.textContent = '';
    litres.classList.remove('invalid');
  }
}

if (litres && litresMessage) {
  litres.addEventListener('input', checkLitres);
}

function checkMember() {
  if (!member || !memberMessage) {
    return;
  }

  const typed = member.value.trim().toUpperCase();
  member.value = typed;

  if (memberShape.test(typed)) {
    memberMessage.textContent = '';
    member.classList.remove('invalid');
  } else {
    memberMessage.textContent = 'A member number looks like ER-0001.';
    member.classList.add('invalid');
  }
}

if (member && memberMessage) {
  member.addEventListener('blur', checkMember);
}

function recordDelivery(event) {
  checkMember();
  checkLitres();

  if (member.classList.contains('invalid')) {
    event.preventDefault();
    member.focus();
  } else if (litres.classList.contains('invalid')) {
    event.preventDefault();
    litres.focus();
  }
}

if (form) {
  form.addEventListener('submit', recordDelivery);
}

function filterRoutes() {
  if (!routeSearch) {
    return;
  }

  const searchTerm = routeSearch.value.trim().toLowerCase();

  routeCards.forEach((routeCard) => {
    const routeText = routeCard.textContent.toLowerCase();
    const matches = routeText.includes(searchTerm);
    routeCard.hidden = !matches;
  });
}

if (routeSearch) {
  routeSearch.addEventListener('input', filterRoutes);
}

function updateAcceptedTotal() {
  if (!acceptedTotal || acceptedRows.length === 0) {
    return;
  }

  let total = 0;

  acceptedRows.forEach((row) => {
    const litresCell = row.cells[3];

    if (row.cells.length > 4 && row.cells[4].textContent.trim() === 'Yes' && litresCell) {
      const litresValue = Number(litresCell.textContent.trim());
      if (!Number.isNaN(litresValue)) {
        total += litresValue;
      }
    }
  });

  acceptedTotal.textContent = total.toFixed(2);
}

if (acceptedTotal) {
  updateAcceptedTotal();
}