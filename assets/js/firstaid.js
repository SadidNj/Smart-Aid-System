$(document).ready(function(){
  function loadGuides(query){
    $.get('index.php', {action: 'search', q: query}, function(data){
      renderList(data);
    }, 'json');
  }

  function renderList(data){
    let html = '';
    if (!data || data.length === 0) {
      html = "<p>No guides found.</p>";
    } else {
      data.forEach(function(g){
        html += `<div class="guide-card">
          <h3>${escapeHtml(g.title)}</h3>
          <p>${escapeHtml((g.steps && g.steps[0]) ? g.steps[0] : (g.short_description||''))}</p>
          <a href="guides.json" class="read-more" data-id="${g.id}">Read More</a>
        </div>`;
      });
    }
    $('#guideList').html(html);
    $('#guideDetail').hide();
    $('#guideList').show();
  }

  $('#searchInput').on('input', function(){
    const q = $(this).val();
    loadGuides(q);
  });

  $(document).on('click', '.read-more', function(e){
    e.preventDefault();
    const id = $(this).data('id');
    $.get('index.php', {action: 'detail', id: id, ajax: 1}, function(html){
      $('#guideDetail').html(html).show();
      $('#guideList').hide();
    });
  });

  $(document).on('click', '#guideDetail .back-to-list', function(e){
    e.preventDefault();
    $('#guideDetail').hide();
    $('#guideList').show();
  });

  function escapeHtml(text){
    if(!text) return '';
    return String(text).replace(/[&<>"']/g, function(m){ 
      return {'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":"&#39;"}[m]; 
    });
  }

  loadGuides('');
});
