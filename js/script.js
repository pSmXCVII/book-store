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
    .then(() => {
      const menuIcon = document.querySelector('#hamburguer');
      const navList = document.querySelector('#menu ul');

      menuIcon.addEventListener('click', function () {
        navList.classList.toggle('show');
      });
      checkActiveMenu();
    })
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


function setPageIcon() {
  const htmlHead = document.querySelector('head');
  const icon = document.createElement('link');
  icon.setAttribute('rel', 'icon');
  icon.setAttribute('href', 'https://site-assets.fontawesome.com/releases/v6.4.2/svgs/sharp-regular/book-open.svg');
  htmlHead.appendChild(icon);
}

window.addEventListener('load', setPageIcon);