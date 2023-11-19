export default function renderToolbar() {
  const formContainer = document.querySelector('form');
  fetch(`/components/sections/toolbar.html`)
    .then(response => response.text())
    .then(data => {
      const toolbar = document.createElement('div');
      toolbar.classList.add('toolbar');
      toolbar.innerHTML = data;
      formContainer.appendChild(toolbar);
    })
    .catch(error => {
      console.error('Ocorreu um erro ao carregar o arquivo HTML: ' + error);
    });
}