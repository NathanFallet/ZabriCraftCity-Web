console.clear();
console.log('Loading JS file...');

// Containers
const wrapper = document.getElementById('wrapper');

// Create Element
const createNode = element => {
  return document.createElement(element);
};

// Append Element
const append = (parent, el) => {
  return parent.appendChild(el);
};

// Render Empty State
const emptyState = () => {
  console.log('Empty state loading...');
  const newText = createNode('div');
  newText.classList = 'c-empty-state';
  newText.innerHTML = `
		<svg class="c-empty-state__icon" viewBox="0 0 24 24" width="48" height="48" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round">
			<line x1="12" y1="2" x2="12" y2="6"></line>
			<line x1="12" y1="18" x2="12" y2="22"></line>
			<line x1="4.93" y1="4.93" x2="7.76" y2="7.76"></line>
			<line x1="16.24" y1="16.24" x2="19.07" y2="19.07"></line>
			<line x1="2" y1="12" x2="6" y2="12"></line>
			<line x1="18" y1="12" x2="22" y2="12"></line>
			<line x1="4.93" y1="19.07" x2="7.76" y2="16.24"></line>
			<line x1="16.24" y1="7.76" x2="19.07" y2="4.93"></line>
		</svg>
		<div style="margin-top: 8px;">Loading...</div>
	`;
  append(wrapper, newText);
  setTimeout(() => {
    newText.remove();
  }, 500);
  console.log('Loaded empty state!');
};

// Render leaderboard
const renderList = () => {
  console.log('Fetching list...');
  const url = `https://zabricraftcity.nathanfallet.me/api.php`;
  emptyState();
  fetch(url).
  then(response => {
    return response.json();
  }).
  then(data => {
    console.log('Got response from API!');
    const tableClass = 'c-table';
    let table = createNode('table');
    table.classList = tableClass;
    const tableContainer = document.querySelector(tableClass);
    table.innerHTML = `
			<thead class="c-table__head">
				<tr class="c-table__head-row">
					<th class="c-table__head-cell u-text--center">Place</th>
					<th class="c-table__head-cell">Pseudo</th>
					<th class="c-table__head-cell u-text--right">Emeralds</th>
				</tr>
			</thead>
			<tbody>
			</tbody>
		`;
    const title = createNode('div');
    title.classList = 'c-headline';
    title.innerHTML = `<h4 class="c-headline__title"><small class="u-text--danger">ZabriCraftCity</small><br/>Realtime leaderboard</h4>`;
    append(wrapper, title);
    append(wrapper, table);
    data.forEach(item => {
      const tableBody = table.querySelector('tbody');
      let tr = createNode('tr');
      tr.classList = "c-table__row";
      tr.innerHTML = `
					<td class="c-table__cell c-table__cell--place u-text--center"><span class="c-place">${item.position}</span></td>
					<td class="c-table__cell c-table__cell--name">${item.pseudo}</td>
					<td class="c-table__cell c-table__cell--points u-text--right">${item.emeralds}</td>
				`;

      if (item.position == 1) {
        tr.querySelector('.c-place').classList.add('c-place--first');
      } else if (item.position == 2) {
        tr.querySelector('.c-place').classList.add('c-place--second');
      } else if (item.position == 3) {
        tr.querySelector('.c-place').classList.add('c-place--third');
      }
      append(tableBody, tr);
      console.log('Data rendered!');
    });

  }).
  catch(err => {
    console.log(err);
  });
};

// Theme toggle
document.getElementById('test').addEventListener('click', () => {
  document.documentElement.classList.toggle('theme--dark');
  document.getElementById('test').classList.toggle('c-toggle--active');
});

renderList();

console.log('Finished loading JS file!');
