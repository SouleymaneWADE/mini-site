const container = document.querySelector('.container');
const inscriptionBtn = document.querySelector('.inscription-btn');
const connexionBtn = document.querySelector('.connexion-btn');

inscriptionBtn.addEventListener('click', () => {
  container.classList.add('active');
});

connexionBtn.addEventListener('click', () => {
  container.classList.remove('active');
});

document.querySelector('.form-box.inscription form').addEventListener('submit', function (e) {
  const password = document.getElementById('password').value;
  const passwordConfirm = document.getElementById('password-confirm').value;

  if (password !== passwordConfirm) {
    e.preventDefault();
    alert('Les mots de passe ne correspondent pas.');
  }
});