// script.js
document.addEventListener('DOMContentLoaded', function () {
  const navToggle = document.getElementById('navToggle');
  const nav = document.getElementById('nav');

  // Toggle menu mobile
  navToggle.addEventListener('click', function () {
    nav.classList.toggle('nav-open');
    if (nav.classList.contains('nav-open')) {
      navToggle.textContent = '✕'; // croix quand ouvert
    } else {
      navToggle.textContent = '☰'; // hamburger quand fermé
    }
  });

  // Fermer le menu quand on clique sur un lien
  document.querySelectorAll('.nav a').forEach(link => {
    link.addEventListener('click', () => {
      nav.classList.remove('nav-open');
      navToggle.textContent = '☰';
    });
  });

  // Année dynamique dans le footer
  document.getElementById('year').textContent = new Date().getFullYear();
});



  // Footer année
  document.getElementById('year').textContent = new Date().getFullYear();

  // Formulaire AJAX
  window.handleForm = function(e){
    e.preventDefault();
    const form = e.target;
    const data = new FormData(form);

    fetch("contact.php", {
      method: "POST",
      body: data
    })
    .then(res => res.text())
    .then(result => {
      if(result.trim() === "success"){
        alert("✅ Merci ! Votre message a bien été envoyé.");
        form.reset();
      } else {
        alert("❌ Erreur : " + result);
      }
    })
    .catch(err => alert("⚠️ Erreur réseau : " + err));
  };

  // Slider avant/après
  const sliders = document.querySelectorAll('.ba-slider');
  sliders.forEach(slider => {
    const wrapper = slider.closest('.ba-wrapper');
    const overlay = wrapper.querySelector('.ba-overlay');
    slider.addEventListener('input', function(){
      overlay.style.width = this.value + "%";
    });
  });

