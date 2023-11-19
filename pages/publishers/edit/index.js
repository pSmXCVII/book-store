import { showDialog, setPageTitle } from "/js/functions.js";
import { addItem, getItemById, updateItem } from "/assets/api.js";
import renderToolbar from "/js/importToolbar.js"

renderToolbar();

const form = document.querySelector('form#publishers-form');
const urlParams = new URLSearchParams(window.location.search);
const id = urlParams.get('id');

document.addEventListener('submit', async (event) => {
  event.preventDefault();
  const formData = new FormData(form);
  let response;
  if (!id) {
    response = await (await addItem(formData, 'publishers'));
  } else {
    response = await (await updateItem(id, formData, 'publishers'));
  }
  const json = (await response.json());
  if (response.ok) {
    showDialog({ title: !id ? 'Cadastrado com sucesso' : 'Alterado com sucesso', message: 'Deseja permanecer com o cadastro aberto?' }, [
      { label: 'Fechar cadastro', variant: 'danger', onclick: () => location.replace('../') },
      { label: 'Permanecer', variant: 'primary', onclick: () => location.replace(`?id=${json.id}`) }
    ]);
  }
});

if (id) {
  const data = await getItemById(id, 'publishers');
  if (data) {
    document.querySelector('#name').value = data?.name;
    document.querySelector('#description').value = data?.description;
    setPageTitle(`Editoras: ${data?.name}`);
  }
}