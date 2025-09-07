document.addEventListener('DOMContentLoaded', function(){
  // Mobile nav
  var navToggle = document.getElementById('navToggle');
  var nav = document.getElementById('nav');
  if (navToggle) {
    navToggle.addEventListener('click', function(){
      var expanded = this.getAttribute('aria-expanded') === 'true';
      this.setAttribute('aria-expanded', (!expanded).toString());
      nav.classList.toggle('show');
    });
  }

  // Accordion
  document.querySelectorAll('.acc-item').forEach(function(item){
    var btn = item.querySelector('.acc-trigger');
    btn.addEventListener('click', function(){
      item.classList.toggle('open');
    });
  });
});
