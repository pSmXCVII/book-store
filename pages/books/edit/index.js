import { showDialog, setPageTitle } from "/js/functions.js";
import { getAllByEntity, addItem, getItemById, updateItem } from "/assets/api.js";
import renderToolbar from "/js/importToolbar.js";

renderToolbar();

const form = document.querySelector('form#books-form');
const urlParams = new URLSearchParams(window.location.search);
const id = urlParams.get('id');

async function mountSelectOptions() {
  const selectComponent = document.querySelector('select#publisherId');
  const publishers = await getAllByEntity('publishers');
  publishers?.forEach(publisher => {
    const option = `<option value="${publisher.id}">${publisher.name}</option>`
    selectComponent?.insertAdjacentHTML("beforeEnd", option);
  });
};

mountSelectOptions().then(async () => {
  if (id) {
    const data = await getItemById(id, 'books');
    if (data) {
      document.querySelector('#name').value = data?.name;
      document.querySelector('#description').value = data?.description;
      document.querySelector('#publisherId').value = data?.publisherId;
      setPageTitle(`Livros: ${data?.name}`);
    }
  }
});

document.addEventListener('submit', async (event) => {
  event.preventDefault();
  const formData = new FormData(form);
  let response;
  if (!id) {
    response = await (await addItem(formData, 'books'));
    const json = (await response.json());
    if (response.ok) {
      showDialog({ title: !id ? 'Cadastrado com sucesso' : 'Alterado com sucesso', message: 'Deseja permanecer com o cadastro aberto?' }, [
        { label: 'Fechar cadastro', variant: 'danger', onclick: () => location.replace('../') },
        { label: 'Permanecer', variant: 'primary', onclick: () => location.replace(`?id=${json.id}`) }
      ]);
    }
  } else {
    response = await (await updateItem(id, formData, 'books'));
  }
  if (response.ok) {
    showDialog({ title: !id ? 'Cadastrado com sucesso' : 'Alterado com sucesso', message: 'Deseja permanecer com o cadastro aberto?' }, [
      { label: 'Fechar cadastro', variant: 'danger', onclick: () => location.replace('../') },
      { label: 'Permanecer', variant: 'primary' }
    ]);
  }
});