<ul id="news-list"></ul>

<script>
fetch('/api/news')
  .then(res => res.json())
  .then(data => {
      const list = document.getElementById('news-list');
      data.forEach(n => {
          const li = document.createElement('li');
          li.innerHTML = `<a href="${n.url}" target="_blank">${n.title}</a> (${new Date(n.published_at).toLocaleString()})`;
          list.appendChild(li);
      });
  });
</script>
