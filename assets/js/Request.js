function onTypeChange(){
  var t = document.getElementById('type').value;
  var wrap = document.getElementById('bg-wrap');
  wrap.style.display = (t === 'blood') ? 'block' : 'none';
}
document.addEventListener('DOMContentLoaded', onTypeChange);

function validateRequestForm(){
  var t = document.getElementById('type').value;
  var name = document.getElementById('name').value.trim();
  var details = document.getElementById('details').value.trim();
  if(!t || !name || !details){ alert('Please fill required fields.'); return false; }
  return true;
}
