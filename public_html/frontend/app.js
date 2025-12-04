const api = '/api/items';
const itemsEl = document.getElementById('items');
const form = document.getElementById('addForm');
const input = document.getElementById('textInput');

async function fetchItems() {
  try {
    const res = await fetch(api);
    if (!res.ok) throw new Error('Network response was not ok');
    const data = await res.json();
    render(data);
  } catch (err) {
    console.error('Failed to fetch items', err);
  }
}

function render(list) {
  itemsEl.innerHTML = '';
  list.forEach(item => {
    const li = document.createElement('li');
    const span = document.createElement('span');
    span.textContent = item.text;
    li.appendChild(span);

    const btn = document.createElement('button');
    btn.textContent = 'Delete';
    btn.className = 'delete';
    btn.onclick = async () => {
      try {
        await fetch(`${api}/${item.id}`, { method: 'DELETE' });
        fetchItems();
      } catch (err) {
        console.error('Failed to delete', err);
      }
    };

    li.appendChild(btn);
    itemsEl.appendChild(li);
  });
}

form.addEventListener('submit', async (e) => {
  e.preventDefault();
  const text = input.value.trim();
  if (!text) return;
  try {
    await fetch(api, {
      method: 'POST',
      headers: {'Content-Type': 'application/json'},
      body: JSON.stringify({ text })
    });
    input.value = '';
    fetchItems();
  } catch (err) {
    console.error('Failed to add item', err);
  }
});

// Initial load
fetchItems();

