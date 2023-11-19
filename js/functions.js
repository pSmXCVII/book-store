import { deleteItem } from "/assets/api.js";

const entity = location.pathname.toString().replace('/pages/', '').replace('/', '');

export function showDialog({ title, message }, actions) {
  const body = document.querySelector('body');
  const dialogBackdrop = document.createElement('div');
  dialogBackdrop.classList.add('dialog-backdrop');
  const dialogContainer = document.createElement('div');
  dialogContainer.classList.add('dialog-container');
  dialogContainer.innerHTML = `
    <header class="header"><h3 class="title">${title}</h3></header>
    <div class="dialog-content">
      ${message}
    </div>
  `;

  const dialogFooter = document.createElement('footer');
  if (actions) {
    dialogFooter.classList.add('dialog-footer');
    actions.forEach(action => {
      const button = document.createElement('button');
      button.classList.add('button');
      button.innerText = action.label;
      if (action.onclick) {
        button.onclick = () => {
          action.onclick();
          dialogBackdrop.remove();
        }
      } else {
        button.onclick = () => dialogBackdrop.remove();
      }
      if (action.variant) {
        button.classList.add(action.variant);
      }
      dialogFooter.appendChild(button);
    });
  } else {
    const button = document.createElement('button');
    button.classList.add('button');
    button.classList.add('danger');
    button.innerText = 'Fechar';
    button.onclick = () => dialogBackdrop.remove();
    dialogFooter.appendChild(button);
  }


  body.appendChild(dialogBackdrop);
  dialogBackdrop.appendChild(dialogContainer)
  dialogContainer.appendChild(dialogFooter);
};

export function createCard(item, listContainer, showOptions) {
  const cardContainer = document.createElement('div');
  const deleteButton = document.createElement('button');
  deleteButton.classList.add('button');
  deleteButton.classList.add('danger');
  deleteButton.setAttribute('data-id', item?.id);
  deleteButton.innerText = 'Excluir'
  deleteButton.addEventListener('click', onDeleteItem)

  const editButton = document.createElement('button');
  editButton.classList.add('button');
  editButton.setAttribute('data-id', item?.id);
  editButton.innerText = 'Editar'
  editButton.addEventListener('click', onEditItem)


  cardContainer.classList.add('card-container');
  cardContainer.classList.add('elevation-1');
  cardContainer.id = `card-${item?.id}`;
  cardContainer.innerHTML = `
    <div class="card-header"><h3>${item?.name}</h3></div>
    <div class="card-content">
      ${item?.publisher ? `<p><b>Editora:</b> ${item.publisher?.name}</p>` : ''}
      <p class="card-description">${item?.description || '<i>(Sem descrição)</i>'}</p>
    </div >
  `;
  listContainer?.appendChild(cardContainer);

  if (showOptions) {
    const cardFooter = document.createElement('div');
    cardFooter.classList.add('card-footer');
    cardFooter.appendChild(editButton);
    cardFooter.appendChild(deleteButton);
    cardContainer?.appendChild(cardFooter);
  }
}

export function generateCardsList(list, listContainer, showOptions = true) {
  listContainer.innerHTML = '';
  if (list?.length > 0) {
    list?.forEach(item => {
      createCard(item, listContainer, showOptions);
    });
  } else {
    listContainer.innerHTML = '<div>Nenhum item encontrado</div>'
  }
}

async function onEditItem(event) {
  event.preventDefault();
  const id = event.target.attributes["data-id"].value;

  location.replace(`edit?id=${id}`);
}

function onDeleteItem(event) {
  event.preventDefault();
  showDialog({ title: 'Excluir cadastro', message: 'Tem certeza que deseja excluir esse cadastro?' }, [
    { label: 'Excluir', variant: 'danger', onclick: () => removeItem() },
    { label: 'Cancelar', variant: 'primary' }
  ]);
  async function removeItem() {
    const id = event.target.attributes["data-id"].value;
    try {
      const response = await deleteItem(id, entity);
      if (response.ok) {
        const cardToRemove = document.querySelector(`.card-container#card-${id}`)
        cardToRemove?.remove();
        showDialog({ title: 'Informação', message: 'O registro foi excluído com sucesso' }, [
          { label: 'Fechar', variant: 'danger' }
        ]);
      } else {
        const { message } = await response.json();
        showDialog({ title: 'Erro ao excluir o registro', message });
      }
    } catch (error) {
      showDialog({ title: 'Erro ao excluir o registro', message: 'Ocorreu um problema ao excluir o registro. Tente novamente em alguns instantes' });
    }
  }
}