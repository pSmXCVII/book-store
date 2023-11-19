function checkActiveMenu() {
  const menusList = document.querySelectorAll('#menu a');

  menusList?.forEach(menu => {
    const path = window.location.pathname;
    if (path.includes(`/pages/${menu.id}/`) || (path === '/' && menu.id === 'home')) {
      menu.classList.add('active-menu');
    };
  });
}

function renderLayout() {
  const headerContainer = document.querySelector('header');
  const footerContainer = document.querySelector('footer');

  fetch(`/components/sections/header.html`)
    .then(response => response.text())
    .then(data => {
      headerContainer.innerHTML = data;
    })
    .then(() => checkActiveMenu())
    .catch(error => {
      console.error('Ocorreu um erro ao carregar o arquivo HTML: ' + error);
    });

  fetch(`/components/sections/footer.html`)
    .then(response => response.text())
    .then(data => {
      footerContainer.innerHTML = data;
    })
    .then(() => checkActiveMenu())
    .catch(error => {
      console.error('Ocorreu um erro ao carregar o arquivo HTML: ' + error);
    });
}
window.addEventListener('load', renderLayout);